<?php

/* @var $this yii\web\View */
/* @var $user common\models\ar\User */

$activateLink = Yii::$app->urlManager->createAbsoluteUrl(['/user/activate', 'token' => $activateToken]);
$rejectLink = Yii::$app->urlManager->createAbsoluteUrl(['/user/activate', 'token' => $rejectToken]);
?>
Hello <?= $user->username ?>,

Follow the link below to activate your account:

<?= $activateToken ?>

Or the link bellow to reject:

<?= $rejectLink ?>