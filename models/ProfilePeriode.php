<?php

/**
 * This is the model class for table "profile_periode".
 *
 * The followings are the available columns in table 'profile_periode':
 * @property integer $id
 * @property string $date_begin
 * @property string $date_end
 * @property string $created_at
 * @property integer $created_by
 * @property string $created_ip
 * @property string $modified_at
 * @property integer $modified_by
 * @property string $modified_ip
 */
class ProfilePeriode extends UTIActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ProfilePeriode the static model class
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
        return 'profile_periode';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('created_by, modified_by', 'numerical', 'integerOnly'=>true),
            array('created_ip, modified_ip', 'length', 'max'=>255),
            array('date_begin, date_end, created_at, modified_at', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, date_begin, date_end, paid, created_at, created_by, created_ip, modified_at, modified_by, modified_ip', 'safe', 'on'=>'search'),
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
            'director' => array(self::HAS_MANY, 'ProfileDirectorBonuses', 'periode__id'),
            'directorinfinity' => array(self::HAS_MANY, 'ProfileDirectorInfinityBonuses', 'periode__id'),
            'auto' => array(self::HAS_MANY, 'ProfileAutoBonuses', 'periode__id'),
            'gifts' => array(self::HAS_MANY, 'ProfileGiftsBonuses', 'periode__id'),
            'house' => array(self::HAS_MANY, 'ProfileHouseBonuses', 'periode__id'),
            'instant' => array(self::HAS_MANY, 'ProfileInstantBonuses', 'periode__id'),
            'leader' => array(self::HAS_MANY, 'ProfileLeaderBonuses', 'periode__id'),
            'linear' => array(self::HAS_MANY, 'ProfileLinearBonuses', 'periode__id'),
            'stair' => array(self::HAS_MANY, 'ProfileStairBonuses', 'periode__id'),
            'report' => array(self::HAS_MANY, 'ProfileReportFinal', 'periode__id'),
			'transactions' => array(self::BELONGS_TO, 'FinanceTransactions', 'transactions__id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'date_begin' => 'Date Begin',
            'date_end' => 'Date End',
			'paid' => 'Paid',
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
        $criteria->compare('date_begin',$this->date_begin,true);
        $criteria->compare('date_end',$this->date_end,true);
        $criteria->compare('created_at',$this->created_at,true);
        $criteria->compare('created_by',$this->created_by);
        $criteria->compare('created_ip',$this->created_ip,true);
        $criteria->compare('modified_at',$this->modified_at,true);
        $criteria->compare('modified_by',$this->modified_by);
        $criteria->compare('modified_ip',$this->modified_ip,true);
		$criteria->compare('paid',$this->paid,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}