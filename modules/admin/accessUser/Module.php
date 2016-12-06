<?php

namespace accessUser;

use Yii;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'accessUser\controllers';

    public function init()
    {
        $this->defaultRoute = 'profile';
        parent::init();
    }
}
