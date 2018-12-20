<?php

if ($this->getVar('TEXT', '') != '') {

    echo '
      <h3>Überschrift</h3>
      <div class="form-group">
          <label class="col-sm-3 control-label">Überschrift</label>
          <div class="col-sm-9">
          ' . $this->getVar('TEXT') . '
          </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label">Art der Überschrift</label>
        <div class="col-sm-9">';
    switch ($this->getVar('TAG')) {
        case 'h1':
            echo 'Überschrift 1 (H1) - Nur einmal pro Seite verwenden';
            break;
        case 'h2':
            echo 'Überschrift 2 (H2)';
            break;
        case 'h3':
            echo 'Überschrift 3 (H3)';
            break;
        case 'h4':
            echo 'Überschrift 4 (H4)';
            break;
        case 'h5':
            echo 'Überschrift 5 (H5)';
            break;
        case 'h6':
            echo 'Überschrift 6 (H6)';
            break;
    }
    echo '
        </div>
      </div>';
}




