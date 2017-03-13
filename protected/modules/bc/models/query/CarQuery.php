<?php

namespace bc\models\query;

/**
 * This is the ActiveQuery class for [[\bc\models\Car]].
 *
 * @see \bc\models\Car
 */
class CarQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \bc\models\Car[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \bc\models\Car|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
