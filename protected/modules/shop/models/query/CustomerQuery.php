<?php

namespace shop\models\query;

/**
 * This is the ActiveQuery class for [[\shop\models\Customer]].
 *
 * @see \shop\models\Customer
 */
class CustomerQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \shop\models\Customer[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \shop\models\Customer|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
