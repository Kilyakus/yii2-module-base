<?php
namespace kilyakus\modules\components;

use Yii;
use yii\filters\AccessControl;

class Controller extends \bin\admin\components\AppController
{
    public function init()
    {
        parent::init();

        if($this->module->module->id == 'admin' || $this->module->module->id == 'app'){
            $this->layout = Yii::$app->getModule('admin')->controllerLayout;
        }
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['developer','administrators','moderators'],
                    ],
                ],
            ],
        ];
    }

    public function beforeAction($action)
    {
        if(!parent::beforeAction($action))
            return false;

        if(Yii::$app->user->isGuest && $this->module->module->id == 'admin'){
            Yii::$app->user->setReturnUrl(Yii::$app->request->url);
            Yii::$app->getResponse()->redirect(['/user/security/login'])->send();
            return false;
        }
        else{
            // if((!IS_ROOT && ($this->rootActions == 'all' || !in_array($action->id, $this->rootActions))) && $this->module->module->id == 'admin'){
            //     throw new \yii\web\ForbiddenHttpException('You cannot access this action');
            // }

            if($action->id === 'index'){
                $this->setReturnUrl();
            }

            return true;
        }
    }
}