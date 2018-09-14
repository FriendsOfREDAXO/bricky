<?php

/**
 * This file is part of the Bricky package.
 *
 * @author (c) Friends Of REDAXO
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Bricky\Brick;

class Headline extends Brick
{
    public function getName()
    {
        return 'Headline';
    }

    public function getInput()
    {
        $s = new \rex_select();
        $s->setName('BRICK_INPUT_VALUE[HEADLINE_TAG]');
        $s->addOptions(['h1' => 'H1', 'h2' => 'H2', 'h3' => 'H3']);
        return '
            <div class="form-group">
                <label class="col-md-3">
                    Text
                </label>
                <div class="col-md-6">
                    <input class="form-control" name="BRICK_INPUT_VALUE[HEADLINE_TEXT]" type="text" />
                </div>
                <div class="col-md-3">
                    <div class="rex-select-style">
                        '.$s->get().'
                    </div>
                </div>
            </div>';
    }

    public function getBackendOutput()
    {
        return $this->getFrontendOutput();
    }

    public function getFrontendOutput()
    {
        return sprintf('<%2$s>%1$s</%2$s>', 'BRICK_VALUE[HEADLINE_TEXT]', 'BRICK_VALUE[HEADLINE_TAG]');
    }

}
