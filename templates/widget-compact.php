<div class="ga-review">
    <h2><span class="ga-note-emphasis"><? echo $global_rate ?></span>/10</h2>
    <blockquote>
         <div class="ga-content">
            <div class="ga-comment-short ga-show-all ga-show-all-<? echo $id ?> ">
                <span class='ga-opening-quote'>“</span>
                <? echo $comment_short ?> 
                <span class="ga-show-all ga-show-all-link ga-show-all-<? echo $id ?>" onclick="toggleSubNotes(<?echo $id ?>, true)">(<? _e("see_more", "guestapp") ?>)</span>
                <span class="ga-closing-quote">”</span>
                
            </div>
            <div class="ga-comment-full ga-hide-all ga-hide-all-<? echo $id ?>" ?>
                <span class='ga-opening-quote'>“</span><? echo $comment_all ?><span class="ga-closing-quote">”</span>
            </div>
            <div class="ga-subratings ga-note-hidden" id="review-<? echo $id ?>">
                <ul>
                    <? foreach($ratings as $key => $value): ?>
                        <li class="ga-subrating">
                            <strong class="ga-subcat"><? _e($key, "guestapp") ?></strong>
                            <span class="ga-note"> <?echo $value ?></span>
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
                        </li>
                    <? endforeach ?>
                </ul>
            </div>
            <div class='ga-review-info'>
                <a href="<? echo $verif_link ?>">
                    <span class="ga-seal">
                        <img src='<? echo plugin_dir_url(__FILE__) . '../images/seal.png' ?>'>
                    </span>
                </a>
                <h3 class="ga-client-name"><? echo $user_name ?></h3> - 
                <date><? echo date("d F Y", $timestamp) ?></date> - 
                <span class="ga-staytype"><? _e($stay_type, 'guestapp') ?></span> - 
                <span class="ga-country">
                    <img src='<? echo plugin_dir_url(__FILE__) . '../images/flag/'.$flag ?>'>
                </span>
            </div>
            <div class="ga-slider-controller">

            </div>
        </div>
        
    </blockquote>
</div>