<?php

use yii\helpers\Html;
use acmepy\base\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Accesos a Grupos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-child-index">
	<!--h3><?= Html::encode($this->title) ?></h3-->
	
	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],
			'parent',
			'child',
			//'created_at',
			//'updated_at',
			['class' => 'acmepy\base\grid\ActionColumn'],
		],
	]); ?>
</div>
