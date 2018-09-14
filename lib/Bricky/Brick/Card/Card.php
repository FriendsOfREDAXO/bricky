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

class Card extends Brick
{
    public function getName()
    {
        return 'Karte';
    }

    public function getInput()
    {
        return '
            <div class="form-group">
                <label class="col-md-3">
                    Titel
                </label>
                <div class="col-md-9">
                    <input class="form-control" name="BRICK_INPUT_VALUE[CARD_TITLE]" type="text" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3">
                    Text
                </label>
                <div class="col-md-9">
                    <textarea class="form-control" name="BRICK_INPUT_VALUE[CARD_TEXT]" rows="6"></textarea>
                </div>
            </div>';
    }

    public function getBackendOutput()
    {
        return '<h2>BRICK_VALUE[CARD_TITLE]</h2><p>BRICK_VALUE[CARD_TEXT]</p>';
    }

    public function getFrontendOutput()
    {
        return '<h2>BRICK_VALUE[CARD_TITLE]</h2><p>BRICK_VALUE[CARD_TEXT]</p>';
    }

}
