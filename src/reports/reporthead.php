<?php

use yii\helpers\Html;
use acmepy\base\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="row invoice-info">
	<div class="col-sm-10">
		<h5><i class="fas fa-globe"></i> Caja Mutual de Cooperativistas del Py<h5>
		<h4 class="page-header"><?= Html::encode($title) ?></h4>
	</div>
	<div class="col-sm-2">
		<small class="float-right">Pagina : <?= $currentPage . ' de ' . $totalPages ?></small><br>
		<small class="float-right">Fecha : <?= $date ?></small><br>
		<small class="float-right">Usuario : <?= $user ?></small><br>
	</div>
</div>
<?php if (isset($displayFilter)){ ?>
	<div class="row invoice-info">
		<?php foreach($displayFilter as $f){ ?>
			<div class="col-sm-6">
				<?= $f ?>
			</div>
		<?php } ?>
	</div>
<?php } ?>
