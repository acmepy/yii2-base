<?php 
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use acmepy\base\widgets\Navbar;
use acmepy\base\widgets\Sidebar;
use app\models\Users;

/* @var $this \yii\web\View */
/* @var $content string */

//Yii::$app->user->logout();
if (Yii::$app->controller->action->id === 'login') { 
	acmepy\base\AdminLte3\LoginLteAssetSample::register($this);
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
	acmepy\base\AdminLte3\AdminLteAsset::register($this);
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
<!--body class="hold-transition sidebar-mini layout-fixed"--> <!--onload="onLoad()"-->
<body class="sidebar-mini layout-fixed text-sm"> <!--control-sidebar-slide-open--><!--onload="onLoad()"-->
	<?php $this->beginBody() ?>
	<div class="wrapper">
		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<!-- Content Header (Page header) -->
			<div class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<br><br>
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
			'items' => [
				'title'  => (Yii::$app->name!=$this->title?'<h3 class="m-0 text-light">' . Html::encode($this->title) .'</h3>':'  '),
				'search' => false
			],
		]); ?>
		<!-- Main Sidebar Container -->
		<?= Sidebar::widget([
			'directoryAsset' => $directoryAsset,
			'brand' => [
				'image' => $directoryAsset . '/dist/img/AdminLTELogo.png',
				'alt'   => Yii::$app->name,
				'text'  => Yii::$app->name,
				'href'  => Yii::getAlias('@web'),
			],
			'user' => [
				'photo' => Yii::getAlias('@web').'/img/avatar.png',
				'name'  => Yii::$app->user->identity->userdesc,
				'logout'  => Yii::getAlias('@web') . '/site/logout',
			],
			'items' => [
				['label' => 'Inicio', 'fa-icon' => 'fas fa-tachometer-alt', 'active' => 'active', 'href' =>  Yii::getAlias('@web')],
				['label' => 'Asambleas', 'fa-icon' => 'fab fa-stack-overflow', 'active' => 'active', 'href' =>  Yii::getAlias('@web'). '/asambleas'],
				['label' => 'Afiliados', 'fa-icon' => 'fas fa-grip-horizontal', 'active' => 'active', 'href' =>  Yii::getAlias('@web'). '/asambleaspadron'],
				['label' => 'Acreditados', 'fa-icon' => 'fas fa-users', 'active' => 'active', 'href' => Yii::getAlias('@web'). '/asambleasacreditados'],
				['label' => 'Mesas', 'fa-icon' => 'fas fa-th-large', 'active' => 'active', 'href' =>  Yii::getAlias('@web'). '/asambleasmesas'],
				//['label' => 'Votos', 'fa-icon' => 'fas fa-person-booth', 'active' => 'active', 'href' =>  'index'],
				[
					'label' => 'Configuración',
					'fa-icon' => 'fas fa-cogs', 
					'items' => [
						['label' => 'Usuarios',             'href' => Yii::getAlias('@web'). '/auth/users',         'fa-icon' => 'fas fa-users-cog'],
						['label' => 'Grupos',               'href' => Yii::getAlias('@web'). '/auth/groups',        'fa-icon' => 'fas fa-user-friends'],
						['label' => 'Grupos por Usuarios',  'href' => Yii::getAlias('@web'). '/auth/authassignment','fa-icon' => 'fas fa-users'],
						['label' => 'Accesos a grupos',     'href' => Yii::getAlias('@web'). '/auth/authitemchild', 'fa-icon' => 'fas fa-user-shield'],
						['label' => 'Permisos disponibles', 'href' => Yii::getAlias('@web'). '/auth/authitem',      'fa-icon' => 'fas fa-user-tag'],
						['label' => 'Auditoria',            'href' => Yii::getAlias('@web'). '/auth/history',       'fa-icon' => 'fas fa-user-tag'],
					],
				],
			],
		]); ?>
		<!--footer class="main-footer">
			<?= Breadcrumbs::widget([
				'homeLink' => ['label' => 'Inicio', 'url' => Yii::getAlias('@web')],
				'itemTemplate' => '<li class="breadcrumb-item">{link}</li>',
				'activeItemTemplate' => '<li class="breadcrumb-item active">{link}</li>',
				'links'   => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [''],
				'options' => ['class' => 'breadcrumb float-sm-left']
			])?>
			<div class="float-right d-none d-sm-inline-block">
				<b>Version</b> 1.0.0
			</div>
		</footer-->
	</div>
	<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
<?php } ?>
