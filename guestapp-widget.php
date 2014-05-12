<?php

/*
 * GuestApp Widget
 * Displays one or more reviews
 * Usage : [guestapp (lang=x) (id=x)]
 * [guestapp lang=x] : Displays as many reviews as possible in a particular language
 * [guestapp id=x] : Displays the review with id x, overrides lang
 * [guestapp] : Displays as many reviews as possible, starting from the latest, using the widget rules
 */
class GuestApp_Widget extends WP_Widget {
    /*
     * Used to cache the data returned by the database so it doesn't get hit too often by queries.
     * Shared by all the instances
     */
    static $jsonCache = null;

    /*
     * Register widget with WordPress.
     */
    function __construct() {
        load_plugin_textdomain('guestapp', false, dirname(plugin_basename(__FILE__)) . "/lang/");

        $this->fillCache();

        parent::__construct(
            'guestapp_widget', // Base ID
            'GuestApp', // Name
            array('description' => __('guestapp_desc', 'guestapp')) // Args
        );

    }

    //=============================================================================
    // Setup & hooks
    //=============================================================================

    /*
     * Configures the widget creation form
     */
    public function form($instance) {
        // Parsing the form data
        //============================
        $title  = (isset($instance['title'])    ? $instance['title']    : __("review", "guestapp"));
        $number = (isset($instance['number'])   ? $instance['number']   : rand(1, 64));
        $amount = (isset($instance['amount'])   ? $instance['amount']   : 5);
        $lang   = (isset($instance['lang'])     ? $instance['lang']     : "any");
        $type   = (isset($instance['type'])     ? $instance['type']     : "0");
        $color  = (isset($instance['color'])    ? $instance['color']    : 'light');
        $note   = (isset($instance['note'])     ? $instance['note']     : 'both');

        $data = array(
            "titleId"       => $this->get_field_id('title'),
            "titleName"     => $this->get_field_name('title'),
            "title"         => esc_attr($title),
            "numberId"      => $this->get_field_id('number'),
            "numberName"    => $this->get_field_name('number'),
            "number"        => esc_attr($number),
            "amountId"      => $this->get_field_id('amount'),
            "amountName"    => $this->get_field_name('amount'),
            "amount"        => esc_attr($amount),
            "langId"        => $this->get_field_id('lang'),
            "langName"      => $this->get_field_name('lang'),
            "lang"          => esc_attr($lang),
            "typeId"        => $this->get_field_id('type'),
            "typeName"      => $this->get_field_name('type'),
            "type"          => esc_attr($type),
            "colorId"       => $this->get_field_id("color"),
            "colorName"     => $this->get_field_name("color"),
            "color"         => esc_attr($color),
            "noteId"        => $this->get_field_id("note"),
            "noteName"      => $this->get_field_name("note"),
            "note"          => esc_attr($note)
        );

        print render('templates/widget_settings.php', $data);
    }

    /*
     * Once the widget is updated, insert everything into the database
     */
    public function update($new_instance, $old_instance) {
        global $wpdb;

        $instance = array();
        $instance['title']  = (isset($new_instance['title'] )) ? strip_tags($new_instance['title'] ) : '';
        $instance['number'] = (isset($new_instance['number'])) ? strip_tags($new_instance['number']) : '';
        $instance['amount'] = (isset($new_instance['amount'])) ? strip_tags($new_instance['amount']) : '';
        $instance['lang']   = (isset($new_instance['lang']  )) ? strip_tags($new_instance['lang']  ) : '';
        $instance['type']   = (isset($new_instance['type']  )) ? strip_tags($new_instance['type']  ) : '';
        $instance['color']  = (isset($new_instance['color'] )) ? strip_tags($new_instance['color'] ) : '';
        $instance['note']   = (isset($new_instance['note']  )) ? strip_tags($new_instance['note']  ) : '';

        // Inserting the instance => amount into the database
        $this->insertWidgetProps("amount", $instance['amount'], $instance['number']);

        // Inserting the language in the db
        $this->insertWidgetProps("lang", $instance['lang'], $instance['number']);

        // Setting the widget type
        $this->insertWidgetProps("type", $instance['type'], $instance['number']);

        // Setting the widget color
        $this->insertWidgetProps("color", $instance['color'], $instance['number']);

        // Setting the widget note display style
        $this->insertWidgetProps("note", $instance['note'], $instance['number']);
        
        return $instance;
    }

    function insertWidgetProps($prop, $value, $number) {
        global $wpdb;

        $data = array(
            "option_name"  => "guestapp_widget_" . $number . "_" . $prop,
            "option_value" => $value,
            "autoload"     => "yes"
        );
        $wpdb->replace($wpdb->options, $data);        
    }

    //=============================================================================
    // Data related
    //=============================================================================

    /*
     * Fills the JSON cache with all the reviews for this user
     * Also inserts them into the database
     */
    function fillCache() {
        // Given by wordpress to access the database.
        global $wpdb;

        // Checking if we can load from database
        if (GuestApp_Widget::$jsonCache === null) {
            $returned = $wpdb->get_row("SELECT * FROM $wpdb->options WHERE option_name = 'guestapp_review_data';");

            if (is_object($returned)) {
                // If $returned is not an object, this probably means it's the first time we activate the plugin
                // And the token has not been set yet
                GuestApp_Widget::$jsonCache = json_decode($returned->option_value);
            }
        }
    }

