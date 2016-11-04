<?php

/**
 * This is the model class for table "profile_linear_bonuses_persents".
 *
 * The followings are the available columns in table 'profile_linear_bonuses_persents':
 * @property integer $id
 * @property integer $linear_level
 * @property integer $linear_min
 * @property integer $linear_value
 * @property string $created_at
 * @property integer $created_by
 * @property string $created_ip
 * @property string $modified_at
 * @property integer $modified_by
 * @property string $modified_ip
 * @property integer $linear_max
 */
class ProfileLinearBonusesPersents extends UTIActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ProfileLinearBonusesPersents the static model class
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
        return 'profile_linear_bonuses_persents';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('linear_level, linear_min, linear_value, created_by, modified_by, linear_max', 'numerical', 'integerOnly'=>true),
            array('created_ip, modified_ip', 'length', 'max'=>255),
            array('created_at, modified_at', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, linear_level, linear_min, linear_value, created_at, created_by, created_ip, modified_at, modified_by, modified_ip, linear_max', 'safe', 'on'=>'search'),
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
            'linear_level' => 'Linear Level',
            'linear_min' => 'Linear Min',
            'linear_value' => 'Linear Value',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'modified_at' => 'Modified At',
            'modified_by' => 'Modified By',
            'modified_ip' => 'Modified Ip',
            'linear_max' => 'Linear Max',
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
        $criteria->compare('linear_level',$this->linear_level);
        $criteria->compare('linear_min',$this->linear_min);
        $criteria->compare('linear_value',$this->linear_value);
        $criteria->compare('created_at',$this->created_at,true);
        $criteria->compare('created_by',$this->created_by);
        $criteria->compare('created_ip',$this->created_ip,true);
        $criteria->compare('modified_at',$this->modified_at,true);
        $criteria->compare('modified_by',$this->modified_by);
        $criteria->compare('modified_ip',$this->modified_ip,true);
        $criteria->compare('linear_max',$this->linear_max);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}