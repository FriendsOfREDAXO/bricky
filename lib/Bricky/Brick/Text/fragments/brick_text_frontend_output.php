<?php

if ($this->getVar('SHOW', '') == 'true') {

    if ($this->getVar('TEXT', '') != '') {
        echo $this->getVar('TEXT', '');
    }
}