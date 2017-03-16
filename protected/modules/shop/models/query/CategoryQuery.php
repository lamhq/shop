<?php

namespace shop\models\query;
use shop\models\Category;

/**
 * This is the ActiveQuery class for [[\shop\models\Category]].
 *
 * @see \shop\models\Category
 */
class CategoryQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \shop\models\Category[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \shop\models\Category|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function active()
    {
        $this->andWhere(['status' => Category::STATUS_ACTIVE]);
        return $this;
    }

    public function bySlug($slug) {
        $this->andWhere(['slug'=>$slug]);
        return $this;
    }
}
