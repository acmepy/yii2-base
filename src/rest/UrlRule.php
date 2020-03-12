<?php
namespace acmepy\base\rest;

class UrlRule extends \yii\rest\UrlRule{
  public $path = '@app/controllers';

  public function init()
  {
    $d = dir(\Yii::getAlias($this->path));
    $arr = [];
    /*while (false !== ($entry = $d->read())) {
       if (strpos($entry, 'Controller.php') !== false) {
          $arr[] = substr($this->path, strpos($this->path, "modules/")+8, 4) . lcfirst(str_replace(['Controller.php'], '', $entry));
       }
    }*/
	$arr = ['api/articulos', 'api/parametros'];
    $this->controller = $arr;
	parent::init();
  }
}