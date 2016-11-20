<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\models\ar\UserProfile */

$this->title = 'Update Profile';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <?php
            $form = ActiveForm::begin([
                    'id' => 'form-profile',
                    'options' => [
                        'enctype' => 'multipart/form-data',
                        'class' => 'form-horizontal tabular-form'
                    ],
                    'fieldConfig' => [
                        'template' => '{label} <div class="col-sm-8">{input}</div>',
                        'labelOptions' => ['class' => 'col-sm-2 control-label']
                    ],
            ]);
            ?>
            <?= $form->field($model, 'fullname') ?>
            <?= $form->field($model, 'bio') ?>
            <?= $form->field($model, 'address') ?>
            <?= $form->field($model, 'gender')->dropDownList(['male' => 'male', 'female' => 'female']) ?>
            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
