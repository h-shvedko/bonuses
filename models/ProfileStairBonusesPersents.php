<?php

/**
 * This is the model class for table "profile_stair_bonuses_persents".
 *
 * The followings are the available columns in table 'profile_stair_bonuses_persents':
 * @property integer $id
 * @property string $alias_from
 * @property string $alias_to
 * @property integer $stair_value
 * @property string $created_at
 * @property integer $created_by
 * @property string $created_ip
 * @property string $modified_at
 * @property integer $modified_by
 * @property string $modified_ip
 */
class ProfileStairBonusesPersents extends UTIActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ProfileStairBonusesPersents the static model class
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
        return 'profile_stair_bonuses_persents';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('stair_value, created_by, modified_by', 'numerical', 'integerOnly'=>true),
            array('alias_from, alias_to, created_ip, modified_ip', 'length', 'max'=>255),
            array('created_at, modified_at', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, alias_from, alias_to, stair_value, created_at, created_by, created_ip, modified_at, modified_by, modified_ip', 'safe', 'on'=>'search'),
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
            'alias_from' => 'Alias From',
            'alias_to' => 'Alias To',
            'stair_value' => 'Stair Value',
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
        $criteria->compare('alias_from',$this->alias_from,true);
        $criteria->compare('alias_to',$this->alias_to,true);
        $criteria->compare('stair_value',$this->stair_value);
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
	
	public static function getPersent($alias)
	{
		$criteria = new CDBCriteria();
		$criteria->select = 'max(stair_value) as stair_value';
		$criteria->condition = 'alias_to = :alias';
		$criteria->params = array(':alias' => $alias);
		
		$result = self::model()->find($criteria);
		
		return (int) $result->stair_value;
	}
}