<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\ar\User */


$activateLink = Yii::$app->urlManager->createAbsoluteUrl(['/user/activate', 'token' => $activateToken]);
$rejectLink = Yii::$app->urlManager->createAbsoluteUrl(['/user/activate', 'token' => $rejectToken]);
?>
<div class="password-reset">
    <p>Hello <?= Html::encode($user->username) ?>,</p>

    <p>Follow the link below to activate or reject your account:</p>

    <p><?= Html::a('Activate', $activateLink) ?> <?= Html::a('Reject', $activateLink) ?></p>
</div>
