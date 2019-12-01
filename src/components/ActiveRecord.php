<?php
namespace kilyakus\modules\components;

class ActiveRecord extends \yii\db\ActiveRecord
{
    public static $SLUG_PATTERN = '/^[0-9a-z-]{0,128}$/';

    public $transferClasses = [];

    public static function find()
    {
        return new ActiveQuery(get_called_class());
    }

    public function formatErrors()
    {
        $result = '';
        foreach($this->getErrors() as $attribute => $errors) {
            $result .= implode(" ", $errors)." ";
        }
        return $result;
    }

    public function __get($name){
       if (array_key_exists($name, $this->transferClasses)){
         return $this->transferClasses[$name];
       }

       return parent::__get($name);
    }

    public function __set($name, $value){
       if (array_key_exists($name, $this->transferClasses))
           $this->transferClasses[$name] = $value;

       else parent::__set($name, $value);
    }

    public function put($attribute)
    {
        $this->transferClasses[$attribute] = null;
        $this->__set($attribute, null);
    }
}