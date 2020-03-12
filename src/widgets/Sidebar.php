<?php
//
//la url de dashboard v1 tiene que apuntar a la raiz
//
namespace acmepy\base\widgets;
use yii\base\Widget;

class Sidebar extends Widget
{
	public $directoryAsset;

	public $aside;
	public $brand;
	public $user;
	public $items;
	
	public function init(){
		parent::init();
		$this->load_sample();
		if (!isset($this->aside['class']))
			$this->aside['class'] = 'main-sidebar elevation-4 sidebar-dark-success';
		if (!isset($this->brand['class']))
			$this->brand['class'] = 'brand-link navbar-success';
	}
	
	public function run(){
		return '
<!--aside class="main-sidebar sidebar-dark-primary elevation-4"-->
<!--aside class="main-sidebar elevation-4 sidebar-dark-success"-->
<aside class="'.$this->aside['class'].'">
	<!-- Brand Logo -->
	<!--a href="'.$this->brand['href'].'" class="brand-link"-->
	<!--a href="'.$this->brand['href'].'" class="brand-link navbar-success"-->
	<a href="'.$this->brand['href'].'" class="'.$this->brand['class'].'">
	  <img src="'.$this->brand['image'].'" alt="'.$this->brand['alt'].'" class="brand-image img-circle elevation-3"
		   style="opacity: .8">
	  <span class="brand-text font-weight-light">'.$this->brand['text'].'</span>
	</a>
	<!-- Sidebar -->
	<div class="sidebar">
	  <!-- Sidebar user panel (optional) -->
	  <div class="user-panel mt-3 pb-3 mb-3 d-flex">
		<div class="image">
		  <img src="'.$this->user['photo'].'" class="img-circle elevation-2" alt="User Image">
		</div>
		<div class="info">
		  <a href="'.$this->user['logout'].'" class="d-block">'.$this->user['name'].'</a>
		</div>
	  </div>
	  <nav class="mt-2">
		<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
		  <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
		  '.$this->menu($this->items).'
		</ul>
	  </nav>
	</div>
</aside>';
	}
	
	private function menu($items){
		#$tmp = '<li class="nav-item"><a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i><p>Contraer</p></a></li>';
		$tmp = '';
		foreach($items as $item){
			if (isset($item['header'])){
				$tmp .= '
						'.$this->li_head($item);
			}else if (isset($item['items'])){
				$tmp .= $this->li_tree($item);
			}else{
				$tmp .= $this->li_item($item);
			}
		};
		return $tmp;
	}
	
	private function li_head($item){
		return '
		  <li class="nav-header">'.$item['header'].'</li>
		  ';
	}
	
	private function li_item($item){
		$controller_id = substr($item['href'], strrpos($item['href'], "/")+1);
		if (!\Yii::$app->user->can($controller_id.'_index') && $controller_id != 'web'){
			return '';
		}
		$href = (isset($item['href']))?$item['href']:'#';
		return '<li class="nav-item">
			<a href="'.$href.'" class="nav-link">
			  <i class="nav-icon '.$item['fa-icon'].'"></i>
			  <p>'.$item['label'].(isset($item['badge-type'])?('<span class="right badge badge-'.$item['badge-type'].'">'.$item['badge'].'</span>'):'').'</p>
			</a>
		  </li>';
	}
	
	private function li_tree($items){
		$icon = $items['fa-icon'];
		$label = isset($items['label'])?$items['label']:'';
		$status = isset($items['status'])?$items['status']:'';
		$active = isset($items['active'])?$items['active']:'';
		$menus  = $this->li_tree_item($items['items']);
		if ($menus == ''){
			return '';
		}
		return '<li class="nav-item has-treeview '.$status.'">
			<a href="#" class="nav-link '.$active.'">
			  <i class="nav-icon '.$icon.'"></i>
			  <p>
				'.$label.'
				<i class="right fas fa-angle-left"></i>
			  </p>
			</a>
			<ul class="nav nav-treeview">
			  '.$menus.'
			</ul>
		  </li>';
	}
	
	private function li_tree_item($items){
		$tmp = '';
		foreach($items as $item){
			if (isset($item['items'])){
				$tmp .= $this->li_tree($item['items']);
			}else{
				$controller_id = substr($item['href'], strrpos($item['href'], "/")+1);
				if (\Yii::$app->user->can($controller_id.'_index')){
					$href = (isset($item['href']))?$item['href']:'#';
					$icon = (isset($item['fa-icon'])?$item['fa-icon']:'far fa-circle');
					$tmp .= '<li class="nav-item">
						<a href="'.$href.'" class="nav-link">
						  <i class="nav-icon '.$icon.'"></i>
						  <p>'.$item['label'].'</p>
						</a>
					  </li>';
				}
			}
		}
		return $tmp;
	}
	
