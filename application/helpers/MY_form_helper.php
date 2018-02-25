<?php

function form_dropdownpro($name = '', $objects = [], $valuefield, $textfield, $selected = [], $extra = '') {
    $options[0] = '-- Select --';
    foreach ($objects as $object) {
        $options[$object->{$valuefield}] = $object->{$textfield};
    }

    return form_dropdown($name, $options, $selected, $extra);
}

function form_radiogroup($name = '', $objects = [], $valuefield, $textfield) {
    $result = '';

    $i = 0;
    foreach ($objects as $object) {
        $data = array('name' => $name,
            'id' => $name . $i,
            'value' => $object->{$valuefield});

        $result .= "<div>" . form_radio($data) . $object->{$textfield} . "</div>\n";
        $i++;
    }

    return $result;
}

function form_labelpro($label_text, $id) {
    $attributes = array('class' => 'control-label');
    return form_label($label_text, $id, $attributes) . "\n";
}

function form_listboxpro($name = '', $objects = [], $valuefield, $textfield, $selected = [], $extra = []) {
    $options = [];
	foreach ($objects as $object) {
        $options[$object->{$valuefield}] = $object->{$textfield};
    }

    return form_dropdown($name, $options, $selected, $extra);
}

function form_glyphButton($button, $glyph){
    $extraButton = array('class' => "btn $button btn-lg btn-round");
    return form_button("knop", "<span class='glyphicon $glyph'></span>", $extraButton);
}
