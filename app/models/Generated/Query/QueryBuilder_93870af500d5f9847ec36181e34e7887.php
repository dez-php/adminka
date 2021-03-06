<?php

/**
 *
 * Generated by DezDevTools @ 2016-09-22 21:29:09
 *
 * @author Ivan Gontarenko
 * @licence MIT
 *
*/

namespace AdminkaModels\Generated\Query;

use Dez\ORM\Model\QueryBuilder as OrmQueryBuilder;

class QueryBuilder_93870af500d5f9847ec36181e34e7887 extends OrmQueryBuilder
{

    /**
     * @param $value
     * @param string $criteria
     * @return QueryBuilder_93870af500d5f9847ec36181e34e7887
    */
    public function whereResourceId($value, $criteria = null)
    {
        return $this->where('resource_id', $value, (null !== $criteria ? $criteria : '='));
    }

    /**
     * @param $vector
     * @return QueryBuilder_93870af500d5f9847ec36181e34e7887
    */
    public function orderByResourceId($vector = 'ASC')
    {
        return $this->order('resource_id', $vector);
    }

    /**
    * @return QueryBuilder_93870af500d5f9847ec36181e34e7887
    */
    public function groupByResourceId()
    {
        return $this->getNativeBuilder()->group('resource_id');
    }

    /**
     * @param $value
     * @param string $criteria
     * @return QueryBuilder_93870af500d5f9847ec36181e34e7887
    */
    public function whereName($value, $criteria = null)
    {
        return $this->where('name', $value, (null !== $criteria ? $criteria : '='));
    }

    /**
     * @param $vector
     * @return QueryBuilder_93870af500d5f9847ec36181e34e7887
    */
    public function orderByName($vector = 'ASC')
    {
        return $this->order('name', $vector);
    }

    /**
    * @return QueryBuilder_93870af500d5f9847ec36181e34e7887
    */
    public function groupByName()
    {
        return $this->getNativeBuilder()->group('name');
    }

    /**
     * @param $value
     * @param string $criteria
     * @return QueryBuilder_93870af500d5f9847ec36181e34e7887
    */
    public function whereLabel($value, $criteria = null)
    {
        return $this->where('label', $value, (null !== $criteria ? $criteria : '='));
    }

    /**
     * @param $vector
     * @return QueryBuilder_93870af500d5f9847ec36181e34e7887
    */
    public function orderByLabel($vector = 'ASC')
    {
        return $this->order('label', $vector);
    }

    /**
    * @return QueryBuilder_93870af500d5f9847ec36181e34e7887
    */
    public function groupByLabel()
    {
        return $this->getNativeBuilder()->group('label');
    }

}