    /*
     *  Generates the overview of the establishment
     */
    private function build_average($params) {
        $ga = new GuestApp();

        $out = render('templates/widget-overview.php', array("data" => $ga->getAverageData(GuestApp_Widget::$jsonCache),
                                                             "color"=> $params["color"],
                                                             "note" => $params["note"]
                                                             ));

        return $out;
    }

    /*
     * Generates the user reviews
     * @param $json The data used to build the reviews (which we already got earlier, already filtered)
     * @param $isSidebarWidget True if this widget was inserted into the sidebar, false otherwise
     */
    private function build_reviews($json, $params = array()) {
        $out  = "";
        $ga   = new GuestApp();
        $data = $ga->getReviewData($json);

        $out .= render('templates/before_widget.php', array("count"  => count($data->data), 
                                                            "compact"=> $params["compact"],
                                                            "number" => $params["number"],
                                                            "color"  => $params["color"],
                                                            "note"   => $params["note"]
                                                            ));
        $total = count($data->data);
        $counter = 1;
        foreach ($data->data as $review) {         
            $out .= render('templates/widget.php', array("review" => $review,
                                                         "note"   => $params["note"],
                                                         "compact"=> $params["compact"],
                                                         "total"  => $total,
                                                         "counter"=> $counter));
            $counter++;
        }
        $out .= render('templates/after_widget.php', array("color" => $params["color"],
                                                           "note"  => $params["note"]
                                                           ));
        return $out;
    }

    /*
     * Renders the widget once it is called
     */
    public function widget($args, $instance) {
        $ga = new GuestApp();
        // What WP will output once we build it
        $out                = "";

        //============================================================================
        // Parameters
        //============================================================================
        $title              = apply_filters('widget_title', isset($instance['title']) ? $instance['title'] : "");
        $isSidebarWidget    = !isset($instance['from_shortcode']);
        $number      = !isset($instance['number']) ? null                                                : $instance['number'];
        $qty         = !isset($instance['qty'])    ? get_option("guestapp_widget_".$number."_amount", 0) : $instance['qty']; 
        $noavg       = !isset($instance['noavg'])  ? false                                               : $instance['noavg'];
        $compact     = !isset($instance['compact'])? get_option("guestapp_widget_".$number."_type", "0") : $instance['compact'];
        $lang        = $isSidebarWidget            ? get_option('guestapp_widget_' . $number . "_lang")  : $instance['lang']; 
        $colorscheme = (!isset($instance['color']) ? get_option("guestapp_widget_" . $number . "_color") : $instance['color']);
        $note        = (!isset($instance['note'])  ? get_option("guestapp_widget_" . $number . "_note") : $instance['note']);
        $compact     = $compact == "1" ? "ga-compact" : "";
        $id = $compact ? "ga-compact-$number" : "";
        // Getting the reviews, filtered by $lang and $qty if they are set
        $json = $ga->getJSONData($lang, $qty, GuestApp_Widget::$jsonCache);

        if ($isSidebarWidget) {

            $out .= "<aside class='ga-reviews widget widget_ga masonry-brick $colorscheme $compact' id='$id'>";
        }
        else {
            $out .= "<div class='ga-reviews $colorscheme $compact' id='$compact'>";
        }

        //============================================================================
        // Contracts 
        //============================================================================
        // Couldn't retrieve the JSON for some reason
        if ($json === null) {
            $data = array();
            $out .= render('templates/before_widget.php', array("count"  => 0, 
                                                            "compact"=> $compact,
                                                            "number" => $number,
                                                            "color"  => $colorscheme,
                                                            "note"   => $note
                                                            ));
            $out .= render('templates/error_generic.php', $data);
            $out .= render('templates/after_widget.php', array("color" => $colorscheme,
                                                           "note"  => $note
                                                           ));
            if ($isSidebarWidget) {
                echo $out . "</aside>";
            } else {
                return $out . "</div>";
            }
            return $out;
        }
        // An error occured on the server
        if (isset($json->error)) {
            $out .= render('templates/before_widget.php', array("count"  => 0, 
                                                            "compact"=> $compact,
                                                            "number" => $number,
                                                            "color"  => $colorscheme,
                                                            "note"   => $note
                                                            ));
            $out .= render('templates/error_json.php', $json);
            $out .= render('templates/after_widget.php', array("color" => $colorscheme,
                                                           "note"  => $note
                                                           ));
            if ($isSidebarWidget) {
                echo $out . "</aside>";
            } else {
                return $out . "</div>";
            }
            return $out;
        }
        // No reviews
        if (count($json->reviews) == 0) {
            $data = array();
            $out .= render('templates/before_widget.php', array("count"  => 0, 
                                                            "compact"=> $compact,
                                                            "number" => $number,
                                                            "color"  => $colorscheme,
                                                            "note"   => $note
                                                            ));
            $out .= render('templates/error_noreview.php', $data);
            $out .= render('templates/after_widget.php', array("color" => $colorscheme,
                                                           "note"  => $note
                                                           ));
            if ($isSidebarWidget) {
                echo $out . "</aside>";
            } else {
                return $out . "</div>";
            }
            return $out;
        }

        //============================================================================
        // It worked
        //============================================================================
        // Sidebar widgets are wrapped into an <aside>, shortcode widgets are wrapped into a div
        // Sidebar widgets never render the average

        if (!$noavg && !$compact) {
            $out .= $this->build_average(array("color" => $colorscheme,
                                               "note"  => $note));
        }
        $out .= $this->build_reviews($json, array("compact" => $compact === "ga-compact", 
                                                  "number"  => $number,
                                                  "color"   => $colorscheme,
                                                  "note"    => $note));


        if ($isSidebarWidget) {
            echo $out . "</aside>";
        } else {
            return $out . "</div>";
        }
    }
}

