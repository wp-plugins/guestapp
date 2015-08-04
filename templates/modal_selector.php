<div id="guestapp-modal" style="display:none; margin: 0 auto;">
    <h1 style="text-align: center">GuestApp Widget</h1>
    <div class="container">
        <div class="lang-selector">

            <h3><? _e("Language", "guestapp") ?></h3>
            <input type="checkbox" checked id="lang-check-all" name="lang-all" value="all"><label for="lang-check-all"><? _e("Any", "guestapp") ?></label>

            <input type="checkbox" class="lang-selector" id="lang-check-fr" name="lang-fr" value="fr"><label for="lang-check-fr"><img style="height: 16px; position:relative; top: 4px;" src="<? echo $flagFr ?>"><? _e("French", "guestapp") ?></label>

            <input type="checkbox" class="lang-selector" id="lang-check-en" name="lang-en" value="en"><label for="lang-check-en"><img style="height: 16px; position:relative; top: 4px;" src="<? echo $flagEn ?>"><? _e("English", "guestapp") ?></label>

            <input type="checkbox" class="lang-selector" id="lang-check-de" name="lang-de" value="de"><label for="lang-check-de"><img style="height: 16px; position:relative; top: 4px;" src="<? echo $flagDe ?>"><? _e("German", "guestapp") ?></label>

            <input type="checkbox" class="lang-selector" id="lang-check-es" name="lang-es" value="es"><label for="lang-check-es"><img style="height: 16px; position:relative; top: 4px;" src="<? echo $flagEs ?>"><? _e("Spanish", "guestapp") ?></label>

            <input type="checkbox" class="lang-selector" id="lang-check-nl" name="lang-nl" value="nl"><label for="lang-check-nl"><img style="height: 16px; position:relative; top: 4px;" src="<? echo $flagNl ?>"><? _e("Dutch", "guestapp") ?></label>

            <br>

        </div>
        <h3><? _e("Amount of reviews to show", "guestapp") ?></h3>
        <select class="widefat" id="review-qty">
            <option value="5"><? _e("5 reviews") ?></option>
            <option value="10"><? _e("10 reviews") ?></option>
            <option value="30"><? _e("30 reviews") ?></option>
            <option value="50"><? _e("50 reviews") ?></option>
            <option value="100"><? _e("100 reviews") ?></option>
        </select><br>

        <h3><? _e("Appearance", "guestapp") ?></h3>

        <br>

        <label>
            <? _e("Theme", "guestapp") ?>
        </label><br>
        <select id="colorpicker" class="widefat">
            <option value="dark"> <? _e("Dark", "guestapp") ?></option>
            <option value="light"> <? _e("Light", "guestapp") ?></option>
        </select><br><br>

        <label>
            <? _e("Note display", "guestapp") ?>
        </label><br>
        <select id="note-visualisation" class="widefat">
            <option value="note" id="note"> <? _e("Note", "guestapp") ?></option>
            <option value="stars" id="stars"> <? _e("Stars", "guestapp") ?></option>
            <option value="both" id="both"> <? _e("Notes & Stars", "guestapp") ?></option>
        </select><br><br>
        <input type="radio" checked id="normal" name="display-type"><label for="normal"><?_e("Normal", "guestapp")?></label>
        <input type="radio" id="compact-widget" name="display-type"><label for="compact-widget"><?_e("Compact", "guestapp")?></label><br>
        <input type="checkbox" id="noshow-averages" name="display-type"><label for="noshow-averages"><?_e("Do not show averages", "guestapp")?></label>

        <span id="plugin_url" style="display:none"> <? echo plugin_dir_url(__FILE__); ?></span>

        <button class="button wide button-primary" style="width: 100%; text-align: center;" onclick='getShortcode(); tb_close()'>
            <? _e("Insert", "guestapp") ?>
        </button>

        <h3><? _e("Preview", "guestapp") ?></h3>
        <img id="guestapp-widget-preview" style="display: block; margin: 0 auto;">

        <script>
            getPreview();
        </script>
    </div>
</div>
<a href="#TB_inline?width=800&inlineId=guestapp-modal" class="thickbox button">GuestApp</a>
