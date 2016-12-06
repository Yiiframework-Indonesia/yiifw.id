<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use category\models\PostCategory as Category;

/* @var $this yii\web\View */
/* @var $model modules\admin\category\models\PostCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-category-form">

    <?php
    $form = ActiveForm::begin([
        'id' => 'post-category-form',
        'validateOnBlur' => false,
    ]);
            
   
    ?>

    <div class="row">
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-body">

                   

                    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

                    <?php echo $form->field($model, 'parent_id')->dropDownList(Category::getCategories(), ['prompt' => '', 'encodeSpaces' => true]) ?>

                    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="record-info">

                        <?= $form->field($model, 'visible')->checkbox() ?>

                        <div class="form-group">
                            <?php if ($model->isNewRecord): ?>
                                <?= Html::submitButton('Create', ['class' => 'btn btn-primary']) ?>
                                <?= Html::a('Cancel', ['/admin/category/default'], ['class' => 'btn btn-default']) ?>
                            <?php else: ?>
                                <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
                                <?= Html::a('Delete', ['/admin/category/delete', 'id' => $model->id], [
                                    'class' => 'btn btn-default',
                                    'data' => [
                                        'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                        'method' => 'post',
                                    ],
                                ])
                                ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
