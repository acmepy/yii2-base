<?php
namespace acmepy\base\widgets;
use yii\base\Widget;

class Dropdown extends Widget{
	
	public $items = [
		[
			'options' => [
				'class'       => 'nav-link',
				'icon-class'  => 'far fa-comments',
				'count-class' => 'badge badge-danger navbar-badge',
				'menu-class'  => 'dropdown-menu dropdown-menu-lg dropdown-menu-right',
			],
			'items' =>[
				['name' => 'Brad Diesel',    'type' => 'danger',  'time' => '4 Hours Ago', 'msg' => 'Call me whenever you can...', 'image' => '/dist/img/user1-128x128.jpg'],
				['name' => 'John Pierce',    'type' => 'muted',   'time' => '4 Hours Ago', 'msg' => 'I got your message bro',      'image' => '/dist/img/user8-128x128.jpg'],
				['name' => 'Nora Silvester', 'type' => 'warning', 'time' => '4 Hours Ago', 'msg' => 'The subject goes here',       'image' => '/dist/img/user3-128x128.jpg'],
			],
		],
	];
	
	public function run(){
		$tmp = '
	<!--ul class="navbar-nav ml-auto"-->';
		foreach ($this->items as $i){
			$tmp .= '
		<li class="nav-item dropdown">
			<!-- Messages Dropdown Menu -->
			<a class="'.$i['options']['class'].'" data-toggle="dropdown" href="#">
			  <i class="'.$i['options']['icon-class'].'"></i>
			  <span class="'.$i['options']['count-class'].'">'.count($i['items']).'</span>
			</a>
			<div class="'.$i['options']['menu-class'].'">
			  '.$this->msgs($this->items).'
			</div>
		</li>';
		}
		$tmp .= '
	<!--/ul-->';
		return $tmp;
	}

	private function msgs($items){
		$tmp = '';
		foreach($items as $i){
			$tmp .='
			  <a href="#" class="dropdown-item">
				<!-- Message Start -->
				'.$this->msg($i).'
				<!-- Message End -->
			  </a>
			  <div class="dropdown-divider"></div>
';
		}
		$tmp .= '
		<a href="#" class="dropdown-item dropdown-footer">See All Messages</a>';
		return $tmp;
	}
			  
			  
			  
	private function msg($item){
		return'
				<div class="media">
				  <img src="'.$item['image'].'" alt="User Avatar" class="img-size-50 mr-3 img-circle">
				  <div class="media-body">
					<h3 class="dropdown-item-title">
					  '.$item['name'].'
					  <span class="float-right text-sm text-'.$item['type'].'"><i class="fas fa-star"></i></span>
					</h3>
					<p class="text-sm">'.$item['msg'].'</p>
					<p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> '.$item['time'].'</p>
				  </div>
				</div>';
	}
}
