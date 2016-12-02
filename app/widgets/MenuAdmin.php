<?php

namespace app\widgets;

use rmrevin\yii\fontawesome\FontAwesome;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\Menu;

/**
 *  Custom Menu dengan tambahan icon
 *
 *  Cara menggunakan
 *  ```php
 *  <?= MenuAdmin::widget([
 *      'items' => [
 *          [
 *              'label' => 'Menu',
 *              'url' => ['url'],
 *              'icon' => 'icon'
 *          ],
 *      ]
 *      'options' => ['class' => 'main-menu'],
 *  ])?>
 *  ```
 *
 *  @author Muhamad Alfan <muhamad.alfan01@gmail.com>
 *  @since  1.0
 */

class MenuAdmin extends Menu
{
    /**
     * Encode label
     *
     * @var boolean
     */
    public $encodeLabels = false;

    /**
     * Aktif css class
     *
     * @var string
     */
    public $activeCssClass = 'current-page';

    /**
     * Aktif parents menu
     *
     * @var boolean
     */
    public $activateParents = true;

    /**
     * Initial template html dan label
     *
     * @return mixed
     */
    public function init()
    {
        parent::init();
        $this->linkTemplate  = '<a href="{url}">{icon}{label}</a>';
    }

    /**
     * Render untuk setiap item menu
     *
     * @param  array $item [item menu]
     * @return string [tag html]
     */
    protected function renderItem($item)
    {
        $template = ArrayHelper::getValue($item, 'template', $this->linkTemplate);
        $url      = Url::to(ArrayHelper::getValue($item, 'url', '#'));
        $icon     = empty($item['icon']) ? '' : FontAwesome::i($item['icon']);
        unset($item['icon']);
        return strtr($template, [
            '{url}'   => $url,
            '{label}' => $item['label'],
            '{icon}'  => $icon,
        ]);
    }
}
