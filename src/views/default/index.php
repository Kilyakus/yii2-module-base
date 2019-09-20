<?php
use bin\admin\models\Setting;
use yii\helpers\Url;

$this->title = Yii::t('easyii', 'System');
?>

<h4><?= Yii::t('easyii', 'Current version') ?>: <b><?= Setting::get('version') ?></b>
    <?php if(\bin\admin\AdminModule::VERSION > floatval(Setting::get('version'))) : ?>
        <a href="<?= Url::to(['/admin/update']) ?>" class="btn btn-success"><?= Yii::t('easyii', 'Update') ?></a>
    <?php endif; ?>
</h4>

<br>

<p>
    <a href="<?= Url::toRoute(['/admin/system/flush-cache']) ?>" class="btn btn-default"><i class="glyphicon glyphicon-flash"></i> <?= Yii::t('easyii', 'Flush cache') ?></a>
</p>

<br>

<p>
    <a href="<?= Url::toRoute(['/admin/system/clear-assets']) ?>" class="btn btn-default"><i class="glyphicon glyphicon-trash"></i> <?= Yii::t('easyii', 'Clear assets') ?></a>
</p>