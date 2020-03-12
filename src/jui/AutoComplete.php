<?php
namespace acmepy\base\jui;

use yii\helpers\Html;
use yii\web\JsExpression;

class AutoComplete extends \yii\jui\AutoComplete{
	
	public function init(){
		$this->options['class'] = 'form-control';
		if (isset($this->clientOptions['source']['url'])){
			$this->clientOptions['source'] = new JsExpression("function(request, response) {
						var val = $('#".Html::getInputId($this->model, $this->attribute)."').val();
						$.getJSON('".$this->clientOptions['source']['url']."?id='+val, {
							term: request.term
						}, response);
					}");
		}
		if (!isset($this->clientOptions['minLength'])){
			$this->clientOptions['minLength'] = 3;
		}
		if (isset($this->clientOptions['description'])){
			$this->clientOptions['close'] = new JsExpression('function( event, ui ) {
				var id = $("#'.Html::getInputId($this->model, $this->attribute).'").val();
				$.getJSON( "'.$this->clientOptions['description'].'?id="+id, function( data ) {
					$("#'.Html::getInputId($this->model, $this->clientOptions['description']).'").val(data);
				});
            }');
		}		
		parent::init();
	}
/*	
	public function jsSource($arg = []){
		return new JsExpression("function(request, response) {
						var val = $('#".Html::getInputId($this->model, $this->attribute)."').val();
						$.getJSON('".$this->clientOptions['source']['url']."?id='+val, {
							term: request.term
						}, response);
					}");
	}
*/
}