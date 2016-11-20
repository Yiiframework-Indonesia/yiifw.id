<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\models\form\Login */

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-lg-4 col-lg-offset-4">
        <div class="panel panel-default">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
            <div class="panel-heading">SIGN IN FORM</div>
            <div class="panel-body">
                <?= $form->field($model, 'username')->textInput(['placeholder' => 'username'])->label(false) ?>
                <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'password'])->label(false) ?>
                <?= $form->field($model, 'rememberMe')->checkbox() ?>
                <div style="color:#999;margin:1em 0">
                    If you forgot your password you can <?= Html::a('reset it', ['request-password-reset']) ?>.
                    For new user you can <?= Html::a('signup', ['signup']) ?>.
                </div>
            </div>
            <div class="panel-footer">
                <div class="clearfix">
<!--                    <a href="<?= Url::to(['signup'])?>" class="btn btn-default pull-left">Sign Up</a>-->
                    <button type="submit" class="btn btn-primary btn-raised pull-right">
                        <i class="fa fa-btn fa-sign-in"></i> Sign In
                    </button>
                </div>
                <a href="<?= Url::to(['auth', 'authclient' => 'facebook'])?>" class="btn btn-inverse btn-raised btn-block"><i class="fa fa-facebook"></i> Sign In with facebook</a>
                <a href="<?= Url::to(['auth', 'authclient' => 'google'])?>" class="btn btn-danger btn-raised btn-block"><i class="fa fa-google"></i> Sign In with Google</a>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>