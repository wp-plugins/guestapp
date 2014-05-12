<div class="ga-review">
    
    <? if ($note == "both" || $note == "note"): ?>
        <h2><span class="ga-note-emphasis"><? echo $review["global_rate"] ?></span>/10</h2>
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

            <div class="ga-comment-short ga-show-all ga-show-all-<? echo $review["id"] ?> ">
                <span class='ga-opening-quote'>“</span>
                <? echo $review["comment_short"] ?> 
                <span class="ga-show-all ga-show-all-link ga-show-all-<? echo $review["id"] ?>" onclick="toggleSubNotes(<?echo $review["id"] ?>, <? echo $compact ? 'true': 'false' ?>)">(<? _e("see_more", "guestapp") ?>)</span>
                <span class="ga-closing-quote">”</span>
            </div>

            <div class="ga-comment-full ga-hide-all ga-hide-all-<? echo $review["id"] ?>">
                <span class='ga-opening-quote'>“</span>
                <? echo $review["comment_all"] ?>
                <span class="ga-hide-all ga-hide-all-link ga-hide-all-<? echo $review["id"] ?>" onclick="toggleSubNotes(<?echo $review["id"] ?>, <? echo $compact ? 'true': 'false' ?>)">(<? _e("see_less", "guestapp") ?>)</span>
                <span class="ga-closing-quote">”</span>
            </div>

                
            <div class="ga-subratings ga-note-hidden ga-review-<? echo $review["id"] ?>">
                <ul>
                    <? foreach($review["ratings"] as $key => $value): ?>
                        <li class="ga-subrating">
                            <strong class="ga-subcat"><? _e($key, "guestapp") ?></strong>
                            <? if ($note == "both" || $note == "note"): ?>
                                <span class="ga-note"> <?echo $value ?></span>
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
                        </li>
                    <? endforeach ?>
                </ul>
            </div>
            <div class='ga-review-info'>
                <? if (!empty($review["verif_link"])): ?>
                    <a target="_blank" href="<? echo $review["verif_link"] ?>">
                        <span class="ga-seal">
                            <img src='<? echo plugin_dir_url(__FILE__) . '../images/seal.png' ?>'>
                        </span>
                    </a>
                <? endif ?>
                <h3 class="ga-client-name"><? echo $review["user_name"] ?></h3> - 
                <date><? echo date_i18n("d F Y", $review["timestamp"]) ?></date> - 
                <span class="ga-staytype"><? _e($review["stay_type"], 'guestapp') ?></span> - 
                <span class="ga-country">
                    <img src='<? echo plugin_dir_url(__FILE__) . '../images/flag/'.$review["flag"] ?>'>
                </span>
            </div>
        </div>
        
    </blockquote>
</div>