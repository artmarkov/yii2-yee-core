<?php

namespace yeesoft\db;

use Yii;

trait ActiveQueryFilterTrait
{

    /**
     * @var array the list of the ActiveQueryFilter.
     */
    private $_filters;

    /**
     * 
     * @return $this
     */
    public function applyFilters()
    {
        /* @var $this ActiveQuery */
        $modelClass = $this->modelClass;
        $filters = $this->getFilters($modelClass);

        /* @var $filter \yeesoft\filters\ActiveQueryFilter */
        foreach ($filters as $filter) {
            $filter->apply($this);
        }

        return $this;
    }

    public function getFilters($modelClass)
    {
        $user = Yii::$app->user;
        $filters = Yii::$app->authManager->getFiltersByUserId($user->id);

        if (!$this->_filters) {
            $this->_filters = [];
            foreach ($filters as $filter) {
                $this->_filters[] = (new $filter);
            }
            
        }

        return $this->_filters;
    }

}