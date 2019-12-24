<?php
use yii\helpers\Url;

use kilyakus\web\widgets as Widget;

$action = $this->context->action->id;
?>

<?= Widget\NavPage::widget([
	'options' => [
		'class' => 'nav-pills',
	],
	'encodeLabels' => false,
	'items' => [
		[
			'label' => ($action !== 'edit' && $action !== 'settings' ? '<i class="fa fa-list"></i>&nbsp; ' : '<i class="fa fa-arrow-left"></i>&nbsp; ') . Yii::t('easyii', 'List'),
			'url' => $this->context->getReturnUrl(['/system/modules']),
			'active' => ($action === 'index'),
		],
		[
			'label' => '<i class="fa fa-plus"></i>&nbsp; ' . Yii::t('easyii', 'Create'),
			'url' => Url::to(['/system/modules/create']),
			'active' => ($action === 'create'),
		]
	],
]) ?>