<?php
namespace shop\models\query;
use Yii;
use shop\models\Product;

/**
 * This is the ActiveQuery class for [[\shop\models\Product]].
 *
 * @see \shop\models\Product
 */
class ProductQuery extends \yii\db\ActiveQuery
{
    /**
     * @inheritdoc
     * @return \shop\models\Product[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \shop\models\Product|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function active() {
        $this->andWhere(['status' => Product::STATUS_ACTIVE]);
        return $this;
    }

    public function instock() {
        $this->andWhere(['quantity > 0']);
        return $this;
    }

    public function visible() {
        $this->andWhere(['<', 'available_time', date('Y-m-d H:i:s')]);
        return $this;
    }

    public function bySlug($slug) {
        $this->andWhere([
            'slug' => Yii::$app->helper->normalizeSlug($slug)
        ]);
        return $this;
    }
}
