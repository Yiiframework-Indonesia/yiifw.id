<?php

namespace category\models;


use paulzi\nestedintervals\NestedIntervalsQueryTrait;


/**
 * This is the ActiveQuery class for [[Post]].
 *
 * @see Post
 */
class PostCategoryQuery extends \yii\db\ActiveQuery
{

    use NestedIntervalsQueryTrait;


    /**
     * @inheritdoc
     * @return Post[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Post|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

}
