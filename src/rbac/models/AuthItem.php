<?php

namespace acmepy\base\rbac\models;

use Yii;

/**
 * This is the model class for table "auth_item".
 *
 * @property string $name
 * @property int $type
 * @property string|null $description
 * @property string|null $rule_name
 * @property resource|null $data
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property AuthAssignment[] $authAssignments
 * @property AuthRule $ruleName
 * @property AuthItemChild[] $authItemChildren
 * @property AuthItemChild[] $authItemChildren0
 * @property AuthItem[] $children
 * @property AuthItem[] $parents
 */
class AuthItem extends \acmepy\base\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
	public static function tableName(){
		return 'auth_item';
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
            [['name', 'type'], 'required'],
            [['type', 'created_at', 'updated_at'], 'integer'],
            [['description', 'data'], 'string'],
            [['name', 'rule_name'], 'string', 'max' => 64],
            [['name'], 'unique'],
            [['rule_name'], 'exist', 'skipOnError' => true, 'targetClass' => AuthRule::className(), 'targetAttribute' => ['rule_name' => 'name']],
		];
	}

    /**
     * {@inheritdoc}
     */
	public function attributeLabels(){
		return [
			'name' => 'Nombre',
			'type' => 'Tipo',
			'description' => 'Descripcion',
			'rule_name' => 'Regla',
			'data' => 'Dato',
			'created_at' => 'Creado',
			'updated_at' => 'Modificado',
		];
	}

    /**
     * Gets query for [[AuthAssignments]].
     *
     * @return \yii\db\ActiveQuery
     */
	public function getAuthAssignments(){
		return $this->hasMany(AuthAssignment::className(), ['item_name' => 'name']);
	}

    /**
     * Gets query for [[RuleName]].
     *
     * @return \yii\db\ActiveQuery
     */
	public function getRuleName(){
		return $this->hasOne(AuthRule::className(), ['name' => 'rule_name']);
	}

    /**
     * Gets query for [[AuthItemChildren]].
     *
     * @return \yii\db\ActiveQuery
     */
	public function getGroups(){
		return $this->hasMany(AuthItemChild::className(), ['parent' => 'name']);
	}

    /**
     * Gets query for [[AuthItemChildren0]].
     *
     * @return \yii\db\ActiveQuery
     */
	public function getAuths(){
		return $this->hasMany(AuthItemChild::className(), ['child' => 'name']);
	}

    /**
     * Gets query for [[Children]].
     *
     * @return \yii\db\ActiveQuery
     */
	public function getChildren(){
		return $this->hasMany(AuthItem::className(), ['name' => 'child'])->viaTable('auth_item_child', ['parent' => 'name']);
	}

    /**
     * Gets query for [[Parents]].
     *
     * @return \yii\db\ActiveQuery
     */
	public function getParents(){
		return $this->hasMany(AuthItem::className(), ['name' => 'parent'])->viaTable('auth_item_child', ['child' => 'name']);
	}

	public static function find(){ 
		return parent::find()->where(parent::search(__class__)); 
	} 
	
	public static function Groups(){
		return  self::autocomplete('name', ['type' => '2']);
	}

	public static function AuthPend($for = 'admin'){
		return  self::autocomplete('name', [
			'and', 
				['not in', 'name', AuthItemChild::autocomplete('child', ['=', 'parent', $for])], 
				['type' => '1'],
		]);
	}

	public static function AuthPendDrop($for = 'admin'){
		return self::dataDrop(['name', 'name'], [
			'and', 
				['not in', 'name', AuthItemChild::autocomplete('child', ['=', 'parent', $for])], 
				['type' => '1'],
		]);
	}
}
