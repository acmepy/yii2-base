<?php
namespace acmepy\base\widgets;
use yii\base\Widget;
use yii\helpers\Html;

/*
pages/widgets.html
Falta implementar collapsable, minize, maximize, refresh 

<div class="card card-primary">
  <div class="card-header">
	<h3 class="card-title">$title</h3>
  </div>
	<div class="card-body">
	  $body
	</div>
	<div class="card-footer">
	  $footer
	</div>
</div>
*/

class Card extends Widget{
	public $icon;
	public $title;
    public $content;
	public $buttons;
	public $options;
	public function run(){
		$class = isset($this->options['class'])?$this->options['class']:'card';
		$class_header = isset($this->options['class-header'])?$this->options['class-header']:'card-header';
		return Html::tag('div', 
			Html::tag('div', $this->head(). $this->btns(), ['class'=>$class_header]). 
			Html::tag('div', $this->content, ['class'=>'card-body']), 
			['class'=> $class]
		);
	}
	
	private function head(){
		return Html::tag('h3', Html::tag('i', '', ['class'=>'mr-1 fas '.$this->icon]) . $this->title, ['class'=>'card-title']);
	}
	
	private function btns(){
		$tmp = '';
		if (isset($this->buttons)){
			if (is_array($this->buttons)){
				$tmp = Html::tag('div', Html::tag('ul', $this->btn(), ['class'=>'nav nav-pills ml-auto']), ['class'=>'card-tools']);
			}
		}
		return $tmp;
	}
	
	private function btn(){
		$tmp = '';
		foreach($this->buttons as $b){
			$status = (isset($b['status']))?$b['status']:'';
			$tmp .= Html::tag('li',  Html::a($b['label'], [$b['href'], 'id' => $id], ['class' => 'nav-link '.$status, 'data-toggle'=>'tab']), ['class'=>'nav-item']);
		}
		return tmp;
	}
}
