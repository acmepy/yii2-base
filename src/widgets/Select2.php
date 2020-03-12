<?php
namespace acmepy\base\widgets;

use yii\web\View;
use yii\base\Widget;
use yii\helpers\Html;

class Select2 extends Widget{
	
	public function run(){
		Select2Asset::register($this->getView());
		$this->getView()->registerJs("
			$('.select2').select2()
			$('.select2bs4').select2({theme: 'bootstrap4'})", 
			View::POS_READY, 
			'select2-handler'
		);
		return '
		<div class="form-group">
		  <label>Minimal</label>
		  <select class="form-control select2bs4" style="width: 100%;">
			<option selected="selected">Alabama</option>
			<option>Alaska</option>
			<option>California</option>
			<option>Delaware</option>
			<option>Tennessee</option>
			<option>Texas</option>
			<option>Washington</option>
		  </select>
		</div>';

	}
}