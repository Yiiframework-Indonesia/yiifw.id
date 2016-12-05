<?php

namespace app\models\form;

use accessUser\models\User;
use Yii;
use yii\base\Model;

/**
 * Password reset request form
 */
class PasswordResetRequest extends Model
{
    public $email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => 'accessUser\models\User',
                'filter'      => ['status' => User::STATUS_ACTIVE],
                'message'     => 'There is no user with such email.',
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return boolean whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'email'  => $this->email,
        ]);

        if ($user) {
            $token = Yii::$app->tokenManager->generateToken($user->id, 'reset.password', Yii::$app->params['user.passwordResetTokenExpire']);
            return Yii::$app->mailer->compose([
                'html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'], [
                'user' => $user, 'token' => $token])
                ->setFrom([Yii::$app->params['supportEmail'] => 'yiiframework.id robot'])
                ->setTo($this->email)
                ->setSubject('Password reset for yiiframework.id')
                ->send();
        }

        return false;
    }
}
