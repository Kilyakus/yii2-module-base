<?php
namespace kilyakus\modules\components;

use kilyakus\nestedsets\behaviors\NestedSetsQueryBehavior;

class ActiveQueryNS extends ActiveQuery
{
    public function behaviors()
    {
        return [
            NestedSetsQueryBehavior::className(),
        ];
    }

    public function sort()
    {
        $this->orderBy('order_num DESC, lft ASC');
        return $this;
    }
}