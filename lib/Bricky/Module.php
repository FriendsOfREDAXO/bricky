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
    private $module_id;


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

    public function validateValueId($valueId)
    {
        $valueId = (int)$valueId;
        if ($valueId < 1 || $valueId >= 20) {
            return null;
        }
        return $valueId;
    }

    public function getInput($valueId)
    {
        $bricks = $this->getBricks();
        if(!$bricks || !$this->validateValueId($valueId)) {
            return null;
        }

        $form = '';
        foreach ($bricks as $brick) {
            $prefixedName = $brick->getPrefixedName();

            $brickForm = sprintf('
                <fieldset class="form-horizontal">
                    <legend>%s</legend>
                    %s
                </fieldset>            
            ', $brick->getName(), $brick->getInput());

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
                        'REX_INPUT_VALUE['.$valueId.'][0]['.$prefixedName.$match['widget'][0].'_'.$id.']',
                        '', // kein Value übergeben, wird von MBlock gesetztz
                        $args);
                    $brickForm = str_replace($match['complete'][0], $widget, $brickForm);
                }
            }

            $brickForm = str_replace('BRICK_INPUT_VALUE[', 'REX_INPUT_VALUE['.$valueId.'][0]['.$prefixedName, $brickForm);
            $form .= $brickForm;
        }

        return \MBlock::show($valueId, $form);
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
