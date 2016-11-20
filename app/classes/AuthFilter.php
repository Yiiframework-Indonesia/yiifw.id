<?php

namespace app\classes;

use Yii;
use yii\base\ActionFilter;
use yii\di\Instance;
use yii\web\User;
use yii\web\ForbiddenHttpException;

/**
 * Description of AuthFilter
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class AuthFilter extends ActionFilter
{
    /**
     *
     * @var User 
     */
    public $user = 'user';

    /**
     *
     * @var \Closure|string
     */
    public $rule;

    /**
     * @var array
     */
    public $roles = [];

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
        if ($this->user->getIsGuest()) {
            $this->user->loginRequired();
            return false;
        }
        $actionId = $this->getActionId($action);
        if ($this->rule !== null) {
            $callback = is_string($this->rule) ? [$this->owner, $this->rule] : $this->rule;
            if (!call_user_func($callback, $this->user, $actionId, $action)) {
                throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
            }
        }
        if (!empty($this->roles)) {
            foreach ($this->roles as $role) {
                if ($this->user->can($role)) {
                    return true;
                }
            }
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }
        return true;
    }
}
