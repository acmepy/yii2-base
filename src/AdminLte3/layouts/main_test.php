<?php 
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\hjg\base\widgets\Navbar;
use app\hjg\base\widgets\Sidebar;

/* @var $this \yii\web\View */
/* @var $content string */

//Yii::$app->user->logout();
if (Yii::$app->controller->action->id === 'login') { 
	app\hjg\themes\AdminLte3\LoginLteAsset::register($this);
?>
<!DOCTYPE html>
<?php $this->beginPage() ?>
<html lang="<?= Yii::$app->language ?>">
	<head>
		<meta charset="<?= Yii::$app->charset ?>"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?= Html::csrfMetaTags() ?>
		<title><?= Html::encode($this->title) ?></title>
		<?php $this->head() ?>
		<?= Html::csrfMetaTags() ?>
		<?php $this->head() ?>
	</head>
	<body class="login-page">
	<?php $this->beginBody() ?>
		<?= $content ?>
	<?php $this->endBody() ?>
	</body>
</html>
<?php $this->endPage();
}else{
	app\hjg\themes\AdminLte3\AdminLteAsset::register($this);
	$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte'); 
?>
<!DOCTYPE html>
<?php $this->beginPage() ?>
<html lang="<?= Yii::$app->language ?>">
<head>
	<meta charset="<?= Yii::$app->charset ?>"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?= Html::encode($this->title.' | '/*.(isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : 'Home')*/) ?></title>
	<?= Html::csrfMetaTags() ?>
	<!-- Tell the browser to be responsive to screen width -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
		<?php $this->head() ?>
</head>
<body class="hold-transition sidebar-mini layout-fixed"> <!--onload="onLoad()"-->
	<?php $this->beginBody() ?>
	<div class="wrapper">
		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<div class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<br><br><h1 class="m-0 text-dark"><?= Html::encode($this->title) ?></h1>
						</div><!-- /.col -->
						<div class="col-sm-6">
							<?= Breadcrumbs::widget([
								'itemTemplate' => '<li class="breadcrumb-item">{link}</li>',
								'activeItemTemplate' => '<li class="breadcrumb-item active">{link}</li>',
								'links'   => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [''],
								'options' => ['class' => 'breadcrumb float-sm-right']])
							?>
						</div><!-- /.col -->
					</div><!-- /.row -->
				</div><!-- /.container-fluid -->
			</div>
			<!-- /.content-header -->
			<section class="content">
				<div class="container-fluid">
					<?= $content ?> 
				</div>
			</section>
			<!-- /.content-wrapper -->
			<!-- Control Sidebar -->
			<aside class="control-sidebar control-sidebar-dark">
				<!-- Control sidebar content goes here -->
			</aside>
			<!-- /.control-sidebar -->
		</div>
		<!-- Navbar -->
		<?= Navbar::widget([
			'directoryAsset' => $directoryAsset,
		]); ?>
		<!-- Main Sidebar Container -->
		<?= Sidebar::widget([
			'directoryAsset' => $directoryAsset,
		]); ?>
		<footer class="main-footer">
		  <strong>Copyright &copy; 2020 <a href="http://acmepy.com">Acme Lab</a>.</strong>
		  All rights reserved.
		  <div class="float-right d-none d-sm-inline-block">
			<b>Version</b> 3.0.1
		  </div>
		</footer>
	</div>
	<!-- ./wrapper -->
	<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
<?php } ?>
