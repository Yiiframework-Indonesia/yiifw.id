<?php

use yii\helpers\Html;
use app\widgets\Panel;
/* @var $this yii\web\View */
/* @var $model modules\admin\category\models\PostCategory */

$this->title = 'Update Post Category: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Post Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="post-category-update">

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
