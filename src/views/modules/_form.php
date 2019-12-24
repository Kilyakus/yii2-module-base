<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

use kilyakus\web\widgets as Widget;
?>
<?php $form = ActiveForm::begin(['enableAjaxValidation' => true]); ?>

<?= $form->field($model, 'name') ?>
<?= $form->field($model, 'class') ?>
<?= $form->field($model, 'title') ?>
<?= $form->field($model, 'icon') ?>

<?= Widget\Button::widget([
	'type' => Widget\Button::TYPE_SUCCESS,
	'title' => Yii::t('easyii', 'Save'),
	'icon' => 'fa fa-check',
	'block' => true,
	'options' => [
		'type' => 'submit'
	]
]) ?>

<?php ActiveForm::end(); ?>