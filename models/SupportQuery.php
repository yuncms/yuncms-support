<?php

namespace yuncms\support\models;

/**
 * This is the ActiveQuery class for [[Support]].
 *
 * @see Support
 */
class SupportQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /*public function active()
    {
        return $this->andWhere(['status' => Support::STATUS_PUBLISHED]);
    }*/

    /**
     * @inheritdoc
     * @return Support[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Support|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
