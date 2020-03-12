<?php
namespace acmepy\base\widgets;

use Yii;

class ActiveField extends \yii\widgets\ActiveField{
	public $auditDate = ['created_at', 'updated_at'];
	public $numberType = ['decimal', 'number'];
	public $numberClass= 'form-control text-right';

	public function textInput($options = []){
		$att = $this->attribute;
		//begin tabular input data
		if (substr($att, 0, 1) == '['){
			$att = substr($att, strpos($att, ']')+1);
		}elseif (strpos($att, '[')){
			$att = substr($att, 0, strpos($att, '['));
		}
		//end tabular input data
		if (method_exists($this->model, 'getTableSchema')){
			$type = $this->model->getTableSchema()->columns[$att]->type;
		}else{
			$type = '';
		}
		if (in_array($type, $this->numberType)){
			$options['class'] = $this->numberClass;
			$options['type']  = 'number';
		}elseif (in_array($att, $this->auditDate)){
			$options = ['disabled' => true, 'value' => $this->model->$att ? Yii::$app->formatter->asDatetime($this->model->$att) : ''];
		}
		return parent::textInput($options);
	}
}