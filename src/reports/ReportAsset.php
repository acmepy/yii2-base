<?php
namespace acmepy\base\reports;

use yii\base\Exception;
use yii\web\AssetBundle;

class ReportAsset extends AssetBundle{
    public $sourcePath = '@bower';
	public $css = [
	];
	
	public $js = [
	];
	
    public $depends = [
		'acmepy\base\AdminLte3\ReportsAsset',
    ];

	public function init(){
        parent::init();
    }
}