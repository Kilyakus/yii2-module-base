<?php
use kilyakus\modules\models\Setting;
use yii\helpers\Url;

$this->title = Yii::t('easyii', 'System');

$module = Yii::$app->controller->module->id;
?>

<h4><?= Yii::t('easyii', 'Current version') ?>: <b><?= Setting::get('version') ?></b>
    <?php if(\bin\admin\AdminModule::VERSION > floatval(Setting::get('version'))) : ?>
        <a href="<?= Url::to(['/' . $module . '/update']) ?>" class="btn btn-success"><?= Yii::t('easyii', 'Update') ?></a>
    <?php endif; ?>
</h4>

<br>

<p>
    <a href="<?= Url::toRoute(['/' . $module . '/default/flush-cache']) ?>" class="btn btn-default"><i class="glyphicon glyphicon-flash"></i> <?= Yii::t('easyii', 'Flush cache') ?></a>
</p>

<br>

<p>
    <a href="<?= Url::toRoute(['/' . $module . '/default/clear-assets']) ?>" class="btn btn-default"><i class="glyphicon glyphicon-trash"></i> <?= Yii::t('easyii', 'Clear assets') ?></a>
</p>