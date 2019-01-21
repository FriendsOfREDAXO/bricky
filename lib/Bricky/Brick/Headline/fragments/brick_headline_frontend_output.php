<?php

$text = $this->getVar('TEXT', '');
$tag = $this->getVar('TAG', '');

if ($this->getVar('SHOW', '') == 'true') {
    if ($this->getVar('TEXT', '') != '') {
        echo '<' . $tag . ' class="headline" >' . $text . '</' . $tag . '>';
    }
}