<?php

namespace app\classes;

use yii\base\Behavior;
use yii\helpers\ArrayHelper;
use yii\web\User;

/**
 * Description of UserInfo
 *
 * @property User $owner Description
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class UserInfo extends Behavior
{
    private $_profile;

    protected function initProfile()
    {
        if ($this->_profile !== null) {
            return;
        }
        $this->_profile = [];
        /* @var $identity \app\models\ar\User */
        if (($identity = $this->owner->identity) !== null) {
            if (($profile = $identity->profile) !== null) {
                $this->_profile = [
                    'fullname' => $profile->fullname,
                    'address' => $profile->address,
                    'bio' => $profile->bio,
                    'gender' => $profile->gender,
                    'avatarUrl' => $profile->avatarUrl,
                ];
            }
            $this->_profile['username'] = $identity->username;
            $this->_profile['email'] = $identity->email;
            $this->_profile['company'] = $identity->company;
        }
    }

    /**
     * @inheritdoc
     */
    public function canGetProperty($name, $checkVars = true)
    {
        return in_array($name, ['username', 'fullname', 'address', 'bio',
            'gender', 'avatarUrl', 'email', 'company']);
    }

    /**
     * @inheritdoc
     */
    public function __get($name)
    {
        $this->initProfile();
        return ArrayHelper::getValue($this->_profile, $name);
    }
}
