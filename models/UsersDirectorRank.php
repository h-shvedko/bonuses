<?php

/**
 * This is the model class for table "users_director_rank".
 *
 * The followings are the available columns in table 'users_director_rank':
 * @property integer $id
 * @property string $alias
 * @property string $agv
 * @property string $vpg
 * @property integer $personal_invited
 * @property integer $position
 * @property string $created_at
 * @property integer $created_by
 * @property string $created_ip
 * @property string $modified_at
 * @property integer $modified_by
 * @property string $modified_ip
 * @property string $alias_invited
 * @property integer $count_director_invited
 */
class UsersDirectorRank extends UTIActiveRecord
{
    const DIRECTOR = 'director';
    const SILVER_DIRECTOR = 'silver_director';
    const PEARL_DIRECTOR = 'pearl_director';
    const GOLD_DIRECTOR = 'gold_director';
    const RUBIN_DIRECTOR = 'rubin_director';
    const EMERALD_DIRECTOR = 'emerald_director';
    const PLATINUM_DIRECTOR = 'platinum_director';
    const BRILLIANCE_DIRECTOR = 'brilliance_director';

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return UsersDirectorRank the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'users_director_rank';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('personal_invited, position, created_by, modified_by, count_director_invited', 'numerical', 'integerOnly' => true),
            array('alias', 'length', 'max' => 50),
            array('agv, vpg', 'length', 'max' => 10),
            array('created_ip, modified_ip, alias_invited', 'length', 'max' => 255),
            array('created_at, modified_at', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, alias, agv, vpg, personal_invited, position, created_at, created_by, created_ip, modified_at, modified_by, modified_ip, alias_invited, count_director_invited', 'safe', 'on' => 'search'),
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
            'lang' => array(self::HAS_ONE, 'UsersDirectorRankLang', 'id'),
            'profilebonamor' => array(self::HAS_MANY, 'ProfileBonamor', array('director__id' => 'id')),
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
            'agv' => 'Agv',
            'vpg' => 'Vpg',
            'personal_invited' => 'Personal Invited',
            'position' => 'Position',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'modified_at' => 'Modified At',
            'modified_by' => 'Modified By',
            'modified_ip' => 'Modified Ip',
            'alias_invited' => 'Alias Invited',
            'count_director_invited' => 'Count Director Invited',
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

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('alias', $this->alias, true);
        $criteria->compare('agv', $this->agv, true);
        $criteria->compare('vpg', $this->vpg, true);
        $criteria->compare('personal_invited', $this->personal_invited);
        $criteria->compare('position', $this->position);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('created_ip', $this->created_ip, true);
        $criteria->compare('modified_at', $this->modified_at, true);
        $criteria->compare('modified_by', $this->modified_by);
        $criteria->compare('modified_ip', $this->modified_ip, true);
        $criteria->compare('alias_invited', $this->alias_invited, true);
        $criteria->compare('count_director_invited', $this->count_director_invited);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

}
