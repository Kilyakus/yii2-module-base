<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $model->title;
?>
<?= $this->render('_menu') ?>
<div class="card">
    <?= $this->render('_submenu', ['model' => $model]) ?>
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
        <?= Html::submitButton(Yii::t('easyii', 'Save'), ['class' => 'btn btn-primary']) ?>
        <?php Html::endForm(); ?>
    <?php else : ?>
        <?= Yii::t('easyii', 'Module') ?> "<?= Yii::t('easyii/'.$model->name, $model->title) ?>" <?= Yii::t('easyii', 'doesn`t have any redirects') ?>.
    <?php endif; ?>
    <a href="<?= Url::to(['/admin/modules/restore-redirects', 'id' => $model->module_id]) ?>" class="pull-right text-warning"><i class="glyphicon glyphicon-flash"></i> <?= Yii::t('easyii', 'Restore default redirects') ?></a>
</div>