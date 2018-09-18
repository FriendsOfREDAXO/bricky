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

    private $grids = [
        '12',
        '6-6',
        '8-4',
        '4-8',
        '4-4-4',
        '6-3-3',
        '3-6-3',
        '3-3-6',
        '3-3-3-3',
    ];

    private $views = [
        'NORMAL',
        'SLICES',
    ];


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

    public function getGrids()
    {
        return $this->grids;
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
            '<?php'."\n".
            "\n".
            'use Bricky\Bricky;'."\n".
            "\n".
            'echo Bricky::getModule(\'REX_MODULE_ID\')->getInput(1);'."\n";
    }

    public static function getModuleOutput()
    {
        return
            '<?php'."\n".
            "\n".
            'use Bricky\Bricky;'."\n".
            "\n".
            'echo Bricky::getModule(\'REX_MODULE_ID\')->getOutput(\rex_var::toArray(\'REX_VALUE[1]\'));'."\n";
    }
}
