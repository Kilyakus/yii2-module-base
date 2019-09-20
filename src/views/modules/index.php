<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use kilyakus\modules\models\Module;
use kilyakus\web\widgets as Widget;

$this->title = Yii::t('easyii', 'Modules');

if($data->count > 0) {
    foreach($data->models as $module){
        $columns[] = [
            ['content' => Yii::t('easyii/'.$module->name,$module->title)],
            ['content' => '<i class="' . ($module->icon ? $module->icon : 'fa fa-asterisk') . '"></i>', 'options' => ['class' => 'text-center']],
            ['content' => (
                $module->settings['enableMenu'] ? Html::checkbox('', $module->header == Module::MENU_ON, [
                    'class' => 'switch',
                    'data-id' => $module->primaryKey,
                    'data-link' => Url::to(['/admin/modules/']),
                    'data-sublink' => 'menu-',
                    'data-reload' => '1'
                ]) : ''
            ), 'options' => ['class' => 'text-center']],
            ['content' => Html::checkbox('', $module->status == Module::STATUS_ON, [
                'class' => 'switch',
                'data-id' => $module->primaryKey,
                'data-link' => Url::to(['/admin/modules/']),
                'data-reload' => '1'
            ]), 'options' => ['class' => 'text-center']],
            ['content' => Widget\DropDown::widget([
                'button' => [
                    'icon' => 'fa fa-cog',
                    'iconPosition' => Widget\Button::ICON_POSITION_LEFT,
                    'type' => Widget\Button::TYPE_PRIMARY,
                    // 'size' => Widget\Button::SIZE_SMALL,
                    'disabled' => false,
                    'block' => false,
                    'outline' => true,
                    'hover' => false,
                    'circle' => true,
                    'options' => ['title' => Yii::t('easyii', 'Actions')]
                ],
                'options' => ['class' => 'dropdown-menu-right'],
                'items' => [
                    [
                        'label' => Yii::t('easyii', 'Edit'),
                        'icon' => 'fa fa-edit',
                        'url' => Url::to(['/admin/modules/edit/', 'id' => $module->primaryKey]),
                    ],
                    [
                        'label' => Yii::t('easyii', 'Copy'),
                        'icon' => 'glyphicon glyphicon-link',
                        'url' => Url::to(['/admin/modules/copy/', 'id' => $module->primaryKey]),
                    ],
                    [
                        'divider' => true,
                    ],
                    [
                        'label' => Yii::t('easyii', 'Move up'),
                        'icon' => 'fa fa-arrow-up',
                        'url' => Url::to(['/admin/modules/up/', 'id' => $module->primaryKey]),
                    ],
                    [
                        'label' => Yii::t('easyii', 'Move down'),
                        'icon' => 'fa fa-arrow-down',
                        'url' => Url::to(['/admin/modules/down/', 'id' => $module->primaryKey]),
                    ],
                    [
                        'divider' => true,
                    ],
                    [
                        'label' => Yii::t('easyii', 'Delete item'),
                        'icon' => 'fa fa-times',
                        'url' => Url::to(['/admin/modules/delete/', 'id' => $module->primaryKey]),
                        'linkOptions' => ['title' => Yii::t('easyii', 'Delete item'), 'class' => 'confirm-delete', 'data-reload' => '0'],
                    ],
                ],
            ]), 'options' => ['width' => 150]],
        ];
    }
}
?>

<?= $this->render('_menu') ?>

<?php if($data->count > 0) : ?>

    <?= Widget\KtDataTable::widget([
        'tableOptions' => ['id' => 'tb-example'],
        'hover' => true, // Defaults to true
        'bordered' => false, // Defaults to false
        'striped' => false, // Defaults to true
        'condensed' => false, // Defaults to true
        'portlet' => [
            'title' => $this->title,
            'icon' => 'fa fa-archive',
            'bodyOptions' => [
                'class' => ($data->count <= 0) ?: 'kt-portlet__body--fit',
            ],
            'footerContent' => LinkPager::widget([
                'pagination' => $data->pagination
            ]),
            'pluginSupport' => false,
        ],
        'beforeHeader' => [
            [
                'columns' => [
                    ['content' => Yii::t('easyii', 'Title')],
                    ['content' => Yii::t('easyii', 'Icon'), 'options' => ['width' => 100, 'class' => 'text-center']],
                    ['content' => Yii::t('easyii', 'Menu'), 'options' => ['width' => 100, 'class' => 'text-center']],
                    ['content' => Yii::t('easyii', 'Status'), 'options' => ['width' => 100, 'class' => 'text-center']],
                    ['content' => '', 'options' => ['width' => 30]],
                ],
            ],
        ],
        'showFooter' => true,
        'columns' => $columns
    ]); ?>

<?php else : ?>
    <p><?= Yii::t('easyii', 'No records found') ?></p>
<?php endif; ?>