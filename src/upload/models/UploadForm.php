<?php
namespace acmepy\base\upload\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $file;
	public $dir  = '';
	public $save = false;

    public function rules()
    {
        return [
            //[['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
            //[['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xls, csv, txt, xlsx'],
        ];
    }
    
    public function upload()
    {
        if ($this->validate()) {
			if ($this->save)
				$this->file->saveAs($dir . $this->file->baseName . '.' . $this->file->extension);
            return true;
        } else {
            return false;
        }
    }
}