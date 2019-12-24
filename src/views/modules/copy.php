<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

use kilyakus\web\widgets as Widget;

$this->title = $model->title;
?>
<?= $this->render('_menu') ?>

<?php Widget\Portlet::begin([
    'options' => ['class' => 'kt-portlet--tabs', 'id' => 'kt_page_portlet'],
    'headerContent' => $this->render('_submenu', ['model' => $model])
]); ?>

	<?php $form = ActiveForm::begin(['enableAjaxValidation' => true]) ?>
	<?= $form->field($formModel, 'title') ?>
	<?= $form->field($formModel, 'name') ?>

	<?= Widget\Button::widget([
		'type' => Widget\Button::TYPE_WARNING,
		'title' => Yii::t('easyii', 'Copy'),
		'icon' => 'fa fa-copy',
		'block' => true,
		'options' => [
			'type' => 'submit'
		]
	]) ?>

	<?php ActiveForm::end(); ?>

<?php Widget\Portlet::end(); ?>