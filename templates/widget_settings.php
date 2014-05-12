<p>
    <label for="<? echo $titleId ?>">
        <? _e("title", "guestapp") ?> : 
    </label>
    <input class="widefat" id="<? echo $titleId ?>" name="<? echo $titleName ?>" type="text" value="<? echo $title ?>">

    <label for="<? echo $amountId ?>">
        <? _e("review_count", 'guestapp') ?> : 
    </label><br>
    <select class="widefat" value="<? echo $amount ?>" id="<? echo $amountId ?>" name="<? echo $amountName ?>">
        <option value="5" <? echo ($amount == 5 ? "selected" : "") ?>><? _e("reviews5", "guestapp") ?></option>
        <option value="10" <? echo ($amount == 10 ? "selected" : "") ?>><? _e("reviews10", "guestapp") ?></option>
        <option value="30" <? echo ($amount == 30 ? "selected" : "") ?>><? _e("reviews30", "guestapp") ?></option>
        <option value="50" <? echo ($amount == 50 ? "selected" : "") ?>><? _e("reviews50", "guestapp") ?></option>
        <option value="100" <? echo ($amount == 100 ? "selected" : "") ?>><? _e("reviews100", "guestapp") ?></option>
    </select><br>

    <label for="<? echo $langId ?>">
        <? _e("lang", "guestapp") ?>
    </label><br>
    <select class="widefat" id="<? echo $langId ?>" name="<? echo $langName ?>" value="<? echo $lang ?>">
        <option value="any" <? echo ($lang == 'any' ? "selected" : "") ?>><? _e("any", "guestapp") ?></option>
        <option value="de" <? echo ($lang == 'de' ? "selected" : "") ?>><? _e("de", "guestapp") ?></option>
        <option value="fr" <? echo ($lang == 'fr' ? "selected" : "") ?>><? _e("fr", "guestapp") ?></option>
        <option value="en" <? echo ($lang == 'en' ? "selected" : "") ?>><? _e("en", "guestapp") ?></option>
        <option value="nl" <? echo ($lang == 'nl' ? "selected" : "") ?>><? _e("nl", "guestapp") ?></option>
        <option value="es" <? echo ($lang == 'es' ? "selected" : "") ?>><? _e("es", "guestapp") ?></option>
    </select><br>
    <hr>
    <h3>Style</h3>

    <label for="<? echo $colorId ?>">
        <? _e("color", "guestapp") ?>
    </label><br>
    <select class="widefat" id="<? echo $colorId ?>" name="<? echo $colorName ?>" value="<? echo $color ?>">
        <option value="dark" <? echo ($color == "dark" ? "selected" : "") ?>> <? _e("dark", "guestapp") ?></option>
        <option value="light" <? echo ($color == "light" ? "selected" : "") ?>> <? _e("light", "guestapp") ?></option>
    </select>

    <label>
        <? _e("note_visual", "guestapp") ?>
    </label><br>
    <select id="<? echo $noteId ?>" name="<? echo $noteName ?>" class="widefat">
        <option value="note" <? echo ($note == "note" ? "selected" : "") ?>> <? _e("note", "guestapp") ?></option>
        <option value="stars" <? echo ($note == "stars" ? "selected" : "") ?>> <? _e("stars", "guestapp") ?></option>
        <option value="both" <? echo ($note == "both" ? "selected" : "") ?>> <? _e("both", "guestapp") ?></option>
    </select><br><br>


    <label for="<? echo $typeId ?>">
        <? _e("type", "guestapp"); ?>
    </label><br>
    <input type="radio" value="0" name="<? echo $typeName ?>" <? echo ($type == "0" ? "checked" : "") ?> >Normal</input>
    <input type="radio" value="1" name="<? echo $typeName ?>" <? echo ($type == "1" ? "checked" : "") ?> >Compact</input><br>

    <div style="display: none">
        <label for="<? echo $numberId ?>" title="<? _e('help_widget_id', 'guestapp') ?>">
            <? _e("widget_id", "guestapp") ?> :
        </label>
        <input disabled type="number" id="<? echo $numberId ?>" name="<? echo $numberName ?>" value="<? echo $number ?>" /><br>
    </div>
</p>