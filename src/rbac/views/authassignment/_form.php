<?php

use yii\helpers\Html;
use acmepy\base\widgets\ActiveForm;
use app\models\AuthItem;
use app\models\Users;

/* @var $this yii\web\View */
/* @var $model app\models\AuthAssignment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="auth-assignment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'item_name')->dropDownList(AuthItem::dataDrop(['name', 'name'], ['type' => 2]), ['prompt' => 'Seleccione Uno' ]) ?>

    <?= $form->field($model, 'user_id')->dropDownList(Users::dataDrop(['username', 'username']), ['prompt' => 'Seleccione Uno' ]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

	<br>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
