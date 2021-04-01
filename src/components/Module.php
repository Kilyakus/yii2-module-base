<?php
namespace kilyakus\modules\components;

use Yii;
use kilyakus\modules\models\Module as ModuleModel;

class Module extends \yii\base\Module
{
    public $defaultRoute = 'a';

    public $settings = [];

    public $i18n;

    public static $installConfig = [
        'title' => [
            'ru' => 'Пользовательский модуль',
            'en' => 'Custom Module',
        ],
        'icon' => 'fa fa-asterisk',
        'order_num' => 0,
    ];

    public function init()
    {
        parent::init();

        $modules = Yii::$app->getModule('admin')->activeModules;

        foreach($modules as $module)
        {
            $moduleName = static::getModuleName($module->class);
            static::registerTranslations($moduleName);
        }
    }

    public static function registerTranslations($moduleName)
    {
        $moduleClassFile = '';
        foreach(ModuleModel::findAllActive() as $name => $module){
            if($name == $moduleName){
                $moduleClassFile = (new \ReflectionClass($module->class))->getFileName();
                break;
            }
        }

        if($moduleClassFile){
            Yii::$app->i18n->translations['easyii/'.$moduleName.'*'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en-US',
                'basePath' => dirname($moduleClassFile) . DIRECTORY_SEPARATOR . 'messages',
                'fileMap' => [
                    'easyii/'.$moduleName => 'admin.php',
                    'easyii/'.$moduleName.'/api' => 'api.php'
                ]
            ];
        }
    }

    public static function getModuleName($namespace)
    {
        foreach(ModuleModel::findAllActive() as $module)
        {
            $moduleClassPath = preg_replace('/[\w]+$/', '', $module->class);
            if(strpos($namespace, $moduleClassPath) !== false){
                return $module->name;
            }
        }
        return false;
    }
}