<?php
namespace acmepy\base\AdminLte3;
use yii\base\Exception;
use yii\web\AssetBundle as BaseAdminLteAsset;
/**
 * AdminLte AssetBundle
 * @since 0.1
 */
class SimpleInputAsset extends BaseAdminLteAsset
{
    public $sourcePath = '@vendor/acmepy/yii2-base/src/AdminLte3/assets/css';
    public $css     = [
		'simple.input.css',
	];

    public $js      = [
	];
    public $depends = [
		'acmepy\base\AdminLte3\AdminLteAsset',
    ];
}