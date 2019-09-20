<?php
namespace kilyakus\modules\controllers;

use yii\data\ActiveDataProvider;

use kilyakus\modules\models\LoginForm;

class LogsController extends \bin\admin\components\Controller
{
    public $rootActions = 'all';

    public function actionIndex()
    {
        $data = new ActiveDataProvider([
            'query' => LoginForm::find()->desc(),
        ]);

        return $this->render('index', [
            'data' => $data
        ]);
    }
}