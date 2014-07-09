<p>
    <label for="<? echo $titleId ?>">
        <? _e("title", "guestapp") ?> : 
    </label>
    <input class="widefat" id="<? echo $titleId ?>" name="<? echo $titleName ?>" type="text" value="<? echo $title ?>">

    <label for="<? echo $amountId ?>">
        <? _e("Amount of reviews to show", 'guestapp') ?> : 
    </label><br>
    <select class="widefat" value="<? echo $amount ?>" id="<? echo $amountId ?>" name="<? echo $amountName ?>">
        <option value="5" <? echo ($amount == 5 ? "selected" : "") ?>><? _e("5 reviews", "guestapp") ?></option>
        <option value="10" <? echo ($amount == 10 ? "selected" : "") ?>><? _e("10 reviews", "guestapp") ?></option>
        <option value="30" <? echo ($amount == 30 ? "selected" : "") ?>><? _e("30 reviews", "guestapp") ?></option>
        <option value="50" <? echo ($amount == 50 ? "selected" : "") ?>><? _e("50 reviews", "guestapp") ?></option>
        <option value="100" <? echo ($amount == 100 ? "selected" : "") ?>><? _e("100 reviews", "guestapp") ?></option>
    </select><br>

    <label for="<? echo $langId ?>">
        <? _e("Language", "guestapp") ?>
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
        <? _e("Theme", "guestapp") ?>
    </label><br>
    <select class="widefat" id="<? echo $colorId ?>" name="<? echo $colorName ?>" value="<? echo $color ?>">
        <option value="dark" <? echo ($color == "dark" ? "selected" : "") ?>> <? _e("Dark", "guestapp") ?></option>
        <option value="light" <? echo ($color == "light" ? "selected" : "") ?>> <? _e("Light", "guestapp") ?></option>
    </select>

    <label>
        <? _e("note_visual", "guestapp") ?>
    </label><br>
    <select id="<? echo $noteId ?>" name="<? echo $noteName ?>" class="widefat">
        <option value="note" <? echo ($note == "note" ? "selected" : "") ?>> <? _e("Note", "guestapp") ?></option>
        <option value="stars" <? echo ($note == "stars" ? "selected" : "") ?>> <? _e("Stars", "guestapp") ?></option>
        <option value="both" <? echo ($note == "both" ? "selected" : "") ?>> <? _e("Notes & Stars", "guestapp") ?></option>
    </select><br><br>


    <label for="<? echo $typeId ?>">
        <? _e("Type", "guestapp"); ?>
    </label><br>
    <input type="radio" value="0" name="<? echo $typeName ?>" <? echo ($type == "0" ? "checked" : "") ?> ><? _e("Normal", "guestapp") ?></input>
    <input type="radio" value="1" name="<? echo $typeName ?>" <? echo ($type == "1" ? "checked" : "") ?> ><? _e("Compact", "guestapp") ?></input><br>
    <input type="checkbox" <? echo $noavg == 'on' ? "checked" : "" ?> name="<? echo $noavgName ?>"><? _e("Do not show averages", "guestapp") ?>

    <div style="display: none;">
        <label for="<? echo $numberId ?>">
        </label>
        <input disabled class="uuid-input" type="text" id="<? echo $numberId ?>" name="<? echo $numberName ?>" value="<? echo $number ?>" /><br>
    </div>
</p>