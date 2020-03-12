<?php
//
//la cantidad de alertas debe ser amarillo y no rojo
//
namespace acmepy\base\widgets;

use Yii;
use yii\base\Widget;

class Navbar extends Widget
{
	public $directoryAsset;
	public $css;
	public $items;
	
	public function init(){
		parent::init();
		$this->load_sample();
		if (!isset($this->items['link']))
			$this->items['link'] = [];
	}
	
	public function run(){
		return '
  <!-- navbar -->
  <!--nav class="main-header navbar navbar-expand navbar-success navbar-dark fixed-top"-->
  <nav class="'.$this->css.'">
    <!-- Left navbar links -->
	'.(isset($this->items['link'])?$this->navLeft($this->items['link']):'').'
    '.(isset($this->items['title'])?$this->items['title']:'').'
    <!-- SEARCH FORM -->
    '.($this->items['search']?$this->navSearch():'').'
    <!-- Right navbar links -->
    '.(isset($this->items['notifications'])?$this->navRigth($this->items):'').'
  </nav>
  <!-- /.navbar -->
';
	}
	
	private function navLeft($items){
		$tmp = '
    <ul class="navbar-nav">
		<li class="nav-item">
			<a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
		</li>
';
		foreach($items as $i){
			$tmp .= 
'		<li class="nav-item d-none d-sm-inline-block">
			<a href="'.$i['href'].'" class="nav-link">'.$i['label'].'</a>
		</li>
';
		}
$tmp .= '
    </ul>
';
		return $tmp;
	}
	
	private function navSearch(){
		if ($this->items['search']){
			return '
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>';
		}else return '';
	}
	
	private function navRigth($items){
		return '
	<ul class="navbar-nav ml-auto">
		<!-- Messages Dropdown Menu -->
		'.$this->dropdown('messages', $items['messages']).'
		<!-- Notifications Dropdown Menu -->
		'.$this->dropdown('notifications', $items['notifications']).'
		<li class="nav-item">
			<a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">
				<i class="fas fa-th-large"></i>
			</a>
		</li>
    </ul>';
	}
	
	private function dropdown($type, $items){
		if ($type == 'messages'){
			$count = count($items);
			$items = $this->messages($items);
			$icon  = 'fa-comments';
		}else if ($type == 'notifications'){
			$count = count($items);
			$items = $this->notifications($items);
			$icon  = 'fa-bell';
		}
			
		return '
		<li class="nav-item dropdown">
			<a class="nav-link" data-toggle="dropdown" href="#">
			  <i class="far '.$icon.'"></i>
			  <span class="badge badge-danger navbar-badge">'.$count.'</span>
			</a>
			<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
				<span class="dropdown-item dropdown-header">'.$count.' Messages</span>
				<div class="dropdown-divider"></div>
					'.$items.'
			</div>
		</li>
		';
	}
	
	private function messages($items){
		$tmp = '';
		foreach($items as $item){
			$tmp .= '<a href="#" class="dropdown-item">
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
				</div>
			</a>
			<div class="dropdown-divider"></div>';
		}
		$tmp .= '
		<a href="#" class="dropdown-item dropdown-footer">See All Messages</a>';
		return $tmp;
	}
			  
	private function notifications($items){
		$tmp = '';
		foreach($items as $item){
			$tmp .= '
		<a href="#" class="dropdown-item">
			<i class="fas fa-envelope mr-2"></i>'.$item['text'].'
			<span class="float-right text-muted text-sm">'.$item['time'].'</span>
		</a>
		<div class="dropdown-divider"></div>';
		}
		$tmp .= '
		<a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>';
		return $tmp;
	}
	
	
	private function load_sample(){
		if (!isset($this->css))
			$this->css = 'main-header navbar navbar-expand navbar-success navbar-dark fixed-top';
		if (!isset($this->items))
			$this->items = [
				'link' => [
					['label' => 'Home', 'href' => 'index3.html'],
					['label' => 'Contact', 'href' => '#'],
					['label' => Yii::$app->user->identity->username, 'href' => '#'],
				],
				'search' => true,
				'messages' => [
					['name' => 'Brad Diesel',    'type' => 'danger',  'time' => '4 Hours Ago', 'msg' => 'Call me whenever you can...', 'image' => $this->directoryAsset.'/dist/img/user1-128x128.jpg'],
					['name' => 'John Pierce',    'type' => 'muted',   'time' => '4 Hours Ago', 'msg' => 'I got your message bro',      'image' => $this->directoryAsset.'/dist/img/user8-128x128.jpg'],
					['name' => 'Nora Silvester', 'type' => 'warning', 'time' => '4 Hours Ago', 'msg' => 'The subject goes here',       'image' => $this->directoryAsset.'/dist/img/user3-128x128.jpg'],

				],
				'notifications' => [
					['text' => '4 new messages',    'time' => '3 mins'],
					['text' => '8 friend requests', 'time' => '12 hours'],
					['text' => '3 new reports',     'time' => '2 days'],
				],
			];
	}
}
