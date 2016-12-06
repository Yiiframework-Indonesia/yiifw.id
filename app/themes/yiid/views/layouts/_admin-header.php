<!-- top navigation -->
<?php

use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;
use rmrevin\yii\fontawesome\FontAwesome;

?>
<div class="top_nav">
	<div class="nav_menu">

        <?php NavBar::begin([
            'options' => [
                'class' => '',
                'role'=>'navigator'
            ],
            'innerContainerOptions' => [
                //'class' => 'container-fluid'
            ]
		]);?>
                
		<?=Nav::widget([
                    'encodeLabels' => false,
		    'items' => [
		    	['label' => FontAwesome::i('bars'), 'url' => '#', 'linkOptions' => ['id' => 'menu_toggle']],
		        [
		            'label' => substr(Yii::$app->user->identity->profile->fullname,0,10),
		            'items' => [
		                [
				            'label' => 'Profile',
				            'url' => ['/admin/access-user/profile/index'],
						],
						[
				            'label' => 'Change Password',
				            'url' => ['/admin/access-user/profile/change-password'],
						],
		                [
				            'label' => 'Log Out',
				            'url' => ['/user/logout'],
							'linkOptions' => ['data-method' => 'post']
						],
		            ],
		            'options' => ['class' =>'pull-right'],
		        ],
		        
		    ],
		    'options' => ['class' =>'nav-pills'],
		]);?>

		<?php NavBar::end();?>

	</div>
</div>