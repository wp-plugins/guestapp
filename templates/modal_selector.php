<div id="guestapp-modal" style="display:none; margin: 0 auto;">
    <h1 style="text-align: center">GuestApp Widget</h1>
    <div class="container">
        <div class="lang-selector">

            <h3><? _e("lang", "guestapp") ?></h3>
            <input type="checkbox" checked id="lang-check-all" name="lang-all" value="all"><label for="lang-check-all"><? _e("all", "guestapp") ?></label>

            <input type="checkbox" class="lang-selector" id="lang-check-fr" name="lang-fr" value="fr"><label for="lang-check-fr"><img style="height: 16px; position:relative; top: 4px;" src="<? echo $flagFr ?>"><? _e("fr", "guestapp") ?></label>

            <input type="checkbox" class="lang-selector" id="lang-check-en" name="lang-en" value="en"><label for="lang-check-en"><img style="height: 16px; position:relative; top: 4px;" src="<? echo $flagEn ?>"><? _e("en", "guestapp") ?></label>

            <input type="checkbox" class="lang-selector" id="lang-check-de" name="lang-de" value="de"><label for="lang-check-de"><img style="height: 16px; position:relative; top: 4px;" src="<? echo $flagDe ?>"><? _e("de", "guestapp") ?></label>

            <input type="checkbox" class="lang-selector" id="lang-check-es" name="lang-es" value="es"><label for="lang-check-es"><img style="height: 16px; position:relative; top: 4px;" src="<? echo $flagEs ?>"><? _e("es", "guestapp") ?></label>

            <input type="checkbox" class="lang-selector" id="lang-check-nl" name="lang-nl" value="nl"><label for="lang-check-nl"><img style="height: 16px; position:relative; top: 4px;" src="<? echo $flagNl ?>"><? _e("nl", "guestapp") ?></label>

            <br>
            
        </div>
        <h3><? _e("review_count", "guestapp") ?></h3>
        <select class="widefat" id="review-qty">
            <option value="5">5 avis</option>
            <option value="10">10 avis</option>
            <option value="30">30 avis</option>
            <option value="50">50 avis</option>
            <option value="100">100 avis</option>
        </select><br>
        
        <h3><? _e("appearance", "guestapp") ?></h3>
        
        <br>

        <label>
            <? _e("color", "guestapp") ?>
        </label><br>
        <select id="colorpicker" class="widefat">
            <option value="dark"> <? _e("dark", "guestapp") ?></option>
            <option value="light"> <? _e("light", "guestapp") ?></option>
        </select><br><br>

        <label>
            <? _e("note_visual", "guestapp") ?>
        </label><br>
        <select id="note-visualisation" class="widefat">
            <option value="note" id="note"> <? _e("note", "guestapp") ?></option>
            <option value="stars" id="stars"> <? _e("stars", "guestapp") ?></option>
            <option value="both" id="both"> <? _e("both", "guestapp") ?></option>
        </select><br><br>
        <input type="radio" checked id="normal" name="display-type"><label for="normal"><?_e("normal", "guestapp")?></label>
        <input type="radio" id="compact-widget" name="display-type"><label for="compact-widget"><?_e("compact_widget", "guestapp")?></label><br>
        <input type="checkbox" id="noshow-averages" name="display-type"><label for="noshow-averages"><?_e("noshow_average", "guestapp")?></label>

        <span id="plugin_url" style="display:none"> <? echo plugin_dir_url(__FILE__); ?></span>

        <button class="button wide button-primary" style="width: 100%; text-align: center;" onclick='getShortcode(); tb_close()'>
            <? _e("insert", "guestapp") ?>
        </button>

        <h3><? _e("preview", "guestapp") ?></h3>
        <img id="guestapp-widget-preview" style="display: block; margin: 0 auto;">

        <script>
            getPreview();
        </script>
    </div>
</div>
<a href="#TB_inline?width=800&inlineId=guestapp-modal" class="thickbox button">GuestApp</a>