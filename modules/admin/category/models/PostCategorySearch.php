<?php

namespace category\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use category\models\PostCategory;

/**
 * PostCategorySearch represents the model behind the search form about `modules\admin\category\models\PostCategory`.
 */
class PostCategorySearch extends PostCategory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'visible', 'created_at', 'updated_at', 'created_by', 'updated_by', 'lft', 'rgt', 'depth'], 'integer'],
            [['title', 'slug', 'description'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = PostCategory::find();

       $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->request->cookies->getValue('_grid_page_size', 20),
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ],
            ],
        ]);
       
        $this->load($params);
       
        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'visible' => $this->visible,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,

        ]);
        
        if (isset($this->parent_id) && $this->parent_id > 1) {
            $parent = PostCategory::findOne((int)$this->parent_id);
            $query->andWhere(['>', 'left_border', $parent->left_border]);
            $query->andWhere(['<', 'right_border', $parent->right_border]);
        }
        
        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
