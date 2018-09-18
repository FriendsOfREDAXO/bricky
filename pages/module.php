<?php

/**
 * This file is part of the Bricky package.
 *
 * @author (c) Friends Of REDAXO
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Bricky\Bricky;
use Bricky\Module;

$id = rex_request('id', 'int');
$func = rex_request('func', 'string');
$action = rex_request('action', 'string');

if ($action == 'cache') {
    Module::deleteCache();
}

if ($func == '') {
    $query = '  SELECT      `b`.`id`,
                            `b`.`module_id`,
                            `m`.`name`,
                            `b`.`bricks` 
                FROM        '.rex::getTable(Module::TABLE_NAME) .' AS b
                LEFT JOIN   '.rex::getTable('module').' AS m
                    ON      `b`.`module_id` = `m`.`id`
                ';

    $list = rex_list::factory($query);
    $list->addTableAttribute('class', 'table-striped');

    $tdIcon = '<i class="rex-icon fa fa-gears"></i>';
    $thIcon = '<a href="'.$list->getUrl(['func' => 'add']).'"><i class="rex-icon rex-icon-add-article"></i></a>';
    $list->addColumn($thIcon, $tdIcon, 0, ['<th class="rex-table-icon">###VALUE###</th>', '<td class="rex-table-icon">###VALUE###</td>']);
    $list->setColumnParams($thIcon, ['func' => 'edit', 'id' => '###id###']);

    $list->setColumnLabel('id', rex_i18n::msg('id'));
    $list->setColumnLayout('id', ['<th class="rex-table-id">###VALUE###</th>', '<td class="rex-table-id" data-title="'.rex_i18n::msg('id').'">###VALUE###</td>']);

    $list->setColumnLabel('module_id', $this->i18n('module_id'));
    $list->setColumnLabel('name', $this->i18n('module_name'));

    $list->addColumn($this->i18n('function'), '<i class="rex-icon rex-icon-edit"></i> '.$this->i18n('edit'));
    $list->setColumnLayout($this->i18n('function'), ['<th class="rex-table-action" colspan="2">###VALUE###</th>', '<td class="rex-table-action">###VALUE###</td>']);
    $list->setColumnParams($this->i18n('function'), ['func' => 'edit', 'id' => '###id###']);

    $content = $list->get();

    $fragment = new rex_fragment();
    $fragment->setVar('title', $this->i18n('modules'));
    $fragment->setVar('content', $content, false);
    $content = $fragment->parse('core/page/section.php');

    echo $content;
} elseif ($func == 'add' || $func == 'edit') {
    $title = $func == 'edit' ? $this->i18n('edit') : $this->i18n('add');

    $form = rex_form::factory(rex::getTable('bricky_module'), '', 'id = '.$id, 'post', false);
    $form->addParam('id', $id);
    $form->addParam('action', 'cache');
    $form->setApplyUrl(rex_url::currentBackendPage());
    $form->setEditMode($func == 'edit');
    $form->addErrorMessage(REX_FORM_ERROR_VIOLATE_UNIQUE_KEY, $this->i18n('bricky_module_exists'));

    if ($func == 'add') {
        $field = $form->addTextField('module_name');
    } else {
        $value = $this->i18n('module_not_exists');
        $sql = rex_sql::factory();
        $module = $sql->getArray('SELECT `m`.`name` FROM '.rex::getTable(Module::TABLE_NAME) .' AS b LEFT JOIN   '.rex::getTable('module').' AS m ON `b`.`module_id` = `m`.`id` WHERE `b`.`id` = :id LIMIT 1', ['id' => $id]);
        if (isset($module[0]['name'])) {
            $value = $module[0]['name'];
        }
        $field = $form->addReadOnlyField('module_name', $value);
    }
    $field->setLabel($this->i18n('module_name'));


    $field = $form->addSelectField('bricks');
    $field->setLabel($this->i18n('bricks_registered'));
    $field->setNotice($this->i18n('bricks_select_notice'));
    $select = $field->getSelect();
    $select->setMultiple();

    $registeredBricks = [];
    foreach (Bricky::getInstance()->getBricks() as $brick) {
        $select->addOption($brick->getName(), $brick->getClassName());
        $registeredBricks[$brick->getClassName()] = $brick->getName();
    }

    $field = $form->addReadOnlyField('bricks');
    $field->setAttribute('class', 'hidden');
    $savedBricks =  explode('|', trim($field->getValue(), '|'));
    foreach ($savedBricks as $index => $savedBrick) {
        if (isset($registeredBricks[$savedBrick])) {
            $savedBricks[$index] = $registeredBricks[$savedBrick];
        }
    }
    $field = $form->addRawField(
        sprintf(
            '<dl class="rex-form-group form-group">
                <dt><label class="control-label">%s</label></dt>
                <dd><pre class="rex-code">%s</pre></dd>
            </dl>', $this->i18n('bricks_saved'), implode('<br />', $savedBricks))
    );

    $content = $form->get();

    $fragment = new rex_fragment();
    //$fragment->setVar('title', $title);
    $fragment->setVar('body', $content, false);
    $content = $fragment->parse('core/page/section.php');

    echo $content;
}

