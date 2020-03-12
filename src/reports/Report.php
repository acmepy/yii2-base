<?php
namespace acmepy\base\reports;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\web\View;

class Report extends Widget{

	public $view;
	public $dataProvider;
	public $columns;
	public $id = 'table';
	public $title;
	public $head = true;
	public $footer = false;
	public $pageSize = 20;
	public $displayFilter;

	public function run(){
		$tmp = $this->pageSize;
		//$this->pageSize = ($this->pageSize > $this->dataProvider->getCount())?$this->dataProvider->getCount():$this->pageSize;
		$this->dataProvider->pagination->pageSize = $this->pageSize;
		$id = 'example';
		do{
			$this->renderPage();
			$this->renderPageBreak();
			$this->dataProvider->pagination->setPage($this->dataProvider->pagination->getPage() +1);
		} while ($this->dataProvider->pagination->getPage() < $this->dataProvider->pagination->getPageCount());
		
	}

	public function renderPage(){
        ReportAsset::register($this->getView());
		$bodyTable  = $this->renderBody();
		$reportHead = $this->reportHead();
		$beginTable = $this->beginTable();
		$headTable  = ($this->head)?$this->renderHeadTable():'';
		$footer     = ($this->footer)?$this->renderFooter():'';
		$endTable   = $this->endTable();
		echo $reportHead . $beginTable . $headTable . $bodyTable . $footer . $endTable;
	}
	
	public function reportHead(){
		return Yii::$app->controller->renderPartial('@vendor/acmepy/yii2-base/src/reports/reporthead', [
			'company_name' => 'Caja Mutual de Cooperativistas del Py',
			'date' => Yii::$app->formatter->asDatetime(time()),
			'title' => $this->title,
			'currentPage' => $this->dataProvider->pagination->getPage()+1,
			'totalPages' => $this->dataProvider->pagination->getPageCount(),
			'user' => Yii::$app->user->id,	
			'displayFilter' => $this->displayFilter,
		]);
	}
	
	public function beginTable(){
		return '<table id="'.$this->id.'" class="table table-hover display" style="width:100%">';
	}
	
	public function renderHeadTable(){
		return '<thead><tr>' . $this->colNames() . '</tr></thead>';
	}
	
	public function renderBody(){
		$r = '<tbody>';
		$sc = 0;
		foreach($this->dataProvider->getModels() as $m){
			$f = '';
			$v = '';
			foreach($this->columns as $c){
				if (is_string($c)){
					if ($c == 'SerialColumn'){
						$v = ++$sc;
					}elseif (strpos($c,':')){
						$t = 'as' . substr($c, strpos($c, ':')+1);
						$c = substr($c, 0, strpos($c, ':'));
						$v = \Yii::$app->formatter->$t($m->$c);
					}else{
						$v = $m->$c;
					}
				}elseif (is_array($c)){
					$v = $c['value'];
					if (is_callable($v)){
						$v = $v($m);
					}
				}
				$f .= '<td>' . $v . '</td>';
			}
			$r.= '<tr>' . $f . '</tr>';
		}
		return $r . '</tbody>';
	}
	
	public function renderFooter(){
		echo '<tfoot>'.$this->colNames().'</tfoot>';
	}
	
	public function endTable(){
		return '</table>';
	}
	
	private $_colNames;
	public function colNames(){
		if (isset($this->_colNames)){
			return $this->_colNames;
		}
		
		$a = (new $this->dataProvider->query->modelClass)->attributeLabels();
		$r = '';
		foreach($this->columns as $c){
			if (is_string($c)){
				if ($c == 'SerialColumn'){
					$c = '#';
				}elseif (strpos($c,':')){
					$c = substr($c, 0, strpos($c, ':'));
				}
				$n = isset($a[$c])?$a[$c]:ucfirst($c);
			}elseif(is_array($c)){
				$n = isset($c['label'])?$c['label']:'';
			}
			$r .= '<th>'.$n.'</th>';
		}
		return $r;
	}
	
	private function renderPageBreak(){
		echo '<div class="report-page-cut"></div>';
	}

	private function registerCss(){
		$this->registerCss("
		@media print{
			div.page-break{
				display:block;
				page-break-before:always;
			}
		}");
	}

	private function registerJS(){
/*
		$this->view->registerJs('
			var t= $("#'.$this->id.'").DataTable( {
				dom: "Bfrtip",
				pageLength: 20,
				buttons: [
					"copy", "csv", "excel", //"pdf", 
					{
						extend: "print",
						autoPrint: true,
						title: "",

						//For repeating heading.
						repeatingHead: {
							logo: "https://www.google.co.in/logos/doodles/2018/world-cup-2018-day-22-5384495837478912-s.png",
							logoPosition: "right",
							logoStyle: "",
							title: "<h3 align=\"center\">Sample Heading</h3>"
						}
					},
				],
				"columnDefs": [ {
					"searchable": false,
					"orderable": false,
					"targets": 0
				} ],
				"order": [[ 3, \'asc\' ]]
			} );
			t.on( \'order.dt search.dt\', function () {
				t.column(0, {search:\'applied\', order:\'applied\'}).nodes().each( function (cell, i) {
					cell.innerHTML = i+1;
				} );
			} ).draw();',
			\yii\web\View::POS_READY,
			$this->id . '-handler'
		);		
*//*
		$this->view->registerJs('
			$("#'.$this->id.'").DataTable( {
				dom: "Bfrtip",
				pageLength: 20,
				buttons: [
					"copy", "csv", "excel", "pdf", 
					{
						extend: "print",
						customize: function ( win ) {
							$(win.document.body)
								.css( "font-size", "10pt" )
								.prepend(
									\'<img src="http://datatables.net/media/images/logo-fade.png" style="position:absolute; top:0; left:0;" />\'
								);
		 
							$(win.document.body).find( "table" )
								.addClass( "compact" )
								.css( "font-size", "inherit" );
						}
					}
				]
			} );',
			\yii\web\View::POS_READY,
			$this->id . '-handler'
		);		
*/
	}
}