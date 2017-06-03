<?php

namespace shop\models\query;

/**
 * This is the ActiveQuery class for [[\shop\models\Review]].
 *
 * @see \shop\models\Review
 */
class ReviewQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

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
}
