<?php
namespace acmepy\base\widgets;

use yii\base\Widget;
use yii\helpers\Html;

class Chart extends Widget{
	
	public function run(){
		$tmp = $this->div([
			'content' => $this->canvas(['id' => 'revenue-chart-canvas']), 
			'status' => 'active', 
			'id' => 'revenue-chart']).
			   Html::tag('div', $this->canvas(['id' => 'sales-chart-canvas']),   ['class' => ['chart', 'tab-pane'], 'id' => 'sales-chart', 'style' => 'position: relative; height: 300px;']);
		$tmp = Html::tag('div', $tmp, ['class' => ['tab-content', 'p-0']]);
		return '<div class="tab-content p-0">
				  <!-- Morris chart - Sales -->
                  <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;">
                      <canvas id="revenue-chart-canvas" height="300" style="height: 300px;"></canvas>   
                  </div>
                  <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;">
                    <canvas id="sales-chart-canvas" height="300" style="height: 300px;"></canvas>                         
                  </div>  
                </div>';
	}
	
	private function div($arg){
		if (!isset($arg['id']))    $arg['id']     = '';
		if (!isset($arg['class'])) $arg['status'] = '';
		if (!isset($arg['style'])) $arg['style']  = '';
		return Html::tag('div', $arg['content'], ['class' => ['chart', 'tab-pane', $arg['status']], 'id' => $arg['id'], 'style' => $arg['style']]);
	}
	
	private function canvas($arg){
		if (!isset($arg['height'])) $arg['height'] = '300';
		if (!isset($arg['style']))  $arg['style'] = 'height: 300px;';
		return Html::tag('canvas', '', ['id' => $arg['id'], 'height' => $arg['height'], 'style' => $arg['style']]);
	}
}
