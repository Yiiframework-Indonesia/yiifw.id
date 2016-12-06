<?php

namespace category;

/**
 * category module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'category\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->defaultRoute = 'category';
        parent::init();

        // custom initialization code goes here
    }
}
