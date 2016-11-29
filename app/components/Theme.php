<?php
namespace app\components;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Theme
 *
 * @author Henry <alvin_vna@yahoo.con>
 */
class Theme extends \yii\base\Theme {
    /**
     * Theme folder name
     *
     * @var string
     */
    public $theme;

    public function init()
    {
        parent::init();

        if (!isset($this->theme)) {
            $this->theme = 'default';
        }

        $this->basePath = '@app/themes/' . $this->theme . '/web';
        $this->baseUrl = '@web/themes/' . $this->theme . '/web';
        $this->pathMap = [
            '@app/views' => '@app/themes/' . $this->theme . '/views',
        ];
    }
}
