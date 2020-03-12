<?php

use yii\helpers\Html;
use acmepy\base\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Permisos Disponibles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-index">
	<!--h3><?= Html::encode($this->title) ?></h3-->
	
	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],
			'name',
			//'type',
			'description:ntext',
			//'rule_name',
			//'data',
			//'created_at',
			//'updated_at',
			['class' => 'acmepy\base\grid\ActionColumn'],
		],
	]); ?>
</div>
