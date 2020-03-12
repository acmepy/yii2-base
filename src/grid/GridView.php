<?php
namespace acmepy\base\grid;

use Yii;
use yii\web\View;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use acmepy\base\widgets\LinkPager;

class GridView extends \yii\grid\GridView
{
    /**
     * Apply class `table-responsive` if enabled.
     */
    public $responsive = false;
    
    /**
     * @var array the HTML attributes for the grid table element.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $tableOptions = ['class' => 'table table-striped table-bordered'];
    
    /**
     * @inheritdoc
     */
    public $pager = ['class' => LinkPager::class];
	
	public $pageSize = 15;
    
    /**
     * @inheritdoc
     */
    public function init()
    {
		//$this->caption = '<h>Hola';
		//$this->layout = "{summary}{items}\n<div>{pager}";
		$this->layout = "{search}{summary}{items}{pager}";
		$this->tableOptions = ['class' => 'table table-sm'];
		$this->formatter = \Yii::$app->components['formatter'];
        parent::init();
        
		$this->dataProvider->pagination->pageSize = $this->pageSize;
        if ($this->responsive) {
            $this->tableOptions['class'] = $this->tableOptions['class'] . ' table-responsive';
        }
    }
	
    public function renderSection($name){
        switch ($name) {
            case '{summary}':
                return $this->renderSummary();
            case '{items}':
                return $this->renderItems();
            case '{pager}':
                return $this->renderPager();
            case '{sorter}':
                return $this->renderSorter();
            case '{search}':
                return $this->renderSearch();
            default:
                return false;
        }
    }
	
	public function renderSearch(){
		$con    = Yii::$app->controller->id;
		$exp    = $con . '/export/';
		$search = isset($_REQUEST['search'])?' value="'.$_REQUEST['search'].'"':'';
		$tipo   = isset($_REQUEST['tipo'])? $_REQUEST['tipo']:'';
		$sel_si = '';
		$sel_no = '';
		$sel_todos = '';
		if ($tipo=='10'){
			$sel_si = 'selected="selected"';
		} else if ($tipo == '0'){
			$sel_si = 'selected="selected"';
		} else {
			$sel_todos = 'selected="selected"';
		}
		
		$voto   = Yii::$app->user->can($con . '_filter_voto')?'
			<select class="form-control select2bs4" id="tipo" name="tipo">
				<option '.$sel_todos.'>Todos</option>
				<option '.$sel_si.' value="10">Con Voto</option>
				<option '.$sel_no.' value="0">Sin Voto</option>
			</select>':'';
		$create = Yii::$app->user->can($con . '_create')    ?'<a class="btn btn-outline-secondary bg-success" href="'.Url::toRoute('create').'"><i class="fas fa-plus"></i></a>':'';
		$delete = Yii::$app->user->can($con . '_delete_all')?'<a class="btn btn-outline-secondary bg-danger" href="'.Url::toRoute('deleteall').'"><i class="far fa-trash-alt"></i></a>':'';
		$import = Yii::$app->user->can($con . '_import')    ?'<a class="btn btn-outline-secondary" id="importButton" href="#"><i class="fas fa-file-import text-warning"></i></a>':'';
		$export = Yii::$app->user->can($con . '_export')    ?'
				<button class="btn btn-outline-secondary" type="submit" formaction="'.Url::toRoute($exp.'xls').'"><i class="fas fa-file-excel text-success"></i></button>
				<button class="btn btn-outline-secondary" type="submit" formaction="'.Url::toRoute($exp.'csv').'"><i class="fas fa-file-csv"></i></button>
				<button class="btn btn-outline-secondary" type="submit" formaction="'.Url::toRoute($exp.'pdf').'"><i class="fas fa-file-pdf text-danger"></i></button>':'';
		$print  = Yii::$app->user->can($con . '_print')     ?'<button class="btn btn-outline-secondary" formaction="'.Url::toRoute('print').'"><i class="fas fa-print text-dark"></i></button>':'';
		echo '
	<form class="form-inline ml-3">
		<div class="input-group col-sm-8 offset-md-4">
			'.$voto.'
			<input type="search" name="search" class="form-control" placeholder="Buesqueda" aria-label="Busqueda" '.$search.'>
			<div class="input-group-append">
				<button class="btn btn-outline-secondary" type="submit" formaction="'.Url::toRoute('index').'"><i class="fas fa-search"></i></button>
				'.$print.'
				'.$export.'
				'.$import.'
				'.$delete.'
				'.$create.'
			</div>
		</div>
	</form>';
//		if (Yii::$app->user->can($con . '_import')){
			echo $this->render(
				'@acmepy/base/upload/views/upload', [
				'model' => new \acmepy\base\upload\models\UploadForm(), 
				'type' => 'data'
			]);
//		}
	}

}

