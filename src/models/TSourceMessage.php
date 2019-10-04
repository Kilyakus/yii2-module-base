<?php
namespace kilyakus\modules\models;

use Yii;

use kilyakus\modules\behaviors\CacheFlush;

class TSourceMessage extends \kilyakus\modules\components\ActiveRecord
{

    const CACHE_KEY = 'source_message';

    private $_translations;

    public static function tableName()
    {
        return 'source_message';
    }

    public function rules()
    {
        return [
            [['category', 'message'], 'required'],
            ['category',  'match', 'pattern' => '/^[a-z]+$/'],
            ['message', 'unique'],
            ['message',  'checkExists'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'category' => Yii::t('easyii', 'Category'),
            'message' => Yii::t('easyii', 'Text'),
        ];
    }


    public function behaviors()
    {
        return [
            CacheFlush::className(),
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            return true;
        } else {
            return false;
        }
    }

    public function afterFind()
    {
        parent::afterFind();
    }

    public function getTranslations()
    {
        if(!$this->_translations){
            $this->_translations = [];

            foreach(TMessage::find()->where(['id' => $this->id])->all() as $model){
                $this->_translations[] = $model;
            }
        }
        return $this->_translations;
    }

    public function checkExists($attribute)
    {
        if(class_exists($this->$attribute)){
            $this->addError($attribute, Yii::t('easyii', 'Translation is exist'));
        }
    }

}