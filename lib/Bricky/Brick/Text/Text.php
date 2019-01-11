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

class Text extends Brick
{
    public function getName()
    {
        return 'Text (CKEditor 5)';
    }
    public function getInput()
    {

        return '
            <div class="form-group">
                <label class="col-md-3">
                    Text
                </label>
                <div class="col-md-9">
                     <textarea class="form-control cke5-editor" data-profile="light" data-lang="<?php echo \Cke5\Utils\Cke5Lang::getUserLang(); ?>" name="BRICK_INPUT_VALUE[TEXT]">BRICK_INPUT_VALUE[TEXT]</textarea>
                </div>
            </div>';
    }

    public function getBackendOutput(array $brickValues)
    {
        $fragment = new \rex_fragment();
        foreach ($brickValues as $var => $value) {
            $fragment->setVar($var, $value, false);
        }
        return $fragment->parse('brick_text_backend_output.php');

    }

    public function getFrontendOutput(array $brickValues)
    {
        $fragment = new \rex_fragment();
        foreach ($brickValues as $var => $value) {
            $fragment->setVar($var, $value, false);
        }
        return $fragment->parse('brick_text_frontend_output.php');
    }
}

