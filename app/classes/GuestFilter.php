<?php

namespace app\classes;

use Yii;
use yii\base\ActionFilter;
use yii\di\Instance;
use yii\web\User;
use yii\web\ForbiddenHttpException;

/**
 * Description of GuestFilter
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class GuestFilter extends ActionFilter
{
    /**
     *
     * @var User 
     */
    public $user = 'user';

    public function init()
    {
        $this->user = Instance::ensure($this->user, User::className());
    }

    /**
     *
     * @param \yii\base\Action $action
     * @return boolean
     */
    public function beforeAction($action)
    {
        if (!$this->user->getIsGuest()) {
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }
        return true;
    }
}
