<?php
$this->title = $model->title;
?>
<?= $this->render('_menu') ?>
<div class="card">
	<?= $this->render('_submenu', ['model' => $model]) ?>
	<?= $this->render('_form', ['model' => $model]) ?>
</div>