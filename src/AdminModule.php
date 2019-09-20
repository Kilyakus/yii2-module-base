<?php
namespace kilyakus\modules;

use Yii;

class AdminModule extends \bin\admin\AdminModule
{
	// public function beforeAction($action)
 //    {
 //        if(!parent::beforeAction($action))
 //            return false;

 //        if(!IS_ROOT && Yii::$app->controller->id != 'sign' || Yii::$app->user->isGuest){

 //            Yii::$app->user->setReturnUrl(Yii::$app->request->url);
 //            Yii::$app->getResponse()->redirect(['/lab/sign/in'])->send();

 //            return false;
 //        }
 //    }
}
