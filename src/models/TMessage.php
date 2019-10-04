<?php
namespace kilyakus\modules\models;

use Yii;

use kilyakus\modules\behaviors\CacheFlush;

class TMessage extends \kilyakus\modules\components\ActiveRecord
{

    const CACHE_KEY = 'message';

    public static function tableName()
    {
        return 'message';
    }

    public function rules()
    {
        return [
            [['language', 'translation'], 'required'],
            ['language',  'match', 'pattern' => '/^[a-z]+$/'],
            // ['translation', 'unique'],
            ['translation',  'checkExists'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'language' => Yii::t('easyii', 'Language'),
            'translation' => Yii::t('easyii', 'Translation'),
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

    public function checkExists($attribute)
    {
        if(class_exists($this->$attribute)){
            $this->addError($attribute, Yii::t('easyii', 'Translation is exist'));
        }
    }

}