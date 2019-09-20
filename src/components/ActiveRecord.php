<?php
namespace kilyakus\modules\components;

/**
 * Base active record class for easyii models
 * @package bin\admin\components
 */
class ActiveRecord extends \yii\db\ActiveRecord
{
    /** @var string  */
    public static $SLUG_PATTERN = '/^[0-9a-z-]{0,128}$/';

    public $transferClasses = [];

    /**
     * Get active query
     * @return ActiveQuery
     */
    public static function find()
    {
        return new ActiveQuery(get_called_class());
    }

    /**
     * Formats all model errors into a single string
     * @return string
     */
    public function formatErrors()
    {
        $result = '';
        foreach($this->getErrors() as $attribute => $errors) {
            $result .= implode(" ", $errors)." ";
        }
        return $result;
    }

    public function __get($name){
       if (array_key_exists($name, $this->transferClasses))
           return $this->transferClasses[$name];

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