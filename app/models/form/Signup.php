<?php

namespace app\models\form;

use Yii;
use app\models\ar\User;
use app\models\ar\UserProfile;
use yii\base\Model;

/**
 * Signup form
 */
class Signup extends Model
{
    public $username;
    public $fullname;
    public $email;
    public $password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'in', 'not' => true,
                'range' => ['admin', 'administrator', 'superadmin', 'super', 'root']],
            ['username', 'unique', 'targetClass' => '\app\models\ar\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            [['fullname'], 'required'],
            [['fullname'], 'string', 'min' => 3, 'max' => 255],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\app\models\ar\User', 'message' => 'This email address has already been taken.'],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->status = $user::STATUS_PANDING;
            return Yii::$app->getDb()->transaction(function() use($user) {
                    if ($user->save()) {
                        $profile = new UserProfile([
                            'fullname' => $this->fullname,
                        ]);
                        $user->link('profile', $profile);
                        $this->sendEmail($user);
                        Yii::$app->session->setFlash('success', 'Registration success. Check your email');
                        return $user;
                    }
                });
        }

        return null;
    }

    public function sendEmail($user)
    {
        /* @var $mailer \yii\mail\BaseMailer */
        /* @var $message \yii\mail\BaseMessage */
        $params = [
            'user' => $user,
            'activateToken' => Yii::$app->tokenManager
                ->generateToken(['activate', $user->id], 'activate.account', Yii::$app->params['user.activateExpire']),
            'rejectToken' => Yii::$app->tokenManager->generateToken(['reject', $user->id], 'activate.account'),
        ];

        return Yii::$app->mailer->compose(['html' => 'activationAccount-html', 'text' => 'activationAccount-text'], $params)
                ->setFrom([Yii::$app->params['supportEmail'] => 'yiiframework.id robot'])
                ->setTo($this->email)
                ->setSubject('Activation account for yiiframework.id')
                ->send();
    }
}
