<?php
namespace acmepy\base\AdminLte3;
use yii\base\Exception;
use yii\web\AssetBundle as BaseAdminLteAsset;
/**
 * AdminLte AssetBundle
 * @since 0.1
 */
class ReportsAsset extends BaseAdminLteAsset
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte';
    public $css     = [
		'plugins/fontawesome-free/css/all.min.css',
		//'//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css',
		//'plugins/icheck-bootstrap/icheck-bootstrap.min.css',
		'dist/css/adminlte.min.css',
		//'plugins/overlayScrollbars/css/OverlayScrollbars.min.css',
		//'plugins/daterangepicker/daterangepicker.css',
		//'plugins/summernote/summernote-bs4.css',
		//'//fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700',
		//'/dev/web/css/site.css', //provisorio
	];

    public $js      = [
		//'plugins/jquery/jquery.min.js',
		//'plugins/bootstrap/js/bootstrap.bundle.min.js',
		'dist/js/adminlte.min.js',
	];
    public $depends = [
		//con estos no se visualiza correctamente
        'yii\web\YiiAsset',
		//10/02/2020 no encuentra y genera error
        //'yii\bootstrap4\BootstrapAsset',
        //'yii\bootstrap4\BootstrapPluginAsset',
    ];
    /**
     * @var string|bool Choose skin color, eg. `'skin-blue'` or set `false` to disable skin loading
     * @see https://almsaeedstudio.com/themes/AdminLTE/documentation/index.html#layout
     */
    public $skin = '_all-skins';
    /**
     * @inheritdoc
     */
    public function init()
    {
        // Append skin color file if specified
        /*if ($this->skin) {
            if (('_all-skins' !== $this->skin) && (strpos($this->skin, 'skin-') !== 0)) {
                throw new Exception('Invalid skin specified');
            }
            $this->css[] = sprintf('css/skins/%s.min.css', $this->skin);
        }*/
        parent::init();
    }
}