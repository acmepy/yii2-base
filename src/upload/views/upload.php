<?php
//implementar yii\bootstrap\Modal;
//yii\bootstrap\Progress
//https://www.yiiframework.com/wiki/2546/batch-gridview-data-ajax-send-splitted-in-chunks-displaying-bootstrap-progress-bar
//http://yii2-snippets.1luc1.bplaced.net/en/progress-bar

use acmepy\base\widgets\ActiveForm;
use yii\web\View;
use yii\jui\ProgressBar;

if (!isset($type)){
	$type = 'file';
}
$upload = 'upload'.$type;

$js = "\$('#importButton').click(function(){\$('#".$upload."').modal();});";
$js.= "\$('#sendFile').click(function(){\$('#".$upload."_progress').modal();\$('#".$upload."').hide();});";
if ($type=='file'){
	$js .= "\$( document ).ready(function(){\$('#uploadfile').modal();});";
};

$this->registerJs($js, View::POS_READY, 'importButton');
$ok = isset($ok)?$ok:'Importar';
$action = isset($action)?$action:'import';

$this->registerJs('$("#sendFile").click(function(){
	var interval = 5000;
	var url= "'.Yii::$app->urlManager->createUrl(['tei/'.Yii::$app->controller->id."/progreso"]).'"
	setInterval(function() { $.post(url, function( data ){
		var val = 0;
		if (typeof data["estado"] !== "undefined"){
			/*if ((data["estado"]).indexOf("Iniciando")){
				val = 90;
			}else if ((data["estado"]).indexOf("Leyendo")){
				val = 30;
			}else if ((data["estado"]).indexOf("Procesando")){
				val = 60;
			}else if ((data["estado"]).indexOf("Validando")){
				val = 80;
			}else if ((data["estado"]).indexOf("Guardando")){
				val = 95;
			}
			$( "#progressbar" ).progressbar({"value" : val});*/
			$( ".progress-bar" ).text(data["estado"] + "   " + data["actual"] + "/" + data["total"]);
		}
})}, interval)});', View::POS_READY, 'ajax-percentage');
?>
<?php $form = ActiveForm::begin(['action'=>[$action], 'options' => ['enctype' => 'multipart/form-data']]) ?>
	<div class="modal fade" id="<?=$upload?>" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLongTitle">Importar Datos</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<?= $form->field($model, 'file')->fileInput() ?>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
					<button class="btn btn-primary" id="sendFile"><?= $ok ?></button>
				</div>
			</div>
		</div>
	</div>
<?php ActiveForm::end() ?>

<div class="modal fade" id="<?=$upload?>_progress" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Importar Datos</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<!--div id="progressbar"><div class="progress-label">Cargando...</div></div-->
				<!--?= ProgressBar::widget(['clientOptions' => ['value' => 75], 'id'=>'progressBarx']) ?-->
				<div id="progressbar" class="progress">
					<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%" id="progressbar">
						Importando
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
				<!--button class="btn btn-primary">Enviar</button-->
			</div>
		</div>
	</div>
</div>
