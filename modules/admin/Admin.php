<?php

namespace modules\admin;

class Admin extends \yii\base\Module
{
    public $controllerNamespace = 'modules\admin\controllers';
     
    public function init()
    {
        parent::init();

        // custom initialization code goes here
        $this->modules = [
            'event' => [
                'class' => 'modules\admin\event\Module',
            ], 
            'admin' => [
                'class' => 'mdm\admin\Module',
            ],

        ];
    }
}
