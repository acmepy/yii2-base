<?php

namespace acmepy\base\rbac\models;

use Yii;

/**
 * This is the model class for table "auth_rule".
 *
 * @property string $name
 * @property resource|null $data
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property AuthItem[] $authItems
 */
class AuthRule extends \acmepy\base\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
	public static function tableName(){
		return 'auth_rule';
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
            [['name'], 'required'],
            [['data'], 'string'],
            [['created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 64],
            [['name'], 'unique'],
		];
	}

    /**
     * {@inheritdoc}
     */
	public function attributeLabels(){
		return [
			'name' => 'Recla',
			'data' => 'Dato',
			'created_at' => 'Creado',
			'updated_at' => 'Modificado',
		];
	}

    /**
     * Gets query for [[AuthItems]].
     *
     * @return \yii\db\ActiveQuery
     */
	public function getAuthItems(){
		return $this->hasMany(AuthItem::className(), ['rule_name' => 'name']);
	}

	public static function find(){ 
		return parent::find()->where(parent::search(__class__)); 
	} 
}
