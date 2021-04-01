<?php
namespace kilyakus\modules\behaviors;

use Yii;

class StatusController extends \yii\base\Behavior
{
    public $model;
    public $attribute = 'status';

    public function changeStatus($id, $status)
    {
        $modelClass = $this->model;

        if(($model = $modelClass::findOne($id)))
        {
            $model->status = $status;
            $model->update();
            // Yii::$app->db->createCommand('UPDATE ' . $model::tableName() . ' SET ' . $this->attribute . '=:status WHERE ' . $model::primaryKey()[0] . '=:id', ['id' => $model->primaryKey, 'status' => $status])->execute();
        }
        else{
            $this->error = Yii::t('easyii', 'Not found');
        }

        return $this->owner->formatResponse(Yii::t('easyii', 'Status successfully changed'));
    }

    public function changeHeader($id, $status)
    {
        $modelClass = $this->model;

        if(($model = $modelClass::findOne($id)))
        {
            $model->header = $status;
            $model->update();
        }
        else{
            $this->error = Yii::t('easyii', 'Not found');
        }

        return $this->owner->formatResponse(Yii::t('easyii', 'Status successfully changed'));
    }
}