<?php
// Moi c'est Bob. Quand je commit, ca casse.
// Et quand je recommit, ca casse pas.
/**
 * GuestApp service utilities
 * Almost every function expects `$token` to be set. If it is not,
 * requests will most likely fail.
 */
class GuestApp {
    
    public $APIPath;
    private $token;

    /**
     * Constructor for GuestApp
     * Sets up the API Path and the token
     * If no token is provided, the token will be null
     * @param string $token
     */
    function __construct($token = null) {
        $this->APIPath = "https://admin.guestapp.me/rest/reviews.json?";
        //$this->APIPath = "http://guestapp.dev/app_dev.php/rest/reviews.json?"; // DEBUG
        // Et quand je commit ici, ca casse probablement
        $this->token = $token;
    }

    /**
     * Checks if `$token` is a valid GuestApp token
     * @param string $token
     * @return boolean
     */
    public function checkToken($token) {
        // Check token against API
        // Copy the token, do a request with the new token, put it back
        $tempToken = $this->token;
        $this->token = $token;

        $data = $this->pullFromAPI();

        $isValid = !isset($data->error);

        $this->token = $tempToken;

        return $isValid;
    }

    /**
     * Retrieves all the reviews for this token from the API as a json_decoded object
     * Requires `$token` to be set.
     */
    public function getAll() {
        return $this->pullFromAPI(false, 10000000);
    }

    /**
     * Compares two subratings by their amount of reviews
     */
    private static function compare_amount($a, $b) {
        if ($a == $b) {
            return 0;
        }

        return($a->count > $b->count) ? -1 : 1;
    }

    /**
     * Gets the review data for presentation
     * From a $json source of data
     * @param string $json
     * @return object data
     */
    public function getReviewData($json) {
        $composite = new stdClass();
        $composite->data = array();

        foreach ($json->reviews as $review) {

            $data = array(
                "id"            => $review->id,
                "user_name"     => $review->user_name,
                "creation_date" => $review->creation_date,
                "timestamp"     => $review->creation_date_timestamp,
                "global_rate"   => $review->global_rate,
                "ratings"       => isset($review->ratings) ? $review->ratings : new stdClass(),
                "comment_short" => substr($review->comment, 0, 200) . (strlen($review->comment) > 200 ? "..." : ""),
                "comment_all"   => isset($review->comment) ? $review->comment : "",
                "stay_type"     => isset($review->type) ? $review->type : "",
                "flag"          => strtolower($review->language_code).'.png',
                "establishment" => $review->establishment_name,
                "verif_link"    => isset($review->authenticity_url) ? $review->authenticity_url : null
            );
            $composite->data[] = $data;
            $composite->count = count($json->reviews);
        }

        return $composite;
    }

    /**
     * Gets the average data for presentation
     * From a $json source of data
     * @param string $json
     * @return array data
     */
    public function getAverageData($json) {
        $json = $this->getJSONData(null, null, $json);
        $sum = 0;
        $average = 0;
        $global_stars = 0;
        $global_half_stars = 0;
        $sub_ratings = array();
        $sub_averages = array();
        $sub_data = array();

        // First, we build the average rating coming from the global rates
        for ($i = 0; $i < $json->count; $i++) {
            $sum += $json->reviews[$i]->global_rate;

            // If there are subratings, we also add up their values to be able to create their average later
            if (isset($json->reviews[$i]->ratings)) {
                foreach($json->reviews[$i]->ratings as $key => $value) {
                    // If this subrating already exists in our list, we simply add to it
                    // otherwise, we create it.
                    if (isset($sub_ratings[$key])) {
                        $sub_ratings[$key]->total += $value;
                        $sub_ratings[$key]->count += 1;
                    } else {
                        $data = new stdClass();
                        $data->total = $value;
                        $data->count = 1;
                        $sub_ratings[$key] = $data;
                    }
                }
            }
        }
        $average = round($sum / $json->count, 1);

        // We build the subratings averages
        foreach ($sub_ratings as $key => $value) {
            $sub_averages[$key] = $value->total / $value->count;
        }

        // Calculating the amount of stars shown
        $global_stars = floor($average / 2);
        $global_half_stars = ($average - $global_stars < 1 &&  
                              $average - $global_stars > 0) ? 1 : 0;

        // Building  the data sent to the template for the subratings
        foreach ($sub_averages as $key => $value) {
            $data = new stdClass();
            $data->key = $key;
            $data->average = round($value, 1);
            $data->count = $sub_ratings[$key]->count;
            $sub_data[] = $data;
        }

        // Sorting the subratings, putting the ones with the most reviews at the front
        usort($sub_data, array("GuestApp", "compare_amount"));

        // Building the final array, sent to the template
        $data = array(
            "count"                 => $json->count,
            "average"               => $average,
            "establishment_name"    => $json->reviews[0]->establishment_name,
            "global_stars"          => $global_stars,
            "global_half_stars"     => $global_half_stars,
            "subratings"            => $sub_data
        );

        return $data;
    }

    /**
     * Returns the data that fits the $lang and $qty parameters
     * @param string $lang formatted like "fr,en,es"
     * @param integer $quantity
     * @param object $original
     * @return object datas
     */
    public function getJSONData($lang, $quantity, $original = null) {
        // The widget can set two options related to the content. the first is lang, which defines the language of the reviews. The second is quantity, which defines the max amount of reviews shown
        $lang_array = explode(",", $lang);
        $returned = array();
        $count = 0;

        $data = is_object($original) ? clone $original : new stdClass();

        if (!isset($data->reviews)) {
            return null; // No reviews. Stop parsing.
        }

        foreach ($data->reviews as $rev) { // Selecting which reviews will be shown
            if ($quantity != 0 && $count >= $quantity) { // There is a maximum amount of shown reviews, and we've reached it
                break;
            }

            if ($lang !== null && $lang !== "any") { // One or more language has been set
                if (in_array(strtolower($rev->language_code), $lang_array)) { // We recover any language that matches the request
                    $returned[] = $rev;
                    $count++;
                }
            } else {
                if ($quantity == 0) { // There is no maximum amount of shown reviews. We just send the entire data back
                    $returned = $data->reviews;
                    break;
                } else { // There is a maximum amount. We simply append, until we reach the maximum
                    $returned[] = $rev;
                    $count++;
                }
            }

        }

        $data->reviews = $returned;
        return $data;
    }

    /**
     * Pulls reviews from the API
     * Requires `$token` to be set
     * @param boolean $only_new If set to true, only the unread reviews will be sent.
     * @param integer $count The amount of reviews to get
     * @return object the response (not a string)
     */
    private function pullFromAPI($only_new = false, $count = 50000) {
        $query = $this->APIPath;

        $data = array();

        if ($this->token != null) {
            $data['access_token'] = $this->token;
        }
        $data['count'] = $count;

        $query .= http_build_query($data);

        // We need to use cURL here
        // file_get_contents returns false, or null on any other code than HTTP 200
        // Errors are 401, and we can't get the response.

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $query);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_FRESH_CONNECT, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $return = curl_exec($curl);

        // The curl request has failed
        if ($return === FALSE) {
            // Reinitialize the object, and build an error message
            $return = new stdClass();

            $return->error = "server_down";
            $return->error_description = "Couldn't reach the server";
            return;
        }
        curl_close($curl);

        return json_decode($return);
    }
}