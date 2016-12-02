<!-- top navigation -->
<?php

use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;
use rmrevin\yii\fontawesome\FontAwesome;

?>
<div class="top_nav">
	<div class="nav_menu">

		<?php NavBar::begin();?>

		<?=Nav::widget([
			'encodeLabels' => false,
		    'items' => [
		    	['label' => FontAwesome::i('bars'), 'url' => '#', 'linkOptions' => ['id' => 'menu_toggle']],
		        [
		            'label' => Yii::$app->user->identity->profile->fullname,
		            'items' => [
		                [
				            'label' => 'Logout',
				            'url' => ['/user/logout'],
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