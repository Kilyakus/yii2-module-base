<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use bin\admin\models\TMessage;

?>
<?php $form = ActiveForm::begin(['enableAjaxValidation' => true]); ?>
<?= $form->field($model, 'category')->dropDownList(['easyii' => 'default']) ?>
<?= $form->field($model, 'message') ?>
<?php foreach (Yii::$app->urlManager->languages as $key => $language) : ?>
	<?php if($language != 'en') : ?>
		<?php 
			$model = TMessage::find()->where(['id' => $model->id,'language' => $language])->one();
			$model = $model ? $model : new TMessage;
		?>
		<?= $form->field($model, 'language[]')->hiddenInput(['value' => $language])->label(false) ?>
		<?= $form->field($model, 'translation[]')->textInput(['value' => $model->translation])->label(Yii::t('easyii', 'Translate to ({0})', $language)) ?>
	<?php endif; ?>
<?php endforeach; ?>
<?= Html::submitButton(Yii::t('easyii', 'Save'), ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>