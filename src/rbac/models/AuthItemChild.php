<?php

namespace acmepy\base\rbac\models;

use Yii;

/**
 * This is the model class for table "auth_item_child".
 *
 * @property string $parent
 * @property string $child
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property AuthItem $parent0
 * @property AuthItem $child0
 */
class AuthItemChild extends \acmepy\base\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
	public static function tableName(){
		return 'auth_item_child';
	}

	public function beforeSave($insert) { 
	   if ($insert) { 
		   //$this->create_by = \Yii::$app->user->identity->id; 
		   $this->created_at = time(); 
	   } else { 
		   //$this->updated_by = \Yii::$app->user->identity->id; 
		   $this->updated_at = time(); 
	   } 
	   return parent::beforeSave($insert); 
	}

    /**
     * {@inheritdoc}
     */
	public function rules(){
		return [
            [['parent', 'child'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['parent', 'child'], 'string', 'max' => 64],
            [['parent', 'child'], 'unique', 'targetAttribute' => ['parent', 'child']],
            [['parent'], 'exist', 'skipOnError' => true, 'targetClass' => AuthItem::className(), 'targetAttribute' => ['parent' => 'name']],
            [['child'], 'exist', 'skipOnError' => true, 'targetClass' => AuthItem::className(), 'targetAttribute' => ['child' => 'name']],
		];
	}

    /**
     * {@inheritdoc}
     */
	public function attributeLabels(){
		return [
			'parent' => 'Grupo',
			'child' => 'Permiso',
			'created_at' => 'Creado',
			'updated_at' => 'Modificado',
		];
	}

    /**
     * Gets query for [[Parent0]].
     *
     * @return \yii\db\ActiveQuery
     */
	public function getGroup(){
		return $this->hasOne(AuthItem::className(), ['name' => 'parent']);
	}

    /**
     * Gets query for [[AuthItem]].
     *
     * @return \yii\db\ActiveQuery
     */
	public function getAuth(){
		return $this->hasOne(AuthItem::className(), ['name' => 'child']);
	}

	public static function find(){ 
		return parent::find()->where(parent::search(__class__)); 
	} 
	
	public static function Groups(){
		return AuthItem::Groups();
	}
	
	public static function Permisos($for = 'admin'){
		return AuthItem::AuthPendDrop($for);
		//return self::dataDrop(['parent', 'parent']);
	}
}
