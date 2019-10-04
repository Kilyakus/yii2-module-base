<?php
$this->title = $model->message;
?>
<?= $this->render('_menu') ?>
<div class="card">
	<?= $this->render('_form', ['model' => $model]) ?>
</div>