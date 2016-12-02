<?php

namespace app\widgets;

use rmrevin\yii\fontawesome\component\Icon;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
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


/**
 *  Change Render Item Function.
 * 
 *  @author Henry <alvin_vna@yahoo.com>
 */
class MenuAdmin extends Menu
{   
    
    /**
     * @inheritdoc
     */
    public $labelTemplate = '{label}';
    
    /**
     * @inheritdoc
     */
    public $linkTemplate = '<a href="{url}">{icon}<span>{label}</span>{badge}</a>';
    
    
    /**
     * @inheritdoc
     */
    public $submenuTemplate = "\n<ul class=\"nav child_menu\">\n{items}\n</ul>\n";
    
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
        Html::addCssClass($this->options, 'nav side-menu');
        parent::init();
    }

    /**
     * Render untuk setiap item menu
     *
     * @param  array $item [item menu]
     * @return string [tag html]
     */
    protected function renderItem($item)
    {
        $renderedItem = parent::renderItem($item);
        if (isset($item['badge'])) {
            $badgeOptions = ArrayHelper::getValue($item, 'badgeOptions', []);
            Html::addCssClass($badgeOptions, 'label pull-right');
        } else {
            $badgeOptions = null;
        }
        return strtr(
            $renderedItem,
            [
                '{icon}' => isset($item['icon'])
                    ? new Icon($item['icon'], ArrayHelper::getValue($item, 'iconOptions', []))
                    : '',
                '{badge}' => (
                    isset($item['badge'])
                        ? Html::tag('small', $item['badge'], $badgeOptions)
                        : ''
                    ) . (
                    isset($item['items']) && count($item['items']) > 0
                        ? (new Icon('chevron-down'))->tag('span')
                        : ''
                    ),
            ]
        );
    }
}
