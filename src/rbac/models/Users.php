<?php

namespace acmepy\base\rbac\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property string $id
 * @property string $username
 * @property string $userdesc
 * @property string|null $auth_key
 * @property string|null $password_hash
 * @property string|null $password_reset_token
 * @property string|null $email
 * @property int $status
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property string|null $verification_token
 */
class Users extends \acmepy\base\db\ActiveRecord
{
	const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    /**
     * {@inheritdoc}
     */
	public static function tableName(){
		return 'users';
	}

	public function beforeSave($insert) { 
	   if ($insert) { 
		   //$this->create_by = \Yii::$app->user->identity->id; 
		   $this->created_at = time(); 
	   } else { 
		   //$this->updated_by = \Yii::$app->user->identity->id; 
		   $this->updated_at = time(); 
	   } 
		if ($this->oldAttributes['password_hash'] != $this->password_hash) {
		  $this->password_hash = Yii::$app->getSecurity()->generatePasswordHash($this->password_hash);
		}
		
		return parent::beforeSave($insert); 
	}

    /**
     * {@inheritdoc}
     */
	public function rules(){
		return [
            [['id', 'username', 'userdesc'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['id', 'username', 'userdesc', 'password_hash', 'password_reset_token', 'email', 'verification_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
            [['id'], 'unique'],
		];
	}

    /**
     * {@inheritdoc}
     */
	public function attributeLabels(){
		return [
			'id' => 'ID',
			'username' => 'Usuario',
			'userdesc' => 'Nombre',
			'auth_key' => 'Codigo de Autorización',
			'password_hash' => 'Clave',
			'password_reset_token' => 'Codigo de reinicio de clave',
			'email' => 'Email',
			'status' => 'Estado',
			'created_at' => 'Creado',
			'updated_at' => 'Modificado',
			'verification_token' => 'Codigo de Verificacion',
		];
	}

	//cuando esta habilitado la busqueda, quiere filtrar el usuario con los datos del index actual (el filtro de cliente tambien le aplica al usuario actual y no lo encuentra)
	public static function find(){ 
		//if (Yii::$app->controller->id != 'users')
		//	return parent::find()->where(parent::search(__class__)); 
		//else 
			return parent::find();
	} 
}



/*
public function behaviors()

	{

		return array(

			'ActiveRecordHistoryLogger'

				=> 'application.models.behaviors.ActiveRecordHistoryLogger',

		);

	}
*/