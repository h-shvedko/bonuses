<?php

/**
 * This is the model class for table "profile_bonamor_structure_settings".
 *
 * The followings are the available columns in table 'profile_bonamor_structure_settings':
 * @property integer $id
 * @property integer $user__id
 * @property integer $referal_register_type
 * @property integer $profile_bonamor__contract_no
 * @property integer $register_leg
 * @property integer $register_filltype
 * @property string $created_at
 * @property integer $created_by
 * @property string $created_ip
 * @property string $modified_at
 * @property integer $modified_by
 * @property string $modified_ip
 */
class ProfileBonamorStructureSettings extends UTIActiveRecord
{
    const REGISTER_TYPE_SELF        = 1;    // Регистрация рефералов в структуру под спонсора
    const REGISTER_TYPE_CONTRACT    = 2;    // Регистрация рефералов под определенный контракт (задан в поле contract_no)

    const REGISTER_LEG_LEFT     = 1;    // Регистрация рефералов в левую ногу
    const REGISTER_LEG_RIGHT    = 2;    // Регистрация рефералов в правую ногу

    const REGISTER_FILLTYPE_POWER   = 1;    // Регистрация рефералов в сильную ногу
    const REGISTER_FILLTYPE_WEAK    = 2;    // Регистрация рефералов в слабую ногу

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ProfilebonamorStructureSettings the static model class
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
		return 'profile_bonamor_structure_settings';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user__id, referal_register_type, profile_bonamor__contract_no, register_leg, register_filltype, created_by, modified_by', 'numerical', 'integerOnly'=>true),
//			array('profile_bonamor__contract_no', 'is_contract_exist'),
			array('created_ip, modified_ip', 'length', 'max'=>100),
			array('created_at, modified_at', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user__id, referal_register_type, profile_bonamor__contract_no, register_leg, register_filltype, created_at, created_by, created_ip, modified_at, modified_by, modified_ip', 'safe', 'on'=>'search'),
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
            'user'                  => array(self::BELONGS_TO, 'Users', 'user__id'),
            //'profile_contract_no'   => array(self::BELONGS_TO, 'Profilebonamor', array('profile_bonamor__contract_no' => 'contract_no'))
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user__id' => 'User',
			'referal_register_type' => 'Referal Register Type',
			'profile_bonamor__contract_no' => 'Profile bonamor Contract No',
			'register_leg' => 'Register Leg',
			'register_filltype' => 'Register Filltype',
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
		$criteria->compare('user__id',$this->user__id);
		$criteria->compare('referal_register_type',$this->referal_register_type);
		$criteria->compare('profile_bonamor__contract_no',$this->profile_bonamor__contract_no);
		$criteria->compare('register_leg',$this->register_leg);
		$criteria->compare('register_filltype',$this->register_filltype);
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

    public function is_contract_exist($attribute, $params)
    {
        if ($this->referal_register_type == self::REGISTER_TYPE_CONTRACT)
        {
            if (empty($this->profile_bonamor__contract_no))
            {
                $this->addError('profile_bonamor__contract_no', 'Введите номер контракта!');
                return;
            }

            $profile = Profilebonamor::model()->find('contract_no=:contract_no', array(':contract_no' => $this->profile_bonamor__contract_no));

            if (($profile == NULL) || ($profile->user == NULL) || ($profile->user->profile == NULL))
            {
                $this->addError('profile_bonamor__contract_no', 'Пользователь с номером контракта ' . $this->profile_bonamor__contract_no . ' не найден!');
                return;
            }

            if ($profile->user->profile->token == NULL)
            {
                $this->addError('profile_bonamor__contract_no', 'Пользователь с номером контракта ' . $this->profile_bonamor__contract_no . ' не найден в бинарной структуре!');
            }
        }
    }
}