<?php

namespace acmepy\base\rbac\models;

use Yii;

/**
 * This is the model class for table "auth_assignment".
 *
 * @property string $item_name
 * @property string $user_id
 * @property int|null $created_at
 *
 * @property AuthItem $itemName
 */
class AuthAssignment extends \acmepy\base\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
	public static function tableName(){
		return 'auth_assignment';
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
            [['item_name', 'user_id'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['item_name', 'user_id'], 'string', 'max' => 64],
            [['item_name', 'user_id'], 'unique', 'targetAttribute' => ['item_name', 'user_id']],
            [['item_name'], 'exist', 'skipOnError' => true, 'targetClass' => AuthItem::className(), 'targetAttribute' => ['item_name' => 'name']],
		];
	}

    /**
     * {@inheritdoc}
     */
	public function attributeLabels(){
		return [
			'item_name' => 'Grupo',
			'user_id' => 'Usuario',
			'created_at' => 'Creado',
			'created_at' => 'Modificado',
		];
	}

    /**
     * Gets query for [[ItemName]].
     *
     * @return \yii\db\ActiveQuery
     */
	public function getItemName(){
		return $this->hasOne(AuthItem::className(), ['name' => 'item_name']);
	}

	public static function find(){ 
		return parent::find()->where(parent::search(__class__)); 
	} 
}
