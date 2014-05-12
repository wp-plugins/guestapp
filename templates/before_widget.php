<div class="ga-widget-container <? echo $color ?>">
	<div class="ga-review-container 
	           <? if ($compact) echo 'liquid-slider' ?> 
	           <?php if ($count > 3 && !$compact) echo 'ga-review-perfectable'; ?>" 
	     id="<?php if ($compact === true) echo 'ga-slider-' . $number; ?>">