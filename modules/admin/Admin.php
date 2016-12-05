<?php

namespace modules\admin;

use Yii;

class Admin extends \yii\base\Module
{
    public $controllerNamespace = 'modules\admin\controllers';

    public function init()
    {
        //set alias module (biar namespace tidak terlalu panjang)
        Yii::setAlias('@accessUser', dirname(dirname(__DIR__)) . '/modules/admin/accessUser');

        parent::init();
        //set default route
        $this->defaultRoute = 'access-user';

        //set module-module yang perlu login
        $this->modules = [
            'access-user' => [
                'class'  => 'accessUser\Module',
            ],
            'event' => [
                'class' => 'modules\admin\event\Module',
            ],
            'admin' => [
                'class' => 'mdm\admin\Module',
            ],
        ];
    }
}
