<?php

/**
 * This is the model class for table "profile_periode_binar_summury".
 *
 * The followings are the available columns in table 'profile_periode_binar_summury':
 * @property integer $id
 * @property integer $users__id
 * @property integer $periode__id
 * @property integer $ll_count
 * @property integer $rl_count
 * @property integer $pi_ll_total_count
 * @property integer $pi_rl_total_count
 * @property integer $pi_ll_total_count_paid
 * @property integer $pi_rl_total_count_paid
 * @property integer $new_ll_count
 * @property integer $new_rl_count
 * @property integer $pi_ll_count
 * @property integer $pi_rl_count
 * @property integer $pi_ll_count_paid
 * @property integer $pi_rl_count_paid
 * @property integer $paid_ll_count
 * @property integer $paid_rl_count
 * @property integer $steps_count
 * @property integer $weight_step
 * @property integer $pi_bonus
 * @property integer $structure_bonus
 * @property string $created_at
 * @property integer $created_by
 * @property string $created_ip
 * @property string $modified_at
 * @property integer $modified_by
 * @property string $modified_ip
 */
class ProfilePeriodeBinarSummury extends UTIActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ProfilePeriodeBinarSummury the static model class
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
        return 'profile_periode_binar_summury';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('users__id, periode__id, ll_count, rl_count, pi_ll_total_count, pi_rl_total_count, pi_ll_total_count_paid, pi_rl_total_count_paid, new_ll_count, new_rl_count, pi_ll_count, pi_rl_count, pi_ll_count_paid, pi_rl_count_paid, paid_ll_count, paid_rl_count, steps_count, pi_bonus, created_by, modified_by', 'numerical', 'integerOnly'=>true),
            array('created_ip, modified_ip', 'length', 'max'=>255),
            array('created_at, modified_at', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, users__id, periode__id, ll_count, rl_count, pi_ll_total_count, pi_rl_total_count, pi_ll_total_count_paid, pi_rl_total_count_paid, new_ll_count, new_rl_count, pi_ll_count, pi_rl_count, pi_ll_count_paid, pi_rl_count_paid, paid_ll_count, paid_rl_count, steps_count, weight_step, pi_bonus, structure_bonus, created_at, created_by, created_ip, modified_at, modified_by, modified_ip', 'safe', 'on'=>'search'),
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
		'periode' => array(self::BELONGS_TO, 'ProfilePeriodeBinar', 'periode__id'),
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
            'll_count' => 'Ll Count',
            'rl_count' => 'Rl Count',
            'pi_ll_total_count' => 'Pi Ll Total Count',
            'pi_rl_total_count' => 'Pi Rl Total Count',
            'pi_ll_total_count_paid' => 'Pi Ll Total Count Paid',
            'pi_rl_total_count_paid' => 'Pi Rl Total Count Paid',
            'new_ll_count' => 'New Ll Count',
            'new_rl_count' => 'New Rl Count',
            'pi_ll_count' => 'Pi Ll Count',
            'pi_rl_count' => 'Pi Rl Count',
            'pi_ll_count_paid' => 'Pi Ll Count Paid',
            'pi_rl_count_paid' => 'Pi Rl Count Paid',
            'paid_ll_count' => 'Paid Ll Count',
            'paid_rl_count' => 'Paid Rl Count',
            'steps_count' => 'Steps Count',
            'weight_step' => 'Weight Step',
            'pi_bonus' => 'Pi Bonus',
            'structure_bonus' => 'Structure Bonus',
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
        $criteria->compare('ll_count',$this->ll_count);
        $criteria->compare('rl_count',$this->rl_count);
        $criteria->compare('pi_ll_total_count',$this->pi_ll_total_count);
        $criteria->compare('pi_rl_total_count',$this->pi_rl_total_count);
        $criteria->compare('pi_ll_total_count_paid',$this->pi_ll_total_count_paid);
        $criteria->compare('pi_rl_total_count_paid',$this->pi_rl_total_count_paid);
        $criteria->compare('new_ll_count',$this->new_ll_count);
        $criteria->compare('new_rl_count',$this->new_rl_count);
        $criteria->compare('pi_ll_count',$this->pi_ll_count);
        $criteria->compare('pi_rl_count',$this->pi_rl_count);
        $criteria->compare('pi_ll_count_paid',$this->pi_ll_count_paid);
        $criteria->compare('pi_rl_count_paid',$this->pi_rl_count_paid);
        $criteria->compare('paid_ll_count',$this->paid_ll_count);
        $criteria->compare('paid_rl_count',$this->paid_rl_count);
        $criteria->compare('steps_count',$this->steps_count);
        $criteria->compare('weight_step',$this->weight_step);
        $criteria->compare('pi_bonus',$this->pi_bonus);
        $criteria->compare('structure_bonus',$this->structure_bonus);
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