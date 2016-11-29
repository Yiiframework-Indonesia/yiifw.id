<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\assets;

use Yii;
use yii\web\AssetBundle;
use yii\web\View;

/**
 * Description of ThemeAsset
 *
 * @author Alvina
 */
class ThemeAsset extends AssetBundle{
    public $css = [
        'css/theme.css',
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'app\assets\AppAsset',
        //'rmrevin\yii\fontawesome\AssetBundle',
    ];

    public function init()
    {
        parent::init();
        if (isset(Yii::$app->view->theme->basePath)) {
            $this->sourcePath = Yii::$app->view->theme->basePath;
        }
    }

    /**
     * Registers this asset bundle with a view.
     * @param \yii\web\View $view the view to be registered with
     * @return static the registered asset bundle instance
     */
    public static function register($view)
    {
        $js = <<<JS
            $('[data-toggle="tooltip"]').tooltip()
JS;

        $view->registerJs($js, View::POS_READY);

        return parent::register($view);
    }
}
