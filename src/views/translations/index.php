<?php
use kilyakus\modules\models\Module;
use yii\helpers\Html;
use yii\helpers\Url;
use kilyakus\web\widgets as Widget;

$this->title = Yii::t('easyii', 'Translations');

$module = $this->context->module->id;

foreach($data->models as $model) {

    foreach ($model->translations as $translation) {

        $counter++;

        $visible = $counter == 1;

        $rows = count($model->translations);

        $columns[] = [
            [
                'content' => $model->primaryKey,
                'options' => ['rowspan' => $rows],
                'visible' => IS_ROOT && $visible
            ],
            [
                'content' => $model->category,
                'options' => ['rowspan' => $rows],
                'visible' => $visible
            ],
            [
                'content' => $model->message,
                'options' => ['rowspan' => $rows],
                'visible' => $visible
            ],
            [
                'content' => $translation->language,
            ],
            [
                'content' => $translation->translation,
            ],
            [
                'content' => Widget\Dropdown::widget([
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
                            'url' => Url::to(['/' . $module . '/translations/edit', 'id' => $model->primaryKey]),
                        ],
                        [
                            'divider' => true,
                        ],
                        [
                            'label' => Yii::t('easyii', 'Delete item'),
                            'icon' => 'fa fa-times',
                            'url' => Url::to(['/' . $module . '/translations/delete', 'id' => $model->primaryKey]),
                            'linkOptions' => ['class' => 'confirm-delete', 'data-reload' => '0'],
                        ],
                    ],]), 
                'options' => ['rowspan' => $rows],
                'visible' => IS_ADMIN && $visible
            ],
        ];

    }

    $counter = 0;
    
}
?>
<?= $this->render('_menu') ?>

<?php Widget\Portlet::begin([
    'title' => $this->title,
    'icon' => 'fa fa-language',
    // 'scroller' => [
    //     'max-height' => 50,
    //     'format' => 'vh',
    // ],
    'bodyOptions' => [
        'class' => (!count($data->count) ?: 'kt-portlet__body--fit'),
    ],
    'footerContent' => \yii\widgets\LinkPager::widget([
        'pagination' => $data->pagination
    ])
]); ?>

    <?php if(count($data->count > 0)) : ?>

        <?= Widget\KtDataTable::widget([
            'tableOptions' => ['id' => 'tb-example'],
            'hover' => true,
            'bordered' => false,
            'striped' => false,
            'condensed' => false,
            'beforeHeader' => [
                [
                    'columns' => [
                        ['content' => '#', 'options' => ['width' => 50], 'visible' => IS_ROOT],
                        ['content' => Yii::t('easyii', 'Category'), 'options' => ['width' => 150]],
                        ['content' => Yii::t('easyii', 'Text')],
                        ['content' => Yii::t('easyii', 'Language'), 'options' => ['width' => 100]],
                        ['content' => Yii::t('easyii', 'Translation')],
                        ['content' => '', 'options' => ['width' => 80], 'visible' => IS_ADMIN],
                    ],
                ],
            ],
            'showFooter' => true,
            'columns' => $columns
        ]); ?>

    <?php else : ?>

        <p><?= Yii::t('easyii', 'No records found') ?></p>

    <?php endif; ?>

<?php Widget\Portlet::end(); ?>