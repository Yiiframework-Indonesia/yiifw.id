<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

use app\components\grid\GridView;
use app\components\grid\GridPageSize;

use modules\admin\category\models\PostCategory;
/* @var $this yii\web\View */
/* @var $searchModel modules\admin\category\models\PostCategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Post Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-category-index">
    <?php
        app\widgets\Panel::begin(
            [
                'header' => Html::encode($this->title),
                'icon' => 'cog',
            ]
        )
    ?>
    
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    
    <div class="row">
                <div class="col-sm-12 text-right">
                    <?= GridPageSize::widget(['pjaxId' => 'post-category-grid-pjax']) ?>
                </div>
            </div>
   <?php Pjax::begin(['id' => 'post-category-grid-pjax']) ?>
    <?= GridView::widget([
        'id' => 'post-category-grid',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'bulkActionOptions' => [
                    'gridId' => 'post-category-grid',
                    'actions' => [Url::to(['bulk-delete']) =>  'Delete']
        ],
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            ['class' => 'yii\grid\CheckboxColumn', 'options' => ['style' => 'width:10px']],
            [
                        'class' => 'app\components\grid\columns\TitleActionColumn',
                        'controller' => '/post/category',
                        'title' => function (PostCategory $model) {
                            return Html::a($model->title, ['/post/category/update', 'id' => $model->id], ['data-pjax' => 0]);
                        },
                        'buttonsTemplate' => '{update} {delete}',
            ],
            [
                        'attribute' => 'parent_id',
                        'value' => function (PostCategory $model) {

                            if ($parent = $model->getParent()->one() AND $parent->id > 1) {
                                return Html::a($parent->title, ['/admin/category/default/update', 'id' => $parent->id], ['data-pjax' => 0]);
                            } else {
                                return '<span class="not-set">' . Yii::t('yii', '(not set)') . '</span>';
                            }

                        },
                        'format' => 'raw',
                        'filter' => PostCategory::getCategories(),
                        'filterInputOptions' => ['class' => 'form-control', 'encodeSpaces' => true],
            ],
            'description:ntext',
            [
                        'class' => 'app\components\grid\columns\StatusColumn',
                        'attribute' => 'visible',
                        'filterInputOptions' => ['class' => 'form-control', 'encodeSpaces' => true],
            ],
          
        ],
    ]); ?>
    <?php Pjax::end() ?>
    <?php app\widgets\Panel::end()?>
</div>
