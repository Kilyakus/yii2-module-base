<?php
$this->title = Yii::t('easyii', 'Create module');
?>
<?= $this->render('_menu') ?>
<div class="card">
	<?= $this->render('_form', ['model' => $model]) ?>
</div>