<?php

use yii\helpers\Html;
use app\widgets\MenuAdmin;

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
        <div class="profile">
            <div class="profile_pic">
                <?=Html::img('@web/img/default.jpg', ['class' => 'img-circle profile_img', 'alt' => '...'])?>
            </div>
            <div class="profile_info">
                <span>Assalamu 'alaikum,</span>
                <h2><?=Yii::$app->user->identity->profile->fullname?></h2>
            </div>
        </div>

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <h3>Role User</h3>
                <?php
                    $menuGeneral = [
                        ['label' => 'Home', 'url' => ['/dashboard/users/index'], 'icon' => 'home'],
                        ['label'  => 'Control Panel<span class="fa fa-chevron-down"></span>', 'url' => ['#'], 'icon' => 'wrench',
                            'items'   => [
                                ['label' => 'User Accounts', 'url' => ['/ma/user/index']],
                                ['label' => 'Systems', 'url' => ['/ma/systems/index']],
                            ],
                        ],
                        ['label'  => 'Help<span class="fa fa-chevron-down"></span>', 'url' => "#", 'icon' => 'question-circle ',
                            'items'   => [
                                ['label' => 'Faq', 'url' => ['#']],
                                ['label' => 'About', 'url' => ['#']],
                            ],
                        ],
                    ];

                    echo MenuAdmin::widget([
                        'items'   => $menuGeneral,
                        'options' => ['class' => 'nav side-menu'],
                        'submenuTemplate' => "\n<ul class='nav child_menu'>\n{items}\n</ul>\n",
                    ]);
                ?>
            </div>
        </div>
    </div>
</div>