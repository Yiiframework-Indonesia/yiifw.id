<?php

use yii\helpers\Html;
use app\widgets\MenuAdmin;
use mdm\admin\components\MenuHelper;

?>

<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <?php
                $header = Html::img('@web/favicon-32x32.png', ['alt' => '...', 'width' => '35px']);
                $header .= Html::tag('span', Yii::$app->name,['style' => 'padding-left: 5px']);

                echo Html::a($header,Yii::$app->homeUrl, ['class' => 'site_title']);
            ?>
        </div>
        
        <!-- menu profile quick info -->
        <div class="profile" style="padding-bottom: 80px">
            <div class="profile_pic">
                <?php $profile = Yii::$app->user->identity->profile;
                    if($profile && $profile->photo_id) {
                        $avatar = $profile->avatarUrl;
                    } else {
                        $avatar = '@web/img/default.jpg';
                    }
                ?>
                <?=Html::img($avatar, ['class' => 'img-circle profile_img', 'alt' => '...'])?>
            </div>
            <div class="profile_info">
                <span>Assalamu 'alaikum,</span>
                <h2>
                    <?php
                    if (Yii::$app->user->isGuest) {
                        Yii::$app->getResponse()->redirect(\Yii::$app->getUser()->loginUrl);
                    } else {
                        echo Yii::$app->user->identity->profile->fullname;
                    }
                    ?>
                    
                </h2>
            </div>
        </div>

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <h3>Role User</h3>
                <?php

                $menuCallback = function($menu) {
                    $item = [
                        'label' => $menu['name'],
                        'url' => MenuHelper::parseRoute($menu['route']),
                    ];

                    if($menu['name'] == NULL){
                         $item = [
                            'label' => 'Label Kosong',
                            'url' => MenuHelper::parseRoute($menu['route']),
                        ];
                    }

                    if (!empty($menu['data'])) {
                        $item['icon'] = 'fa ' . $menu['data'];
                    } else {
                        $item['icon'] = 'fa fa-angle-double-right';
                    }
                    if ($menu['children'] != []) {
                        $item['items'] = $menu['children'];
                    }
                    return $item;
                };
                $items = MenuHelper::getAssignedMenu(Yii::$app->user->id, null, $menuCallback);

                $menuGeneral = [
                        ['label' => 'Home', 'url' => ['#'], 'icon' => 'home'],
                        ['label' => 'Event', 'url' => ['/event/'], 'icon' => 'calendar'],
                        ['label'  => 'Control Panel', 'url' => ['#'], 'icon' => 'wrench',
                            'items'   => [
                                ['label' => 'User Accounts', 'url' => ['#']],
                                ['label' => 'Systems', 'url' => ['#']],
                            ],
                        ],
                        ['label'  => 'Help', 'url' => "#", 'icon' => 'question-circle ',
                            'items'   => [
                                ['label' => 'Faq', 'url' => ['#']],
                                ['label' => 'About', 'url' => ['#']],
                            ],
                        ],
                    ];

                    echo MenuAdmin::widget([
                        'items'   => $menuGeneral,
                    ]);
                ?>
            </div>
        </div>
    </div>
</div>