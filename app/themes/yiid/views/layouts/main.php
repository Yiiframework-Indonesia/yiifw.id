<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AppAsset;
use app\assets\ThemeAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\widgets\Alert;

Yii::$app->assetManager->forceCopy = true;
AppAsset::register($this);
ThemeAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'Yii Framework Indonesia',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-default navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => 'Home', 'url' => ['/site/index']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Login', 'url' => ['/user/login']];
    } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/user/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer id="footer">
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-sm-6 footerleft ">
				<div class="logofooter"><?=Html::img('@web/img/yii_logo.png', ['width'=>'180px','alt'=>'Yii Framework Indonesia'])?></div>
				<p>Yii is a free, open-source Web application development framework written in PHP5 that promotes clean, DRY design and encourages rapid development. It works to streamline your application development and helps to ensure an extremely efficient, extensible, and maintainable end product.</p>
				<p><i class="fa fa-phone"></i> Phone (Indonesia) : +62 xxxx xxxx xxxx</p>
				<p><i class="fa fa-envelope"></i> E-mail : info@yiiframework.id</p>
			</div>
			<div class="col-md-2 col-sm-6 paddingtop-bottom">
				<h6 class="heading7"><i class="fa fa-sitemap"></i> MENU</h6>
				<ul class="footer-ul">
					<li><a href="#"> Home</a></li>
					<li><a href="#"> About</a></li>
					<li><a href="#"> Tutorial</a></li>
					<li><a href="#"> Case Studies</a></li>
					<li><a href="#"> Career</a></li>
					<li><a href="#"> Privacy Policy</a></li>
					<li><a href="#"> Frequently Ask Questions</a></li>
				</ul>
			</div>
			<div class="col-md-3 col-sm-6 paddingtop-bottom">
				<h6 class="heading7"><i class="fa fa-newspaper-o"></i> LATEST POST</h6>
				<div class="footer-post">	
					<p><a href="#">Blog Post</a> <span>2016</span></p>
				</div>
			</div>
			<div class="col-md-3 col-sm-6 paddingtop-bottom">
				<div class="fb-page" data-href="https://www.facebook.com/groups/yii.indonesia/" data-tabs="timeline" data-height="300" data-small-header="false" style="margin-bottom:15px;" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
					<div class="fb-xfbml-parse-ignore">
						<blockquote cite="https://www.facebook.com/groups/yii.indonesia/"><a href="https://www.facebook.com/groups/yii.indonesia/">Facebook</a></blockquote>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>

<?=$this->render('_copyright.php')?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
