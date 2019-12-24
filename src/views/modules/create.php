<?php
use kilyakus\web\widgets as Widget;

$this->title = Yii::t('easyii', 'Create module');
?>
<?= $this->render('_menu') ?>

<?php Widget\Portlet::begin([
    'options' => ['class' => 'kt-portlet--tabs', 'id' => 'kt_page_portlet'],
    'title' => $this->title,
    'icon' => 'fa fa-pen'
]); ?>

	<?= $this->render('_form', ['model' => $model]) ?>

<?php Widget\Portlet::end(); ?>