//=============================================================================
// Form options (writing)
//=============================================================================

/*
 * Register the widget to wordpress
 */
function register_guestapp_widget() {
    register_widget('Guestapp_Widget' );
    wp_enqueue_style("perfect-scrollbar-css", plugin_dir_url(__FILE__). 'styles/perfect-scrollbar.min.css');
    wp_enqueue_style("guestapp-widget-css", plugin_dir_url(__FILE__) . 'styles/style.css');
    wp_enqueue_style("guestapp-liquid-slider-css", plugin_dir_url(__FILE__) . 'styles/liquid-slider.css' );
    wp_enqueue_style("guestapp-fallback", "http://guestapp.me/wp-plugin-fix.css");
    wp_enqueue_script('jquery');
    wp_enqueue_script("jquery-touchswipe", "http://cdnjs.cloudflare.com/ajax/libs/jquery.touchswipe/1.6.4/jquery.touchSwipe.js", "jquery");
    wp_enqueue_script("jquery-easing", "http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js", "jquery" );
    wp_enqueue_script("perfect-scrollbar", plugin_dir_url(__FILE__) . "js/perfect-scrollbar.min.js", "jquery");
    wp_enqueue_script("liquid-slider", plugin_dir_url(__FILE__) . "js/jquery.liquid-slider.min.js", "jquery");
    wp_enqueue_script("guestapp-widget-js", plugin_dir_url(__FILE__ ) . "js/guestapp.js", "perfect-scrollbar");
}
add_action('widgets_init', 'register_guestapp_widget' );

/*
 * Adds a button that allows you to pick a specific language
 * and insert the shortcode into the post
 */
function add_form_button() {
    $ga = new GuestApp(get_option("guestapp_token"));

    add_thickbox();

    $data = array(
        "flagFr"    => plugin_dir_url(__FILE__) . '/images/flag/fr.png',
        "flagEn"    => plugin_dir_url(__FILE__) . '/images/flag/en.png',
        "flagNl"    => plugin_dir_url(__FILE__) . '/images/flag/nl.png',
        "flagEs"    => plugin_dir_url(__FILE__) . '/images/flag/es.png',
        "flagDe"    => plugin_dir_url(__FILE__) . '/images/flag/de.png'
    );
    print render('templates/modal_selector.php', $data);
}
add_action('media_buttons', 'add_form_button');

//=============================================================================
// Shortcode
//=============================================================================
/*
 * Registers the [guestapp] shortcode
 */
function guestapp_shortcode($atts) {
    // Shortcode params
    $params = array(
        "number"  => null,
        "id"      => null,
        "lang"    => "any",
        "qty"     => 0,
        "noavg"   => false,
        "compact" => false,
        "color"   => 'light',
        "note"    => 'both'
    );

    /* Data sanitization
     * Just setting the params to a default value if they don't match any property known */
    if ($params["color"] != "dark" && 
        $params["color"] != "light") {
        $params["color"] = "light";
    }

    if ($params["note"] != "both" && 
        $params["note"] != "note" && 
        $params["note"] != "stars") {
        $params["note"] = "both";
    }

    // Extract the shortcode attributes into the scope
    extract(shortcode_atts($params, $atts, 'guestapp'));

    // Error message
    $error = "<div class='ga-widget-container'<p>" . __('invalid_shortcode', 'guestapp') . "</p></div>";

    if ($id !== null && !is_numeric($id)) {
        return $error;
    }

    // Data has been validated, no need to check it anymore.
    $instance = array(
        'number'            => intval($number),
        'from_shortcode'    => true,
        'id'                => intval($id),
        'lang'              => $lang,
        'qty'               => $qty,
        'noavg'             => $noavg === "true" ? true : false,
        'compact'           => $compact === "true" ? true : false,
        'color'             => $color,
        'note'              => $note
    );

    $args = array(
        'title'             => "GuestApp",
        'before_title'      => '',
        'after_title'       => ''
    );

    $widget = new GuestApp_Widget();
    $content = $widget->widget($args,$instance);

    return $content;
}
add_shortcode('guestapp','guestapp_shortcode');
