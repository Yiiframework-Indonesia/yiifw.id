<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;
use app\widgets\Panel;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \accessUser\models\UserProfile */

$this->title = 'Update Profile';
$this->params['breadcrumbs'][] = ['label' => 'Profile', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Panel::begin(
    [
        'header' => 'Update Profile',
        'icon'   => 'user',
    ]
)?>
<div class="update-profile col-sm-7">
    <p>Please fill out the following fields to change your profile.</p><br>
    <?php $form = ActiveForm::begin(['id' => 'form-change', 'layout' => 'horizontal']); ?>
        <?= $form->field($model, 'fullname') ?>
        <?= $form->field($model, 'bio') ?>
        <?= $form->field($model, 'birth_day')->widget(DatePicker::classname(), [
            'type' => DatePicker::TYPE_COMPONENT_APPEND,
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'yyyy-mm-dd'
            ]
        ]) ?>
        <?= $form->field($model, 'address') ?>
        <?= $form->field($model, 'gender')->radioList(['Male' => 'Male', 'Female' => 'Female']); ?>
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-4">
                <?= Html::resetButton('Reset', ['class' => 'btn btn-default', 'name' => 'change-button']) ?>
                <?= Html::submitButton('Save', ['class' => 'btn btn-primary', 'name' => 'change-button']) ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
</div>
<?php Panel::end()?>