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
                    <input class="form-control" name="BRICK_INPUT_VALUE[TITLE]" type="text" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3">
                    Text
                </label>
                <div class="col-md-9">
                    <textarea class="form-control" name="BRICK_INPUT_VALUE[TEXT]" rows="6"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-3">
                    Link setzen
                </label>
                <div class="col-md-9">
                    BRICK_LINK[id=1]
                </div>
            </div>';
    }

    public function getBackendOutput(array $brickValues)
    {
        $fragment = new \rex_fragment();
        foreach ($brickValues as $var => $value) {
            $fragment->setVar($var, $value, false);
        }
        return $fragment->parse('brick_card_backend_output.php');
    }

    public function getFrontendOutput(array $brickValues)
    {
        $return = '';
        if ($brickValues['TITLE'] != '') {
            $return .= sprintf('<h2>%s</h2>', $brickValues['TITLE']);
        }
        if ($brickValues['TEXT'] != '') {
            $return .= sprintf('<p>%s</p>', nl2br($brickValues['TEXT']));
        }
        if ($article = \rex_article::get($brickValues['LINK_1'])) {
            $return = sprintf('<a href="%s">%s</a>', $article->getUrl(), $return);
        }


        return $return;
    }

}
