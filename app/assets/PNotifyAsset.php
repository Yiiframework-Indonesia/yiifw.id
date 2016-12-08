<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 *  Admin Assets
 *
 *  @author Muhamad Alfan <muhamad.alfan01@gmail.com>
 *  @since  1.0
 */
class PNotifyAsset extends AssetBundle
{
    public $sourcePath = '@plugins/pnotify';

    public $css = [
        'pnotify.css',
        'pnotify.buttons.css',
        'pnotify.nonblock.css',
    ];

    public $js = [
        'pnotify.js',
        'pnotify.buttons.js',
        'pnotify.nonblock.js',
    ];

    public $depends = [
        'app\assets\AdminAsset',
    ];
}
