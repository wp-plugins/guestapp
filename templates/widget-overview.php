    <? //==================================================================================
       // Hotel Overview (average notes)
       //==================================================================================  ?>
    <div itemscope itemtype="http://data-vocabulary.org/Review-aggregate" class="ga-review-average">
        <p style="text-align: center; margin: 0; border: none; font-family: 'Open Sans', Helvetica, Arial, sans-serif; font-size: 16px; line-height: 30px; font-weight: bold;" itemprop="itemreviewed">
            <? echo $data["establishment_name"] ?>
        </p>

        <div class="ga-rate">
            <? //==================================================================================
               // Average rating
               //================================================================================== ?>
            <? 
                $showNumericRating = ($note == "both" || $note == "note");
                $numericRatingStyle = $showNumericRating ? "border: none; font-family: 'Open Sans', Helvetica, Arial, sans-serif; line-height: 34px; margin: 0; margin-top: 0px; text-align: center;" : "opacity: 0; font-size: 1px; position: absolute;"
            ?>
            <p style="<? echo $numericRatingStyle; ?>" class="ga-rate-average-num" >
                <span itemprop="rating" style="color: #DA3466; font-weight: bold; font-size: 26px;">
                    <? echo $data["average"] ?>
                </span> 
                / 
                <span itemprop="best">10</span>
            </p>

            <? //==================================================================================
               // Average stars
               //==================================================================================  
            ?>
            <? if ($note == "both" || $note == "stars"): ?>
                <div class="ga-rate-average-stars">
                    <? // Output floor($average / 2) full stars ?>
                    <? for($i = 0; $i < floor($data["average"] / 2); $i++): ?>
                        <i class="fa fa-star"></i>
                    <? endfor ?>

                    <? // If $average/2 - floor($average/2) is > 0, it means the note has a half part to it 
                       // We add a half star to compensate (this also means that any note between x.1 and x.9
                       // Will be represented with a half star, which is somewhat imprecise if we're at the 
                       // upper or lower ends of the note?>
                    <? if(($data["average"] / 2) - floor($data["average"] / 2) > 0): ?>
                        <i class="fa fa-star-half-o"></i>
                    <? endif ?>

                    <? // Fill the rest with empty stars ?>
                    <? for($i = 0; $i <= 4 - ($data["average"] / 2); $i++): ?>
                        <i class="fa fa-star-o"></i>
                    <? endfor ?>
                </div>
            <? endif ?>

            <? //==================================================================================
               // Review count
               //==================================================================================  ?>
            <p style="font-size: 11px; font-style: italic; text-align: center;" class="ga-stay-count">
                <? _e("Average rate on", "guestapp") ?> 
                <span itemprop="count"><?echo $data['count'] ?></span> 
                <? _e("Review", "guestapp") ?>
            </p>
        </div>
        <? //==================================================================================
           // List of subratings
           //==================================================================================  ?>
        <div class="ga-subratings">
            <? // Only if the user wants to show it ?>
            <? if ($showSubratings): ?>
                <div style="width: 100%;" class="ga-subrating-holder">
                    <? // Display each subnote as `Category [note] [stars]`
                       // Also, only the first three subnotes are shown by default
                       // Others get a .ga-note-hidden css class and are shown later through some js
                       // See the part about stars before for info as to how it works. It's the same ?>
                    <? $counter = 0; 
                       $maxCount = 3; ?>
                    <? foreach($data['subratings'] as $rating): ?>
                        <? if ($counter >= $maxCount): ?>
                            <div style="padding-left: 0; margin-left: 0;" class="ga-subrating ga-note-hidden">
                        <? else: ?>
                            <div class="ga-subrating">
                        <? endif ?>

                            <strong class="ga-subcat"><? _e($rating->key, "guestapp") ?></strong>
                            <div class="ga-note-container">
                                <? if ($note == "both" || $note == "note"): ?>
                                    <span class="ga-rate-average-num"><span class="ga-note-emphasis"> <?echo $rating->average ?></span> / 10 </span>
                                <? endif ?>

                                <? if ($note == "both" || $note == "stars"): ?>
                                    <div class="ga-note-stars">

                                    <? for($i = 0; $i < floor($rating->average / 2); $i++): ?>
                                        <i class="fa fa-star"></i>
                                    <? endfor ?>

                                    <? if(($rating->average / 2) - floor($rating->average / 2) > 0): ?>
                                        <i class="fa fa-star-half-o"></i>
                                    <? endif ?>

                                    <? for($i = 0; $i <= 4 - ($rating->average / 2); $i++): ?>
                                        <i class="fa fa-star-o"></i>
                                    <? endfor ?>
                                    </div>
                                <? endif ?>
                            </div>
                        </div>
                        <? $counter++ ?>
                    <? endforeach ?>
                </div>
                <? // Only show the more/less links if there is more than three reviews ?>
                <? if ($counter > $maxCount): ?>
                    <div class="ga-show-all ga-show-all-link ga-show-global" onclick="toggleNotes(jQuery(this))">
                        <? _e("See more...", "guestapp") ?>
                    </div>
                    <div class="ga-hide-all ga-hide-all-link ga-hide-global" onclick="toggleNotes(jQuery(this))">
                        <? _e("See less...", "guestapp") ?>
                    </div>
                <? endif ?>
            <? endif ?>
        </div>
    </div>
