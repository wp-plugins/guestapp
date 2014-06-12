<? // Review data
   // Represent a single review by an user 
?>
<div itemscope itemtype="http://data-vocabulary.org/Review" class="ga-review">
    <? // Microformat stuff
       // Those particular properties have to be shown in meta tags, because they are either not shown
       // in the review, or they're not in the right format (like dtreviewed)
    ?>
    <meta content="0" itemprop="worst">
    <meta content="10" itemprop="best">
    <meta content="<? echo $review['establishment'] ?>" itemprop="itemreviewed">
    <meta content="<? echo date('c', $review['timestamp']) ?>" itemprop="dtreviewed">

    <? // See rules about stars, notes & both ?>
    <? if ($note == "both" || $note == "note"): ?>
        <p style="text-align: center; font-family: 'Open Sans', Helvetica, Arial, sans-serif; font-weight: bold;"><span style="color: #DA3466; font-size: 1.3em !important;" itemprop="rating" class="ga-note-emphasis"><? echo $review["global_rate"] ?></span>/10</p>
    <? endif ?>
    
    <? if ($note == "both" || $note == "stars"): ?>
        <div class="ga-note-stars-global">
        <? for($i = 0; $i < floor($review["global_rate"] / 2); $i++): ?>
            <i class="fa fa-star"></i>
        <? endfor ?>
        <? if(($review["global_rate"] / 2) - floor($review["global_rate"] / 2) > 0): ?>
            <i class="fa fa-star-half-o"></i>
        <? endif ?>
        <? for($i = 0; $i <= 4 - ($review["global_rate"] / 2); $i++): ?>
            <i class="fa fa-star-o"></i>
        <? endfor ?>
        </div>
    <? endif ?>

    <blockquote>
         <div class="ga-content">

            <div class="ga-comment-short ga-show-all ga-show-all-<? echo $review["id"] ?>">
                <? // 'Tis but a dirtey hack. Background images are overrated. ?>
                <span class='ga-opening-quote'>“</span>
                <span itemprop="summary"><? echo $review["comment_short"] ?></span>
                
                <? // Togglers
                   // Open in a popup if we're in compact mode
                   // Show inline if not
                   // (Protip : it's actually disabled in the js, and will always open inline) ?>
                <? if ($compact): ?>
                    <span class="ga-show-all ga-show-all-link ga-show-all-<? echo $review["id"] ?>" onclick="toggleSubNotes(jQuery(this),<?echo $review["id"] ?>, true)">
                        (<? _e("See more...", "guestapp") ?>)
                    </span>
                <? else: ?>
                    <span class="ga-show-all ga-show-all-link ga-show-all-<? echo $review["id"] ?>" onclick="toggleSubNotes(jQuery(this),<?echo $review["id"] ?>, false)">
                        (<? _e("See more...", "guestapp") ?>)
                    </span>
                <? endif ?>
                
                <? // End of the dirty hack ?>
                <span class="ga-closing-quote">”</span>
            </div>

            <div class="ga-comment-full ga-hide-all ga-hide-all-<? echo $review["id"] ?>">
                <? // Dirty hack 2 : the dirty hackening ?>
                <span class='ga-opening-quote'>“</span>
                <span itemprop="description"><? echo $review["comment_all"] ?></span>
                
                <? if ($compact): ?>
                    <span class="ga-hide-all ga-hide-all-link ga-hide-all-<? echo $review["id"] ?>" onclick="toggleSubNotes(jQuery(this), <?echo $review["id"] ?>, true)">
                        (<? _e("See less...", "guestapp") ?>)
                    </span>
                <? else: ?>
                    <span class="ga-hide-all ga-hide-all-link ga-hide-all-<? echo $review["id"] ?>" onclick="toggleSubNotes(jQuery(this), <?echo $review["id"] ?>, false)">
                        (<? _e("See less...", "guestapp") ?>)
                    </span>
                <? endif ?>

                <span class="ga-closing-quote">”</span>
            </div>

            <? // List of the subratings for this particular review ?>
            <div class="ga-subrating ga-note-hidden ga-review-<? echo $review["id"] ?>">
                <div class="ga-subrating-holder">
                    <? foreach($review["ratings"] as $key => $value): ?>
                        <div class="ga-subrating">
                            <strong class="ga-subcat"><? _e($key, "guestapp") ?></strong>
                            <div class="ga-note-container">
                                <? if ($note == "both" || $note == "note"): ?>
                                    <span class="ga-rate-average-num"><span class="ga-note-emphasis"> <?echo $value ?></span> / 10 </span>
                                <? endif ?>
                                <? if ($note == "both" || $note == "stars"): ?>
                                    <div class="ga-note-stars">
                                    <? for($i = 0; $i < floor($value / 2); $i++): ?>
                                        <i class="fa fa-star"></i>
                                    <? endfor ?>
                                    <? if(($value / 2) - floor($value / 2) > 0): ?>
                                        <i class="fa fa-star-half-o"></i>
                                    <? endif ?>
                                    <? for($i = 0; $i <= 4 - ($value / 2); $i++): ?>
                                        <i class="fa fa-star-o"></i>
                                    <? endfor ?>
                                    </div>
                                <? endif ?>
                            </div>
                        </div>
                    <? endforeach ?>
                </div>
            </div>
            <? // Seal of authenticity & client info ?>
            <div class='ga-review-info'>
                <? if (!empty($review["verif_link"])): ?>
                    <a target="_blank" href="<? echo $review["verif_link"] ?>">
                        <span class="ga-seal">
                            <img alt="Guestapp Seal" src='<? echo plugin_dir_url(__FILE__) . '../images/seal.png' ?>'>
                        </span>
                    </a>
                <? endif ?>
                <p style="display: inline-block; margin: 0; font-weight: normal; font-size: 9pt;" itemprop="reviewer" class="ga-client-name"><? echo $review["user_name"] ?></p> - 
                <div class="date"><? echo date_i18n("d F Y", $review["timestamp"]) ?></div> - 
                <span class="ga-staytype"><? _e($review["stay_type"], 'guestapp') ?></span> - 
                <span class="ga-country">
                    <img alt="Flag" src='<? echo plugin_dir_url(__FILE__) . '../images/flag/'.$review["flag"] ?>'>
                </span>
            </div>
        </div>
        
    </blockquote>
</div>