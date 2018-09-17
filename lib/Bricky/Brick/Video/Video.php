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

class Video extends Brick
{
    public function getName()
    {
        return 'Video';
    }

    public function getInput()
    {
        $s = new \rex_select();
        $s->setName('BRICK_INPUT_VALUE[SOURCE]');
        $s->addOptions(['YouTube' => 'YouTube', 'vimeo' => 'Vimeo']);
        return '
            <p>
              <a data-toggle="collapse" href="#VideoInfo" aria-expanded="false" aria-controls="collapseExample">
               <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
              </a>
            </p>
            <div class="collapse" id="VideoInfo">
              <div class="card card-body">
                <p>In dem Eingabefeld "Video-ID" bitte nur die ID des Videos eingeben<br/>
                <b>Beispiel:</b><br/>
                YouTube: https://www.youtube.com/watch?v=<b>jsbhA64PvwA</b><br/>
                Vimeo: https://vimeo.com/<b>142260520</b></p>
              </div>
            </div>
            <div class="form-group">
                <label class="col-md-3">
                    Video-ID
                </label>
                <div class="col-md-6">
                    <input class="form-control" name="BRICK_INPUT_VALUE[TEXT]" type="text" />
                </div>
                <div class="col-md-3">
                    <div class="rex-select-style">
                        '.$s->get().'
                    </div>
                </div>
            </div>';
    }

    public function getBackendOutput(array $brickValues)
    {
        return $this->getFrontendOutput($brickValues);
    }

    public function getFrontendOutput(array $brickValues)
    {
        // TODO
    }

}
