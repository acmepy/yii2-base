<?php
namespace acmepy\base\i18n;

class Formatter extends \yii\i18n\Formatter{
	
    public function asPassword($value){
        return str_repeat ('*', strlen ($value));
    }
	
	public function asUserStatus($value){
		return $value==10?'Activo':'Inactivo';
	}
	
	public function asSiNo($value){
		return !$value?'No':'Sí';
	}
}