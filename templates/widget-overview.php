<link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
<div class="ga-widget-container <? echo $color ?> ga-average">
	<div itemscope itemtype="http://data-vocabulary.org/Review" class="ga-review-average">
		<h3 itemprop="itemreviewed"><? echo $data["establishment_name"] ?></h3>
		<div class="ga-rate">
			<meta content="0" itemprop="worst"></meta>
			<meta content="10" itemprop="best"></meta>
			<? if ($note == "both" || $note == "note"): ?>
				<h2 class="ga-rate-average-num" itemprop="aggregateRating"><span class="ga-note-emphasis"><? echo $data["average"] ?></span> / 10</span>
			<? endif ?>

			<? if ($note == "both" || $note == "stars"): ?>
				<span class="ga-rate-average-stars">
					<? for($i = 0; $i < $data["global_stars"]; $i++): ?>
						<i class="fa fa-star"></i>
					<? endfor ?>
					<? if($data["global_half_stars"] == 1): ?>
						<i class="fa fa-star-half-o"></i>
					<? endif ?>
					<? for($i = $data['global_stars']; $i <= 4 - $data['global_half_stars']; $i++): ?>
						<i class="fa fa-star-o"></i>
					<? endfor ?>
				</span>
			<? endif ?>

			<em itemprop="reviewCount" class="ga-stay-count">(<?echo $data['count'] ?> <? _e("review", "guestapp") ?> )</em>
		</div>
		<div class="ga-subratings">
			<ul>
				<? $counter = 0; ?>
                <? foreach($data['subratings'] as $rating): ?>
                    <li class="ga-subrating <? if ($counter > 2) echo 'ga-note-hidden' ?>">
                        <strong class="ga-subcat"><? _e($rating->key, "guestapp") ?></strong>
                        
                        <? if ($note == "both" || $note == "note"): ?>
                        	<span class="ga-note"> <?echo $rating->average ?></span>
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
                    </li>
                    <? $counter++ ?>
                <? endforeach ?>
            </ul>
            <? if ($counter > 3): ?>
				<span class="ga-show-all ga-show-all-link ga-show-global" onclick="toggleNotes(true)"><? _e("see_more", "guestapp") ?></span>
				<span class="ga-hide-all ga-hide-all-link ga-hide-global" onclick="toggleNotes(false)"><? _e("see_less", "guestapp") ?></span>
			<? endif ?>
		</div>
	</div>
</div>