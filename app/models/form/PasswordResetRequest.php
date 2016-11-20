<?php

namespace app\models\form;

use Yii;
use app\models\ar\User;
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
                'targetClass' => 'app\models\ar\User',
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => 'There is no user with such email.'
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
                'email' => $this->email,
        ]);

        if ($user) {
            $token = Yii::$app->tokenManager->generateToken($user->id, 'reset.password', Yii::$app->params['user.passwordResetTokenExpire']);
            return Yii::$app->queue->push('job/send-mail', [
                    'view' => ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
                    'params' => ['user' => $user, 'token' => $token],
                    'from' => [Yii::$app->params['supportEmail'] => 'yiiframework.id robot'],
                    'to' => $this->email,
                    'subject' => 'Password reset for yiiframework.id',
            ]);
        }

        return false;
    }
}
