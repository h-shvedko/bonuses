<?php

/**
 * This is the model class for table "profile_rank_history".
 *
 * The followings are the available columns in table 'profile_rank_history':
 * @property integer $id
 * @property integer $users__id
 * @property integer $periode__id
 * @property string $pv
 * @property string $agv
 * @property string $vpg
 * @property integer $pi
 * @property string $rank
 * @property integer $rank__id
 * @property string $gv
 * @property integer $is_riese
 * @property integer $transaction__id
 * @property string $created_at
 * @property integer $created_by
 * @property string $created_ip
 * @property string $modified_at
 * @property integer $modified_by
 * @property string $modified_ip
 */
class ProfileRankHistory extends UTIActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ProfileRankHistory the static model class
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
		return 'profile_rank_history';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('users__id', 'required'),
			array('users__id, periode__id, pi, rank__id, is_riese, transaction__id, created_by, modified_by', 'numerical', 'integerOnly'=>true),
			array('pv, agv, vpg, gv', 'length', 'max'=>100),
			array('rank', 'length', 'max'=>255),
			array('created_ip, modified_ip', 'length', 'max'=>100),
			array('created_at, modified_at', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, users__id, periode__id, pv, agv, vpg, pi, rank, rank__id,director__id, gv, is_riese, transaction__id, created_at, created_by, created_ip, modified_at, modified_by, modified_ip', 'safe', 'on'=>'search'),
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
		 'ranks' => array(self::BELONGS_TO, 'UsersRank', 'rank__id'),
		 'ranks_director' => array(self::BELONGS_TO, 'UsersDirectorRank', 'director__id'),
		 'user' => array(self::BELONGS_TO, 'Users', 'users__id'),
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
			'periode__id' => 'Periode',
			'pv' => 'Pv',
			'agv' => 'Agv',
			'vpg' => 'Vpg',
			'pi' => 'Pi',
			'rank' => 'Rank',
			'rank__id' => 'Rank',
			'gv' => 'Gv',
			'is_riese' => 'Is Riese',
			'transaction__id' => 'Transaction',
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
		$criteria->compare('periode__id',$this->periode__id);
		$criteria->compare('pv',$this->pv,true);
		$criteria->compare('agv',$this->agv,true);
		$criteria->compare('vpg',$this->vpg,true);
		$criteria->compare('pi',$this->pi);
		$criteria->compare('rank',$this->rank,true);
		$criteria->compare('rank__id',$this->rank__id);
		$criteria->compare('gv',$this->gv,true);
		$criteria->compare('is_riese',$this->is_riese);
		$criteria->compare('transaction__id',$this->transaction__id);
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