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

class Module
{
    const TABLE_NAME = 'bricky_module';

    private static $cacheLoaded = false;
    private static $modules = [];

    private $bricks;
    private $grids;
    private $maxCtypes;
    private $minCtypes;
    private $module_id;
    private $view;

    private $ctypesOrder;
    private $selectedGrid;


    private function __construct()
    {

    }

    public function getBricks()
    {
        $registeredBricks = Bricky::getInstance()->getBricks();
        if (!$registeredBricks) {
            return null;
        }

        $moduleBricks = [];
        foreach ($registeredBricks as $registeredBrick) {
            if (in_array($registeredBrick->getClassName(), $this->bricks)) {
                $moduleBricks[] = $registeredBrick;
            }
        }

        return $moduleBricks;
    }

    public function getGrid()
    {
    }

    public function validateValueId($valueId)
    {
        $valueId = (int)$valueId;
        if ($valueId < 1 || $valueId >= 20) {
            return null;
        }
        return $valueId;
    }

    public function getInput()
    {
        $bricks = $this->getBricks();
        //if(!$bricks || !$this->validateValueId($valueId)) {
        //    return null;
        //}

        $form = '';
        // select für die Slices darstellung
        $bricksSelectOptions = [];
        foreach ($bricks as $brick) {
            $prefixedName = $brick->getPrefixedName();

            // Key-Value-Pair vertauscht überegben, damit später korrekt alphabetisch sortiert werden kann
            $bricksSelectOptions['- '.rex_escape($brick->getName())] = rex_escape($brick->getClassName());

            $brickForm = sprintf('
                <fieldset class="form-horizontal" data-bricky-selectable="%s">
                    <legend>%s</legend>
                    %s
                </fieldset>            
            ', rex_escape($brick->getClassName()), rex_escape($brick->getName()), $brick->getInput());

            // Widgets finden und anpassen
            preg_match_all('@(?<complete>BRICK_(?<widget>MEDIA|MEDIALIST|LINK|LINKLIST)\[(?<args>.*?)\])@', $brickForm, $matches, PREG_SET_ORDER | PREG_OFFSET_CAPTURE);
            if ($matches) {
                foreach ($matches as $match) {
                    $args = \rex_string::split($match['args'][0]);
                    if (!isset($args['id'])) {
                        continue;
                    }
                    $id = $args['id'];
                    unset($args['id']);

                    $widgetClass = '\rex_var_'.strtolower($match['widget'][0]);
                    $widget = $widgetClass::getWidget(
                        $id,
                        'REX_INPUT_VALUE[{{{ VALUE_ID }}}][0]['.$prefixedName.$match['widget'][0].'_'.$id.']',
                        '', // kein Value übergeben, wird von MBlock gesetzt
                        $args);
                    $brickForm = str_replace($match['complete'][0], $widget, $brickForm);
                }
            }

            // Inputs finden und anpassen
            $brickForm = str_replace('BRICK_INPUT_VALUE[', 'REX_INPUT_VALUE[{{{ VALUE_ID }}}][0]['.$prefixedName, $brickForm);
            $form .= $brickForm;
        }

        if ($this->isSliceView()) {
            // alphabetisch sortieren und Key-Value-Pair vertauschen, damit rex_select korrekt value und label setzen kann
            ksort($bricksSelectOptions);
            $bricksSelectOptions = array_flip($bricksSelectOptions);

            $bricksSelect = new \rex_select();
            $bricksSelect->setName('REX_INPUT_VALUE[{{{ VALUE_ID }}}][0][BRICK_SELECT]');
            $bricksSelect->addOption('Brick wählen', '');
            $bricksSelect->addOptions($bricksSelectOptions);

            $bricksSelectForm = sprintf('
                <fieldset class="form-horizontal select_bricky" data-bricky-select-a-brick>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Auswahl</label>
                        <div class="col-md-3">
                            <div class="rex-select-style">
                                %s
                            </div>
                        </div>
                    </div>
                </fieldset>            
            ', $bricksSelect->get());

            /*
            $bricksSelectForm = sprintf('
                <fieldset class="form-horizontal" data-bricky-select-a-brick>
                    <legend>kein Element ausgewählt</legend>
                    <div class="form-group">
                        <label class="col-md-2 control-label">Auswahl</label>
                        <div class="col-md-3">
                            <div class="rex-select-style">
                                %s
                            </div>
                        </div>
                    </div>
                </fieldset>            
            ', $bricksSelect->get());
            */

            $form = $bricksSelectForm.$form;
        }

        $ctypes = [];
        for ($i = 1; $i <= $this->maxCtypes; $i++) {
            $ctypes[$i] = \MBlock::show($i, str_replace('{{{ VALUE_ID }}}', $i, $form));
        }

        $fragment = new \rex_fragment();
        $fragment->setVar('minCtypes', $this->minCtypes);
        $fragment->setVar('maxCtypes', $this->maxCtypes);
        $fragment->setVar('grids', $this->grids);
        $fragment->setVar('view', $this->view);
        $fragment->setVar('selectedGrid', $this->selectedGrid);
        $fragment->setVar('ctypes', $ctypes, false);
        $fragment->setVar('ctypesOrder', $this->ctypesOrder);

        return $fragment->parse('bricky_module_input.php');
    }

    public function getOutput(array $blocks)
    {
        if (\rex::isBackend()) {
            return $this->getBackendOutput($blocks);
        }
        return $this->getFrontendOutput($blocks);
    }

    public function getBackendOutput(array $blocks)
    {
        return $this->generateOutput($blocks, 'getBackendOutput');
    }

    public function getFrontendOutput(array $blocks)
    {
        return $this->generateOutput($blocks, 'getFrontendOutput');
    }

    protected function generateOutput(array $blocks, $method)
    {
        $bricks = $this->getBricks();
        if(!$bricks) {
            return null;
        }

        $blocks = $this->normalizeOutputBlocks($blocks);

        $blockKeys = array_flip(array_keys($blocks[0]));

        // alle im Modul verwendeten Bricks sammeln
        $usedBricks = [];
        foreach ($bricks as $brick) {
            if (isset($blockKeys[$brick->getPrefixedName()])) {
                $usedBricks[$brick->getPrefixedName()] = $brick;
            }
        }

        $output = '';
        foreach ($blocks as $blockIndex => $block) {
            foreach ($block as $brickPrefixedName => $blockValues) {
                if (!isset($usedBricks[$brickPrefixedName])) {
                    // Slices können noch Bricks enthalten,
                    // die nicht mehr zum Modul gehören
                    continue;
                }
                $brick = $usedBricks[$brickPrefixedName];
                $output .= $brick->{$method}($blockValues);
            }
        }

        return $output;
    }

    /**ctype-
     * Erstellt ein nested Array anhand des Prefixes
     *  $blocks = [
     *      0 => [
     *          'CARD__TITLE' => 'Title'
     *          'CARD__TEXT' => 'Description text'
     *      ]
     *  ]
     *
     *  return [
     *      0 => [
     *          'CARD__' => [
     *              'TITLE' => 'Title'
     *              'TEXT' => 'Description text'
     *          ]
     *      ]
     *  ]
     *
     * @param array $blocks
     *
     * @return array
     */
    protected function normalizeOutputBlocks(array $blocks)
    {
        foreach ($blocks as $blockIndex => $block) {
            foreach ($block as $blockKey => $blockValue) {
                $pos = strpos($blockKey, Brick::PREFIX) + strlen(Brick::PREFIX);
                $key = substr($blockKey, 0, $pos);
                $subKey = substr($blockKey, $pos);
                $blocks[$blockIndex][$key][$subKey] = $blockValue;
                unset($blocks[$blockIndex][$blockKey]);
            }
        }
        return $blocks;
    }

    public function setCtypesOrder($value)
    {
        $this->ctypesOrder = $value;
        return $this;
    }

    public function setSelectedGrid($value)
    {
        $this->selectedGrid = $value;
        return $this;
    }

    protected function isSliceView()
    {
        return $this->view == 'SLICES';
    }

    /**
     * Returns the module object for the given id.
     *
     * @param int $id Profile id
     *
     * @return self
     */
    public static function get($id)
    {
        if (self::exists($id)) {
            return self::$modules[$id];
        }
        return null;
    }

    /**
     * Checks if the given module exists.
     *
     * @param int $id Profile id
     *
     * @return bool
     */
    public static function exists($id)
    {
        self::checkCache();
        return isset(self::$modules[$id]);
    }

    /**
     * Loads the cache if not already loaded.
     */
    private static function checkCache()
    {
        if (self::$cacheLoaded) {
            return;
        }

        $file = \rex_path::addonCache('bricky', 'modules.cache');
        if (!file_exists($file)) {

            $sql = \rex_sql::factory();
            $sql->setQuery('SELECT * FROM '.\rex::getTable(self::TABLE_NAME));

            $brickyModules = [];
            /* @var $brickyModule \rex_sql */
            foreach ($sql as $brickyModule) {
                $id = $brickyModule->getValue('module_id');
                foreach ($sql->getFieldnames() as $fieldName) {
                    switch ($fieldName) {
                        case 'id':
                        case 'module_name':
                            break;
                        case 'createdate':
                        case 'updatedate':
                            $brickyModules[$id][$fieldName] = $sql->getDateTimeValue($fieldName);
                            break;
                        case 'bricks':
                            $brickyModules[$id][$fieldName] = explode('|', trim($brickyModule->getValue($fieldName), '|'));
                            break;
                        case 'grids':
                            $grids = explode('|', trim($brickyModule->getValue($fieldName), '|'));
                            $availableGrids = Bricky::getInstance()->getAvailableGrids();
                            foreach ($grids as $index => $grid) {
                                if (!in_array($grid, $availableGrids)) {
                                    unset($grids[$index]);
                                }
                            }

                            $minCtypes = 1;
                            $maxCtypes = 1;
                            if (count($grids) < 1) {
                                $grids = null;
                            } else {
                                $min = 1;
                                $max = 1;
                                foreach ($grids as $grid) {
                                    $count = substr_count($grid, '-') + 1;
                                    $min = $count > $min ? $min : $count;
                                    $max = $count > $max ? $count : $max;
                                }
                                $minCtypes = $min;
                                $maxCtypes = $max;
                            }

                            $brickyModules[$id][$fieldName] = $grids;
                            $brickyModules[$id]['minCtypes'] = $minCtypes;
                            $brickyModules[$id]['maxCtypes'] = $maxCtypes;
                            break;
                        default:
                            $brickyModules[$id][$fieldName] = $brickyModule->getValue($fieldName);
                            break;
                    }
                }
            }
            $file = \rex_path::addonCache('bricky', 'modules.cache');
            if (\rex_file::putCache($file, $brickyModules) === false) {
                throw new \rex_exception('Bricky cache file could not be generated');
            }
        }

        foreach (\rex_file::getCache($file) as $id => $data) {
            $module = new self();
            foreach ($data as $key => $value) {
                $module->$key = $value;
            }
            self::$modules[$id] = $module;
        }
        self::$cacheLoaded = true;
    }

    public static function deleteCache()
    {
        $file = \rex_path::addonCache('bricky', 'modules.cache');
        \rex_file::delete($file);
    }
}