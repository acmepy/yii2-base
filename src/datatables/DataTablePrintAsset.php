<?php
namespace acmepy\base\datatables;

use yii\base\Exception;
use yii\web\AssetBundle;

class DataTablePrintAsset extends AssetBundle{
    public $sourcePath = '@bower';
    /*
	public $css     = [
		'datatables.net-bs4/css/dataTables.bootstrap4.css',
		'datatables.net-buttons-bs4/css/buttons.bootstrap4.css'
	];
	*/
    /*
	public $js      = [
		'datatables.net-bs4/js/dataTables.bootstrap4.js',
		'datatables.net-buttons-bs4/js/buttons.bootstrap4.js',
		'datatables.net-buttons/js/buttons.flash.js',
		'jszip/dist/jszip.js',
		'pdfmake/build/pdfmake.js',
		'pdfmake/build/vfs_fonts.js',
		'datatables.net-buttons/js/buttons.html5.js',
		'datatables.net-buttons/js/buttons.print.js',
		
	];
	*/
	
	public $css = [
		//'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css',
		//'https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css',
		//'https://cdn.datatables.net/buttons/1.6.1/css/buttons.bootstrap4.min.css',
		'datatables.net-bs4/css/dataTables.bootstrap4.css',
		'datatables.net-buttons-bs4/css/buttons.bootstrap4.css'
	];
	
	public $js = [
		//'https://code.jquery.com/jquery-3.3.1.js',
		//'https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js',
		'datatables.net/js/jquery.dataTables.js',
		//'https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js',
		'datatables.net-bs4/js/dataTables.bootstrap4.js',
		//'https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js',
		'datatables.net-buttons/js/dataTables.buttons.js',
		//'https://cdn.datatables.net/buttons/1.6.1/js/buttons.bootstrap4.min.js',
		'datatables.net-buttons-bs4/js/buttons.bootstrap4.js',		
		//'https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js',
		'jszip/dist/jszip.js',
		//'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js',
		'pdfmake/build/pdfmake.js',
		//'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js',
		'pdfmake/build/vfs_fonts.js',
		//'https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js',
		'datatables.net-buttons/js/buttons.html5.js',
		//'https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js',
		//'datatables.net-buttons/js/buttons.print.js',
		'/dev/web/js/buttons.print.js',
		//'https://cdn.datatables.net/buttons/1.6.1/js/buttons.colVis.min.js',
		
	];
	
    public $depends = [
		//'acmepy\base\AdminLte3\ReportsAsset',
		'acmepy\base\AdminLte3\AdminLteAsset',
    ];

	public function init(){
        parent::init();
    }
}