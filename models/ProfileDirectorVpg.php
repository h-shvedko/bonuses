<?php

/**
 * This is the model class for table "profile_director_vpg".
 *
 * The followings are the available columns in table 'profile_director_vpg':
 * @property integer $id
 * @property integer $users__id
 * @property integer $users__id__from
 * @property integer $periode__id
 * @property string $amount
 * @property string $created_at
 * @property integer $created_by
 * @property string $created_ip
 * @property string $modified_at
 * @property integer $modified_by
 * @property string $modified_ip
 */
class ProfileDirectorVpg extends UTIActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ProfileDirectorVpg the static model class
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
		return 'profile_director_vpg';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('created_at, modified_at', 'required'),
			array('users__id, users__id__from, periode__id, created_by, modified_by', 'numerical', 'integerOnly'=>true),
			array('amount', 'length', 'max'=>8),
			array('created_ip, modified_ip', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, users__id, users__id__from, periode__id, amount, created_at, created_by, created_ip, modified_at, modified_by, modified_ip', 'safe', 'on'=>'search'),
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
			'user_sponsor' => array(self::BELONGS_TO, 'Users', 'users__id__from'),
             'user' => array(self::BELONGS_TO, 'Users', 'users__id'),
            'periode' => array(self::BELONGS_TO, 'ProfilePeriode', 'periode__id'),
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
			'users__id__from' => 'Users Id From',
			'periode__id' => 'Periode',
			'amount' => 'Amount',
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
		$criteria->compare('users__id__from',$this->users__id__from);
		$criteria->compare('periode__id',$this->periode__id);
		$criteria->compare('amount',$this->amount,true);
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