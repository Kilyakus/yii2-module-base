<?php
namespace kilyakus\modules\components;

/**
 * Base active query class for models
 * @package bin\admin\components
 */
class ActiveQuery extends \yii\db\ActiveQuery
{
    /**
     * Apply condition by status
     * @param $status
     * @return $this
     */
    public function status($status)
    {
        $this->andWhere(['status' => (int)$status]);
        return $this;
    }

    /**
     * Order by primary key DESC
     * @return $this
     */
    public function desc()
    {
        $model = $this->modelClass;
        $this->orderBy([$model::primaryKey()[0] => SORT_DESC]);
        return $this;
    }

    /**
     * Order by primary key ASC
     * @return $this
     */
    public function asc()
    {
        $model = $this->modelClass;
        $this->orderBy([$model::primaryKey()[0] => SORT_ASC]);
        return $this;
    }

    /**
     * Order by order_num
     * @return $this
     */
    public function sort()
    {
        $this->orderBy(['order_num' => SORT_DESC]);
        return $this;
    }

    /**
     * Order by date
     * @return $this
     */
    public function sortDate()
    {
        $this->orderBy(['time' => SORT_DESC]);
        return $this;
    }

    public function getCount()
    {
        return count($this);
    }

    public function getModels()
    {
        $dataProvider = new \yii\data\ActiveDataProvider(['query' => $this]);
        return $dataProvider->getModels();
    }

    public function getKeys()
    {
        return $this->count();
    }

    public function getPagination()
    {
        return $this;
    }

    public function getPageCount()
    {
        return count($this->pagination);
    }
}