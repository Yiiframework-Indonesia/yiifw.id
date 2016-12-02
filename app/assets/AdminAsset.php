<?php

namespace app\assets;

use Yii;
use yii\web\AssetBundle;

/**
 *  Admin Assets
 *
 *  @author Muhamad Alfan <muhamad.alfan01@gmail.com>
 *  @since  1.0
 */
class AdminAsset extends AssetBundle
{
    public $css = [
        'css/admin.css',
    ];

    public $js = [
        'js/admin.js',
    ];

    public $depends = [
        'app\assets\AppAsset',
        'app\assets\ThemeAsset',
    ];

    public function init()
    {
        parent::init();
        if (isset(Yii::$app->view->theme->basePath)) {
            $this->sourcePath = Yii::$app->view->theme->basePath;
        }
    }
}
