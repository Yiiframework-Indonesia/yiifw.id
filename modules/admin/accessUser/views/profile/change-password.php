<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\widgets\Panel;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \accessUser\models\form\ChangePassword */

$this->title = 'Change Password';
$this->params['breadcrumbs'][] = ['label' => 'Profile', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php Panel::begin(
    [
        'header' => 'Change Password',
        'icon'   => 'lock',
    ]
)?>
<div class="site-signup col-sm-7">
    <p>Please fill out the following fields to change password.</p><br>
    <?php $form = ActiveForm::begin(['id' => 'form-change', 'layout' => 'horizontal']); ?>
        <?= $form->field($model, 'oldPassword')->passwordInput() ?>
        <?= $form->field($model, 'newPassword')->passwordInput() ?>
        <?= $form->field($model, 'retypePassword')->passwordInput() ?>
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-4">
                <?= Html::resetButton('Reset', ['class' => 'btn btn-default', 'name' => 'change-button']) ?>
                <?= Html::submitButton('Save', ['class' => 'btn btn-primary', 'name' => 'change-button']) ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
</div>
<?php Panel::end()?>