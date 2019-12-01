<?php
namespace kilyakus\modules\components;

use Yii;
use yii\helpers\Url;
use kilyakus\modules\components\Module as ModuleComponent;

class API extends \yii\base\Object
{
    static $classes;

    public $module;

    public function init()
    {
        parent::init();

        $this->module = ModuleComponent::getModuleName(self::className());
        ModuleComponent::registerTranslations($this->module);
    }

    public static function __callStatic($method, $params)
    {
        $name = (new \ReflectionClass(self::className()))->getShortName();
        if (!isset(self::$classes[$name])) {
            self::$classes[$name] = new static();
        }
        return call_user_func_array([self::$classes[$name], 'api_' . $method], $params);
    }

    public static  function liveEdit($text, $path, $tag = 'span')
    {
        return $text ? '<'.$tag.' class="live-edit" data-edit="'.$path.'" data-toggle="tooltip" data-placement="left" data-html="true" title="'.Yii::t('easyii','Edit').'">'.$text.'</'.$tag.'>' : '';
    }

    public static  function getModule($name)
    {
        return Yii::$app->getModule('admin')->activeModules[$name];
    }
}
