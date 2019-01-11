<?php
if ($this->getVar('TEXT', '') != '') {
    if ($this->getVar('TEXT', '') != '<p>&nbsp;</p>') { // CKE5 Editor Fix
        echo $this->getVar('TEXT', '');
    }
}
