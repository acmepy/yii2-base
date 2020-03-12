<?php

use yii\helpers\Html;
use acmepy\base\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Usuarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-index">
	<!--h3><?= Html::encode($this->title) ?></h3-->
	
	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],
			//'id',
			'username',
			'userdesc',
			//'auth_key',
			//'password_hash',
			//'password_reset_token',
			'email:email',
			'status:userStatus',
			//'created_at',
			//'updated_at',
			//'verification_token',
			['class' => 'acmepy\base\grid\ActionColumn'],
		],
	]); ?>
</div>
