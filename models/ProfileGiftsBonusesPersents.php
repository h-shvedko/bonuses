<?php

/**
 * This is the model class for table "profile_gifts_bonuses_persents".
 *
 * The followings are the available columns in table 'profile_gifts_bonuses_persents':
 * @property integer $id
 * @property string $alias
 * @property string $gifts_persent
 * @property string $created_at
 * @property integer $created_by
 * @property string $created_ip
 * @property string $modified_at
 * @property integer $modified_by
 * @property string $modified_ip
 * @property string $director_part
 */
class ProfileGiftsBonusesPersents extends UTIActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ProfileGiftsBonusesPersents the static model class
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
        return 'profile_gifts_bonuses_persents';
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
            array('alias, created_ip, modified_ip', 'length', 'max'=>255),
            array('gifts_persent, director_part', 'length', 'max'=>10),
            array('created_at, modified_at', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, alias, gifts_persent, created_at, created_by, created_ip, modified_at, modified_by, modified_ip, director_part', 'safe', 'on'=>'search'),
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
            'gifts_persent' => 'Gifts Persent',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'modified_at' => 'Modified At',
            'modified_by' => 'Modified By',
            'modified_ip' => 'Modified Ip',
            'director_part' => 'Director Part',
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
        $criteria->compare('gifts_persent',$this->gifts_persent,true);
        $criteria->compare('created_at',$this->created_at,true);
        $criteria->compare('created_by',$this->created_by);
        $criteria->compare('created_ip',$this->created_ip,true);
        $criteria->compare('modified_at',$this->modified_at,true);
        $criteria->compare('modified_by',$this->modified_by);
        $criteria->compare('modified_ip',$this->modified_ip,true);
        $criteria->compare('director_part',$this->director_part,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}