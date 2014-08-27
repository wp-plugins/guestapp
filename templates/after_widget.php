    </div>
    <div class="arrows">
    <? if ($compact): ?>
    	<div class="ls-nav-left-arrow" style="float: left; text-indent: -9999px;">
	    	<a href="#left" data-liquidslider-ref="<? echo $id ?>">Left</a>
    	</div>
    <? endif ?>
    <? if ($compact): ?>
    	<div class="ls-nav-right-arrow" style="float: right; text-indent: -9999px; margin-top: -24px !important;">
	    	<a href="#right" data-liquidslider-ref="<? echo $id ?>">Right</a>
    	</div>
    <? endif ?>
	</div>
    <div class="ga-source">
    	<? _e('Reviews collected by ', 'guestapp') ?>
    	<a href="http://guestapp.me/confiance" target="_blank"><img alt="Guestapp Logo" src="<? echo plugin_dir_url(__FILE__) ?>../images/logo-<? echo $color ?>.png" class="ga-logo"></a>
    </div>
</div>
