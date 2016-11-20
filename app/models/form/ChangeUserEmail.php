<?php

namespace app\models\form;

use Yii;
use app\models\ar\User;
use yii\base\Model;

/**
 * Description of ChangeUserEmail
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class ChangeUserEmail extends Model
{
    public $username;
    public $email;
    public $password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email', 'password'], 'required'],
            ['username', 'in', 'not' => true,
                'range' => ['admin', 'administrator', 'superadmin', 'super', 'root']],
            [['email'], 'email'],
            [['password'], 'validatePassword'],
            [['username', 'email'], 'checkUnique']
        ];
    }


    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     */
    public function validatePassword()
    {
        /* @var $user User */
        $user = Yii::$app->user->identity;
        if (!$user || !$user->validatePassword($this->password)) {
            $this->addError('password', 'Incorrect password.');
        }
    }
    
    public function checkUnique($attribute)
    {
        /* @var $user User */
        $user = Yii::$app->user->identity;
        if($this->$attribute != $user->$attribute){
            if(User::find()->where([$attribute=>  $this->$attribute])->exists()){
                $this->addError($attribute, "{$attribute} \"{$this->$attribute}\" has already been taken.");
            }
        }
    }

    /**
     * Change password.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function change()
    {
        if ($this->validate()) {
            /* @var $user User */
            $user = Yii::$app->user->identity;
            $user->username = $this->username;
            $user->email = $this->email;
            if ($user->save()) {
                return true;
            }
        }

        return false;
    }
}
