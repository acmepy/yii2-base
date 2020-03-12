<?php
namespace acmepy\base\AdminLte3;
use yii\base\Exception;
use yii\web\AssetBundle as BaseAdminLteAsset;
/**
 * AdminLte AssetBundle
 * @since 0.1
 */
class AdminLteAsset extends BaseAdminLteAsset
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte';
    public $css     = [
		'plugins/fontawesome-free/css/all.min.css',
		//'//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css',
		'plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css',
		'plugins/icheck-bootstrap/icheck-bootstrap.min.css',
		'plugins/jqvmap/jqvmap.min.css',
		'dist/css/adminlte.min.css',
		'plugins/overlayScrollbars/css/OverlayScrollbars.min.css',
		
		'plugins/daterangepicker/daterangepicker.css',
		'plugins/icheck-bootstrap/icheck-bootstrap.min.css',

		'plugins/summernote/summernote-bs4.css',
		//'//fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700',
		//'/dev/web/css/site.css', //provisorio
	];
    public $js      = [
		////'plugins/jquery/jquery.min.js',
		'plugins/jquery-ui/jquery-ui.min.js',
		'/dev/web/js/jQuery.UI.tooltip.with.Bootstrap.tooltip.js', //provisorio
//		'plugins/bootstrap/js/bootstrap.bundle.min.js',
		'plugins/chart.js/Chart.min.js',
		'plugins/sparklines/sparkline.js', 
		'plugins/jqvmap/jquery.vmap.min.js',
		'plugins/jqvmap/maps/jquery.vmap.usa.js', 
		'plugins/jquery-knob/jquery.knob.min.js',
		'plugins/moment/moment.min.js',
		
		'plugins/daterangepicker/daterangepicker.js',
		'plugins/bootstrap-switch/js/bootstrap-switch.min.js',
		
		'plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js',
		'plugins/summernote/summernote-bs4.min.js',
		'plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js',
		////'plugins/moment/moment.min.js',
		'plugins/inputmask/min/jquery.inputmask.bundle.min.js',
		'dist/js/adminlte.min.js',
		////'dist/js/pages/dashboard.js',
		////'dist/js/demo.js',
	];
    public $depends = [
        'yii\web\YiiAsset',
		'yii\web\JqueryAsset', 
		//con estos no se visualiza correctamente
        //'yii\bootstrap\BootstrapAsset',
        //'yii\bootstrap\BootstrapPluginAsset',
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