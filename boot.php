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
use Bricky\Bricky;

Bricky::getInstance()->addElement(new Card());
Bricky::getInstance()->addElement(new Headline());
Bricky::getInstance()->addElement(new Image());

if (rex::isBackend() && rex::getUser()) {
    //Bricky::boot();
}
