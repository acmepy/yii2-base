<?php
namespace acmepy\base\widgets;
use yii\base\Exception;
use yii\web\AssetBundle as BaseAdminLteAsset;
/**
 * AdminLte AssetBundle
 * @since 0.1
 */
class Select2Asset extends BaseAdminLteAsset
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte';
    public $css     = [
		'plugins/select2/css/select2.min.css',
		'plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css'
	];
    public $js      = [
		'plugins/select2/js/select2.full.min.js',
	];
    public $depends = [
        'acmepy\base\AdminLte3\AdminLteAsset', 
    ];
}