<?php

$file = rex_file::get(rex_path::addon('bricky','README.md'));
$Parsedown = new Parsedown();

$content =  '<div id="bricky">'.$Parsedown->text($file).'</div>';

$fragment = new rex_fragment();

$fragment->setVar('title', $this->i18n('bricky_info'));
$fragment->setVar('body', $content, false);
echo $fragment->parse('core/page/section.php');


