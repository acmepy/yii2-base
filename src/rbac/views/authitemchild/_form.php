<?php

use yii\helpers\Html;
use acmepy\base\widgets\ActiveForm;
//use app\models\Users;
use acmepy\base\rbac\models\AuthItem;

/* @var $this yii\web\View */
/* @var $model app\models\AuthItemChild */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="auth-item-child-form">
    <?php $form = ActiveForm::begin(); ?>

    <!--?= $form->field($model, 'parent')->textInput(['maxlength' => true]) ?-->
	<!--pasar a widget-->
    <?= $form->field($model, 'parent')->dropDownList(
		AuthItem::dataDrop(['name', 'name'], ['type' => '2']),
		[
			'prompt' => 'Seleccione Uno',
			'onchange' => 'parent();'
		]
	) ?>

    <?= $form->field($model, 'child')->dropDownList(AuthItem::AuthPendDrop('admin'), ['prompt' => 'Seleccione Uno' ]) ?>

<!--?= $form->field($model, 'child')->dropDownList([], ['prompt' => 'Seleccione Uno',]);?-->
		
    <!--?= $form->field($model, 'child')->widget(\yii\jui\AutoComplete::classname(), [
		'options' => [
			'class' => 'form-control',
		],
		'clientOptions' => [
			'source' => AuthItem::AuthPend('admin'),
		],
	]) ?-->

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <br>
	<div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<!--depues pasar a un widget-->
<script>
	function parent(){
		var id = $("#authitemchild-parent :selected").text();
		var url= '<?=Yii::$app->urlManager->createUrl(["auth/authitemchild/permisos"])?>' + "?type=" + id;
		$.post(url, function( data ){
			$("#authitemchild-child").empty();
			var div_data = "<option value>Seleccione Uno</option>";
			$("#authitemchild-child").append(div_data);
			$.each(data,function(i,obj){
				div_data = "<option value="+i+">"+obj+"</option>";
				$("#authitemchild-child").append(div_data);
			});
		});
	}
</script>
