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
        'title' => Yii::t('easyii', 'Restore default redirects'),
        'icon' => 'fa fa-broom',
        'outline' => true,
        'url' => Url::to(['/system/modules/restore-redirects', 'id' => $model->module_id]),
        'options' => [
            'class' => 'pull-right'
        ]
    ]) . '</div>'
]); ?>

    <?php if(sizeof($model->redirects) > 0) : ?>
        <?= Html::beginForm(); ?>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th><?= Yii::t('easyii', 'Page') ?></th>
                    <th><?= Yii::t('easyii', 'Redirect to') ?></th>
                </tr>
            </thead>
            <tbody>
        <?php foreach($model->redirects as $key => $value) : ?>
            <?php if(is_array($value)) : ?>
                <tr>
                    <td><strong><?= Yii::t('easyii', $key); ?>:</strong></td>
                    <td></td>
                </tr>
                <?php foreach($value as $k => $v) : ?>
                    <tr data-id="<?= $k ?>">
                        <?php if(!is_bool($v)) : ?>
                            <td><?= $k; ?></td>
                            <td>
                                <?= Html::input('text', 'Redirects['.$key.']['.$k.']', $v, ['class' => 'form-control']); ?>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr data-id="<?= $key ?>">
                    <?php if(!is_bool($value)) : ?>
                        <td><?= $key; ?></td>
                        <td>
                            <?= Html::input('text', 'Redirects['.$key.']', $value, ['class' => 'form-control']); ?>
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
        <?= Yii::t('easyii', 'Module') ?> "<?= Yii::t('easyii/'.$model->name, $model->title) ?>" <?= Yii::t('easyii', 'doesn`t have any redirects') ?>.
    <?php endif; ?>
<?php Widget\Portlet::end(); ?>