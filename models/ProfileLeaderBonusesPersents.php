<?php

/**
 * This is the model class for table "profile_leader_bonuses_persents".
 *
 * The followings are the available columns in table 'profile_leader_bonuses_persents':
 * @property integer $id
 * @property string $alias
 * @property string $director_alias
 * @property string $min_value
 * @property string $max_value
 * @property integer $leader_persent
 * @property string $leader_val
 * @property string $created_at
 * @property integer $created_by
 * @property string $created_ip
 * @property string $modified_at
 * @property integer $modified_by
 * @property string $modified_ip
 */
class ProfileLeaderBonusesPersents extends UTIActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ProfileLeaderBonusesPersents the static model class
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
        return 'profile_leader_bonuses_persents';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('director_alias', 'required'),
            array('leader_persent, created_by, modified_by', 'numerical', 'integerOnly'=>true),
            array('alias, director_alias, created_ip, modified_ip', 'length', 'max'=>255),
            array('min_value, max_value, leader_val', 'length', 'max'=>10),
            array('created_at, modified_at', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, alias, director_alias, min_value, max_value, leader_persent, leader_val, created_at, created_by, created_ip, modified_at, modified_by, modified_ip', 'safe', 'on'=>'search'),
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
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'alias' => 'Alias',
            'director_alias' => 'Director Alias',
            'min_value' => 'Min Value',
            'max_value' => 'Max Value',
            'leader_persent' => 'Leader Persent',
            'leader_val' => 'Leader Val',
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
        $criteria->compare('alias',$this->alias,true);
        $criteria->compare('director_alias',$this->director_alias,true);
        $criteria->compare('min_value',$this->min_value,true);
        $criteria->compare('max_value',$this->max_value,true);
        $criteria->compare('leader_persent',$this->leader_persent);
        $criteria->compare('leader_val',$this->leader_val,true);
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