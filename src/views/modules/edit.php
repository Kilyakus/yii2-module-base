<?php
use kilyakus\web\widgets as Widget;

$this->title = $model->title;
?>
<?= $this->render('_menu') ?>

<?php Widget\Portlet::begin([
    'options' => ['class' => 'kt-portlet--tabs', 'id' => 'kt_page_portlet'],
    'headerContent' => $this->render('_submenu', ['model' => $model])
]); ?>
	<?= $this->render('_form', ['model' => $model]) ?>
<?php Widget\Portlet::end(); ?>