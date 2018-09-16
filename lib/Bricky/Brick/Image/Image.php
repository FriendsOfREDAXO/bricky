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

class Image extends Brick
{
    public function getName()
    {
        return 'Image';
    }

    public function getInput()
    {
        $s = new \rex_select();
        $s->setName('BRICK_INPUT_VALUE[CAPTION]');
        $s->addOptions(['0' => 'nein', '1' => 'ja']);
        return '
            <div class="form-group">
                <label class="col-md-3">
                    Bild
                </label>
                <div class="col-md-6">
                    BRICK_MEDIA[id=1 category=2]
                </div>
                <div class="col-md-3">
                    <div class="rex-select-style">
                        '.$s->get().'
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3">
                    Hover Bild
                </label>
                <div class="col-md-6">
                    BRICK_MEDIA[id=2]
                </div>
            </div>';
    }

    public function getBackendOutput(array $brickValues)
    {
        $return = '';
        $media = \rex_media::get($brickValues['MEDIA_1']);
        if ($media) {
            $return .= $media->toImage();
        }
        $media = \rex_media::get($brickValues['MEDIA_2']);
        if ($media) {
            $return .= $media->toImage();
        }
        return $return;
    }

    public function getFrontendOutput(array $brickValues)
    {
    }

}
