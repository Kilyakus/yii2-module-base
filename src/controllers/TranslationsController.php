<?php
namespace kilyakus\modules\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\widgets\ActiveForm;

use kilyakus\modules\models\TSourceMessage;
use kilyakus\modules\models\TMessage;

class TranslationsController extends \kilyakus\modules\components\Controller
{

    public function actionIndex()
    {
        $data = new ActiveDataProvider([
            'query' => TSourceMessage::find()->orderBy(['id' => SORT_DESC]),
        ]);
        Yii::$app->user->setReturnUrl('/system/translations');

        return $this->render('index', [
            'data' => $data
        ]);
    }

    public function actionCreate($slug = null)
    {
        $model = new TSourceMessage;

        if ($model->load(Yii::$app->request->post())) {

            if(Yii::$app->request->isAjax){
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            else{

                if($model->save()){

                    $post = Yii::$app->request->post('TMessage');

                    foreach ($post['language'] as $k => $l) {
                        $nm = new TMessage;
                        $nm->id = $model->id;
                        $nm->language = $post['language'][$k];
                        $nm->translation = $post['translation'][$k];
                        $nm->save();
                    }

                    $this->flash('success', Yii::t('easyii', 'TSourceMessage created'));
                    return $this->redirect(['/system/translations']);
                }
                else{
                    $this->flash('error', Yii::t('Create error. {0}', $model->formatErrors()));
                    return $this->refresh();
                }
            }
        }
        else {

            if($slug){
                $model->message = $slug;
            }

            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionEdit($id)
    {
        $model = TSourceMessage::findOne($id);

        if($model === null){
            $this->flash('error', Yii::t('easyii', 'Not found'));
            return $this->redirect(['/system/translations']);
        }

        if ($model->load(Yii::$app->request->post())) {
            if(Yii::$app->request->isAjax){
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            else{

                if(count($model->translations)){
                    foreach ($model->translations as $translation) {
                        $translation->delete();
                    }
                }

                $post = Yii::$app->request->post('TMessage');

                foreach ($post['language'] as $k => $l) {
                    $nm = new TMessage;
                    $nm->id = $model->id;
                    $nm->language = $post['language'][$k];
                    $nm->translation = $post['translation'][$k];
                    $nm->save();
                }

                if($model->save()){
                    $this->flash('success', Yii::t('easyii', 'TSourceMessage updated'));
                }
                else{
                    $this->flash('error', Yii::t('easyii', 'Update error. {0}', $model->formatErrors()));
                }
                return $this->refresh();
            }
        }
        else {
            return $this->render('edit', [
                'model' => $model
            ]);
        }
    }

    public function actionDelete($id)
    {
        if(($model = TSourceMessage::findOne($id))){
            $model->delete();
        } else {
            $this->error = Yii::t('easyii', 'Not found');
        }
        return $this->formatResponse(Yii::t('easyii', 'TSourceMessage deleted'));
    }
}