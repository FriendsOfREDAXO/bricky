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


    public function addElement(Brick $instance)
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


    public function getBackendOutput(array $blocks)
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
                $brick = $usedBricks[$brickPrefixedName];
                $output .= $brick->getBackendOutput($blockValues);
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
}
