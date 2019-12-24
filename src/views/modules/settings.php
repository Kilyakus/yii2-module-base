<?php
use yii\helpers\Html;
use yii\helpers\Url;

use kilyakus\web\widgets as Widget;

$this->title = $model->title;
?>
<?= $this->render('_menu') ?>

<?php Widget\Portlet::begin([
    'options' => ['class' => 'kt-portlet--tabs', 'id' => 'kt_page_portlet'],
    'headerContent' => $this->render('_submenu', ['model' => $model]) . '<div class="d-flex align-items-center">' . Widget\Button::widget([
        'type' => Widget\Button::TYPE_DANGER,
        'title' => Yii::t('easyii', 'Restore default settings'),
        'icon' => 'fa fa-broom',
        'outline' => true,
        'url' => Url::to(['/system/modules/restore-settings', 'id' => $model->module_id]),
        'options' => [
            'class' => 'pull-right'
        ]
    ]) . '</div>'
]); ?>
    <?php if(sizeof($model->settings) > 0) : ?>
        <?= Html::beginForm(); ?>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th width="100"><?= Yii::t('easyii', 'Status') ?></th>
                    <th><?= Yii::t('easyii', 'Title') ?></th>
                    <th><?= Yii::t('easyii', 'Additional settings') ?></th>
                </tr>
            </thead>
            <tbody>
        <?php foreach($model->settings as $key => $value) : ?>
            <?php if(is_array($value)) : ?>
                <tr>
                    <td colspan="2"><strong><?= Yii::t('easyii', $key); ?>:</strong></td>
                    <td></td>
                </tr>
                <?php foreach($value as $k => $v) : ?>
                    <tr data-id="<?= $k ?>">
                        <?php if(!is_bool($v)) : ?>
                            <td></td>
                            <td><?= $k; ?></td>
                            <td>
                                <?= Html::input('text', 'Settings['.$key.']['.$k.']', $v, ['class' => 'form-control']); ?>
                            </td>
                        <?php else : ?>
                            <td class="status">
                                <?= Html::checkbox('Settings['.$key.']['.$k.']', $v, ['class' => 'switch','uncheck' => 0,]) ?>
                            </td>
                            <td>
                                <?= Yii::t('easyii',$k) ?>
                            </td>
                            <td>
                                <?= $k ?>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr data-id="<?= $key ?>">
                    <?php if(!is_bool($value)) : ?>
                        <td></td>
                        <td><?= $key; ?></td>
                        <td>
                            <?= Html::input('text', 'Settings['.$key.']', $value, ['class' => 'form-control']); ?>
                        </td>
                    <?php else : ?>
                        <td class="status">
                            <?= Html::checkbox('Settings['.$key.']', $value, ['class' => 'switch','uncheck' => 0,]) ?>
                        </td>
                        <td>
                            <?= Yii::t('easyii',$key) ?>
                        </td>
                        <td>
                            <?= $key ?>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
        </tbody>
        </table>
        <?= Widget\Button::widget([
            'type' => Widget\Button::TYPE_SUCCESS,
            'title' => Yii::t('easyii', 'Save'),
            'icon' => 'fa fa-check',
            'block' => true,
            'options' => [
                'type' => 'submit'
            ]
        ]) ?>
        <?php Html::endForm(); ?>
    <?php else : ?>
        <?= $model->title ?> <?= Yii::t('easyii', 'module doesn`t have any settings.') ?>
    <?php endif; ?>
<?php Widget\Portlet::end(); ?>