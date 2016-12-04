<?php

use yii\helpers\Html;

use app\widgets\Panel;
/* @var $this yii\web\View */
/* @var $model modules\admin\category\models\PostCategory */

$this->title = 'Create Post Category';
$this->params['breadcrumbs'][] = ['label' => 'Post Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-category-create">
    <?php
        Panel::begin(
            [
                'header' => Html::encode($this->title),
                'icon' => 'cog',
            ]
        )
    ?>
  

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    
    <?php Panel::end() ?>

</div>
