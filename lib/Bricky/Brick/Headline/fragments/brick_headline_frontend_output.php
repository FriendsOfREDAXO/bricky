<?php

    $text = $this->getVar('TEXT', '');
    $tag  = $this->getVar('TAG', '');

    echo '<'.$tag.'>'.$text.'<'.$tag.'>';