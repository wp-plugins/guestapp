<div class="ga-widget-container <? echo $color ?>">
	<? if ($compact): ?>
		<div id="<? echo $id ?>" class="ga-review-container liquid-slider">
	<? elseif ($count > 3): ?>
		<div id="<? echo $id ?>" class="ga-review-container ga-review-perfectable" ?>
	<? endif ?>