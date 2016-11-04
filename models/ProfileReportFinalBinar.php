<?php

/**
 * This is the model class for table "profile_report_final".
 *
 * The followings are the available columns in table 'profile_report_final':
 * @property integer $id
 * @property integer $users__id
 * @property integer $users__id__from
 * @property string $alias
 * @property string $alias__from
 * @property string $director_alias
 * @property string $amount
 * @property string $amount_from
 * @property string $periode_date
 * @property integer $bonuses__id
 * @property integer $sponsor__id
 * @property integer $level
 * @property string $persents
 * @property string $created_at
 * @property integer $created_by
 * @property string $created_ip
 * @property string $modified_at
 * @property integer $modified_by
 * @property string $modified_ip
 * @property integer $transactions__id
 * @property integer $periode__id
 */
class ProfileReportFinalBinar extends UTIActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ProfileReportFinal the static model class
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
        return 'profile_report_final_binar';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('users__id, users__id__from, bonuses__id, sponsor__id, steps, step, level, created_by, modified_by, transactions__id, periode__id', 'numerical', 'integerOnly'=>true),
            array('alias, alias__from, director_alias, created_ip, modified_ip', 'length', 'max'=>255),
            array('amount, amount_from, persents', 'length', 'max'=>100),
            array('periode_date, created_at, modified_at', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, users__id, users__id__from, alias, alias__from, director_alias, step,steps, amount, amount_from, periode_date, bonuses__id, sponsor__id, level, persents, created_at, created_by, created_ip, modified_at, modified_by, modified_ip, transactions__id, periode__id', 'safe', 'on'=>'search'),
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
            'user' => array(self::BELONGS_TO, 'Users', 'users__id'),
            'transactions' => array(self::BELONGS_TO, 'FinanceTransactions', 'transactions__id'),
            'periode' => array(self::BELONGS_TO, 'ProfilePeriodeBinar', 'periode__id'),
            'report' => array(self::HAS_MANY, 'ProfileReportFinalBinar', 'periode__id'),
			'users_bonuses' => array(self::BELONGS_TO, 'UsersBonuses', 'bonuses__id'),
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
            'alias' => 'Alias',
            'alias__from' => 'Alias From',
            'director_alias' => 'Director Alias',
            'amount' => 'Amount',
            'amount_from' => 'Amount From',
            'periode_date' => 'Periode Date',
            'bonuses__id' => 'Bonuses',
            'sponsor__id' => 'Sponsor',
            'level' => 'Level',
            'persents' => 'Persents',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'modified_at' => 'Modified At',
            'modified_by' => 'Modified By',
            'modified_ip' => 'Modified Ip',
            'transactions__id' => 'Transactions',
            'periode__id' => 'Periode',
			'steps' => 'steps',
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
        $criteria->compare('alias',$this->alias,true);
        $criteria->compare('alias__from',$this->alias__from,true);
        $criteria->compare('director_alias',$this->director_alias,true);
        $criteria->compare('amount',$this->amount,true);
        $criteria->compare('amount_from',$this->amount_from,true);
        $criteria->compare('periode_date',$this->periode_date,true);
        $criteria->compare('bonuses__id',$this->bonuses__id);
        $criteria->compare('sponsor__id',$this->sponsor__id);
        $criteria->compare('level',$this->level);
        $criteria->compare('persents',$this->persents,true);
        $criteria->compare('created_at',$this->created_at,true);
        $criteria->compare('created_by',$this->created_by);
        $criteria->compare('created_ip',$this->created_ip,true);
        $criteria->compare('modified_at',$this->modified_at,true);
        $criteria->compare('modified_by',$this->modified_by);
        $criteria->compare('modified_ip',$this->modified_ip,true);
        $criteria->compare('transactions__id',$this->transactions__id);
        $criteria->compare('periode__id',$this->periode__id);
		$criteria->compare('steps',$this->steps);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}