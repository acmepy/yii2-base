<?php
use yii\helpers\Html;
use acmepy\base\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Inicio de Sessión';

$fieldOptions1 = [
    'template' => '<div class="input-group mb-3">{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-envelope"></span></div></div>{error}{hint}</div>', 
];

$fieldOptions2 = [
    'template' => '<div class="input-group mb-3">{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div>{error}{hint}</div>',
];
?>

<div class="login-box">
    <div class="login-logo">
        <a href="#"><?= Yii::$app->name ?></a>
    </div>
    <!-- /.login-logo -->
<div class="card">
    <div class="card-body login-card-body">
        <p class="login-box-msg">Inicio de sessión</p>

        <?php $form = ActiveForm::begin([
			'id' => 'login-form', 
			'enableClientValidation' => false,
		]); ?>

        <?= $form
            ->field($model, 'username', $fieldOptions1)
            ->label(false)
            ->textInput(['placeholder' => $model->getAttributeLabel('username')]) ?>
<br>
        <?= $form
            ->field($model, 'password', $fieldOptions2)
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>
<br>

		<div class="row">
          <div class="col-8">
            <div class="icheck-primary">
				<?= $form->field($model, 'rememberMe')->checkbox() ?>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
			<?= Html::submitButton('Conectar', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
          </div>
          <!-- /.col -->
        </div>

        <?php ActiveForm::end(); ?>

        <!--div class="social-auth-links text-center">
            <p>- OR -</p>
            <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in
                using Facebook</a>
            <a href="#" class="btn btn-block btn-social btn-google-plus btn-flat"><i class="fa fa-google-plus"></i> Sign
                in using Google+</a>
        </div-->
        <!-- /.social-auth-links -->

        <!--a href="#">I forgot my password</a><br>
        <a href="register.html" class="text-center">Register a new membership</a-->

    </div>
    <!-- /.login-box-body -->
	</div>
</div><!-- /.login-box -->
