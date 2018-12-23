<?php

/**
 * This file is part of the Bricky package.
 *
 * @author (c) Friends Of REDAXO
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bricky;

use Bricky\Brick\Brick;

class Bricky
{
    use \rex_singleton_trait;

    /**
     * Array of all bricks.
     *
     * @var Brick[]
     */
    private $bricks = [];

    private $availableGrids = [
        '12',
        '6-6',
        '4-4-4',
        '3-3-3-3',
        '6-3-3',
        '3-6-3',
        '3-3-6',
        '10-2',
        '9-3',
        '8-4',
        '7-5',
        '2-10',
        '3-9',
        '4-8',
        '5-7'
    ];

    private $views = [
        'NORMAL',
        'SLICES',
    ];

    const VALUE_ID_CTYPES_ORDER = 19;
    const VALUE_ID_SELECTED_GRID = 20;

    public function addBrick(Brick $instance)
    {
        $this->bricks[] = $instance;
        \rex_fragment::addDirectory($instance->getFragmentDir());
    }


    public function getBricks()
    {
        if (!count($this->bricks)) {
            return null;
        }

        return $this->bricks;
    }

    public function getAvailableGrids()
    {
        return $this->availableGrids;
    }

    public function getViews()
    {
        return $this->views;
    }

    public static function getModule($moduleId)
    {
        return Module::get($moduleId);
    }

    public static function getModuleInput()
    {
        return
            '<?php' . "\n" .
            "\n" .
            'use Bricky\Bricky;' . "\n" .
            "\n" .
            'echo Bricky::getModule(\'REX_MODULE_ID\')' . "\n" .
            '    ->setCtypesOrder(\'REX_VALUE[' . self::VALUE_ID_CTYPES_ORDER . ']\')' . "\n" .
            '    ->setSelectedGrid(\'REX_VALUE[' . self::VALUE_ID_SELECTED_GRID . ']\')' . "\n" .
            '    ->getInput();' . "\n";
    }

    public static function getModuleOutput()
    {
        return
            '<?php' . "\n" .
            "\n" .
            'use Bricky\Bricky;' . "\n" .
            "\n" .
            '$ctypesOrderOutput = explode(\',\',\'REX_VALUE[19]\');' . "\n" .
            "\n" .
            'if ($ctypesOrderOutput[0] == \'\') {'."\n" .
            ' $ctypesOrderOutput = array(1,2,3,4);'. "\n" .
            '};' . "\n".
            "\n" .
            ' $gridOutput   = \'REX_VALUE[20]\';'. "\n" .
            ' $gridCount = explode(\'-\', $gridOutput);'. "\n" .
            "\n" .
            ' $rex_value[1] = \'REX_VALUE[1]\';'. "\n" .
            ' $rex_value[2] = \'REX_VALUE[2]\';'. "\n" .
            ' $rex_value[3] = \'REX_VALUE[3]\';'. "\n" .
            ' $rex_value[4] = \'REX_VALUE[4]\';'. "\n".
            "\n".
            '$i = 0;'. "\n".
            'foreach ($ctypesOrderOutput as $v) {'. "\n".
            '  if(++$i > count($gridCount)) break;'. "\n".
            '    if ($rex_value[$v] != \'\' ) {'."\n".
            '      if(rex::isBackend()) {'. "\n".
            '        echo \'<div class="form-horizontal bricky_backend_output">\';'."\n".
            '        echo \'<h4>Bereich \'.$i.\'</h4>\';'. "\n".
            '        echo Bricky::getModule(\'REX_MODULE_ID\')->getOutput(\rex_var::toArray($rex_value[$v]));'."\n".
            '        echo \'</div>\';'. "\n".
            '      } else {'."\n".
            '        echo Bricky::getModule(\'REX_MODULE_ID\')->getOutput(\rex_var::toArray($rex_value[$v]));'."\n".
            '    }'. "\n".
            '  }'."\n".
            '}'. "\n";
    }
}