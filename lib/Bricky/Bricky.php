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
            $form .= sprintf('
                <fieldset class="form-horizontal">
                    <legend>%s</legend>
                    %s
                </fieldset>            
            ', $brick->getName(), $brick->getInput());
        }

        $form = str_replace('BRICK_INPUT_VALUE', 'REX_INPUT_VALUE['.$valueId.'][0]', $form);
        return \MBlock::show($valueId, $form);
    }


    public function getBackendOutput(array $blocks)
    {
        $bricks = $this->getBricks();
        if(!$bricks) {
            return null;
        }

        $output = '';
        foreach ($blocks as $blockIndex => $block) {
            $searcher = [];
            $replacer = [];
            foreach ($block as $blockKey => $blockValue) {
                if (is_string($blockValue)) {
                    $searcher[] = 'BRICK_VALUE['.$blockKey.']';
                    $replacer[] = $blockValue;
                } elseif (is_array($blockValue)) {
                    foreach ($blockValue as $search => $replace) {
                        $searcher[] = 'BRICK_VALUE['.$blockKey.']['.$search.']';
                        $replacer[] = $replace;
                    }
                }
            }
            foreach ($bricks as $brick) {
                $parse = $brick->getBackendOutput();
                $output .= str_replace($searcher, $replacer, $parse);
            }
        }
        return $output;
    }
}
