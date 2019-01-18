<?php

$lang = 'de_de';
$path = rex_path::plugin('bricky', 'docs', 'docs/'.$lang.'/');

$files = [];
foreach (scandir($path) as $i_file) {
    if ($i_file != '.' && $i_file != '..') {
        $files[$i_file] = $i_file;
    }
}

if (rex_request('bricky_docs_image', 'string') != '' && isset($files[rex_request('bricky_docs_image', 'string')])) {
    ob_end_clean();
    $content = rex_file::get($path.basename(rex_request('bricky_docs_image', 'string')));
    echo $content;
    exit;
}

$navi = rex_file::get($path.'main_navi.md');

$file = rex_request('bricky_docs_file', 'string', 'bricky_intro.md');
if (!in_array($file, $files)) {
    $file = 'main_intro.md';
}
$content = rex_file::get($path.basename($file));
if ($content == '') {
    $content = '<p class="alert alert-warning">'.rex_i18n::rawMsg('bricky_docs_filenotfound').'</p>';
}

if (class_exists('rex_markdown')) {
    $miu = rex_markdown::factory();
    $navi = $miu->parse($navi);
    $content = $miu->parse($content);

    foreach ($files as $i_file) {
        $search = '#href="('.$i_file.')"#';
        $replace = 'href="index.php?page=bricky/docs&bricky_docs_file=$1"';
        $navi = preg_replace($search, $replace, $navi);
        $content = preg_replace($search, $replace, $content);

        // ![Alt-Text](bildname.png)
        // ![Ein Screenshot](screenshot.png)
        $search = '#\!\[(.*)\]\(('.$i_file.')\)#';
        $replace = '<img src="index.php?page=bricky/docs&bricky_docs_image=$2" alt="$1" style="width:100%"/>';
        $content = preg_replace($search, $replace, $content);
    }
}

$fragment = new rex_fragment();
$fragment->setVar('title', rex_i18n::msg('bricky_docs_navigation'), false);
$fragment->setVar('body', $navi, false);
$navi = $fragment->parse('core/page/section.php');

$fragment = new rex_fragment();
$fragment->setVar('title', rex_i18n::msg('bricky_docs_content'), false);
$fragment->setVar('body', $content, false);
$content = $fragment->parse('core/page/section.php');

echo '<section class="rex-bricky-docs">
    <div class="row">
    <div class="col-md-4 bricky-docs-navi">'.$navi.'</div>
    <div class="col-md-8 bricky-docs-content">'.$content.'</div>
    </div>
</section>';
