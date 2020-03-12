<?php
namespace acmepy\base\widgets;

class ActiveForm extends \yii\widgets\ActiveForm{
	
	public function init(){
		$this->fieldClass        = 'acmepy\base\widgets\ActiveField';
		$this->errorCssClass     = 'is-invalid';
		$this->successCssClass   = 'is-valid';
		$this->validationStateOn = ActiveForm::VALIDATION_STATE_ON_INPUT;
		parent::init();
	}
    public function field($model, $attribute, $options = []){
		$options = [
			'options'      => ['class'=>''],
			'errorOptions' => ['class'=>'invalid-tooltip'],
		];
		return parent::field($model, $attribute, $options);
	}
}