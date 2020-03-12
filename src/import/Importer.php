<?php
namespace acmepy\base\import;
//https://stackoverflow.com/questions/26398750/yii-background-process-issuehttps://stackoverflow.com/questions/26398750/yii-background-process-issue   
use Gevman\Yii2Excel\Exception\ImporterException;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use Yii;
use yii\base\BaseObject;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

class Importer extends \Gevman\Yii2Excel\Importer{
	
	public $tot_rows;
	public $upd_rows = 100;
	
	public function init(){
		session_write_close();
		ini_set('memory_limit', '-1');
		set_time_limit(14400); 
		############
		$this->status(['total' => 0,'actual'=> 0,'estado'=>'Analizando.'], true);
		############
		$this->filePath = \Yii::getAlias($this->filePath);
        try {
			#############
			$this->status(['total' => $this->tot_rows,'actual'=> 0,'estado'=>'Analizando..']);
			#############
            $spreadsheet = IOFactory::load($this->filePath);
            $this->rows = $spreadsheet->getActiveSheet()->toArray();
            if ($this->skipFirstRow) {
                array_shift($this->rows);
            }
			##############
			$this->tot_rows = count($this->rows);
			$this->status(['total' => $this->tot_rows,'actual'=> 0,'estado'=>'Analizando...']);
			##############
            $this->process();
        } catch (Exception $e) {
            throw new ImporterException($e->getMessage(), $e->getCode(), $e);
        }
	}
	
    public function validate(){
        $this->errors = [];
        foreach ($this->models as $index => &$model) {
			/* no funciona pk esta en nulo
			if ($model->scenario == $model::SCENARIO_IMPORT_UPDATE){
				if ($m = $model::findOne($model[$model::primaryKey()[0]])){
					foreach($model->getTableSchema()->columns as $c){
						$n = $c->name;
						if ($m->$n != $model->$n){
							$m->$n = $model->$n;
						}
					}
					$model = $m;
				}
			}
			*/
			###########
			if ((round($index/$this->upd_rows)*$this->upd_rows) == $index){
				$this->status(['total' => $this->tot_rows,'actual'=> $index,'estado'=>'Validando']);
			}
			############
            if (!$model->validate()) {
                $this->errors[$index] = $model->getFirstErrors();
			}
        }
        $this->isValidated = true;

        return empty($this->errors);
    }

	public function save(){
        $savedRows = [];

        if (!$this->isValidated) {
            $this->validate();
        }
		############
		$this->status(['total' => $this->tot_rows,'actual'=> 0,'estado'=>'Guardando']);
		############
        foreach ($this->models as $model) {
			if ($model->save()) {
				$savedRows[] = $model->getPrimaryKey();
			}
			/*if ($model->isNewRecord){
				if ($model->save()) {
					$savedRows[] = $model->getPrimaryKey();
				}
			}else{
				if ($model->update()) {
					$savedRows[] = $model->getPrimaryKey();
				}
			}*/
			###########
			if ((round(count($savedRows)/$this->upd_rows)*$this->upd_rows) == count($savedRows)){
				$this->status(['total' => $this->tot_rows,'actual'=> count($savedRows),'estado'=>'Guardando']);
			}
			###########
        }
        return $savedRows;
    }

    protected function process(){
		################
		$this->status(['total' => $this->tot_rows,'actual'=> 0,'estado'=>'Analizando.']);
		################
        foreach ($this->rows as $index => $row) {
            /** @var ActiveRecord $model */
            $model = (new $this->activeRecord);
            if ($this->scenario) {
                $model->setScenario($this->scenario);
            }
            $attributes = [];
            foreach ($this->fields as $v=>$field) {
                if (!($attribute = ArrayHelper::getValue($field, 'attribute'))) {
                    throw new ImporterException('attribute missing from one of your fields');
                }
                if (!($value = ArrayHelper::getValue($field, 'value'))) {
					$value = $v;
                    //throw new ImporterException('value missing from one of your fields');  0 es false
                }
                //if (!is_callable($value) && !array_key_exists($value, $row)) {
                //    throw new ImporterException("index `$value` not found in row");
                //}
                if (is_callable($value)) {
                    $value = $value($row);
                } else {
                    $value = isset($row[$value])?$row[$value]:'';
                }
				if (gettype($value) != $model->getTableSchema()->columns[$attribute]->type){
					if ('string' == $model->getTableSchema()->columns[$attribute]->type){
						$value = (string)$value;
					}
				}
                $attributes[$attribute] = $value;
            }
			###########
			if ((round(count($attributes)/$this->upd_rows)*$this->upd_rows) == count($attributes)){
				$this->status(['total' => $this->tot_rows,'actual'=> $index,'estado'=>'Procesando']);
			}
			###########
            $model->setAttributes($attributes);
            $this->models[$index] = $model;
        }
    }
	
	public function status($data, $purgue=false){
		\Yii::$app->cache->set('importProgress.json', json_encode($data));
	}
}