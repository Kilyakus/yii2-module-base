<?php
use yii\helpers\Url;

$action = $this->context->action->id;
?>
<ul class="nav nav-tabs">
    <li <?= ($action === 'edit') ? 'class="active"' : '' ?>><a href="<?= Url::to(['/admin/modules/edit/', 'id' => $model->primaryKey]) ?>"> <?= Yii::t('easyii', 'Basic') ?></a></li>
    <li <?= ($action === 'settings') ? 'class="active"' : '' ?>><a href="<?= Url::to(['/admin/modules/settings/', 'id' => $model->primaryKey]) ?>"><i class="glyphicon glyphicon-cog"></i> <?= Yii::t('easyii', 'Advanced') ?></a></li>
    <li <?= ($action === 'redirects') ? 'class="active"' : '' ?>><a href="<?= Url::to(['/admin/modules/redirects/', 'id' => $model->primaryKey]) ?>"><i class="glyphicon glyphicon-share-alt"></i> <?= Yii::t('easyii', 'Redirects') ?></a></li>
    <li class="pull-right <?= ($action === 'copy') ? 'active' : '' ?>"><a href="<?= Url::to(['/admin/modules/copy/', 'id' => $model->primaryKey]) ?>" class="text-muted"><?= Yii::t('easyii', 'Copy') ?></a></li>
</ul>
<br>