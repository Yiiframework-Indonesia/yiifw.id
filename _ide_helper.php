<?php

exit("This file should not be included, only analyzed by your IDE");

class Yii extends \yii\BaseYii
{
    /**
     *
     * @var \local\Application
     */
    public static $app;
}

namespace yii\web {

    /**
     * 'username', 'fullname', 'address', 'bio',
      'gender', 'avatarUrl', 'email', 'company'
     * @property string $username Description
     * @property string $fullname Description
     * @property string $address Description
     * @property string $bio Description
     * @property string $gender Description
     * @property string $avatarUrl Description
     * @property string $email Description
     * @property \app\models\ar\Company $company Description
     * @property \app\models\ar\User|\app\models\ar\Device $identity
     */
    class User extends \yii\base\Component
    {

    }

    /**
     * @property \app\classes\TokenManager $tokenManager
     * @property \yii\authclient\Collection $authClientCollection
     * @property \dee\tools\State $clientProfile
     * @property User $user
     * @property \dee\queue\Queue $queue
     * 
     */
    class Application extends \yii\base\Application
    {
        public function handleRequest($request)
        {

        }
    }

}
