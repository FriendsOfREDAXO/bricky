<?php

/**
 * This file is part of the Bricky package.
 *
 * @author (c) Friends Of REDAXO
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Bricky\Brick\Card;
use Bricky\Brick\Headline;
use Bricky\Brick\Image;
use Bricky\Brick\Video;
use Bricky\Bricky;

Bricky::getInstance()->addBrick(new Card());
Bricky::getInstance()->addBrick(new Headline());
Bricky::getInstance()->addBrick(new Image());
Bricky::getInstance()->addBrick(new Video());

\rex_fragment::addDirectory(\rex_path::addon('project', 'fragments/'));

if (rex::isBackend() && rex::getUser()) {
    rex_extension::register('REX_FORM_SAVED', function (rex_extension_point $ep) {
        $params = $ep->getParams();

        /* @var rex_form $form */
        $form = $params['form'];

        if ($form->getParam('page') != 'bricky/module') {
            return;
        }

        $sql = rex_sql::factory();
        $brickModules = $sql->getArray('SELECT id, module_name FROM '.rex::getTable('bricky_module').' WHERE module_id = "0"');
        if (!count($brickModules)) {
            return;
        }
        foreach ($brickModules as $brickModule) {
            $moduleSql = rex_sql::factory();
            $moduleSql->setTable(rex::getTable('module'));
            $moduleSql->setValue('input', Bricky::getModuleInput());
            $moduleSql->setValue('output', Bricky::getModuleOutput());
            $moduleSql->setValue('name', $brickModule['module_name']);
            $moduleSql->insert();
            $lastInsertModuleId = (int)$moduleSql->getLastId();

            $sql = rex_sql::factory();
            $sql->setTable(rex::getTable('bricky_module'));
            $sql->setWhere('id = :id', ['id' => $brickModule['id']]);
            $sql->setValue('module_id', $lastInsertModuleId);
            $sql->setValue('module_name', '');
            $sql->addGlobalUpdateFields();
            $sql->update();
        }
    });
}
