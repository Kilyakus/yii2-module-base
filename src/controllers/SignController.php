<?php
namespace kilyakus\modules\controllers;

use Yii;
use kilyakus\modules\models\LoginForm;

class SignController extends \yii\web\Controller
{
    public $layout = 'empty';
    public $enableCsrfValidation = false;

    public function actionIn()
    {
        $model = new LoginForm;

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(Yii::$app->user->getReturnUrl(['/lab']));
        } else {
            return $this->render('in', [
                'model' => $model,
            ]);
        }
    }

    public function actionOut()
    {
        Yii::$app->user->logout();

        return $this->redirect(Yii::$app->homeUrl);
    }
}