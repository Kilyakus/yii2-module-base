<?php
namespace kilyakus\modules\models;

use Yii;

use kilyakus\helpers as Helper;
use kilyakus\modules\behaviors as ModuleBehavior;

class Module extends \kilyakus\modules\components\ActiveRecord
{
    const STATUS_OFF= 0;
    const STATUS_ON = 1;
    const MENU_OFF= 0;
    const MENU_ON = 1;

    const CACHE_KEY = 'modules';

    public static function tableName()
    {
        return 'modules';
    }

    public function rules()
    {
        return [
            [['name', 'class', 'title'], 'required'],
            [['name', 'class', 'title', 'icon'], 'trim'],
            ['name',  'match', 'pattern' => '/^[a-z]+$/'],
            ['name', 'unique'],
            ['class',  'match', 'pattern' => '/^[\w\\\]+$/'],
            ['class',  'checkExists'],
            ['icon', 'string'],
            [['status','header'], 'in', 'range' => [0,1]],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => Yii::t('easyii', 'Name'),
            'class' => Yii::t('easyii', 'Class'),
            'title' => Yii::t('easyii', 'Title'),
            'icon' => Yii::t('easyii', 'Icon'),
            'header' => Yii::t('easyii', 'Menu'),
            'order_num' => Yii::t('easyii', 'Order'),
        ];
    }


    public function behaviors()
    {
        return [
            ModuleBehavior\CacheFlush::className(),
            ModuleBehavior\SortableModel::className()
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if(!$this->settings || !is_array($this->settings)){
                $this->settings = self::getDefaultSettings($this->name);
            }
            $this->settings = json_encode($this->settings);

            if(!$this->redirects || !is_array($this->redirects)){
                $this->redirects = self::getDefaultRedirects($this->name);
            }
            $this->redirects = json_encode($this->redirects);

            return true;
        } else {
            return false;
        }
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->settings = $this->settings !== '' ? json_decode($this->settings, true) : self::getDefaultSettings($this->name);
        $this->redirects = $this->redirects !== '' ? json_decode($this->redirects, true) : self::getDefaultRedirects($this->name);
    }

    public static function findAllActive()
    {
        return Helper\Data::cache(self::CACHE_KEY, 3600, function(){
            $result = [];
            try {
                foreach (self::find()->where(['status' => self::STATUS_ON])->sort()->all() as $module) {
                    $module->trigger(self::EVENT_AFTER_FIND);
                    $result[$module->name] = (object)$module->attributes;
                }
            }catch(\yii\db\Exception $e){}

            return $result;
        });
    }

    public function setSettings($settings)
    {
        $newSettings = [];
        foreach($this->settings as $key => $value){
            if(!is_array($value)){
                $newSettings[$key] = is_bool($value) ? ($settings[$key] ? true : false) : ($settings[$key] ? $settings[$key] : '');
            }else{
                foreach($value as $k => $v){
                    $newSettings[$key][$k] = is_bool($v) ? ($settings[$key][$k] ? true : false) : ($settings[$key][$k] ? $settings[$key][$k] : '');
                }
            }
        }
        $this->settings = $newSettings;
    }

    public function setRedirects($redirects)
    {
        $newRedirects = [];
        foreach($this->redirects as $key => $value){
            if(!is_array($value)){
                $newRedirects[$key] = is_bool($value) ? ($redirects[$key] ? true : false) : ($redirects[$key] ? $redirects[$key] : '');
            }else{
                foreach($value as $k => $v){
                    $newRedirects[$key][$k] = is_bool($v) ? ($redirects[$key][$k] ? true : false) : ($redirects[$key][$k] ? $redirects[$key][$k] : '');
                }
            }
        }
        $this->redirects = $newRedirects;
    }

    public function checkExists($attribute)
    {
        if(!class_exists($this->$attribute)){
            $this->addError($attribute, Yii::t('easyii', 'Class does not exist'));
        }
    }

    static function getDefaultSettings($moduleName)
    {
        $modules = Yii::$app->getModule('admin')->activeModules;
        if(isset($modules[$moduleName])){
            return Yii::createObject($modules[$moduleName]->class, [$moduleName])->settings;
        } else {
            return [];
        }
    }

    static function getDefaultRedirects($moduleName)
    {
        $modules = Yii::$app->getModule('admin')->activeModules;
        if(isset($modules[$moduleName])){

            $redirects = isset(Yii::createObject($modules[$moduleName]->class, [$moduleName])->redirects) 
                ? Yii::createObject($modules[$moduleName]->class, [$moduleName])->redirects 
                : [];

            return $redirects;
        } else {
            return [];
        }
    }

}