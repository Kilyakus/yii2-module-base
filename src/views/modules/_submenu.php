<?php
use yii\helpers\Url;

use kilyakus\web\widgets as Widget;

$action = $this->context->action->id;
?>

<?= Widget\Nav::widget([
	'options' => [
		'class' => 'nav-tabs nav-tabs-line nav-tabs-line-brand nav-tabs-line-2x',
	],
	'encodeLabels' => false,
	'items' => [
		[
			'label' => '<span class="fa fa-sliders-h"></span>&nbsp; ' . Yii::t('easyii', 'Basic'),
			'url' => Url::to(['/system/modules/edit/', 'id' => $model->primaryKey]),
			'active' => ($action === 'edit'),
		],
		[
			'label' => '<span class="fa fa-cog"></span>&nbsp; ' . Yii::t('easyii', 'Advanced'),
			'url' => Url::to(['/system/modules/settings/', 'id' => $model->primaryKey]),
			'active' => ($action === 'settings'),
		],
		[
			'label' => '<span class="fa fa-share"></span>&nbsp; ' . Yii::t('easyii', 'Redirects'),
			'url' => Url::to(['/system/modules/redirects/', 'id' => $model->primaryKey]),
			'active' => ($action === 'redirects'),
		],
		[
			'label' => '<span class="fa fa-copy"></span>&nbsp; ' . Yii::t('easyii', 'Copy'),
			'url' => Url::to(['/system/modules/copy/', 'id' => $model->primaryKey]),
			'active' => ($action === 'copy'),
		],
	],
]) ?>