<?php

namespace app\models\query;

use app\models\Slideshow;

/**
 * This is the ActiveQuery class for [[\app\models\Slideshow]].
 *
 * @see \app\models\Slideshow
 */
class SlideshowQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \app\models\Slideshow[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \app\models\Slideshow|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function active()
    {
        $this->andWhere(['status' => Slideshow::STATUS_ACTIVE]);
        return $this;
    }

}
