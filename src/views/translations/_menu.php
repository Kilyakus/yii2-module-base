<?php
use yii\helpers\Url;
use kilyakus\web\widgets as Widget;

$action = $this->context->action->id;
$module = $this->context->module->id;

$nav = [];
$nav[] = [
    'label' => (($action !== 'index') ? '<i class="fa fa-chevron-left"></i>&nbsp; ' : '<i class="fa fa-list-alt"></i>&nbsp; ') . Yii::t('easyii', 'List'),
    'url' => $this->context->getReturnUrl(['/' . $module . '/translations']),
    'active' => ($action === 'index'),
];
$nav[] = [
    'label' => '<i class="fa fa-plus"></i>&nbsp; ' . Yii::t('easyii', 'Create'),
    'url' => Url::to(['/' . $module . '/translations/create']),
    'active' => ($action === 'create'),
];
?>
<?= Widget\NavPage::widget([
    'options' => [
        'class' => 'nav-pills',
    ],
    'encodeLabels' => false,
    'items' => $nav,
]) ?>