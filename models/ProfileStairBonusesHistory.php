<?php

/**
 * This is the model class for table "profile_stair_bonuses_history".
 *
 * The followings are the available columns in table 'profile_stair_bonuses_history':
 * @property integer $id
 * @property integer $users__id
 * @property integer $child__id
 * @property string $child_rank
 * @property string $amount
 * @property integer $periode__id
 * @property integer $gv
 * @property string $created_at
 * @property integer $created_by
 * @property string $created_ip
 * @property string $modified_at
 * @property integer $modified_by
 * @property string $modified_ip
 */
class ProfileStairBonusesHistory extends UTIActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ProfileStairBonusesHistory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'profile_stair_bonuses_history';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('users__id, child__id, periode__id, created_by, modified_by', 'numerical', 'integerOnly'=>true),
			array('child_rank, created_ip, modified_ip', 'length', 'max'=>255),
			array('amount', 'length', 'max'=>10),
			array('created_at, modified_at', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, users__id, child__id, child_rank, amount, periode__id, gv, created_at, created_by, created_ip, modified_at, modified_by, modified_ip', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'periode' => array(self::BELONGS_TO, 'ProfilePeriode', 'periode__id'),
			 'user' => array(self::BELONGS_TO, 'Users', 'child__id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'users__id' => 'Users',
			'child__id' => 'Child',
			'child_rank' => 'Child Rank',
			'amount' => 'Amount',
			'periode__id' => 'Periode',
			'gv' => 'Gv',
			'created_at' => 'Created At',
			'created_by' => 'Created By',
			'created_ip' => 'Created Ip',
			'modified_at' => 'Modified At',
			'modified_by' => 'Modified By',
			'modified_ip' => 'Modified Ip',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('users__id',$this->users__id);
		$criteria->compare('child__id',$this->child__id);
		$criteria->compare('child_rank',$this->child_rank,true);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('periode__id',$this->periode__id);
		$criteria->compare('gv',$this->gv);
		$criteria->compare('created_at',$this->created_at,true);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('created_ip',$this->created_ip,true);
		$criteria->compare('modified_at',$this->modified_at,true);
		$criteria->compare('modified_by',$this->modified_by);
		$criteria->compare('modified_ip',$this->modified_ip,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}