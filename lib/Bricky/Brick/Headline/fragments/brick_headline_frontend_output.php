<?php

$text = $this->getVar('TEXT', '');
$tag = $this->getVar('TAG', '');

if ($text != '') {
    echo '<' . $tag . ' class="headline" >' . $text . '</' . $tag . '>';
}