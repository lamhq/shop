<?php

namespace shop\models\query;

use shop\models\Review;

/**
 * This is the ActiveQuery class for [[\shop\models\Review]].
 *
 * @see \shop\models\Review
 */
class ReviewQuery extends \yii\db\ActiveQuery
{
    public function approved()
    {
        return $this->andWhere('[[status]]='.Review::STATUS_APPROVED);
    }

    /**
     * @inheritdoc
     * @return \shop\models\Review[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \shop\models\Review|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function byProductId($productId) {
        $this->andWhere([
            'product_id' => $productId
        ]);
        return $this;
    }    
}