	private function load_sample(){
//throw new \yii\base\Exception( "Debe pasar la variable directoryAsset" );
		if (!isset($this->aside['class']))
			$this->aside['class'] = 'main-sidebar elevation-4 sidebar-dark-success';
		if (!isset($this->brand)){
			$this->brand = [
				'class' => 'brand-link navbar-success',
				'image' => $this->directoryAsset .'/dist/img/AdminLTELogo.png',
				'alt'   => 'Yii Logo',
				'text'  => 'Yii Admin',
			];
		}
		if (!isset($this->user)){
			$this->user =[
				'photo' => $this->directoryAsset.'/dist/img/user2-160x160.jpg',
				'name'  => 'Alexander Pierce',
			];
		}
		if (!isset($this->items)){
			$this->items = [
				[
					'label' => 'Dashboard',
					'fa-icon' => 'fas fa-tachometer-alt',
					'status' => 'menu-open', 
					'active' => 'active',
					'items' => [
						['label' => 'Dashboard v1', 'href' => $this->directoryAsset.'/index.html'],
						['label' => 'Dashboard v2', 'href' => $this->directoryAsset.'/index2.html'],
						['label' => 'Dashboard v3', 'href' => $this->directoryAsset.'/index3.html']
					]
				],
				['label' => 'Widgets', 'fa-icon' => 'fas fa-th', 'badge' => 'New', 'badge-type' => 'danger', 'href' => $this->directoryAsset.'/pages/widgets.html'],
				[
					'label' => 'Layout Options',
					'fa-icon' => 'fas fa-copy', 
					'items' => [
						['label' => 'Top Navigation','href' => $this->directoryAsset.'/pages/layout/top-nav.html'],
						['label' => 'Boxed',         'href' => $this->directoryAsset.'/pages/layout/boxed.html'],
						['label' => 'Fixed Sidebar', 'href' => $this->directoryAsset.'/pages/layout/boxed.html'],
						['label' => 'Boxed',         'href' => $this->directoryAsset.'/pages/layout/fixed-sidebar.html'],
						['label' => 'Fixed Footer',  'href' => $this->directoryAsset.'/pages/layout/fixed-topnav.html'],
						['label' => 'Collapsed Sidebar', 'href' => $this->directoryAsset.'/pages/layout/collapsed-sidebar.html'],
					],
				],
				[
					'label' => 'Charts',
					'fa-icon' => 'fas fa-chart-pie', 
					'items' =>[
						['label' => 'ChartJS','href' => $this->directoryAsset.'/pages/charts/chartjs.html'],
						['label' => 'Flot',   'href' => $this->directoryAsset.'/pages/charts/flot.html'],
						['label' => 'Inline', 'href' => $this->directoryAsset.'/pages/charts/inline.html'],
					],
				],
				[
					'label' => 'UI Elements',
					'fa-icon' => 'fas fa-tree',
					'items' =>[
						['label' => 'General','href' => $this->directoryAsset.'/pages/UI/general.html'],
						['label' => 'Icons','href' => $this->directoryAsset.'/pages/UI/icons.html'],
						['label' => 'Buttons','href' => $this->directoryAsset.'/pages/UI/buttons.html'],
						['label' => 'Sliders','href' => $this->directoryAsset.'/pages/UI/sliders.html'],
						['label' => 'Modals & Alerts','href' => $this->directoryAsset.'/pages/UI/modals.html'],
						['label' => 'Navbar & Tabs','href' => $this->directoryAsset.'/pages/UI/modals.html'],
						['label' => 'Timeline','href' => $this->directoryAsset.'/pages/UI/timeline.html'],
						['label' => 'Ribbons','href' => $this->directoryAsset.'/pages/UI/ribbons.html'],
					],
				],
				[
					'label' => 'Forms',
					'fa-icon' => 'fas fa-edit', 
					'items' => [
						['label' => 'General Elements','href' => $this->directoryAsset.'/pages/forms/general.html'],
						['label' => 'Advanced Elements','href' => $this->directoryAsset.'/pages/forms/advanced.html'],
						['label' => 'Editors','href' => $this->directoryAsset.'/pages/forms/editors.html'],
					],
				],
				[
					'label' => 'Tables',
					'fa-icon' => 'fas fa-table',
					'items' => [
						['label' => 'Simple Tables','href' => $this->directoryAsset.'/pages/tables/simple.html'],
						['label' => 'DataTables',   'href' => $this->directoryAsset.'/pages/tables/data.html'],
						['label' => 'jsGrid','href' => $this->directoryAsset.'/pages/tables/jsgrid.html'],
						['label' => 'Simple Tables','href' => $this->directoryAsset.'/pages/tables/simple.html'],
						['label' => 'Simple Tables','href' => $this->directoryAsset.'/pages/tables/simple.html'],
						['label' => 'Simple Tables','href' => $this->directoryAsset.'/pages/tables/simple.html'],
						['label' => 'Simple Tables','href' => $this->directoryAsset.'/pages/tables/simple.html'],
						['label' => 'Simple Tables','href' => $this->directoryAsset.'/pages/tables/simple.html'],
						['label' => 'Simple Tables','href' => $this->directoryAsset.'/pages/tables/simple.html'],
					],
				],
				['header' => 'EXAMPLES'],
				['label' => 'Calendar', 'fa-icon' => 'far fa-calendar-alt', 'badge' => '2', 'badge-type' => 'info', 'href' => $this->directoryAsset.'/pages/calendar.html'],
				['label' => 'Gallery', 'fa-icon' => 'far fa-image', 'href' => $this->directoryAsset.'/pages/calendar.html'],
				[
					'label' => 'Mailbox',
					'fa-icon' => 'fas fa-envelope', 
					'items' => [
						['label' => 'Inbox','href' => $this->directoryAsset.'/pages/mailbox/mailbox.html'],
						['label' => 'Compose','href' => $this->directoryAsset.'/pages/mailbox/compose.html'],
						['label' => 'Read','href' => $this->directoryAsset.'/pages/read-mail.html'],
					],
				],
				[
					'label' => 'Pages',
					'fa-icon' => 'fas fa-book',  
					'items' => [
						['label' => 'Invoice','href' => $this->directoryAsset.'/pages/examples/invoice.html'],
						['label' => 'Profile','href' => $this->directoryAsset.'/pages/examples/profile.html'],
						['label' => 'E-commerce','href' => $this->directoryAsset.'/pages/examples/e_commerce.html'],
						['label' => 'Projects','href' => $this->directoryAsset.'/pages/examples/projects.html'],
						['label' => 'Project Add','href' => $this->directoryAsset.'/pages/examples/project_add.html'],
						['label' => 'Project Edit','href' => $this->directoryAsset.'/pages/examples/projects_edit.html'],
						['label' => 'Project Edit','href' => $this->directoryAsset.'/pages/examples/project_detail.html'],
						['label' => 'Contacts','href' => $this->directoryAsset.'/pages/examples/contacts.html'],
					],
				],
				[
					'label' => 'Extras',
					'fa-icon' => 'fas fa-plus-square', 
					'items' => [
						['label' => 'Login','href' => $this->directoryAsset.'/pages/examples/login.html'],
						['label' => 'Register','href' => $this->directoryAsset.'/pages/examples/register.html'],
						['label' => 'Forgot Password','href' => $this->directoryAsset.'/pages/examples/forgot-password.html'],
						['label' => 'Recover Password','href' => $this->directoryAsset.'/pages/examples/recover-password.html'],
						['label' => 'Lockscreen','href' => $this->directoryAsset.'/pages/examples/lockscreen.html'],
						['label' => 'Legacy User Menu','href' => $this->directoryAsset.'/pages/examples/legacy-user-menu.html'],
						['label' => 'Language Menu','href' => $this->directoryAsset.'/pages/examples/language-menu.html'],
						['label' => 'Error 404','href' => $this->directoryAsset.'/pages/examples/404.html'],
						['label' => 'Error 500','href' => $this->directoryAsset.'/pages/examples/500.html'],
						['label' => 'Pace','href' => $this->directoryAsset.'/pages/examples/pace.html'],
						['label' => 'Blank Page','href' => $this->directoryAsset.'/examples/blank.html'],
						['label' => 'Starter Page','href' => $this->directoryAsset.'/starter.html'],
					],
				],
				['header' => 'MISCELLANEOUS'],
				['label' => 'Documentation', 'fa-icon' => 'fas fa-file', 'href' => 'https://adminlte.io/docs/3.0'],
				['header' => 'MULTI LEVEL EXAMPLE'],
				['label' => 'Level 1', 'fa-icon' => 'fas fa-circle'],
				[
					'label' => 'Level 1',
					'fa-icon' => 'fas fa-circle', 
					'items' => [
						['label' => 'Level 2', 'fa-icon' => 'far fa-circle'],
						['label' => 'Level 2', 
							'items' => [
								'label' => 'Level 2',
								'fa-icon' => 'far fa-circle', 
								'items' => [
									['label' => 'Level 3', 'fa-icon' => 'far fa-dot-circle'],
									['label' => 'Level 3', 'fa-icon' => 'far fa-dot-circle'],
									['label' => 'Level 3', 'fa-icon' => 'far fa-dot-circle'],
								],
							],
						],
						['label' => 'Level 2', 'fa-icon' => 'far fa-circle'],
					],
				],
				['label' => 'Level 1', 'fa-icon' => 'fas fa-circle'],
				['header' => 'LABELS'],
				['label' => 'Important', 'fa-icon' => 'far fa-circle text-danger'],
				['label' => 'Warning', 'fa-icon' => 'far fa-circle text-warning'],
				['label' => 'Informational', 'fa-icon' => 'far fa-circle text-info'],
			];
		}
	}
}
