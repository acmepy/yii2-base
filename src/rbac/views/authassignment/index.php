<?php

use yii\helpers\Html;
use acmepy\base\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Grupos por Usuarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-assignment-index">
	<!--h3><?= Html::encode($this->title) ?></h3-->
	
	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],
			'item_name',
			'user_id',
			//'created_at',
			['class' => 'acmepy\base\grid\ActionColumn'],
		],
	]); ?>
</div>
