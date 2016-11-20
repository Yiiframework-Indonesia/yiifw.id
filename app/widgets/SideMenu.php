<?php

namespace app\widgets;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\base\Widget;

/**
 * Description of SideMenu
 *
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @since 1.0
 */
class SideMenu extends Widget
{
    public $items = [];

    public function renderItems($items)
    {
        $lines = [];
        foreach ($items as $item) {
            if (is_string($item)) {
                $lines[] = $item;
                continue;
            }
            if (isset($item['visible']) && !$item['visible']) {
                continue;
            }
            $lines[] = $this->renderItem($item);
        }
        return Html::tag('ul', implode("\n", $lines), ['class' => 'acc-menu']);
    }

    public function renderItem($item)
    {
        $label = ArrayHelper::getValue($item, 'label');
        if ($icon = ArrayHelper::getValue($item, 'icon')) {
            $label = "<span class='icon'><i class='material-icons'>{$icon}</i></span><span>{$label}</span>";
            if ($badge = ArrayHelper::getValue($item, 'badge')) {
                $label .= "<span class='badge badge-{$badge[0]}'>{$badge[1]}</span>";
            }
        }
        $url = ArrayHelper::getValue($item, 'url', '#');
        $content = Html::a($label, $url, ['class' => 'withripple']);
        if (isset($item['items']) && is_array($item['items'])) {
            $content .= "\n" . $this->renderItems($item['items']);
        }
        return Html::tag('li', $content);
    }

    public function run()
    {
        return $this->renderItems($this->items);
    }
}
