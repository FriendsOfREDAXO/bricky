<?php


if ($this->getVar('TEXT', '') != '') {
    if ($this->getVar('TEXT', '') != '<p>&nbsp;</p>') { // CKE5 Editor Fix
    echo '
      <h3>Text</h3>
      <div class="form-group">
          <label class="col-sm-3 control-label">Text</label>
          <div class="col-sm-9">
          ' . $this->getVar('TEXT') . '
          </div>
      </div>
      ';
    }
}




