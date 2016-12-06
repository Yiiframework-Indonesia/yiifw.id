<?php

namespace category\models;


use paulzi\nestedintervals\NestedIntervalsBehavior;
use app\models\ar\User;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "post_category".
 *
 * @property integer $id
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property integer $visible
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $lft
 * @property integer $rgt
 * @property integer $depth
 *
 * @property Post[] $posts
 * @property User $updatedBy
 */
class PostCategory extends \yii\db\ActiveRecord
{
    
    public $parent_id;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post_category';
    }
    
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->visible = 1;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['created_by', 'updated_by', 'created_at', 'updated_at', 'visible', 'parent_id'], 'integer'],
            [['description'], 'string'],
            [['slug', 'title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'slug' => 'Slug',
            'description' => 'Description',
            'visible' => 'Visible',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            BlameableBehavior::className(),
            TimestampBehavior::className(),
//            [
//                'class' => TimestampBehavior::className(),
//                'createdAtAttribute' => 'created_at',
//                'updatedAtAttribute' => 'updated_at',
//                'value' => new Expression('NOW()'),
//            ],
            'sluggable' => [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
            ],
            'nestedInterval' => [
                'class' => NestedIntervalsBehavior::className(),
                'leftAttribute' => 'lft',
                'rightAttribute' => 'rgt',
                'amountOptimize' => '25',
                'noPrepend' => true,
            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }
    
  
    
    /**
     * Return all categories.
     *
     * @param bool $asArray
     *
     * @return static[]
     */
    public static function getCategories($skipCategories = [])
    {
        $result = [];
        $categories = PostCategory::findOne(1)->getDescendants()->all();

        foreach ($categories as $category) {
            if (!in_array($category->id, $skipCategories)) {
                $result[$category->id] = str_repeat('   ', ($category->depth - 1)) . $category->title;
            }
        }

        return $result;
    }
    
    
    public static function find()
    {
        return new PostCategoryQuery(get_called_class());

    }
    /**
     *
     * @inheritdoc
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        $parent = null;

        if (isset($this->parent_id) && $this->parent_id) {
            $parent = PostCategory::findOne((int)$this->parent_id);
        }

        if (!$parent) {
            $parent = PostCategory::findOne(1);
        }

        if (!$parent) {
            throw new \yii\base\InvalidParamException();
        }


        $this->appendTo($parent);

        try {
            return parent::save($runValidation, $attributeNames);
        } catch (yii\base\Exception $exc) {
            \Yii::$app->session->setFlash('crudMessage', $exc->getMessage());
        }

    }
}
