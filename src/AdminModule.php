<?php
namespace kilyakus\modules;

use Yii;

class AdminModule extends \bin\admin\AdminModule
{
	// public function beforeAction($action)
 //    {
 //        if(!parent::beforeAction($action))
 //            return false;

 //        if($action->controller->id != 'sign'){
	//         if(!Yii::$app->userAdmin->identity->isRoot() || Yii::$app->userAdmin->isGuest){

	//             Yii::$app->user->setReturnUrl(Yii::$app->request->url);
	//             Yii::$app->getResponse()->redirect(['/system/sign/in'])->send();

	//             return false;
	//         }
	//     }else{
	//     	parent::beforeAction($action);
	//     }
 //    }
}
