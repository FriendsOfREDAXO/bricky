<div class="bricky-module-input" data-bricky="module">
    <input data-bricky="ctypesOrder" type="hidden" name="REX_INPUT_VALUE[<?= Bricky\Bricky::VALUE_ID_CTYPES_ORDER ?>]" value="<?= $this->ctypesOrder ?>" />
    <div class="nav rex-page-nav">
        <ul class="nav nav-tabs" data-bricky="ctypes">
            <?php
            $ctypesOrderNew = explode(',',$this->ctypesOrder);
            if ($ctypesOrderNew =='') {
                $ctypesOrderNew = '1,2,3,4';
            }
            for ($i = 1; $i <= $this->maxCtypes; $i++):

                $ctypeID = $ctypesOrderNew[($i-1)];



            ?>
                <li data-id="<?= $ctypeID ?>">
                <a id="tab-<?= $ctypeID ?>" href="#bricky-ctype-content-<?= $ctypeID ?>" data-toggle="tab">
                    <i>B<?= $ctypeID ?></i>
                    <span>Bereich <?= $ctypeID ?></span>
                </a>
            </li>
            <?php endfor; ?>
            <?php if (!empty($this->getVar('grids', []))): ?>
            <li class="pull-right" data-bricky="ctypeGrid" data-bricky-ctype="locked">
                <a href="#bricky-ctype-content-settings" data-toggle="tab">
                    <i class="rex-icon rex-icon-metafuncs"></i>
                    <span><?= rex_i18n::msg('bricky_module_input_ctype_settings') ?></span>
                </a>
            </li>
            <?php endif ?>
        </ul>
    </div>

    <div class="tab-content">
        <?php foreach ($this->getVar('ctypes', []) as $index => $ctype): ?>
        <div class="tab-pane fade in" id="bricky-ctype-content-<?= $index ?>">
            <div data-bricky-view="<?= $this->getVar('view')?>">
                <?= $ctype ?>
            </div>
        </div>
        <?php endforeach; ?>

        <?php if (!empty($this->getVar('grids', []))): ?>
        <div class="tab-pane fade in" id="bricky-ctype-content-settings">
            <fieldset class="form-horizontal">
                <legend><?= rex_i18n::msg('bricky_module_input_ctype_settings_grid') ?></legend>
                <input data-bricky="selectedGrid" type="hidden" value="<?= $this->selectedGrid ?>" />
                <div class="form-group" data-bricky="grids">
                    <label class="col-sm-2 control-label"><?= rex_i18n::msg('bricky_module_input_ctype_settings_select') ?></label>
                    <div class="col-sm-10">
                        <div class="bricky-module-input-grid-items">
                        <?php foreach ($this->getVar('grids', []) as $index => $grid): ?>
                            <label class="bricky-module-input-grid-item" data-bricky-grid="<?= $grid ?>">
                                <input name="REX_INPUT_VALUE[<?= Bricky\Bricky::VALUE_ID_SELECTED_GRID ?>]" value="<?= $grid ?>" type="radio"<?= $grid == $this->selectedGrid ? 'checked="checked"' : '' ?>/>
                                <span class="bricky-module-input-grid-item-view">
                                    <?php foreach (explode('-', $grid) as $number): ?>
                                        <span></span>
                                    <?php endforeach; ?>
                                </span>
                            </label>
                        <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>
        <?php endif ?>
    </div>
</div>
