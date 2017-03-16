<?php

namespace shop\models\query;

/**
 * This is the ActiveQuery class for [[\shop\models\CartItem]].
 *
 * @see \shop\models\CartItem
 */
class CartItemQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \shop\models\CartItem[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \shop\models\CartItem|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
