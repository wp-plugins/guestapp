	<? //==================================================================================
	   // Hotel Overview (average notes)
	   //==================================================================================  ?>
	<div itemscope itemtype="http://data-vocabulary.org/Review-aggregate" class="ga-review-average">
		<h3 itemprop="itemreviewed"><? echo $data["establishment_name"] ?></h3>
		<div class="ga-rate">
			<meta content="0" itemprop="worst">
			<meta content="10" itemprop="best">
			<? //==================================================================================
			   // Average rating
			   //================================================================================== ?>
			<? if ($note == "both" || $note == "note"): ?>
				<h2 class="ga-rate-average-num" itemprop="rating"><span class="ga-note-emphasis"><? echo $data["average"] ?></span> / 10</h2>
			<? endif ?>

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
			<em class="ga-stay-count">(<span itemprop="count"><?echo $data['count'] ?></span> <? _e("review", "guestapp") ?> )</em>
		</div>
		<? //==================================================================================
		   // List of subratings
		   //==================================================================================  ?>
		<div class="ga-subratings">
			<? // Only if the user wants to show it ?>
			<? if ($showSubratings): ?>
				<ul>
					<? // Display each subnote as `Category [note] [stars]`
					   // Also, only the first three subnotes are shown by default
					   // Others get a .ga-note-hidden css class and are shown later through some js
					   // See the part about stars before for info as to how it works. It's the same ?>
					<? $counter = 0; ?>
	                <? foreach($data['subratings'] as $rating): ?>
	                	<? if ($counter > 1): ?>
	                		<li class="ga-subrating ga-note-hidden">
	                	<? else: ?>
	                		<li class="ga-subrating">
	                	<? endif ?>

	                        <strong class="ga-subcat"><? _e($rating->key, "guestapp") ?></strong>

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
	                    </li>
	                    <? $counter++ ?>
	                <? endforeach ?>
	            </ul>
	            <? // Only show the more/less links if there is more than three reviews ?>
	            <? if ($counter > 1): ?>
					<div class="ga-show-all ga-show-all-link ga-show-global" onclick="toggleNotes(jQuery(this))">
						<? _e("see_more", "guestapp") ?>
					</div>
					<div class="ga-hide-all ga-hide-all-link ga-hide-global" onclick="toggleNotes(jQuery(this))">
						<? _e("see_less", "guestapp") ?>
					</div>
				<? endif ?>
			<? endif ?>
		</div>
	</div>