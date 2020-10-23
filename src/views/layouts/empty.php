<?php
use yii\helpers\Html;
use kilyakus\web\Engine;

Engine::registerThemeAsset($this);

$this->beginPage();

$this->registerCss("
html, body {margin:0px;width:100%;height:100%;}
#yii-debug-toolbar {opacity:0;left:100%;}
");
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <?= Html::csrfMetaTags() ?>
        <meta name="robots" content="noindex">
        <base target="_parent">
        <!-- <base target="_top"> -->
        <title><?= Yii::t('easyii', Html::encode($this->title)) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>
            <?= $content ?>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>