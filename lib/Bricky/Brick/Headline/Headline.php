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
        $s->setName('BRICK_INPUT_VALUE[TAG]');
        $s->addOptions(['h1' => 'Überschrift 1 (H1) - Nur einmal pro Seite verwenden', 'h2' => 'Überschrift 2 (H2)', 'h3' => 'Überschrift 3 (H3)','h4' => 'Überschrift 4 (H4)','h5' => 'Überschrift 5 (H5)','h6' => 'Überschrift 6 (H6)']);
        return '
            <div class="form-group">
                <label class="col-md-3">
                    Überschrift
                </label>
                <div class="col-md-9">
                    <input class="form-control" name="BRICK_INPUT_VALUE[TEXT]" type="text" />
                </div>
            </div>                
            <div class="form-group">
                <label class="col-md-3">
                    Art der Überschrift
                </label>
                <div class="col-md-9">
                    <div class="rex-select-style">
                        '.$s->get().'
                    </div>
                </div>
            </div>';
    }

    public function getBackendOutput(array $brickValues)
    {
        $fragment = new \rex_fragment();
        foreach ($brickValues as $var => $value) {
            $fragment->setVar($var, $value, false);
        }
        return $fragment->parse('brick_headline_backend_output.php');

    }

    public function getFrontendOutput(array $brickValues)
    {
        $fragment = new \rex_fragment();
        foreach ($brickValues as $var => $value) {
            $fragment->setVar($var, $value, false);
        }
        return $fragment->parse('brick_headline_frontend_output.php');

    }

}
