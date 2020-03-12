<?php
namespace acmepy\base\widgets;
use yii\base\Widget;
use yii\helpers\Html;

class SmallBox extends Widget{
	
	
	const INFO    = 'bg-info';
	const SUCCESS = 'bg-success';
	const WARNING = 'bg-warning';
	const DANGER  = 'bg-danger';
	public $type;
	public $value;
	public $label;
	public $icon;
	public $href;
	public $link;

	public function run(){
		return 	Html::tag('div', 
				   Html::tag('div', Html::tag('h3', $this->value). Html::tag('p', $this->label), ['class'=>'inner']).
				   Html::tag('div', Html::tag('i', '', ['class'=>[$this->icon]]), ['class'=>'icon']).
				   Html::tag('a', $this->link . Html::tag('i', '', ['class'=>['fas', 'fa-arrow-circle-right']]), ['href'=>$this->href, 'class'=>'small-box-footer']),
				   ['class'=>['small-box', $this->type]]
				);
/*		return '
	<div class="small-box '.$this->type.'">
	  <div class="inner">
		<h3>'.$this->value.'</h3>

		<p>'.$this->label.'</p>
	  </div>
	  <div class="icon">
		<i class="ion '.$this->icon.'"></i>
	  </div>
	  <a href="'.$this->href.'" class="small-box-footer">'.$this->link.' <i class="fas fa-arrow-circle-right"></i></a>
	</div>';*/
	}
	
	public static function sup($txt){
		return Html::tag('sup', $txt, ['style' => 'font-size: 20px']);
		//<sup style="font-size: 20px">%</sup>
	}
}