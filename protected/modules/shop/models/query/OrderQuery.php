<?php

namespace shop\models\query;

/**
 * This is the ActiveQuery class for [[\shop\models\Order]].
 *
 * @see \shop\models\Order
 */
class OrderQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \shop\models\Order[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \shop\models\Order|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
