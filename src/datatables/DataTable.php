<?php

namespace acmepy\base\datatables;

use yii\base\Widget;

class DataTable extends Widget{

	public $dataProvider;
	public $columns;
	public $id = 'table';
	public $head = true;
	public $footer = false;

	//public $btn_print;
	public function run(){
		if ($this->dataProvider->getTotalCount()<500){
			$this->dataProvider->pagination->pageSize = 500;
		}else{
			//implementar paginate server
		}
		$id = 'example';
        DataTablePrintAsset::register($this->getView());
		$this->beginTable();
		if ($this->head) $this->renderHead();
		$this->renderBody();
		if ($this->footer) $this->renderFooter();
		$this->endTable();
		$this->registerJS();
		//var_dump($this->dataProvider->pagination->pageSize);
	}

	public function beginTable(){
		echo '<table id="'.$this->id.'" class="display" style="width:100%">';
	}
	
	public function renderHead(){
		echo '<thead><tr>' . $this->colNames() . '</tr></thead>';
	}
	
	public function renderBody(){
		$r = '<tbody>';
		foreach($this->dataProvider->getModels() as $m){
			$f = '';
			$v = '';
			foreach($this->columns as $c){
				if (is_string($c)){
					if ($c == 'SerialColumn'){
						$v = '';
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
		echo $r . '</tbody>';
	}
	
	public function renderFooter(){
		echo '<tfoot>'.$this->colNames().'</tfoot>';
	}
	
	public function endTable(){
		echo '</table>';
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
	
	private function registerJS(){
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
/*
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