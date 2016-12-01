<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\AdminAsset;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\widgets\Alert;

AdminAsset::register($this);
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
<body class="nav-md">
<?php $this->beginBody() ?>

    <div class="container body">
		<div class="main_container">

			<?=$this->render('_admin-sidebar.php')?>

			<?=$this->render('_admin-header.php')?>

        	<!-- page content -->
	    	<div class="right_col" role="main">
	            <?= Breadcrumbs::widget([
		            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
		        ]) ?>

				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
        				<?= $content ?>
					</div>
				</div>
				<?= Alert::widget() ?>
	        </div>

			<footer>
				<?=$this->render('_copyright.php')?>
			</footer>
		</div>
	</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
