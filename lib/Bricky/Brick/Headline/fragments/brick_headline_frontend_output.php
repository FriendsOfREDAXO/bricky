<?php

$text = $this->getVar('TEXT', '');
$tag = $this->getVar('TAG', '');

echo '<' . $tag . ' class="headline" >' . $text . '<' . $tag . '>';