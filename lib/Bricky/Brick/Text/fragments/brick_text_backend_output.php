<?php

if ($this->getVar('SHOW', '') == 'true') {

    if ($this->getVar('TEXT', '') != '') {
        $text = $this->getVar('TEXT', '');
    } else {
        $text = '<span class="alert">Bitte einen Text eingeben!<span>';
    }

    echo '
      <h3>Text</h3>
      <div class="form-group">
          <label class="col-sm-3 control-label">Text</label>
          <div class="col-sm-9">
          ' . $text . '
          </div>
      </div>
      ';
}