<?php
namespace acmepy\base\web;

use Yii;
use yii2tech\spreadsheet\Spreadsheet;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;


class Controller extends \yii\web\Controller{
	
	
	//generar todos los permismo que hay en authitem
	public function behaviors(){
        return [
			'access' => [
                'class' => AccessControl::className(),
                //'only' => ['index', 'view', 'update', 'delete'],
				'except' => ['progreso', 'ocr', 'ruc'],
                'rules' => [
                    ['allow' => true, 'actions' => ['view'],   'roles' => $this->getRolesArray('view')],
                    ['allow' => true, 'actions' => ['index'],  'roles' => $this->getRolesArray('index')],
                    ['allow' => true, 'actions' => ['update'], 'roles' => $this->getRolesArray('update')],
                    ['allow' => true, 'actions' => ['create'], 'roles' => $this->getRolesArray('create')],
                    ['allow' => true, 'actions' => ['delete'], 'roles' => $this->getRolesArray('delete')],
                    ['allow' => true, 'actions' => ['import'], 'roles' => $this->getRolesArray('import')],
                    ['allow' => true, 'actions' => ['export'], 'roles' => $this->getRolesArray('export')],
					
                    ['allow' => true, 'actions' => ['acreditar'], 'roles' => $this->getRolesArray('acreditar')],
                    ['allow' => true, 'actions' => ['permisos'], 'roles' => $this->getRolesArray('permisos')],
                    ['allow' => true, 'actions' => ['cerrar'], 'roles' => $this->getRolesArray('cerrar')],
                    ['allow' => true, 'actions' => ['deleteall'], 'roles' => $this->getRolesArray('delete_all')],
                    ['allow' => true, 'actions' => ['print'], 'roles' => $this->getRolesArray('print')],
                ],
            ],
            /*'verbs' => [ ver si es posible enviar post desde ActionColumn de GridView
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],*/
		];
    }
	
	public function getRolesArray($action = null){
		return [$this->getRoles($action)];
	}
	
	public function getRoles($action = null){
		$form = $this->getForm(); //Yii::$app->controller->id
		return $form.'_'.$action;
	}
	
	public function getForm(){
		$reflect = new \ReflectionClass($this);
		return strtolower(substr($reflect->getShortName(), 0, -10));
	}

	protected function getUsuario(){
		//if (!Yii::$app->user->isGuest)
			return Yii::$app->user->identity->username;
		//return null;
	}	


	public function export($type, $dataProvider){
		ini_set('memory_limit', '-1');
		set_time_limit(14400); 
		\PhpOffice\PhpSpreadsheet\Shared\File::setUseUploadTempDirectory(true);
		$exporter = new Spreadsheet(['dataProvider' => $dataProvider]);
		$exporter->render();
		$maxCol = $exporter->getDocument()->getActiveSheet()->getHighestDataColumn();
		$maxRow = $exporter->getDocument()->getActiveSheet()->getHighestDataRow();
		$exporter->getDocument()->getActiveSheet()->setAutoFilter($exporter->getDocument()->getActiveSheet()->calculateWorksheetDimension());
		$exporter->getDocument()->getActiveSheet()->getStyle('A2:A'.$maxRow)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
		$exporter->getDocument()->getActiveSheet()->getStyle('F2:F'.$maxRow)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
		foreach (range('A',$maxCol) as $col) {
			$exporter->getDocument()->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);  
		}
		$exporter->getDocument()->getActiveSheet()->getStyle('A1:'.$maxCol.'1')->getFont()->setBold(true);
		
		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf($exporter->getDocument());
		$tmpResource = tmpfile();
		if ($tmpResource === false) {
			throw new \RuntimeException('Unable to create temporary file.');
		}
		$exporter->writerType = ucfirst($type);
		return $exporter->send($dataProvider->models[0]::tableName().'.'.$type);
	}

	public function import($agr = []){
		//ver la posibilidad de encapsular en upload
		$activeRecord = isset($agr['activeRecord'])?$agr['activeRecord']:null;
		$fields = isset($agr['fields'])?$agr['fields']:null;
		$arReturn = isset($agr['arReturn'])?$agr['arReturn']:activeRecord;
		$pk = isset($agr['pk'])?$agr['pk']:$arReturn::primaryKey()[0];
		$scenario = isset($agr['scenario'])?$agr['scenario']:$activeRecord::SCENARIO_IMPORT_UPDATE;;
		$upd_rows = isset($agr['upd_rows'])?$agr['upd_rows']:100;
		
        $model = new \acmepy\base\upload\models\UploadForm();
        if (Yii::$app->request->isPost) {
            $model->file = \yii\web\UploadedFile::getInstance($model, 'file');
            if ($model->upload()) {
                // el archivo se subió exitosamente
				$importer = new \acmepy\base\import\Importer([
					'filePath' => $model->file->tempName,
					'activeRecord' => $activeRecord,
					'scenario' => $scenario,
					'skipFirstRow' => true,
					'fields' => $fields,
					'upd_rows' => $upd_rows,
				]);
				
				if (!$importer->validate()) {
					echo "<br>";
					$i = 0;
					foreach($importer->getErrors() as $rowNumber => $errors) {
						echo "<p>Fila $rowNumber : " . implode(',', $errors) . "</p>";
						echo '|'.implode('|', $importer->models[$rowNumber]->attributes).'|';
					}
				} else {
					$savedRows = $importer->save();
					return $this->render('index', [
						'type' => 'Datos Migrados-Actualizados', 
						'dataProvider' => new ActiveDataProvider(['query' => $arReturn::find()->where([$pk=>$savedRows])])
					]);
				}
                return;
            }
        }
        return $this->render('@acmepy/base/upload/views/upload', ['model' => $model, 'type' => 'file']);
	}
	public function actionProgreso() {
		if (\Yii::$app->request->isAjax) {
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return  json_decode(\Yii::$app->cache->get('importProgress.json'),true);
		}
	}

	public function actionOcr(){
		//ver la posibilidad de encapsular en upload
        $model = new \acmepy\base\upload\models\UploadForm();
        if (Yii::$app->request->isPost) {
            $model->file = \yii\web\UploadedFile::getInstance($model, 'file');
            if ($model->upload()) {
				return \acmepy\ocr\Ocr::widget();
			}
		}
        return $this->render('@acmepy/base/upload/views/upload', [
			'model' => $model, 
			'action'=> 'ocr',
			'type'  => 'file', 
			'ok'    => 'Subir'
		]);
	}
}