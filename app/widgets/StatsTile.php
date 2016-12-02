<?php
/**
 * @copyright Copyright (c) 2016 yiiframework.id
 */

namespace app\widgets;


use yii\base\Widget;
use yii\helpers\Html;
use rmrevin\yii\fontawesome\component\Icon;

/**
 * \app\widgets\StatsTile::widget(
 *            [
 *                'icon' => 'list-alt',
 *                'header' => 'Post',
 *                'text' => 'Jumlah Post',
 *                'number' => '10000',
 *            ]
 *       )
 *       ?>
 *
 * @author Henry <henry.finasmart@gmail.com>
 * @since 1.0
 */
class StatsTile extends Widget
{
    public $options = ['class' => 'tile-stats'];
    public $icon;
    public $header;
    public $text;
    public $number;
    public function run()
    {
        echo Html::beginTag('div', $this->options);
        if (empty($this->icon) === false) {
            echo Html::tag('div', new Icon($this->icon), ['class' => 'icon']);
        }
        echo Html::tag('div', $this->number, ['class' => 'count']);
        echo Html::tag('h3', $this->header);
        echo Html::tag('p', $this->text);
        echo Html::endTag('div');
    }
}
