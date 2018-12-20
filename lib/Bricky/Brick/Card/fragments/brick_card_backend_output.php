<?php
$article = null;
if ($this->getVar('LINK_1', 0) > 0) {
    $article = \rex_article::get($this->getVar('LINK_1'));
}
?>

<?php if ($article): ?>
<a href="<?= $article->getUrl() ?>">
    <?php endif ?>

    <?php if ($this->getVar('TITLE', '') != ''): ?>
        <h2><?= $this->getVar('TITLE') ?></h2>
    <?php endif ?>

    <?php if ($this->getVar('TEXT', '') != ''): ?>
        <p><?= nl2br($this->getVar('TEXT')) ?></p>
    <?php endif ?>

    <?php if ($article): ?>
</a>
<?php endif ?>
