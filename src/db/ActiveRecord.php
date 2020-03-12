<?php
namespace acmepy\base\db;

use Yii;
use yii\web\NotFoundHttpException;

//use acmepy\reports\models\ReportsExe;

class ActiveRecord extends \yii\db\ActiveRecord
{
	const CREATE = 'create';
	//update si existe, insert si no
	const SCENARIO_IMPORT_UPDATE = 'import_update';
	
	public function scenarios()
    {
        $scenarios = parent::scenarios();
		$scenarios[self::SCENARIO_IMPORT_UPDATE] = $scenarios['default'];
		$scenarios['view']   = $scenarios['default'];
		$scenarios['index']  = $scenarios['default'];
		$scenarios['create'] = $scenarios['default'];
		$scenarios['update'] = $scenarios['default'];
		$scenarios['delete'] = $scenarios['default'];
        return $scenarios;

    }

	
	/*public function behaviors(){
		return [
			[
				'class' => \katanyoo\activerecordhistory\ActiveRecordBehavior::className(),
				'database' => 'db',
				'ignoreAttributes' => ['created_at', 'updated_at'],
			],
		];
	}*/

	public function init(){
		parent::init();
//		if ($this->scenario == self::CREATE){
			$this->defaultValues();
//		}
	}

	public static function search($clazz){
		$find = [];
		if (isset($_REQUEST['search'])){
			$find = ['or'];
			$search = $_REQUEST['search'];
			foreach((new $clazz)->attributes as $c=>$v){
				$find[] = ['like', $c, '%'.$search.'%', false];
			}
		}
		return $find;
	}
    public function hasErrors($attribute = null)
    {
		return $attribute === null ? !empty($this->getErrors()) : isset($this->getErrors()[$attribute]);
        //return parent::hasErrors($attribute);
    }

	public static function autocomplete($filed = 'id', $filter = []){
		return yii\helpers\ArrayHelper::getColumn(self::find()->where($filter)->all(), $filed);
		//return self::dataDrop([$filed, $filed]);
	}

	public static function dataDrop($fileds = ['id', 'id'], $filter = []){
		return yii\helpers\ArrayHelper::map(self::find()->where($filter)->all(), $fileds[0], $fileds[1]);
	}

	private function defaultValues(){
//		$id = Yii::$app->controller->getIdForm();
		/*$sel = Yii::$app->db->createCommand("select campo, valor from ge_valores_defecto_usuario where id_formulario = $id")->queryAll();
		foreach($sel as $campo=>$valor)
		{
			$c = $valor['campo'];
			$v = $valor['valor'];
			$this->$c = $v;
		}*/
		/*return true;*/
	}
}


