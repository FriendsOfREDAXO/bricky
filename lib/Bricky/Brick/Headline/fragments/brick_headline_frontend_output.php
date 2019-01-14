<?php

$text = $this->getVar('TEXT', '');
$tag = $this->getVar('TAG', '');

if ($this->getVar('SHOW', '') == 'true') {
    echo '<' . $tag . ' class="headline" >' . $text . '</' . $tag . '>';
}