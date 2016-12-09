<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 *  Admin Assets
 *
 *  @author Muhamad Alfan <muhamad.alfan01@gmail.com>
 *  @since  1.0
 */
class FileInputAsset extends AssetBundle
{
    public $sourcePath = '@plugins/fileinput';

    public $js = [
        'fileinput.min.js',
    ];

    public $depends = [
        'app\assets\AdminAsset',
    ];
}
