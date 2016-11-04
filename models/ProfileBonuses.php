<?php

/**
 * This is the model class for table "profile_bonuses".
 *
 * The followings are the available columns in table 'profile_bonuses':
 * @property integer $id
 * @property integer $user__id
 * @property integer $bonuses__id
 * @property integer $transactions__id
 * @property integer $amount_from
 * @property integer $amount
 * @property string $date_periode
 * @property string $created_at
 * @property integer $created_by
 * @property string $created_ip
 * @property string $modified_at
 * @property integer $modified_by
 * @property string $modified_ip
 */
class ProfileBonuses extends UTIActiveRecord
{

    const ALIAS_TYPE_PACKAGE = 'matrix_add_tockens';
    const DELIVERY_TYPE_ALIAS = 'self';
    const COMMENT_FOR_REGISTER_PAY = 'оплата позиции в бинаре';
    const COUNT_OF_PRODUCT_REGISTER = TRUE;
    const STATUS_CLOSE = 'closed';
    const PERCENT_PAYOUT_BINAR = 0.4;
    const SPEC_ALIAS_PAY = 'wallet_in_for_order_pay_yandexmoney';
    const SPEC_ALIAS_INVITED_USER = 'wallet_out_bonus_private_invited';
    const CCPRICE = 0.2;
    const VCCPRICE = 0.35;
    const PCPRICE = 0.5;
    const CLIENT_COMPANY = 'client_company';
    const VIP_CLIENT_COMPANY = 'vip_client_company';
    const PARTNER_COMPANY = 'partner_company';
    const PRIVATE_INVITED_ALIAS = 'lp_bonus';
    const STRUCTURE_BONUS_ALIAS = 'structur_bonus';
    const LINEAR_BONUS_ALIAS = 'linear';
    const LEADER_BONUS_ALIAS = 'leader';
    const DIRECTOR_BONUS_ALIAS = 'director';
	const ENERGY_DIRECTOR_BONUS_ALIAS = 'energy_director';
    const INFINITY_BONUS_ALIAS = 'infinity';
    const INSTANT_BONUS_ALIAS = 'instant';
    const AUTO_BONUS_ALIAS = 'auto';
    const HOUSE_BONUS_ALIAS = 'house';
    const GIFTS_BONUS_ALIAS = 'gifts';
    const STAIR_BONUS_ALIAS = 'stair';
    const LINEAR_BONUS_MIN_PV = 10;
    const STAIR_BONUS_MIN_PV = 20;
	const CLIENT = 'client';
    const PARTNER = 'partner';
    const SPONSOR = 'sponsor';
    const MANAGER = 'manager';
    const DIRECTOR = 'director';
    const VALUE_AGV_SPONSOR = 1000;
    const VALUE_AGV_MANGER = 2500;
    const VALUE_AGV_DIRECTOR = 5000;
    const WAREHOUSE_STATUS_ALIAS = 'held';
    const WAREHOUSE_TYPE_ALIAS = 'orders';
	const WAREHOUSE_TYPE_ALIAS_MOVING = 'moving';
    const PERSENT_OF_AUTO_BONUS = 2;
    const PERSENT_OF_HOUSE_BONUS = 4;
    const ALL_USER_ALIAS = 'all';
    const ONLY_DIRECTOR_USER_ALIAS = 'only_director';
    const HAVE_HOUSE = 'HaveHouse';
    const HAVE_AUTO = 'HaveAuto';
    const MIN_POINTS_FOR_PC = 20;
	const ENERGY_SPONSOR_VALUE_GROUP = 250;
    const ENERGY_MANGER_VALUE_GROUP = 500;
	const BINAR_STOP = 30000;
	const MLM_STOP = 120000;
	const COEF_WALLET_OUT = 100;
	
	private $_userid;
	private $_pv;
	private $_agv;
	private $_vpg;
	private $_steps;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ProfileBonuses the static model class
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
        return 'profile_bonuses';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('users__id, bonuses__id, transactions__id, created_by, modified_by, steps, step', 'numerical', 'integerOnly' => true),
            array('created_ip, modified_ip', 'length', 'max' => 255),
            array('date_periode, created_at, modified_at', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, users__id, bonuses__id, transactions__id, amount_from, amount, date_periode, steps, step, created_at, created_by, created_ip, modified_at, modified_by, modified_ip', 'safe', 'on' => 'search'),
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
            'userbonuses' => array(self::BELONGS_TO, 'UsersBonuses', 'bonuses__id'),
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
            'users__id' => 'User',
            'bonuses__id' => 'Bonuses',
            'transactions__id' => 'Transactions',
            'amount_from' => 'Amount From',
            'amount' => 'Amount',
            'date_periode' => 'Date Periode',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'created_ip' => 'Created Ip',
            'modified_at' => 'Modified At',
            'modified_by' => 'Modified By',
            'modified_ip' => 'Modified Ip',
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

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('users__id', $this->users__id);
        $criteria->compare('bonuses__id', $this->bonuses__id);
        $criteria->compare('transactions__id', $this->transactions__id);
        $criteria->compare('amount_from', $this->amount_from);
        $criteria->compare('amount', $this->amount);
        $criteria->compare('date_periode', $this->date_periode, true);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('created_by', $this->created_by);
        $criteria->compare('created_ip', $this->created_ip, true);
        $criteria->compare('modified_at', $this->modified_at, true);
        $criteria->compare('modified_by', $this->modified_by);
        $criteria->compare('modified_ip', $this->modified_ip, true);
		$criteria->compare('steps', $this->steps, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function checkFirstRegisterPay($transaction, $h = FALSE)
    {
        Yii::import('application.modules.store.models.*');
        $userId = $transaction->getModelTransactions()->credit_object_id;
        $horderAllOfUser = Horders::model()->findAll('users__id = :users__id and register = :register and is_payed = :is_payed', array(':users__id' => (int) $userId, ':register' => (int) TRUE, ':is_payed' => (int) TRUE));
        $horders_id = array_key_exists('horders__id', $transaction->modelsTransactionsObjects) ? $transaction->modelsTransactionsObjects['horders__id']->value : '';
        $horder = Horders::model()->findByPk($horders_id);

        if ($horder->register == (int) TRUE && count($horderAllOfUser) === (int) TRUE && $horder->is_payed == (int) TRUE)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function checkRegisterPay($transaction, $horders_id = FALSE)
    {
        Yii::import('application.modules.store.models.*');

        if (!$horders_id)
        {
            $horders_id = array_key_exists('horders__id', $transaction->modelsTransactionsObjects) ? $transaction->modelsTransactionsObjects['horders__id'] : '';
        }
        $horder = Horders::model()->findByPk($horders_id->value);
        if ($horder->register == (int) TRUE && $horder->is_payed == (int) TRUE)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
	
	public static function getDay($month)
	{
		switch ($month) 
		{
			case 1: 
				return 31;
			case 2: 
				return 28;
			case 3:
				return 31;
			case 4:
				return 30;
			case 5:
				return 31;
			case 6:
				return 30;
			case 7:
				return 31;
			case 8:
				return 31;
			case 9:
				return 30;
			case 10:
				return 31;
			case 11:
				return 30;
			case 12:
				return 31;
		}
	}
	
	//добавляет 2 месяца к сетевой активности или до конца текущей недели для бинара  - ворвращает в зависимости от передоваемого параметра (0- бинар, 1- сетевая структура)
	public static function getDate($value)
	{
		if($value == (int)TRUE)
		{
			if((app_date("m")+1) <= 12)
			{
				$dateUserActivity = strtotime(app_date("Y")."-".(app_date("m")+1)."-".self::getDay(app_date("m")+1));
			}
			else
			{
				$dateUserActivity = strtotime((app_date("Y")+1)."-".(app_date("m")+1 - 12)."-".self::getDay(app_date("m")+1 - 12));
			}
			return $dateUserActivity;
        }
		
		if($value == (int)FALSE)
		{
			if((app_date("d")+(8-app_date("N"))) > app_date("t"))
			{
				if((app_date("m")+1) <= 12)
				{
					$dataSponsorActivity = strtotime(app_date("Y")."-".(app_date("m")+1)."-".(app_date("d")+(8-app_date("N")) - app_date("t")));
				}
				else
				{
					$dataSponsorActivity = strtotime((app_date("Y")+1)."-".(app_date("m")+1 -12)."-".(app_date("d")+(8-app_date("N")) - app_date("t")));
				}
			}
			else
			{
				$dataSponsorActivity = strtotime(app_date("Y")."-".app_date("m")."-".(app_date("d")+(8-app_date("N")))); 
			}
			return $dataSponsorActivity;
		}
	}
	


    public function _updateRoles($transactionModel)
    {

        $users_id = $transactionModel->credit_object_id;
        $specAlias = $transactionModel->spec_alias;
        $user = Users::model()->find('id =:id', array(':id' => (int) $users_id));
        Yii::import('application.modules.admin.modules.roles.models.*');
        Yii::import('application.modules.office.models.*');
		$userRole = Authassignment::model()->find('itemname = :itemname and userid = :userid', array(':itemname' => 'UserNotActive', ':userid' => (int) $users_id));
        if (!empty($userRole))
        {

            $newRole = new Authassignment();
            $newRole->userid = $user->id;
            $newRole->itemname = Stats::ROLE_ACTIVEUSER;
			$newRole->validate();
            if (!$newRole->save())
            {
                throw new CHttpException(403, Yii::t('app', 'Ошибка при обновлении данных пользователя'));
            }
            Authassignment::model()->deleteAll('userid=:userid AND itemname=:notConfirmed', array(':userid' => $user->id, ':notConfirmed' => Stats::ROLE_NOTACTIVEUSER));
            return true;
        }
        return true;
    }
	
	public function activeInFirstLine($userId)
	{
		if (empty($userId))
		{
			throw new CException('Не задан пользователь', E_USER_ERROR);
		}
		
		$profile = Profile::model()->findAll('sponsor__id = :sponsor__id', array(':sponsor__id' => $userId));
		$cnt = (int) FALSE;
		$result = array();
		foreach($profile as $value)
		{
			if($this->getActivity($value->user__id))
			{
				$result[] = $value;
			}
		}
		$cnt = count($result);
		
		return $cnt;
	}
	
	public function activeInFirstLinePrevious($userId)
	{
		if (empty($userId))
		{
			throw new CException('Не задан пользователь', E_USER_ERROR);
		}
		
		$profile = Profile::model()->findAll('sponsor__id = :sponsor__id', array(':sponsor__id' => $userId));
		$cnt = (int) FALSE;
		$result = array();
		foreach($profile as $value)
		{
			$val = $this->getActivityPrevious($value->user__id);
			
			if($val > 0)
			{
				$result[] = $value;
			}
		}
		
		
		$cnt = count($result);
		
		return $cnt;
	}
	
	//-----------проверка активности пользователя-------------------------
	
	public static function checkActivity($userId)
	{
		$criteriaActivity = new CDbCriteria();
		$criteriaActivity->condition = 'user__id = :user__id';
		$criteriaActivity->params = array(':user__id' => $userId);
		$criteriaActivity->order = 'date_end DESC';
		$criteriaActivity->limit = (int) TRUE;
		
		$activity = ProfileActivity::model()->find($criteriaActivity);
		
		return $activity;
	}
	
	//-----------проверка партнера компании на окончание срока бизнес опции-------------------------
	
	public static function checkBizOptions($userId)
	{
		$criteriaActivity = new CDbCriteria();
		$criteriaActivity->condition = 'user__id = :user__id and amount_vcc = :amount_vcc';
		$criteriaActivity->params = array(':user__id' => $userId, ':amount_vcc' => (int) FALSE);
		$criteriaActivity->order = 'date_update DESC';
		$criteriaActivity->limit = (int) TRUE;
		
		$activity = ProfileBonamorHistory::model()->find($criteriaActivity);
		
		return $activity;
	}

    //----------------------Создание заказа для регистрационного пакета------------------

    public function setOrdersToRegister($packagesId, $register = FALSE)
    {
        Yii::import('application.modules.store.models.*');
       // $deliveryTypesId = DeliveryTypes::model()->find('alias = :alias', array(':alias' => self::DELIVERY_TYPE_ALIAS));
       // $payTypesId = PayTypes::model()->find('alias = :alias', array(':alias' => PayTypes::PAY_YANDEXMONEY));
        //$allHordersOfUser = Horders::model()->findAll('users__id = :users__id and register = :register', array(':users__id' => Yii::app()->user->id, ':register' => (int)TRUE));

        $horderRegister = new Horders();
        $horderRegister->users__id = Yii::app()->user->id;
        $horderRegister->total_price = $this->getValueOfPackage($packagesId);
        $horderRegister->store_delivery_types__id = (int) TRUE;
        $horderRegister->store_pay_types__id = (int) TRUE;
        $horderRegister->commentary = self::COMMENT_FOR_REGISTER_PAY;
        $horderRegister->total_points = $this->getPointsOfPackage($packagesId);
		$horderRegister->total_gifts = $this->getGiftsOfPackage($packagesId);
        if ($register != FALSE)
        {
            $horderRegister->register = (int) TRUE;
        }

        if ($horderRegister->validate())
        {
            if (!$horderRegister->save())
            {
                throw new CException('Ошибка сохранение данных', E_USER_ERROR);
            }
			$horderRegister->num = Horders::getNum($horderRegister->id);
			if (!$horderRegister->save())
            {
                throw new CException('Ошибка сохранение данных', E_USER_ERROR);
            }
            //$packageRegister = $this->getRegisterPackage($packagesId);
			$packageRegister = PackagesStoreValue::model()->findAll('packages__id = :packages__id', array(':packages__id' => $packagesId));	
            if (!empty($packageRegister))
            {
			
                foreach ($packageRegister as $packagesValue)
                {
                    $orderRegister = new Orders();
                    $orderRegister->store_horders__id = $horderRegister->id;
                    $orderRegister->catalogues_products__id = $packagesValue->products__id;
                    $orderRegister->count = (int) self::COUNT_OF_PRODUCT_REGISTER;
                    $orderRegister->price = $packagesValue->price;
                    $orderRegister->points = $packagesValue->points;

                    if (!$orderRegister->validate())
                    {
                        throw new CException('Не удалось создать заказ', E_USER_ERROR);
                    }
                    if (!$orderRegister->save())
                    {
                        throw new CException('Ошибка сохранение данных', E_USER_ERROR);
                    }
                }
			}
            else
            {
                return false;
            }
        }
        return $horderRegister;
    }

    public function getRegisterPackage($packagesId)
    {
        Yii::import('application.modules.admin.modules.packages.models.*');

        $registerPackage = PackagesStore::model()->findByPk($packagesId);
		//vg($registerPackage); die;
        if (!empty($registerPackage))
        {
            return $registerPackage;
        }
        else
        {
            throw new CException('Не задано значение для регистрационного пакета', E_USER_ERROR);
        }
    }

    public function getValueOfPackage($packagesId)
    {
        Yii::import('application.modules.admin.modules.packages.models.*');

        $user = Users::model()->findByPk(Yii::app()->user->id);
        $valuePackage = PackagesStore::model()->findByPk($packagesId);

       /* if ($user->profilebonamor->options->alias == $this::CLIENT_COMPANY)
        {
            $price = $valuePackage->price * (1 - $this::CCPRICE);
        }
        elseif ($user->profilebonamor->options->alias == $this::VIP_CLIENT_COMPANY)
        {
            $price = $valuePackage->price * (1 - $this::VCCPRICE);
        }
        elseif ($user->profilebonamor->options->alias == $this::PARTNER_COMPANY)
        {
            $price = $valuePackage->price * (1 - $this::PCPRICE);
        }
        else
        {*/
            $price = $valuePackage->price;
        //}
        return $price;
    }

    public function getValueOfPoints($userId = FALSE)
    {
        $value = 0;
        $start = $this->getStartPeriodeMLM();
        $end = $this->getEndPeriodeMLM();
        if ($userId == FALSE)
        {
            $user = Users::model()->findAll('username != :usernameadmin and username != :usernamesuperadmin', array(':usernameadmin' => 'superadmin', ':usernameadmin' => 'admin'));
            foreach ($user as $users)
            {
                $horders = Horders::model()->findAll('users__id = :users and closed_at >= :datestart and closed_at < :dateend', array(':users' => $users->id, ':datestart' => $start, ':dateend' => $end));
                foreach ($horders as $horder)
                {
                    $value += $horder->total_points;
                }
            }
        }
        else
        {
            $horders = Horders::model()->findAll('users__id = :users and closed_at >= :datestart and closed_at < :dateend', array(':users' => $userId, ':datestart' => $start, ':dateend' => $end));
            foreach ($horders as $horder)
            {
                $value += $horder->total_points;
            }
        }
        return $value;
    }

    public function getValueOfAllOrders($dateStart, $dateEnd)
    {
        Yii::import('application.modules.store.models.*');

        $valueOfBinar = Horders::model()->findAll('closed_at <= :dateclosed and closed_at >= :datestart and register = :register', array(':dateclosed' => app_date("Y-m-d H:m:s", strtotime($dateEnd)), ':datestart' => app_date("Y-m-d H:m:s", strtotime($dateStart)), ':register' => (int) TRUE));
        $sum_points = 0;
		
        foreach ($valueOfBinar as $value)
        {
            $sum_points += $value->total_price;
        }
        return $sum_points;
    }

    public function getPeriode()
    {
		$criteria = new CDbCriteria();
		$criteria->order = 'id desc';
		$criteria->limit = (int) TRUE;
		$criteria->offset = (int) TRUE;
        $periode = ProfilePeriode::model()->find($criteria);

        return $periode;
    }
	
	public function getPeriodeCurrent()
    {
		$criteria = new CDbCriteria();
		$criteria->order = 'id desc';
		$criteria->limit = (int) TRUE;
        $periode = ProfilePeriode::model()->find($criteria);

        return $periode;
    }

    public function getPeriodeBinar()
    {
		$criteria = new CDbCriteria();
		$criteria->order = 'id desc';
		$criteria->limit = (int) TRUE;
		$criteria->offset = (int) TRUE;
        $periode = ProfilePeriodeBinar::model()->find($criteria);

        return $periode;
    }
	
	public function getPeriodeBinarCurrent()
    {
		$criteria = new CDbCriteria();
		$criteria->order = 'id desc';
		$criteria->limit = (int) TRUE;
        $periode = ProfilePeriodeBinar::model()->find($criteria);

        return $periode;
    }
	
	 public static function getWalletsBalance($userId)
    {
	
		$user = Users::model()->findByPk($userId);
	
        $wallets = $user->wallets;
        $balance = array();
        
        foreach ($wallets as $wallet)
        {
            $balance[$wallet->purpose_alias] = $wallet->balance;
        }
        
        return $balance;
    }
	
	public function getCurrentBinarSum($userId)
	{
		if (empty($userId))
		{
			throw new CException('Не задан пользователь', E_USER_ERROR);
		}
		
		$criteria = new CDbCriteria();
		$criteria->select = 'sum(amount) as amount';
		$criteria->condition = 'periode__id = :periode__id and users__id = :users__id';
		$criteria->params = array(':periode__id' => $this->getPeriodeBinarCurrent()->id, ':users__id' => $userId);
		
		$result = ProfileReportFinalBinar::model()->find($criteria);
		
		if(!empty($result))
		{
			return floor($result->amount);
		}
		else
		{
			return (int) FALSE;
		}
		
	}
	
	public function getCurrentPISum($userId, $now = FALSE)
	{
		if (empty($userId))
		{
			throw new CException('Не задан пользователь', E_USER_ERROR);
		}
		$bonuses = UsersBonuses::model()->find('alias = :alias', array(':alias' => UsersBonuses::LP_BONUS));
		$criteria = new CDbCriteria();
		$criteria->select = 'sum(amount) as amount';
		$criteria->condition = 'periode__id = :periode__id and users__id = :users__id and bonuses__id = :bonuses__id';
		if($now != FALSE)
		{
			$criteria->params = array(':periode__id' => $this->getPeriodeBinar()->id, ':users__id' => $userId, ':bonuses__id' => $bonuses->id);
		}
		else
		{
			$criteria->params = array(':periode__id' => $this->getPeriodeBinarCurrent()->id, ':users__id' => $userId, ':bonuses__id' => $bonuses->id);
		}
	/*	$criteria->condition = 'users__id = :users__id and bonuses__id = :bonuses__id';
		$criteria->params = array(':users__id' => $userId, ':bonuses__id' => $bonuses->id);*/
		$result = ProfileReportFinalBinar::model()->find($criteria);
		
		if(!empty($result))
		{
			return floor($result->amount);
		}
		else
		{
			return (int) FALSE;
		}
		
	}
	
	public function getCurrentInstantSum($userId)
	{
		if (empty($userId))
		{
			throw new CException('Не задан пользователь', E_USER_ERROR);
		}
		
		$bonuses = UsersBonuses::model()->find('alias = :alias', array(':alias' => UsersBonuses::INSTANT_BONUS_ALIAS));
		$criteria = new CDbCriteria();
		$criteria->select = 'sum(amount) as amount';
		$criteria->condition = 'periode__id = :periode__id and bonuses__id = :bonuses__id and users__id = :users__id';
		$criteria->params = array(':periode__id' => $this->getPeriodeCurrent()->id, ':bonuses__id' => $bonuses->id, ':users__id' => $userId);
		
		$result = ProfileReportFinal::model()->find($criteria);
		
		if(!empty($result))
		{
			return floor($result->amount);
		}
		else
		{
			return (int) FALSE;
		}
		
	}
	
	public function getCurrentAllSum($userId)
	{
		if (empty($userId))
		{
			throw new CException('Не задан пользователь', E_USER_ERROR);
		}
		
		$bonuses = UsersBonuses::model()->find('alias = :alias', array(':alias' => UsersBonuses::INSTANT_BONUS_ALIAS));
		$criteria = new CDbCriteria();
		$criteria->select = 'sum(amount) as amount';
		$criteria->condition = 'periode__id = :periode__id and bonuses__id != :bonuses__id and users__id = :users__id';
		$criteria->params = array(':periode__id' => $this->getPeriodeCurrent()->id, ':bonuses__id' => $bonuses->id, ':users__id' => $userId);
		
		$result = ProfileReportFinal::model()->find($criteria);
		
		if(!empty($result))
		{
			return floor($result->amount);
		}
		else
		{
			return (int) FALSE;
		}
		
	}
	
	public function getAllSum($userId)
	{
		if (empty($userId))
		{
			throw new CException('Не задан пользователь', E_USER_ERROR);
		}
		
		$criteriaMLM = new CDbCriteria();
		$criteriaMLM->condition = 'users__id = :users__id';
		$criteriaMLM->params = array(':users__id' => $userId);
		$criteriaMLM->with = array(
				'transactions' => array(
							'condition' => 'transactions.status_alias = :closed',
							'params' => array(':closed' => 'closed')
						)		
			);
		
		$criteria = new CDbCriteria();
		$criteria->select = 'sum(t.amount) as amount';
		$criteria->condition = 'users__id = :users__id';
		$criteria->params = array(':users__id' => $userId);
		$criteria->with = array(
				'transactions' => array(
							'condition' => 'transactions.status_alias = :closed',
							'params' => array(':closed' => 'closed')
						)		
			);
		
		$resultMLM = ProfileReportFinal::model()->findAll($criteriaMLM);
		$resultBinar = ProfileReportFinalBinar::model()->find($criteria);
		
		if($resultBinar instanceof ProfileReportFinalBinar)
		{
			$resultBinarAmount = $resultBinar->amount;
		}
		else
		{
			$resultBinarAmount = (int)FALSE;
		}
		
		if(count($resultMLM) > (int)FALSE)
		{
			$resultMLMAmount = (int)FALSE;
			foreach($resultMLM as $result)
			{
				if($result->users_bonuses->alias == self::INFINITY_BONUS_ALIAS || $result->users_bonuses->alias == self::DIRECTOR_BONUS_ALIAS || $result->users_bonuses->alias == self::ENERGY_DIRECTOR_BONUS_ALIAS || $result->users_bonuses->alias == self::LINEAR_BONUS_ALIAS || $result->users_bonuses->alias == self::STAIR_BONUS_ALIAS)
				{
					$resultMLMAmount += $result->amount*100;
				}
				else
				{
					$resultMLMAmount += $result->amount;
				}
			}
		}
		else
		{
			$resultMLMAmount = (int)FALSE;
		}

		$result = $resultMLMAmount + $resultBinarAmount;
		
		if(!empty($result))
		{
			return floor($result);
		}
		else
		{
			return (int) FALSE;
		}
		
	}
	
	public static function getAllSumMLMByPeriode($userId, $periode)
	{
		if (empty($userId))
		{
			throw new CException('Не задан пользователь', E_USER_ERROR);
		}
		
		$criteria = new CDbCriteria();
		$criteria->select = 'sum(t.amount) as amount';
		$criteria->condition = 'users__id = :users__id and  periode__id = :periode__id';
		$criteria->params = array(':users__id' => $userId, ':periode__id' => $periode);
		
		$resultMLM = ProfileReportFinal::model()->find($criteria);
				
		if($resultMLM instanceof ProfileReportFinal)
		{
			$resultMLMAmount = $resultMLM->amount;
		}
		else
		{
			$resultMLMAmount = (int)FALSE;
		}
		
		$result = $resultMLMAmount;
		
		if(!empty($result))
		{
			return floor($result);
		}
		else
		{
			return (int) FALSE;
		}
		
	}

    //----------------------Структурный бонус---------------------------------------------

	public function getBinarAmountForUserStructure($userId)
	{
		if (empty($userId))
		{
			throw new CException('Не задан пользователь', E_USER_ERROR);
		}
		
		$criteriaAmount = new CDbCriteria();
		$criteriaAmount->select = 'sum(report.amount) as amount';
		$criteriaAmount->alias = 'report';
		$criteriaAmount->join = 'LEFT JOIN profile_periode_binar as periode ON report.periode__id = periode.id';
		
		$criteriaAmount->condition = 'report.users__id = :users__id and periode.id = :periode';
		$criteriaAmount->params = array(':users__id' => $userId, ':periode' => $this->getPeriodeBinar()->id);
		
		$reportBinarPeriode = ProfileReportFinalBinar::model()->find($criteriaAmount);
	
		if(!empty($reportBinarPeriode))
		{
			return $reportBinarPeriode->amount;
		}
		else
		{
			return (int) FALSE;
		}
		
	}
	
	public function getBinarAmountForUserPersonal($userId)
	{
		if (empty($userId))
		{
			throw new CException('Не задан пользователь', E_USER_ERROR);
		}
		
		$criteriaAmount = new CDbCriteria();
		$criteriaAmount->select = 'sum(amount) as amount';
		$criteriaAmount->with = array('periode' => array(
													'condition' => 'periode.date_end is NULL',
													)
									);
		$criteriaAmount->condition = 'users__id = :users__id';
		$criteriaAmount->params = array(':users__id' => $userId);
		$reportBinarPeriode = ProfileReportFinalBinar::model()->find($criteriaAmount);
		
		/*
		$criteriaAmount = new CDbCriteria();
		$criteriaAmount->select = 'sum(amount) as amount';
		$criteriaAmount->with = array('periode' => array(
													'order' => 'id DESC',
													'offset' => '1',
													'limit' => '1',
													)
									);
		$criteriaAmount->condition = 'users__id = :users__id';
		$criteriaAmount->params = array(':users__id' => $userId);
		$reportBinarPeriode = ProfileReportFinalBinar::model()->find($criteriaAmount);
		*/
		
		if(!empty($reportBinarPeriode))
		{
			return $reportBinarPeriode->amount;
		}
		else
		{
			return (int) FALSE;
		}
		
	}
	
    public function stepStructureBonuseCalculate($dateStart, $dateEnd)
    {
        $sumBinar = $this->getValueOfAllOrders($dateStart, $dateEnd);
        $bonuseValue = 0;
        $countStepBinar = MatrixTokensWrapper::cntOfStepsCurrentAll($dateStart, $dateEnd);
        $countPackages = $this->getCountPackagesOfBinar($dateStart, $dateEnd);
		
        $persentToPay = self::PERCENT_PAYOUT_BINAR;
		if ($countStepBinar == (int)FALSE)
		{
			return $bonuseValue;
		}
	
        $bonuseValue = $sumBinar * $persentToPay / $countStepBinar;
	
		return $bonuseValue;
    }
	
	public function cntOfSteps($userId, $dateStart = FALSE, $dateEnd = FALSE)
	{
		Yii::import('application.modules.admin.modules.matrix.models.*');
		 if (empty($userId))
		{
			throw new CException('Не задан пользователь', E_USER_ERROR);
		}
		$count = 0;
		$tokensModel = MatrixTokens::model()->find('users__id = :users__id', array(':users__id' => $userId));
		$upline = substr($tokensModel->upline, -8, 8);
		$criteria = new CDbCriteria();
		$criteria->condition = 'upline like :upline and modified_at >= :datestart and modified_at <= :dateend'; // поменять modified_at на status_at на продакшине
		$criteria->params = array(':upline' => '%' . $upline . '.%', ':datestart' => $dateStart,':dateend' => $dateEnd);
		$list = MatrixTokens::model()->findAll($criteria);
		$cntSteps = 0;
		if(!empty($list))
		{
			
			for($j = 0; $j < count($list); $j++ )
			{
				$item = $list[$j]->parent_id;
				$level = $list[$j]->rank;
				for($i = $j+1; $i < count($list); $i++ )
				{
					if($item == $list[$i]->parent_id && $level != $list[$i]->rank)
					{
						$cntSteps ++;
					}
				}
			}
		}
		$count = $cntSteps;
		return $count;
	}	
	
	public static function checkForStructureBonuse($userId)
	{
		$left = MatrixTokensWrapper::model()->cntOfLeftLegTokensProfilePackages($userId);
		$right = MatrixTokensWrapper::model()->cntOfRightLegTokensProfilePackages($userId);
		
		
		if($left > (int)FALSE && $right > (int)FALSE)
		{
			return TRUE;
		}
		
		return FALSE;
	}

    public function addStuctureBonuses($userId = FALSE, $dateStart, $dateEnd) //Структурный бонус по бинару
    {
		ini_set('max_execution_time', 600);
		Yii::import('application.modules.register.models.*');
		 $countStepBinar = MatrixTokensWrapper::cntOfStepsCurrentAll($dateStart, $dateEnd);
        if ($userId != FALSE)
        {
            $activityCurrenUser = $this->getActivity($userId);
			$hasPersonalInvitedDiffLegs = self::checkForStructureBonuse($userId);
            if ($activityCurrenUser == FALSE || $hasPersonalInvitedDiffLegs == FALSE)
            {
                return;
            }
            $bonusType = UsersBonuses::model()->find('alias = :alias', array(':alias' => UsersBonuses::STRUCTURE_BONUS_ALIAS));
            $existStructureBonus = ProfileBonuses::model()->findAll('date_periode >= :date_start and bonuses__id = :bonuses__id', array(':date_start' => $dateStart, ':bonuses__id' => $bonusType->id));
            if (!empty($existStructureBonus))
            {
                return;
            }

            $stepValue = $this->stepStructureBonuseCalculate($dateStart, $dateEnd);
			$countStepOfUser = MatrixTokensWrapper::model()->cntOfStepsCurrent($userId,$dateStart, $dateEnd);	
           
            $amount = $stepValue * $countStepOfUser;
			
            if ($amount == 0)
            {
                return;
            }
			
            $bonusSB = new ProfileBonuses();
            $bonusSB->bonuses__id = $bonusType->id;
            $bonusSB->users__id = $userId;
            $bonusSB->amount = round($amount);
            $bonusSB->date_periode = date("Y-m-d");
			$bonusSB->periode__id = $this->getPeriodeBinar()->id;
			$bonusSB->steps = $countStepOfUser;

            if ($bonusSB->validate())
            {
                if (!$bonusSB->save())
                {
                    throw new CException('Не создан структурный бонус', E_USER_ERROR);
                }
                if (!ProfileBonuses::model()->updateReportFinalBinar($bonusSB, self::STRUCTURE_BONUS_ALIAS))
                {
                    throw new CException('Ошибка создания сводной таблицы6', E_USER_ERROR);
                }
            }
            if (!$this->setFinanceTransactionStructureBonuse($userId))
            {
                throw new CException('Не создана транзакция для структурного бонуса', E_USER_ERROR);
            }
            return true;
        }
        else
        {
            $bonusType = UsersBonuses::model()->find('alias = :alias', array(':alias' => UsersBonuses::STRUCTURE_BONUS_ALIAS));
            $stepValue = $this->stepStructureBonuseCalculate($dateStart, $dateEnd);
            $user = Users::model()->findAll();
            foreach ($user as $users)
            {
                if ($users->username != 'superadmin')
                {
                    $userId = $users->id;
                    $activityCurrenUser = $this->getActivity($userId);
					$hasPersonalInvitedDiffLegs = self::checkForStructureBonuse($userId);
					
                    if ($activityCurrenUser == FALSE || $hasPersonalInvitedDiffLegs == FALSE)
                    {
                        continue;
                    }
					$existStructureBonus = array();
                    $existStructureBonus = ProfileBonuses::model()->findAll('users__id = :users__id and periode__id = :periode__id and bonuses__id = :bonuses__id', array(':periode__id' => $this->getPeriodeBinar()->id, ':bonuses__id' => $bonusType->id, ':users__id' => $userId));
					
                    if (!empty($existStructureBonus))
                    {
                        continue;
                    }
                    $countStepOfUser = MatrixTokensWrapper::model()->cntOfStepsCurrent($userId,$dateStart, $dateEnd);	
                    $amount = $stepValue * $countStepOfUser;
					
					
                    if ($amount != 0)
                    {
					
                       if(($this->getBinarAmountForUserStructure($userId) + $amount) > self::BINAR_STOP)
						{
						
							$amount = self::BINAR_STOP - $this->getBinarAmountForUserStructure($userId);
							$transaction = $this->setFinanceTransactionStructureBonuse($userId, round($amount));
							$transactionId = $transaction->getModelTransactions()->id;
						}
						else
						{
							$transaction = $this->setFinanceTransactionStructureBonuse($userId, round($amount));
							$transactionId = $transaction->getModelTransactions()->id;
						}
                        $bonusSB = new ProfileBonuses();
                        $bonusSB->bonuses__id = $bonusType->id;
                        $bonusSB->users__id = $userId;
                        $bonusSB->amount = round($amount);
                        $bonusSB->date_periode = date("Y-m-d");
						$bonusSB->periode__id = $this->getPeriodeBinar()->id;
                        $bonusSB->transactions__id = $transactionId;
						$bonusSB->step = $countStepOfUser;
						$bonusSB->steps = $countStepBinar;
					//vg($bonusSB);
                        if ($bonusSB->validate())
                        {
                            if (!$bonusSB->save())
                            {
                                throw new CException('Не создан структурный бонус', E_USER_ERROR);
                            }
							if($amount != (int) FALSE)
							{
								if (!ProfileBonuses::model()->updateReportFinalBinar($bonusSB, self::STRUCTURE_BONUS_ALIAS))
								{
									throw new CException('Ошибка создания сводной таблицы6', E_USER_ERROR);
								}
							}
                        }
                    }
                }
					
            }
        }//die("00000000000");
		return true;
    }

    public function setFinanceTransactionStructureBonuse($userId, $amount = FALSE)
    {
       /* $bonusStructureAlias = UsersBonuses::model()->find('alias = :alias', array(':alias' => UsersBonuses::STRUCTURE_BONUS_ALIAS));
        $dateStart = $this->getStartPeriodeBinar();
		
        $amount = $this::model()->findAll('users__id = :users__id and bonuses__id = :bonuses__id and date_periode >= :date_start', array(':users__id' => $userId, ':bonuses__id' => $bonusStructureAlias->id, ':date_start' => $dateStart));

        if (count($amount) > 1)
        {
            return false;
        }*/
        $transaction = new FinanceTransaction('system');

       // $profile = Profile::model()->find('user__id = :user_id', array(':user_id' => $userId));
        $transaction->initMainCurrency();
        $transaction->setSpecificationByAlias('wallet_out_bonus_structure_bonus');

        $transaction->initProperties();
        $transaction->initDebitMainWalletByObjectAndId('users', $userId);
        $transaction->initCreditWalletByObjectAndIdAndPurpose('company', 1, 'bonus_out');

        $transaction->amount = $amount;

        $transaction->modelsTransactionsObjects['redirect_confirm_after_paymentsystem']->value = '/office/default/payresult';
        $transaction->modelsTransactionsObjects['redirect_decline_after_paymentsystem']->value = '/office/default/payresult';
        $transaction->modelsTransactionsObjects['redirect_open_after_paymentsystem']->value = '/paymentsystem/yandexmoney/pay/index';

        $transaction->objectsAttributes = array(
            'redirect_confirm_after_paymentsystem' => array('alias' => 'redirect_confirm_after_paymentsystem', 'value' => '/office/default/payresult'),
            'redirect_decline_after_paymentsystem' => array('alias' => 'redirect_decline_after_paymentsystem', 'value' => '/office/default/payresult'),
            'redirect_open_after_paymentsystem' => array('alias' => 'redirect_open_after_paymentsystem', 'value' => '/paymentsystem/yandexmoney/pay/index')
        );

        if ($transaction->open())
        {
            return $transaction;
        }
        else
        {
            throw new CException('Не создана транзакция для структурного бонуса', E_USER_ERROR);
        }
    }

    public function getPointsOfPackage($packagesId)
    {
        $value = PackagesStore::model()->findByPk($packagesId);

        return $value->points;
    }
	
	public function getGiftsOfPackage($packagesId)
    {
        $value = PackagesStore::model()->findByPk($packagesId);

        return $value->gifts;
    }

    public function getStartPeriodeBinar()
    {
        $start = strtotime("Monday previous week");
        return strftime('%Y-%m-%d', $start);
    }

    public function getEndPeriodeBinar()
    {
        $end = strtotime("Sunday previous week");
        return strftime('%Y-%m-%d', $end);
    }

    public function getCountPackagesOfBinar($dateStart, $dateEnd)
    {
		$horder = Horders::model()->findAll('closed_at <= :dateclosed and closed_at >= :datestart and register = :register', array(':dateclosed' => $dateEnd, ':datestart' => $dateStart, ':register' => (int) TRUE));
        $countPackages = count($horder);

        return $countPackages;
    }

    public function getCountStepOfUser($userId)
    {
        $valueToken = MatrixTokens::model()->findAll();
        $stepToken = array();
        $lenUpline = strpos($valueToken[0]->upline, '.');
        $startPosition = $lenUpline + 1;
        $cnt = count($valueToken);
        $model = MatrixTokens::model()->find('users__id = :users__id', array(':users__id' => $userId));
        $level = $model->level;
        $uplineUser = substr($model->upline, (-1) * $lenUpline);
        for ($i = 0; $i < $cnt; $i++)
        {
            for ($j = 0; $j < $cnt; $j++)
            {
                $upline = substr($valueToken[$j]->upline, $startPosition, $lenUpline);
                if ($upline && $upline == $uplineUser)
                {
                    $stepToken[] = [
                        'id' => $valueToken[$j]->id,
                        'upline' => $upline,
                        'rank' => $valueToken[$j]->rank,
                        'level' => $valueToken[$j]->level,
                    ];
                }
            }
            $startPosition += $lenUpline + 1;
        }

        $countStepMatrix = 0;
        $countStep = count($stepToken);
        for ($k = 0; $k < $countStep; $k++)
        {
            for ($l = $k; $l < $countStep; $l++)
            {
                if ($stepToken[$k]['upline'] == $stepToken[$l]['upline'] && $stepToken[$k]['level'] == $stepToken[$l]['level'] && $stepToken[$k]['rank'] != $stepToken[$l]['rank'])
                {
                    $countStepMatrix++;
                }
            }
        }

        $cntStep = $countStepMatrix;
        return $cntStep;
    }

    public function getCountStepOfBinar()
   	{
		$userAdmin = Users::model()->find('username = "admin"');
		$userId = $userAdmin->id;
		$count = 0;
		$tokensModel = MatrixTokens::model()->find('users__id = :users__id', array(':users__id' => $userId));
		$upline = substr($tokensModel->upline, -8, 8);
		$criteria = new CDbCriteria();
		$criteria->condition = 'upline like :upline';
		$criteria->params = array(':upline' => '%' . $upline . '.%');
		$list = MatrixTokens::model()->findAll($criteria);
		$cntSteps = 0;
		if(!empty($list))
		{
			
			for($j = 0; $j < count($list); $j++ )
			{
				$item = $list[$j]->parent_id;
				$level = $list[$j]->rank;
				for($i = $j+1; $i < count($list); $i++ )
				{
					if($item == $list[$i]->parent_id && $level != $list[$i]->rank)
					{
						$cntSteps ++;
					}
				}
			}
		}
		$count = $cntSteps;
		return $count;
	}	

    public function getActivity($userId)
    {
        if (empty($userId))
        {
            throw new CException('Не задан пользователь2', E_USER_ERROR);
        }
        $criteriaActivity = new CDbCriteria();
		$criteriaActivity->condition = 'user__id = :user__id';
		$criteriaActivity->params = array(':user__id' => $userId);
		$criteriaActivity->order = 'date_end DESC';
		$criteriaActivity->limit = (int) TRUE;
		
		$activity = ProfileActivity::model()->find($criteriaActivity);

        if (!empty($activity) && $activity->date_end >= app_date("Y-m-d"))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
	
	public function getActivityPrevious($userId)
    {
        if (empty($userId))
        {
            throw new CException('Не задан пользователь2', E_USER_ERROR);
        }
		
		$periode = $this->getPeriode();
		
        $criteriaActivity = new CDbCriteria();
		$criteriaActivity->condition = 'user__id = :user__id and date_end >= :date_end';
		$criteriaActivity->params = array(':user__id' => $userId, ':date_end' => $periode->date_end);
		//$criteriaActivity->addBetweenCondition('date_end', $periode->date_begin, $periode->date_end);
				
		$activity = ProfileActivity::model()->findAll($criteriaActivity);
		
		if (!empty($activity))
        {
            return (int) true;
        }
        else
        {
            return (int) false;
        }
    }

//-------------------------------------------------------------------------------------------------------------------------------------------
    public function getStartPeriodeMLM()
    {
        return $this->getPeriode()->date_begin;
    }

    public function getEndPeriodeMLM()
    {
        return $this->getPeriode()->date_end;
    }

    public function getUserGroup($userId)
    {
        Yii::import('application.modules.admin.modules.matrix.models.*');
        if (empty($userId))
        {
            throw new CException('Не задан пользователь3', E_USER_ERROR);
        }
        $valueToken = MatrixTokens::model()->findAll();
        $stepToken = array();
        $lenUpline = strpos($valueToken[1]->upline, '.');
        $startPosition = $lenUpline + 1;
        $cnt = count($valueToken);
        $model = MatrixTokens::model()->find('users__id = :users__id', array(':users__id' => $userId));
        if (empty($model))
        {
            return array();
        }
        $level = $model->level;
        $uplineUser = substr($model->upline, (-1) * $lenUpline);

        for ($i = 0; $i < $cnt; $i++)
        {
            for ($j = $i; $j < $cnt; $j++)
            {
                $upline = substr($valueToken[$j]->upline, $startPosition, $lenUpline);
                if ($upline && $upline == $uplineUser && $model->level != $valueToken[$j]->level)
                {
                    $stepToken[] = $valueToken[$j]->users__id;
                }
            }
            $startPosition += $lenUpline + 1;
        }
        return $stepToken;
    }

    public function getUserGroupCompression($userId)
    {
		if (empty($userId))
        {
            throw new CException('Не задан пользователь4', E_USER_ERROR);
        }
		$group = $this->getUserGroupByUpline($userId);
		$rankUser = ProfileBonamor::model()->find('user__id = :user__id', array(':user__id' => $userId));
		$groupCompression = array();
		foreach($group as $value)
		{
			if($value->user->profilebonamor->rank->position < $rankUser->rank->position)
			{
				$groupCompression[] = $value;
			}
		}
	
        return $groupCompression;
    }

    public function getGroupValue($userId, $dateBegin = false, $dateEnd = false)
    {
        if (empty($userId))
        {
            throw new CException('Не задан пользователь5', E_USER_ERROR);
        }
        $group = $this->getUserGroupByUpline($userId);

        $groupVolume = 0;
		
        foreach ($group as $value)
        {
            $groupVolume += $this->getPersonalVolumePrevious($value->user__id, $dateBegin, $dateEnd);
        }

        return $groupVolume;
    }
	
	public function isWarehouseHolder($userId)
	{
		$warehouse = WarWarehouse::model()->find('users__id = :users__id', array(':users__id' => $userId));
		if(!empty($warehouse))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	public function checkLeaderBonus($userId)
	{
		if($this->isWarehouseHolder($userId))
		{
			$profilebonamor = ProfileBonamor::model()->find('user__id = :user__id', array(':user__id' => $userId));
			$groupValue = $this->getGroupValue($userId);
			$check = ProfileLeaderBonusesPersents::model()->findAll('alias = :alias and min_value <= :value and max_value >= :value', array(':alias' => $profilebonamor->rank->alias, ':value' => $groupValue));
			
			if(!empty($check))
			{
				return TRUE;
			}
			else
			{
				return FALSE;
			}
		}
		else
		{
			return FALSE;
		}
				
	}
	
	 public function getGroupValueForWarehouse($userId, $groupNotInclude)
    {
        if (empty($userId))
        {
            throw new CException('Не задан пользователь5', E_USER_ERROR);
        }
		
		$profile = Profile::model()->find('user__id = :user__id', array(':user__id' => $userId));
		$currentGroup = array();
		$currentGroup = substr($profile->upline,-8,8);
		$profileGroup = array();
		$criteria = new CDbCriteria();
		$criteria->condition = 'upline like :upline';
		$criteria->params = array(':upline' => "%".$currentGroup."%");
		foreach($groupNotInclude as $key=>$valueWar)
		{
			if($valueWar->id != $userId && $valueWar->profile->tree_level > $profile->tree_level)
			{
				$criteria->addCondition('instr(upline, :key'.$key.') = 0');
				$criteria->params = array_merge($criteria->params, array(':key'.$key.'' => $valueWar->profile->upline));
			}
		}
		
		$profileGroup = Profile::model()->findAll($criteria);
		
		$groupVolume = 0;
		
        foreach ($profileGroup as $value)
        {
			$groupVolume += $this->getPersonalVolumePrevious($value->user__id);
        }
		
        return $groupVolume;
    }

//----------------------Личный объем---------------------------------------------------------------------------------------------------------

    public function getPersonalVolume($userId, $dateStart = false, $dateEnd = false)
    {
        if (empty($userId))
        {
            throw new CException('Не задан пользователь6', E_USER_ERROR);
        }
        if ($dateStart == FALSE && $dateEnd == FALSE)
        {
            $valueUser = ProfileBonamorPv::model()->findAll('users__id = :users__id and date_end is NULL', array(':users__id' => $userId));
        }
        elseif ($dateStart == FALSE && $dateEnd != FALSE)
        {
            
            $valueUser = ProfileBonamorPv::model()->findAll('users__id = :users__id and date_end <= :date_end', array(':users__id' => $userId, ':date_end' => $dateEnd));
        }
        elseif ($dateStart != FALSE && $dateEnd == FALSE)
        {
            
            $valueUser = ProfileBonamorPv::model()->findAll('users__id = :users__id and date_start >= :date_start', array(':users__id' => $userId, ':date_start' => $dateStart));
        }
        elseif ($dateStart != FALSE && $dateEnd != FALSE)
        {
            
            $valueUser = ProfileBonamorPv::model()->findAll('users__id = :users__id and date_start >= :date_start and date_end <= :date_end', array(':users__id' => $userId, ':date_start' => $dateStart, ':date_end' => $dateEnd));
        }

        if (count($valueUser) > 1)
        {
            $datePeriode = 0;
            foreach ($valueUser as $value)
            {
                if ($datePeriode < $value->periode)
                {
                    $datePeriode = $value->periode;
                }
            }
            $userPVMaxPeriode = ProfileBonamorPv::model()->find('users__id = :users__id and date_end is NULL', array(':users__id' => $userId));
        }
        if (isset($userPVMaxPeriode))
        {
            return $userPVMaxPeriode->value;
        }
        elseif (!empty($valueUser))
        {
            return $valueUser[0]->value;
        }
        else
        {
            return false;
        }
    }

//-------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------Накопленный групповой объем-------------------------------------------------------------------------------------------

    public function getAccumulatedGroupVolume($userId, $dateStart = false, $dateEnd = false)
    {
        if (empty($userId))
        {
            throw new CException('Не задан пользователь7', E_USER_ERROR);
        }
        if ($dateStart == FALSE && $dateEnd == FALSE)
        {
            $valueUser = ProfileBonamorAgv::model()->findAll('users__id = :users__id', array(':users__id' => $userId));
        }
        elseif ($dateStart == FALSE && $dateEnd != FALSE)
        {
            $dateEnd = $this->getEndPeriodeMLM();
            $valueUser = ProfileBonamorAgv::model()->findAll('users__id = :users__id and periode <= :date_end', array(':users__id' => $userId, ':date_end' => $dateEnd()));
        }
        elseif ($dateStart != FALSE && $dateEnd == FALSE)
        {
            $dateStart = $this->getStartPeriodeMLM();
            $valueUser = ProfileBonamorAgv::model()->findAll('users__id = :users__id and periode >= :date_start', array(':users__id' => $userId, ':date_start' => $dateStart));
        }
        elseif ($dateStart != FALSE && $dateEnd != FALSE)
        {
            $dateStart = $this->getStartPeriodeMLM();
            $dateEnd = $this->getEndPeriodeMLM();
            $valueUser = ProfileBonamorAgv::model()->findAll('users__id = :users__id and periode >= :date_start and periode <= :date_end', array(':users__id' => $userId, ':date_start' => $dateStart, ':date_end' => $dateEnd));
        }

        if (count($valueUser) > 1)
        {
            $datePeriode = 0;
            foreach ($valueUser as $value)
            {
                if ($datePeriode < $value->periode)
                {
                    $datePeriode = $value->periode;
                }
            }
            $userAGVMaxPeriode = ProfileBonamorPv::model()->find('users__id = :users__id and periode = :periode', array(':users__id' => $userId, ':periode' => $datePeriode));
        }
        if (isset($userAGVMaxPeriode))
        {
			$_agv = $userAGVMaxPeriode->value;
            return $_agv;
        }
        elseif (!empty($valueUser))
        {
			$_agv = $valueUser[0]->value;
            return $_agv;
        }
        else
        {
            return false;
        }
    }

	
	public function getAccumulatedGroupVolumePrevious($userId)
    {
        if (empty($userId))
        {
            throw new CException('Не задан пользователь7777', E_USER_ERROR);
        }
		
		$start = $this->getPeriode()->date_begin;
		$end = $this->getPeriode()->date_end;
		
		$criteriaAGV = new CDbCriteria();
		$criteriaAGV->select = 'max(value) as value';
		$criteriaAGV->condition = 'periode >= :start and periode <= :end and users__id = :users__id';
		$criteriaAGV->params = array(':start' => $start, ':end' => $end, ':users__id' => $userId);
	
		$agv = ProfileBonamorAgvHistory::model()->find($criteriaAGV);
		
		if(!empty($agv))
		{
			return $agv->value;
		}
		else
		{
			return (int)FALSE;
		}
    }

//-------------------------------------------------------------------------------------------------------------------------------------------
//----------------------Объем личной группы-------------------------------------------------------------------------------------------------

    public function getVolumeOfPersonalGroup($userId, $dateStart = false, $dateEnd = false)
    {
        if (empty($userId))
        {
            throw new CException('Не задан пользователь8', E_USER_ERROR);
        }
        if ($dateStart == FALSE && $dateEnd == FALSE)
        {
            $valueUser = ProfileBonamorVpg::model()->findAll('users__id = :users__id and date_end is NULL', array(':users__id' => $userId));
        }
        elseif ($dateStart == FALSE && $dateEnd != FALSE)
        {
            $dateEnd = $this->getEndPeriodeMLM();
            $valueUser = ProfileBonamorVpg::model()->findAll('users__id = :users__id and date_end <= :date_end ', array(':users__id' => $userId, ':date_end' => $dateEnd()));
        }
        elseif ($dateStart != FALSE && $dateEnd == FALSE)
        {
            $dateStart = $this->getStartPeriodeMLM();
            $valueUser = ProfileBonamorVpg::model()->findAll('users__id = :users__id and date_start >= :date_start', array(':users__id' => $userId, ':date_start' => $dateStart));
        }
        elseif ($dateStart != FALSE && $dateEnd != FALSE)
        {
            $dateStart = $this->getStartPeriodeMLM();
            $dateEnd = $this->getEndPeriodeMLM();
            $valueUser = ProfileBonamorVpg::model()->findAll('users__id = :users__id and date_start >= :date_start and date_end <= :date_end', array(':users__id' => $userId, ':date_start' => $dateStart, ':date_end' => $dateEnd));
        }

        if (count($valueUser) > 1)
        {
            $datePeriode = 0;
            foreach ($valueUser as $value)
            {
                if ($datePeriode < $value->periode)
                {
                    $datePeriode = $value->periode;
                }
            }
            $userVPGMaxPeriode = ProfileBonamorVpg::model()->find('users__id = :users__id and periode = :periode and date_end is NULL', array(':users__id' => $userId, ':periode' => $datePeriode));
        }

        if (isset($useкVPGMaxPeriode))
        {
            return $userVPGMaxPeriode->value;
        }
        elseif (!empty($valueUser))
        {
            return $valueUser[0]->value;
        }
        else
        {
            return false;
        }
    }

    public function getPrice($transactions, $objectTransaction)
    {
        if ($transactions == NULL)
        {
            throw new CException('Свойство transaction не инициализировано!', E_USER_ERROR);
        }

        if ($transactions == NULL)
        {
            throw new CException('Экземпляр объекта transaction не найден!', E_USER_ERROR);
        }

        $userId = $transactions->debit_object_alias == 'users' ? $transactions->credit_object_id : (int) FALSE;
        $modelTransaction = FinanceTransactions::model()->findAll('credit_object_id = :users__id and spec_alias = :spec_alias and status_alias = :status_alias', array(':users__id' => $userId, 'spec_alias' => self::SPEC_ALIAS_PAY, ':status_alias' => self::STATUS_CLOSE));
        $horders_id = array_key_exists('horders__id', $objectTransaction) ? $objectTransaction['horders__id'] : '';
		
		if(!empty($horders_id))
		{
			$modelHorders = Horders::model()->findByPk($horders_id->value);
			$price = 0;
			foreach($modelHorders->orders as $order)
			{
				$price += $order->count* $order->product->price;
			}
		}
		
		
		return $price;
        
    }

    public function getClienCompanyPrice($transactions, $objectTransaction)
    {
        $priceRetail = $this->getPrice($transactions, $objectTransaction);
        $priceClientCompany = $priceRetail - $priceRetail * self::CCPRICE;
        return $priceClientCompany;
    }

    public function getVIPClienCompanyPrice($transactions, $objectTransaction)
    {
        $priceRetail = $this->getPrice($transactions, $objectTransaction);
        $priceVIPClientCompany = $priceRetail - $priceRetail * self::VCCPRICE;
        return $priceVIPClientCompany;
    }

    public function getPartnerCompanyPrice($transactions, $objectTransaction)
    {
        $priceRetail = $this->getPrice($transactions, $objectTransaction);

        $pricePartnerCompany = $priceRetail - $priceRetail * self::PCPRICE;
        return $pricePartnerCompany;
    }

    public function setInstantBonusValue($transactions, $userId, $objectTransaction)
    {
        if (empty($userId))
        {
            throw new CException('Не задан пользователь9', E_USER_ERROR);
        }
		$value = 0;
        $userModel = Users::model()->findByPk($userId);
		$parentUser = ProfileBonuses::model()->getUplineElderOptions($userId);
		if($parentUser == FALSE)
		{
			return $value;
		}
        $statusParentUser = ProfileBonamor::model()->find('user__id = :users__id', array(':users__id' => $parentUser));
        $statusUser = ProfileBonamor::model()->find('user__id = :users__id', array(':users__id' => $userId));
				
        if (empty($parentUser) || $statusParentUser->options->alias == ProfileBonuses::CLIENT_COMPANY)
        {
            return FALSE;
        }
        if ($statusParentUser->options->alias == ProfileBonuses::VIP_CLIENT_COMPANY && $statusUser->options->alias == ProfileBonuses::CLIENT_COMPANY)
        {
            $value = $this->getClienCompanyPrice($transactions, $objectTransaction) - $this->getVIPClienCompanyPrice($transactions, $objectTransaction);
        }
        if ($statusParentUser->options->alias == ProfileBonuses::PARTNER_COMPANY && $statusUser->options->alias == ProfileBonuses::CLIENT_COMPANY)
        {
            $value = $this->getClienCompanyPrice($transactions, $objectTransaction) - $this->getPartnerCompanyPrice($transactions, $objectTransaction);
        }
        if ($statusParentUser->options->alias == ProfileBonuses::PARTNER_COMPANY && $statusUser->options->alias == ProfileBonuses::VIP_CLIENT_COMPANY)
        {
            $value = $this->getVIPClienCompanyPrice($transactions, $objectTransaction) - $this->getPartnerCompanyPrice($transactions, $objectTransaction);
        }
        return $value;
    }
	
	public function setInstantBonusValueForPK($transactions, $userId, $amountMB, $objectTransaction)
    {
        if (empty($userId))
        {
            throw new CException('Не задан пользователь10', E_USER_ERROR);
        }
				
		$valuePK = 0;

        $userModel = Users::model()->findByPk($userId);
		$parentUser = ProfileBonuses::model()->getUplinePartnerCompany($userId);
		
		if($parentUser == 0)
		{
			return $valuePK;
		}
        $statusParentUser = ProfileBonamor::model()->find('user__id = :users__id', array(':users__id' => $parentUser));
     
		if($statusParentUser->options->alias == ProfileBonuses::PARTNER_COMPANY && $userModel->profilebonamor->options->alias == ProfileBonuses::VIP_CLIENT_COMPANY)
		{
			$valuePK = $this->getClienCompanyPrice($transactions, $objectTransaction) - $this->getPartnerCompanyPrice($transactions, $objectTransaction) - $amountMB;
		} 
        return $valuePK;
    }

    //--------------------------------------------Линейный бонус-------------------------------------------------------
    public function getUserGroupForLinear($userId, $dateStart = FALSE, $dateEnd = FALSE)
    {
		if (empty($userId))
        {
            throw new CException('Не задан пользователь', E_USER_ERROR);
        }
		
		$maxLevel = $this->getMaxLevel($userId);
		
		$groupLiniar = array();
		
		$group = $this->getUserGroupByUplineAndLevel($userId);
		
		
		foreach($group as $value)
		{
			if($value['level'] <= $maxLevel)
			{
				$groupLiniar[] = $value;
			}
		}
																						
        return $groupLiniar;
    }
	
	public function getMaxLevel ($userId)
	{
		if (empty($userId))
        {
            throw new CException('Не задан пользователь12', E_USER_ERROR);
        }
		$maxLevel = 0;
		$criteria = new CDbCriteria();
		$criteria->select = 'max(linear_level) as linear_level';
		$criteria->condition = 'linear_min <= :invited and linear_max >=:invited and linear_value > 0';
		$criteria->params = array(':invited' => count($this->getPersonalInvitedForLinear($userId)));
		$maxLevel = ProfileLinearBonusesPersents::model()->find($criteria);
		
		if(!empty($maxLevel))
		{
			return $maxLevel->linear_level;
		}
		else
		{
			return $maxLevel;
		}
		
	}
	
	public function getUserGroupByUplineAndLevel($userId)
	{
		if (empty($userId))
        {
            throw new CException('Не задан пользователь13', E_USER_ERROR);
        }
		$profile = Profile::model()->find('user__id = :user__id', array(':user__id' => $userId));
		$levelParent = $profile->tree_level;
		
		$currentGroup = '';
		$currentGroup = substr($profile->upline,-8,8);
		$profileGroup = array();
		$profileGroup = Profile::model()->findAll('upline like :upline', array(':upline' => '%'.$currentGroup.'%'));
		$group = array();
		$i = (int) FALSE;
		foreach($profileGroup as $value)
		{
			$pv = $this->getPersonalVolumePrevious($value->user__id);
			if($value->user__id == $userId)
			{
				continue;
			}
			
			$group[] = array(
					'id' => $value->user__id,
					'sponsor__id' => $value->sponsor__id,
					'level' => $value->tree_level - $levelParent,
					'pv' => $pv / 2,
					'used' => (int) FALSE,
				);
		
		}
					
		$groupAll = array();
		$sponsorId = (int) FALSE;
		$sponsorLevel = (int) FALSE;
		$cnt = count($group); 
		for($k = 0; $k < $cnt; $k++)
		{
			if(!$this->IsLinearPas($group[$k]['id']))
			{
				$user = $group[$k];
				for($i = 0; $i < $cnt; $i++)
				{	
					if($group[$i]['sponsor__id'] == $user['id'])
					{
						$group[$i]['sponsor__id'] = $user['sponsor__id'];
						$group[$i]['level'] = $user['level'];
						$sponsorId = $group[$i]['id'];
						$sponsorLevel = $group[$i]['level'];
					}
					if($group[$i]['id'] == $user['sponsor__id'])
					{
						$group[$i]['pv'] += $user['pv'];
					}
					if($sponsorLevel != (int) FALSE && $sponsorId != (int) FALSE)
					{
						for($j = 0; $j < $cnt; $j++)
						{
							if($group[$j]['sponsor__id'] == $sponsorId)
							{
								$group[$j]['level'] = $sponsorLevel + 1;
								$sponsorId = $group[$j]['id'];
								$sponsorLevel = $group[$j]['level'];
							}
						}
						$sponsorId = (int) FALSE;
						$sponsorLevel = (int) FALSE;
					}
				}
			
			}
			else
			{
				$group[$k]['used'] = (int) TRUE;
			}
		}
		
		foreach($group as $val)
		{
			if($val['used'] == (int) TRUE)
			{
				$groupAll[] = $val;
			}
		}
			
		return $groupAll;
	}
	
	public function IsLinearPas($profile)
	{
		if(!($profile instanceof Profile))
		{
			$profile = Profile::model()->find('user__id = :user__id', array(':user__id' => $profile));
		}
		$profileGroup = array();
		$profileGroup = Profile::model()->findAll('sponsor__id = :sponsor__id', array(':sponsor__id' => $profile->user__id));
		
		if(!empty($profile->user->profilebonamor) && $profile->user->profilebonamor->options->alias != self::CLIENT_COMPANY && $this->getPersonalVolumePrevious($profile->user__id) >= self::LINEAR_BONUS_MIN_PV)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	public function setLinearBonusValue($userId, $dateStart, $dateEnd)
	{													
        if (empty($userId))
        {
            throw new CException('Не задан пользователь14', E_USER_ERROR);
        }
		
        $user = Users::model()->findByPk($userId);
		if(empty($user->profilebonamor))
		{
			return;
		}
		
        if ($user->profilebonamor->options->alias == self::CLIENT_COMPANY)
        {
            return;
        }
		
		$linearBonuses = array();
		
        if ($this->getPersonalVolumePrevious($userId) < self::LINEAR_BONUS_MIN_PV)
        {
            return $linearBonuses;
        }
        $group = $this->getUserGroupForLinear($userId);
														
        if (!empty($group))
        {
            $countOfInvited = count($this->getPersonalInvitedForLinear($userId));
			
            $levelCnt = (int) TRUE;
            $maxLevel = (int) FALSE;
            foreach ($group as $matrixLevel)
            {
                if ($matrixLevel['level'] > $maxLevel)
                {
                    $maxLevel = $matrixLevel['level'];
                }
            }
            														
            for ($i = (int) TRUE; $i <= $maxLevel; $i++)
            {
				$sumOfLinearBonus = (int) FALSE;
				$personalVolumeGroup = (int)FALSE;
                for ($j = (int) FALSE; $j < count($group); $j++)
                {
				
					if($group[$j]['id'] == $userId)
					{
						continue;
					}
                    
					$level = $group[$j]['level'];
					if ($level == $i)
					{ 
						$personalVolume = $group[$j]['pv'];
												
						$percentOfLinearBonuses = ProfileLinearBonusesPersents::model()->find('linear_level = :level and linear_min <= :cntInvited and linear_max >= :cntInvited', array(':level' => $level, ':cntInvited' => (int) $countOfInvited));
												
						if (!empty($percentOfLinearBonuses))
						{
							$sumOfLinearBonus += $personalVolume * $percentOfLinearBonuses->linear_value / 100;
							$personalVolumeGroup += $personalVolume;
						}
					}
                }
				$linearBonuses[] = [
					'level' => $i,
					'amount' => $sumOfLinearBonus,
					'users__parent__id' => $userId,
					'pv' => $personalVolumeGroup,
				];

            }
        }
				
        return $linearBonuses;
    }

	public function getPersonalInvitedForLinear($userId)
	{
		$criteria = new CDbCriteria();
		$criteria->with = array(
					'user' => array(
						'with' => array(
							'profilebonamor' => array(
								'with' => array(
									'options' => array(
										'condition' => 'alias != :alias',
										'params' => array(':alias' => self::CLIENT_COMPANY)
									),
								),	
							),
						),
					),
				);
		$criteria->condition = 'sponsor__id = :sponsor__id';
		$criteria->params = array(':sponsor__id' => $userId);
			
		$group = Profile::model()->findAll($criteria);
														
		$groupLiniar = array();
        foreach ($group as $value)
		{
			if($value->user__id == $userId)
			{
				continue;
			}
			$pv = $this->getPersonalVolumePrevious($value->user__id);
														
			if($pv >= self::LINEAR_BONUS_MIN_PV && $value->user->profilebonamor->options->alias != self::CLIENT_COMPANY)
			{											
				$groupLiniar[] = $value->user__id;
			}
		}

		return $groupLiniar;

	}
	
	public static function getCountFirstLine($userId)
	{
		$profile = Profile::model()->count('sponsor__id = :sponsor__id', array(':sponsor__id' => $userId));
		
		return $profile;
	}
	
    public function addBonusesLinear($userId = false, $dateStart, $dateEnd)
    {
        if (empty($userId))
        {
            $users = Users::model()->findAll();
            foreach ($users as $user)
            {
			
			$userId = $user->id;
                if ($user->username != 'superadmin')
                {
				
					if(count($this->getPersonalInvitedForLinear($user->id)) < (int) TRUE)
					{
						continue;
					}
					
	               $resultAll = ProfileBonuses::model()->setLinearBonusValue($user->id, $dateStart, $dateEnd);
	
					$cntResult = count($resultAll);
                    if (!empty($resultAll))
                    {
                        for ($i = (int) FALSE; $i < $cntResult; $i++)
                        {
                            if ($resultAll[$i]['amount'] > (int) FALSE)
                            {
								$pv = $this->getPersonalVolumePrevious($userId);
								
                                $transaction = ProfileBonuses::model()->setFinanceTransactionLinearBonuses($resultAll[$i]['amount'], $resultAll[$i]['users__parent__id'], $resultAll[$i]['level']);
                                $transactionId = $transaction->getModelTransactions()->id;
                                $bonusLinear = new ProfileLinearBonuses();
                                $bonusLinear->amount = $resultAll[$i]['amount'];
                                $bonusLinear->users__id = $resultAll[$i]['users__parent__id'];
                                $bonusLinear->level = $resultAll[$i]['level'];
                                $bonusLinear->periode_date = date("Y.m.d");
                                $bonusLinear->transactions__id = $transactionId;
                                $bonusLinear->periode__id = $this->getPeriode()->id;
								$bonusLinear->pv = $resultAll[$i]['pv'];
								$bonusLinear->kvalify_user = (int)TRUE;
								$bonusLinear->count_first_line = $this::getCountFirstLine($userId);

                                if (!$bonusLinear->save())
                                {
                                    throw new CException('Ошибка сохранения данных', E_USER_ERROR);
                                }
                                if (!ProfileBonuses::model()->updateReportFinal($bonusLinear, self::LINEAR_BONUS_ALIAS))
                                {
                                    throw new CException('Ошибка создания сводной таблицы7', E_USER_ERROR);
                                }
                            }
                        }
                    }
                }
            }
        }
        else
        {
			if($this->getPersonalInvitedForLinear($user->id) < (int) TRUE)
			{
				return TRUE;
			}

            $result = ProfileBonuses::model()->setLinearBonusValue($userId, $dateStart, $dateEnd);
            $cntResult = count($result);
            if (!empty($result))
            {
				$pv = $this->getPersonalVolumePrevious($userId);
                for ($i = (int) FALSE; $i < $cntResult; $i++)
                {
                    if ($result[$i]['amount'] > (int) FALSE)
                    {
                        $transactionBonus = ProfileBonuses::model()->setFinanceTransactionLinearBonuses($result[$i]['amount'], $result[$i]['users__parent__id'], $result[$i]['level']);
                        $transactionId = $transactionBonus->getModelTransactions()->id;

                        $bonusLinear = new ProfileLinearBonuses();
                        $bonusLinear->amount = $result[$i]['amount'];
                        $bonusLinear->users__id = $result[$i]['users__parent__id'];
                        $bonusLinear->level = $result[$i]['level'];
                        $bonusLinear->periode_date = date("Y.m.d");
                        $bonusLinear->transactions__id = $transactionId;
                        $bonusLinear->periode__id = $this->getPeriode()->id;
						$bonusLinear->pv = $result[$i]['pv'];
						$bonusLinear->kvalify_user = (int)TRUE;
						$bonusLinear->count_first_line = $this::getCountFirstLine($userId);

                        if (!$bonusLinear->save())
                        {
                            throw new CException('Ошибка сохранения данных', E_USER_ERROR);
                        }
                        if (!ProfileBonuses::model()->updateReportFinal($bonusLinear, self::LINEAR_BONUS_ALIAS))
                        {
                            throw new CException('Ошибка создания сводной таблицы8', E_USER_ERROR);
                        }
                    }
                }
            }
        }							//die;
        return TRUE;
    }

    public function setFinanceTransactionLinearBonuses($amount, $userId, $level)
    {
        if (empty($userId))
        {
            throw new CException('Не задан пользователь15', E_USER_ERROR);
        }
        $transaction = new FinanceTransaction('system');

        $transaction->initMainCurrency();
		
		switch ((int) $level)
		{
			case 1:
					$transaction->setSpecificationByAlias('wallet_out_linear_bonus');
					break;
			case 2:
					$transaction->setSpecificationByAlias('wallet_out_linear_bonus_level2');
					break;
			case 3:
					$transaction->setSpecificationByAlias('wallet_out_linear_bonus_level3');
					break;
			case 4:
					$transaction->setSpecificationByAlias('wallet_out_linear_bonus_level4');
					break;
			case 5:
					$transaction->setSpecificationByAlias('wallet_out_linear_bonus_level5');
					break;
			case 6:
					$transaction->setSpecificationByAlias('wallet_out_linear_bonus_level6');
					break;
		}
        
        $transaction->initProperties();
        $transaction->initDebitMainWalletByObjectAndId('users', $userId);
        $transaction->initCreditWalletByObjectAndIdAndPurpose('company', 1, 'bonus_out');

        $transaction->amount = round($amount * ProfileBonuses::COEF_WALLET_OUT);

        $transaction->modelsTransactionsObjects['level']->value = $level;
        $transaction->objectsAttributes = array('level' => array(
                'alias' => 'level',
                'value' => $level,
        ));

        if ($transaction->open())
        {
            return $transaction;
        }
        else
        {
            throw new CException('Ошибка создания транзакции', E_USER_ERROR);
        }
    }
	
    //------------------------------------Ступенчатый бонус------------------------------------------------------------

	
	public function getPersonalInvited($userId)
	{
		$criteria = new CDbCriteria();
		$criteria->with = array(
					'user' => array(
						'with' => array(
							'profilebonamor' => array(
								'with' => array(
									'options' => array(
										'condition' => 'alias != :alias',
										'params' => array(':alias' => self::CLIENT_COMPANY)
									),
								),	
							),
						),
					),
				);
		$criteria->condition = 'sponsor__id = :sponsor__id';
		$criteria->params = array(':sponsor__id' => $userId);
			
		$group = Profile::model()->findAll($criteria);
														
		return $group;

	}
	
	public function getUserGroupCompressionForStair($userId, $positionIn = FALSE)
    {
		if (empty($userId))
        {
            throw new CException('Не задан пользователь16', E_USER_ERROR);
        }
		$group = $this->getPersonalInvited($userId);
			
		$rankUser = ProfileBonamor::model()->find('user__id = :user__id', array(':user__id' => $userId));
		$position = $rankUser->rank->position;
		//$positionOut = FALSE;
		$groupCompression = array();
		//$i = (int) FALSE;
		
		foreach($group as $value)
		{
			$refPosition = $value->user->profilebonamor->rank->position;
									
			if($refPosition < $position)
			{	
			
				//$positionOut = $position;
				if($value->user->profilebonamor->rank->alias != self::CLIENT)
				{
					$groupCompression[] = array(
						'id' => $value->user__id,
						'rank' => $value->user->profilebonamor->rank->alias,
						);
				//	$positionOut = $refPosition;
					//$position = $refPosition; 
					//$i++;
															
				}
			}
			/*else
			{
				continue;
			}*/
			
		/*	if($positionIn > $refPosition && $i == (int) FALSE )
			{
				if($value->user->profilebonamor->rank->alias != self::CLIENT)
				{
					$groupCompression[] = array(
						'id' => $value->user__id,
						'rank' => $value->user->profilebonamor->rank->alias,
						);
					$positionOut = $refPosition;
				//	$position = $refPosition; 
					
				}
														
			}*/

			//$groupCompression = array_merge($groupCompression, $this->getUserGroupCompressionForStair($value->user__id, $positionOut));
		}
		
					
        return $groupCompression;
    }
	
    public function setStairBonusValue($userId)
    {
        if (empty($userId))
        {
            throw new CException('Не задан пользователь17', E_USER_ERROR);
        }
		
        $user = Users::model()->findByPk($userId);
		if(empty($user->profilebonamor))
		{
			return;
		}
		
        if ($user->profilebonamor->rank->alias == self::CLIENT || $user->profilebonamor->rank->alias == self::PARTNER)
        {
            return;
        }
		
        if ($this->getPersonalVolumePrevious($userId) < self::STAIR_BONUS_MIN_PV)
        {
            return;
        }
		
        $group = $this->getUserGroupCompressionForStair($userId);
		
        $stairBonuses = array();
		$sumOfStairBonus = (int) FALSE;
		
		$personalVolume = $this->getPersonalVolumePrevious($userId) / 2;
				
		$userRank = $user->profilebonamor->rank->alias;
		if($userRank == UsersRank::ENERGY_SPONSOR)
		{
			$userRank = UsersRank::SPONSOR;
		}
		elseif($userRank == UsersRank::ENERGY_MANAGER)
		{
			$userRank = UsersRank::MANAGER;
		}
		elseif($userRank == UsersRank::ENERGY_DIRECTOR)
		{
			$userRank = UsersRank::DIRECTOR;
		}
							
        if (!empty($group))
        {
							
            $countOfInvited = count($group);
			
            for ($j = 0; $j < $countOfInvited; $j++)
            {
				
                $childUserRank = $group[$j]['rank'];
                $childUserId = $group[$j]['id'];
				
				if($childUserRank == UsersRank::ENERGY_SPONSOR)
				{
					$childUserRank = UsersRank::SPONSOR;
				}
				elseif($childUserRank == UsersRank::ENERGY_MANAGER)
				{
					$childUserRank = UsersRank::MANAGER;
				}
				
				
				
		       
			   $groupOfReferal = $this->getEnergyGroupValue($childUserId) / 2;
			   $groupOfReferal2 = $this->getEnergyGroupValue($childUserId);
                $percentOfStairBonuses = ProfileStairBonusesPersents::model()->find('alias_to = :alias and alias_from = :alias_from', array(':alias' => $userRank, ':alias_from' => $childUserRank));
														
                if (!empty($percentOfStairBonuses))
                {
                    $sumOfStairBonus += $groupOfReferal * $percentOfStairBonuses->stair_value / 100;
					
					if($groupOfReferal > (int)FALSE)
					{
						$this->setStairBonusesHistory($userId,$childUserId, $group[$j]['rank'], $groupOfReferal2, $groupOfReferal * $percentOfStairBonuses->stair_value / 100);
					}
                }
				
            }
        }		
						
		$sumOfStairBonus = $sumOfStairBonus + $personalVolume * ProfileStairBonusesPersents::getPersent($userRank)/100;	
						
        return $sumOfStairBonus;
    }

    public function addBonusesStair($userId = false)
    {             
        if (empty($userId))
        {
            $users = Users::model()->findAll();
            foreach ($users as $user)
            {
                if ($user->username != 'superadmin')
                {
					$userId= $user->id;
					
                    $resultAll = ProfileBonuses::model()->setStairBonusValue($userId);
					
                    $cntResult = count($resultAll); 
																		
                    if (!empty($resultAll))
                    {
                        for ($i = 0; $i < $cntResult; $i++)
                        {
                            if ($resultAll > 0)
                            {
                                $transactionBonus = ProfileBonuses::model()->setFinanceTransactionStairBonuses($resultAll, $userId);
                                $transactionId = $transactionBonus->getModelTransactions()->id;
                                $bonusStair = new ProfileStairBonuses();
                                $bonusStair->amount = $resultAll;
                                $bonusStair->users__id = $userId;
                                $bonusStair->users__id__from = $userId;
                                $bonusStair->alias__from = '';
                                $bonusStair->alias = '';
                                $bonusStair->periode_date = date("Y.m.d");
                                $bonusStair->transactions__id = $transactionId;
                                $bonusStair->periode__id = $this->getPeriode()->id;
								$bonusStair->agv = $this->getAccumulatedGroupVolume($userId);
								$bonusStair->pv =  $this->getPersonalVolumePrevious($userId);
								$bonusStair->vpg = $this->getVolumeOfPersonalGroupPrevious($userId);
								if($user->profilebonamor->director instanceof UsersDirectorRank && $user->profilebonamor->director->position > (int)TRUE)
								{
									$bonusStair->rank__id = $user->profilebonamor->director->lang->name;
								}
								else
								{
									$bonusStair->rank__id = $user->profilebonamor->rank->lang->name;
								}

                                if (!$bonusStair->save())
                                {
                                    throw new CException('Ошибка сохранения данных', E_USER_ERROR);
                                }
                                if (!ProfileBonuses::model()->updateReportFinal($bonusStair, self::STAIR_BONUS_ALIAS))
                                {
                                    throw new CException('Ошибка создания сводной таблицы9', E_USER_ERROR);
                                }
                            }
                        }
                    }
                }
		    }
        }
        else
        {
            $result = ProfileBonuses::model()->setStairBonusValue($userId);
            $cntResult = count($result);
            if (!empty($result))
            {
                for ($i = 0; $i < $cntResult; $i++)
                {
                    if ($result > 0)
                    {
                        $transactionBonus = ProfileBonuses::model()->setFinanceTransactionStairBonuses($result, $userId);
                        $transactionId = $transactionBonus->getModelTransactions()->id;
                        $bonusStair = new ProfileStairBonuses();
                        $bonusStair->amount = $result;
                        $bonusStair->users__id = $userId;
                        $bonusStair->users__id__from = '';
                        $bonusStair->alias__from = '';
                        $bonusStair->alias = '';
                        $bonusStair->periode_date = date("Y.m.d");
                        $bonusStair->transactions__id = $transactionId;
                        $bonusStair->periode__id = $this->getPeriode()->id;
						$bonusStair->agv = $this->getAccumulatedGroupVolume($userId);
						$bonusStair->pv =  $this->getPersonalVolumePrevious($userId);
						$bonusStair->vpg = $this->getVolumeOfPersonalGroupPrevious($userId);
						//$bonusStair->rank__id = $user->profilebonamor->rank__id;

                        if (!$bonusStair->save())
                        {
                            throw new CException('Ошибка сохранения данных', E_USER_ERROR);
                        }
                        if (!ProfileBonuses::model()->updateReportFinal($bonusStair, self::STAIR_BONUS_ALIAS))
                        {
                            throw new CException('Ошибка создания сводной таблицы10', E_USER_ERROR);
                        }
                    }
                }
            }
        }													
										//die;
		return TRUE;
    }
	
	public function setStairBonusesHistory($userId, $childUserId, $childUserRank, $groupOfReferal, $amount)
	{
		if(empty($userId) || empty($childUserId) || empty($childUserRank) || empty($groupOfReferal))
		{
			throw new CException('Не заданы параметры для сохранения истории по ступенчатому бонусу', E_USER_ERROR);
		}
		
		$history = new ProfileStairBonusesHistory();
		$history->users__id = $userId;
		$history->child__id =  $childUserId;
		$history->child_rank = $childUserRank;
		$history->gv = $groupOfReferal;
		$history->amount = $amount;
		$history->periode__id = $this->getPeriode()->id;
		
		if(!$history->save())
		{
			throw new CException('ошибка сохранения истории ступенчатого бонуса', E_USER_ERROR);
		}
	
	}

    public function setFinanceTransactionStairBonuses($amount, $userId)
    {
        if (empty($userId))
        {
            throw new CException('Не задан пользователь18', E_USER_ERROR);
        }
        		
		$transaction = new FinanceTransaction('system');

        $transaction->initMainCurrency();
		
		$transaction->setSpecificationByAlias('wallet_out_stair_bonus');
		
		$transaction->initProperties();
        $transaction->initDebitMainWalletByObjectAndId('users', $userId);
        $transaction->initCreditWalletByObjectAndIdAndPurpose('company', 1, 'bonus_out');

        $transaction->amount = round($amount * ProfileBonuses::COEF_WALLET_OUT);

        $transaction->modelsTransactionsObjects['aliasFrom']->value = $userId;
        $transaction->modelsTransactionsObjects['aliasTo']->value = $userId;
        $transaction->objectsAttributes = array('aliasFrom' => array(
                'alias' => 'aliasFrom',
                'value' => $userId,
            ),
            'aliasTo' => array(
                'alias' => 'aliasTo',
                'value' => $userId,
        ));

        if ($transaction->open())
        {
            return $transaction;
        }
        else
        {
            throw new CException('Ошибка создания транзакции', E_USER_ERROR);
        }
    }

     //-------------------------------------------------------------------------------------------------------------------
    //-----------------------------------Быстрый старт-------------------------------------------------------------------

    public function setFastStartValue($userId, $alias, $volumeOfGroup)
    {
        if (empty($userId))
        {
            throw new CException('Не задан пользователь25', E_USER_ERROR);
        }
		
        $rank = UsersRank::model()->find('alias = :alias', array(':alias' => $alias));        
		$rankAll = $rank->agv;
		
        $accumulatedValue = 0;
        if ($alias == UsersRank::ENERGY_SPONSOR)
        {
            $accumulatedValue = self::VALUE_AGV_SPONSOR + $volumeOfGroup - $rankAll;
        }
        elseif ($alias == UsersRank::ENERGY_MANAGER)
        {
            $accumulatedValue = self::VALUE_AGV_MANGER + $volumeOfGroup - $rankAll;
        }
        elseif ($alias == UsersRank::ENERGY_DIRECTOR)
        {
            $accumulatedValue = self::VALUE_AGV_DIRECTOR + $volumeOfGroup - $rankAll;
        } 
		
		if ($this->updateAccumulatedGroupVolumeForFast($userId, $accumulatedValue))
            return true;
        else
            throw new CException('Не удалось обновить ранг пользователю (быстрый старт)', E_USER_ERROR);
    }
	
	public function updateFastStartValue($userId, $alias, $volumeOfGroup)
    {
        if (empty($userId))
        {
            throw new CException('Не задан пользователь26', E_USER_ERROR);
        }
		
        $rank = UsersRank::model()->find('alias = :alias', array(':alias' => $alias));        
		$rankAll = $rank->agv;
		
        $accumulatedValue = 0;
        if ($alias == UsersRank::ENERGY_SPONSOR)
        {
            $accumulatedValue = self::VALUE_AGV_SPONSOR;
        }
        elseif ($alias == UsersRank::ENERGY_MANAGER)
        {
            $accumulatedValue = self::VALUE_AGV_MANGER;
        }
        elseif ($alias == UsersRank::ENERGY_DIRECTOR)
        {
            $accumulatedValue = self::VALUE_AGV_DIRECTOR;
        } 
		if ($this->updateAccumulatedGroupVolumeForFast($userId, $accumulatedValue))
            return true;
        else
            throw new CException('Не удалось обновить ранг пользователю (быстрый старт)', E_USER_ERROR);
    }

    public function createAccumulatedGroupVolume($userId, $personalVolume)
    {
        if (empty($userId))
        {
            throw new CException('Не задан пользователь27', E_USER_ERROR);
        }
		
        $totalPointsUser = $this->setAccumulatedGroupVolume($userId);
        $userAGVExist = ProfileBonamorAgv::model()->findAll('users__id = :users__id', array(':users__id' => $userId));
        if (!empty($userAGVExist))
        {
            throw new CException('Не удалось создать накопленны групповой объем пользователю, т.к. уже существует', E_USER_ERROR);
        }

        $userAGV = new ProfileBonamorAgv();
        $userAGV->users__id = $userId;
        $totalPointsUser +=$personalVolume;
        $userAGV->value = $totalPointsUser;
        $userAGV->periode = app_date("Y-m-d");
        $userAGV->total_value = $totalPointsUser;

        if (!$userAGV->validate())
        {
            throw new CException('Не удалось обновить ранг пользователю', E_USER_ERROR);
        }
        if (!$userAGV->save())
        {
            throw new CException('Не удалось обновить ранг пользователю', E_USER_ERROR);
        }
        $this->updateAccumulatedGroupVolumeForParent($userId, $totalPointsUser);
        return true;
    }

    public function updateAccumulatedGroupVolume($userId, $totalPointsUser)
    {
        if ($userId != FALSE)
        {
            $user = Users::model()->findByPk($userId);
        }
        if ($totalPointsUser > 0)
        {
            if ($user->profilebonamor->options->alias == UsersOptions::CLIENT_COMPANY)
            {
                $userId = ProfileBonuses::model()->getUplineNotClientCompany($userId);
            }

            $userAGVMaxPeriode = ProfileBonamorAgv::model()->find('users__id = :users__id', array(':users__id' => $userId));

            if (empty($userAGVMaxPeriode))
            {
                if ($this->createAccumulatedGroupVolume($userId, $totalPointsUser))
                {
                    return;
                }
            }

            $userAGVMaxPeriode->value += $totalPointsUser;
            $userAGVMaxPeriode->periode = date("Y-m-d");
            if (!$userAGVMaxPeriode->validate())
            {
                throw new CException('Не удалось обновить накопленный групповой объем', E_USER_ERROR);
            }
            if (!$userAGVMaxPeriode->save())
            {
                throw new CException('Не удалось обновить накопленный групповой объем', E_USER_ERROR);
            }
            $userAGVHistory = new ProfileBonamorAgvHistory();
            $userAGVHistory->attributes = $userAGVMaxPeriode->attributes;
            if (!$userAGVHistory->save())
            {
                throw new CException('Не удалось обновить историю накопленного группового объема', E_USER_ERROR);
            }

            $this->updateAccumulatedGroupVolumeForParent($userId, $totalPointsUser);
            return true;
        }
        else
        {
            return FALSE;
        }
    }
	
	public function updateAccumulatedGroupVolumeForFast($userId, $totalPointsUser)
    {
        if ($userId != FALSE)
        {
            $user = Users::model()->findByPk($userId);
        }
        if ($totalPointsUser > 0)
        {
           
            $userAGVMaxPeriode = ProfileBonamorAgv::model()->find('users__id = :users__id', array(':users__id' => $userId));

            if (empty($userAGVMaxPeriode))
            {
                if ($this->createAccumulatedGroupVolume($userId, $totalPointsUser))
                {
                    return;
                }
            }

            $userAGVMaxPeriode->value = $totalPointsUser;
            $userAGVMaxPeriode->periode = date("Y-m-d");
            if (!$userAGVMaxPeriode->validate())
            {
                throw new CException('Не удалось обновить накопленный групповой объем', E_USER_ERROR);
            }
            if (!$userAGVMaxPeriode->save())
            {
                throw new CException('Не удалось обновить накопленный групповой объем', E_USER_ERROR);
            }
            $userAGVHistory = new ProfileBonamorAgvHistory();
            $userAGVHistory->attributes = $userAGVMaxPeriode->attributes;
            if (!$userAGVHistory->save())
            {
                throw new CException('Не удалось обновить историю накопленного группового объема', E_USER_ERROR);
            }
            return true;
        }
        else
        {
            return FALSE;
        }
    }

    public function updateAccumulatedGroupVolumeForParent($userId, $amount)
    {
        if (empty($userId) || empty($amount))
        {
            return FALSE;
        }
        $user = Users::model()->findByPk($userId);

        $totalPointsUser = $amount;
        $uplineParents = ProfileBonuses::model()->getUplineParents($userId);
        if (!$uplineParents)
        {
            return;
        }
        if ($totalPointsUser > 0 && !empty($uplineParents))
        {
            foreach ($uplineParents as $parent)
            {
                $userAGVMaxPeriode = ProfileBonamorAgv::model()->find('users__id = :users__id', array(':users__id' => $parent));

                if (empty($userAGVMaxPeriode))
                {
                    $this->createAccumulatedGroupVolume($parent, $amount);
                }
                else
                {
                    $userAGVMaxPeriode->value += $totalPointsUser;
                    $userAGVMaxPeriode->periode = date("Y-m-d");
                    if (!$userAGVMaxPeriode->validate())
                    {
                        throw new CException('Не удалось обновить накопленный групповой объем', E_USER_ERROR);
                    }
                    if (!$userAGVMaxPeriode->save())
                    {
                        throw new CException('Не удалось обновить накопленный групповой объем', E_USER_ERROR);
                    }
                    $userAGVHistory = new ProfileBonamorAgvHistory();
                    $userAGVHistory->attributes = $userAGVMaxPeriode->attributes;
                    if (!$userAGVHistory->save())
                    {
                        throw new CException('Не удалось обновить историю накопленного группового объема', E_USER_ERROR);
                    }
                }
            }
        }
    }

    public function setAccumulatedGroupVolume($userId)
    {
        if (empty($userId))
        {
            throw new CException('Не задан пользователь28', E_USER_ERROR);
        }
        $stepToken = $this->getUserGroupByUpline($userId);
        if (!empty($stepToken))
        {
            $hordersUsers = 0;
            foreach ($stepToken as $value)
            {
                $horders = Horders::model()->findAll('users__id = :users__id', array(':users__id' => $value));
                if (!empty($horders))
                {
                    foreach ($horders as $valueHorders)
                    {
                        $hordersUsers += $valueHorders->total_points;
                    }
                }
            }
            return $hordersUsers;
        }
        else
        {
            return 0;
        }
    }

    //------------------------------------------------------Лидерский бонус ---------------------------------------------------------------

    public function setLeaderBonusesValue($userId = FALSE, $dateStart, $dateEnd)
    {ini_set('max_execution_time', 300);
		$leaderBonuses = array();
		$groupWarehouses = array();
		$warWarehouse = WarWarehouse::model()->findAll();
		Yii::import('application.modules.admin.modules.invoice.models.*');
		WarTurnover::model()->setTurnoverForWarehouses($dateStart, $dateEnd, $this->getPeriode()->id);
		
		foreach($warWarehouse as $war)
		{
			if($this->checkLeaderBonus($war->users__id))
			{
				$groupWarehouses[] = $war->users;
			}
		}
		if ($userId == FALSE)
        {
            $user = Users::model()->findAll();
            foreach ($user as $users)
            {		
				$value = (int) FALSE;			
				$userId = $users->id;
				
				
                if ($users->username != 'superadmin')
                {
                    $persent = 0;
                    $amount = 0;
                    $warehouse = WarWarehouse::model()->find('users__id = :users__id', array(':users__id' => $users->id));
								
                    if (!empty($warehouse))
                    {
                        if ($users->profilebonamor->rank->alias != UsersRank::CLIENT && $users->profilebonamor->rank->alias != UsersRank::PARTNER && $users->profilebonamor->rank->alias != UsersRank::SPONSOR)
                        {
							/*if(!empty($users->profilebonamor->director))
							{*/
								$groupValue = $this->getGroupValueForWarehouse($users->id, $groupWarehouses);
								$leaderBonuses = ProfileLeaderBonusesPersents::model()->findAll('alias = :alias and min_value<= :value and max_value >= :value', array(':alias' => $users->profilebonamor->rank->alias, ':value' => $groupValue));
							//}
							//if($userId == 308) vg($leaderBonuses);
                            foreach ($leaderBonuses as $bonuses)
                            {
								
								if(!empty($users->profilebonamor->director))
								{
									$directorAlias = $users->profilebonamor->director->alias;
									
									if ($groupValue >= $bonuses->min_value && $groupValue <= $bonuses->max_value && $value < $bonuses->leader_val && $bonuses->director_alias == $directorAlias)
									{
										
										$persent = $bonuses->leader_persent;
										$amount = $bonuses->leader_val + $bonuses->leader_persent * $this->getVolumeOfWarehouse($users->id, $dateStart, $dateEnd);
										$value = $bonuses->leader_val;
									}
								}
								else
								{
									if ($groupValue >= $bonuses->min_value && $groupValue <= $bonuses->max_value && $value < $bonuses->leader_val && empty($bonuses->director_alias))
									{
										$persent = $bonuses->leader_persent;
										$amount = $bonuses->leader_val + $bonuses->leader_persent * $this->getVolumeOfWarehouse($users->id, $dateStart, $dateEnd);
										$value = $bonuses->leader_val;
									}							
								}
                                
                            }
							if ($persent > (int) FALSE && $amount > (int) FALSE && !$this->addLeaderBonuses($users, $users->profilebonamor->rank->alias, NULL, $persent, $amount))
							{	
								throw new CException('Не удалось обновить лидерский бонус', E_USER_ERROR);
							}
							
							//if($userId == 308){ vg($users->profilebonamor->rank->alias); vg($users->profilebonamor->director__id); /*vg($bonuses);*/ vg($amount); vg($this->getVolumeOfWarehouse($users->id, $dateStart, $dateEnd));}
                        }
                    }
                }
            }
			
        }
        else
        {
            $persent = 0;
            $amount = 0;
			$value = (int) FALSE;	
            $warehouse = WarWarehouse::model()->find('users__id = :users__id', array(':users__id' => $userId));
            if (!empty($warehouse))
            {
                $war_volume = $warehouse;
                $users = Users::model()->findByPk($userId);
                if ($users->profilebonamor->rank->alias != UsersRank::CLIENT && $users->profilebonamor->rank->alias != UsersRank::PARTNER && $users->profilebonamor->rank->alias != UsersRank::SPONSOR)
                {
					/*if(!empty($users->profilebonamor->director))
					{*/
						$leaderBonuses = ProfileLeaderBonuses::model()->findAll('alias = :alias', array(':alias' => $users->profilebonamor->rank->alias));
					//}
                    $groupValue = $this->getGroupValueForWarehouse($users->id, $groupWarehouses);
                    foreach ($leaderBonuses as $bonuses)
                    {	
                        if ($groupValue >= $bonuses->min_value && $groupValue <= $bonuses->max_value && $value < $bonuses->leader_val)
                        {
                            $persent = $bonuses->leader_persent;
                            $amount = $bonuses->leader_val + $bonuses->leader_persent * $this->getVolumeOfWarehouse($userId, $dateStart, $dateEnd);
							$value = $bonuses->leader_val;
                        }
                    }
					if ($persent > (int) FALSE && $amount > (int) FALSE && !$this->addLeaderBonuses($users, $users->profilebonamor->rank->alias, NULL, $persent, $amount))
					{
						throw new CException('Не удалось обновить лидерский бонус', E_USER_ERROR);
					}
                }
            }
        } //die;
		return TRUE;
    }

    public function getVolumeOfWarehouse($userId, $dateStart, $dateEnd)
    {
        if (!$userId)
        {
            throw new CException('Не задан пользователь29', E_USER_ERROR);
        }
		Yii::import('application.modules.admin.modules.warehouse.models.*');
		Yii::import('application.modules.admin.modules.invoice.models.*');
        $statusWarahouse = WarHordersStatus::model()->find('alias = :alias', array(':alias' => self::WAREHOUSE_STATUS_ALIAS));
        $typeWarehouse = WarHordersType::model()->find('alias = :alias', array(':alias' => self::WAREHOUSE_TYPE_ALIAS));
		//$typeWarehouseMoving = WarHordersType::model()->find('alias = :alias', array(':alias' => self::WAREHOUSE_TYPE_ALIAS_MOVING));
       
        $warehouse = WarWarehouse::model()->find('users__id = :users__id', array(':users__id' => $userId));
		
		$criteria = new CDbCriteria();
		$criteria->condition = 'object_id_from = :object_id_from and status__id = :status__id and type__id = :type__id1';
		$criteria->params = array(':object_id_from' => $warehouse->id, ':status__id' => $statusWarahouse->id,':type__id1' => $typeWarehouse->id);
        $warHorders = WarHorders::model()->findAll($criteria);
		
        $sum = 0;
        foreach ($warHorders as $horders)
        {
		
		    if ($horders->created_at >= $dateStart && $horders->created_at <= $dateEnd)
            {
                $sum += $horders->points;
            }
        }
		
        return $sum;
    }

    public function addLeaderBonuses($users, $alias, $director_alias = FALSE, $persent, $amount)
    {
        if (!$users || !$alias)
        { 
            throw new CException('Не задан пользователь30', E_USER_ERROR);
        }
		$userId = $users->id;
        if ($amount > 0 && $persent > 0)
        {
            $transaction = $this->setFinanceTransactionLeaderBonuses(round($amount), $userId);
            $transactionId = $transaction->getModelTransactions()->id;
            $leaderModel = new ProfileLeaderBonuses();
            $leaderModel->users__id = $userId;
            $leaderModel->alias = $persent;
            $leaderModel->director_alias = $director_alias;
            $leaderModel->persents = $persent;
            $leaderModel->amount = round($amount);
			$leaderModel->rank = $users->profilebonamor->rank->lang->name;
			$leaderModel->pv = $this->getGroupValue($users->id);
            $leaderModel->periode_date = app_date("Y.m.1");
            $leaderModel->transactions__id = $transactionId;
            $leaderModel->periode__id = $this->getPeriode()->id;

            if ($leaderModel->validate())
            {
                if (!$leaderModel->save())
                { 
                    throw new CException('Не удалось обновить лидерский бонус', E_USER_ERROR);
                }
                if (!ProfileBonuses::model()->updateReportFinal($leaderModel, self::LEADER_BONUS_ALIAS))
                {
                    throw new CException('Ошибка создания сводной таблицы15', E_USER_ERROR);
                }
            }
			return TRUE;
        }
        else
        {
            return false;
        }
    }

    public function setFinanceTransactionLeaderBonuses($amount, $userId)
    {
        if (empty($userId))
        {
            throw new CException('Не задан пользователь31', E_USER_ERROR);
        }

        $transaction = new FinanceTransaction('system');

        $transaction->initMainCurrency();
        $transaction->setSpecificationByAlias('wallet_out_leader_bonus');

        $transaction->initProperties();
        $transaction->initDebitMainWalletByObjectAndId('users', $userId);
        $transaction->initCreditWalletByObjectAndIdAndPurpose('company', 1, 'bonus_out');

        $transaction->amount = $amount;

        if ($transaction->open())
        {
            return $transaction;
        }
        else
        {
            throw new CException('Финансовая операция для лидерского бонусу не создана', E_USER_ERROR);
        }
    }

//----------------------------------------------Гифт-бонус---------------------------------------------------------------------------------------------

	//расчет Гифт-бонуса
	
    public function setGiftsBonusesValue($userId, $transaction, $aliasIn = FALSE, $aliasOut = FALSE)
    {
        if (empty($userId))
        {
            throw new CException('Не задан пользователь32', E_USER_ERROR);
        }
        if (empty($transaction))
        {
            throw new CException('Не задана транзакция', E_USER_ERROR);
        }

        $giftsBonuses = array();
        $giftsBonusesUser = 0;
        $giftsBonusesDirector = 0;
        $horder = $transaction->objects;
		
        foreach ($horder as $horders)
        {
            if ($horders->alias == 'horders__id')
            {
                $horderModel = $horders;
            }
        }
        $total_gifts = Horders::model()->findByPk($horderModel->value);

        if ($aliasIn != FALSE)
        {
            $giftsPersentModelIn = ProfileGiftsBonusesPersents::model()->find('alias = :alias', array(':alias' => $aliasIn));
            $giftsBonusesUser = $total_gifts->total_gifts;// * $giftsPersentModelIn->gifts_persent / 100;
        }
        if ($aliasOut != FALSE)
        {
            $giftsPersentModelOut = ProfileGiftsBonusesPersents::model()->find('alias = :alias', array(':alias' => $aliasOut));
            $giftsBonusesDirector = ($total_gifts->total_gifts * ($giftsPersentModelIn->director_part / 100))/($giftsPersentModelIn->gifts_persent / 100);
        }

        $giftsBonuses = [
            'user_bonuses' => $giftsBonusesUser,
            'director_bonuses' => $giftsBonusesDirector,
            'user_persents' => $giftsPersentModelIn->gifts_persent,
            'director_persents' => $giftsPersentModelIn->director_part,
        ];
		
        return $giftsBonuses;
    }

//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	// выбор первого вышестоящего директора
	
    public function getUplineDirector($userId)
    {
        if (empty($userId))
        {
            throw new CException('Не задан пользователь33', E_USER_ERROR);
        }
        Yii::import('application.modules.admin.modules.matrix.models.*');
        $tokens = Profile::model()->find('user__id = :users__id', array(':users__id' => $userId));
        $parentId = $tokens->sponsor__id;
		
        while (!empty($parentId))
        {
            $tokensParent = Profile::model()->find('user__id = :users__id', array(':users__id' => $parentId));
            if (!empty($tokensParent))
            {
				
                if (!empty($tokensParent->user->profilebonamor->is_director_completed) && $tokensParent->user->profilebonamor->is_director_completed >= (int)FALSE)
                {
                    return $tokensParent->user__id;
                }
                $parentId = $tokensParent->sponsor__id;
            }
            else
            {
                break;
            }
        }

        return FALSE;
    }

	//выбор вышестоящих не клиентов компании (БО)
	
    public function getUplineParents($userId, $flag = FALSE)
    {
        if (empty($userId))
        {
            throw new CException('Не задан пользователь34', E_USER_ERROR);
        }
        $user = Users::model()->findByPk($userId);
        $parentId = $user->profile->sponsor__id;
        $listParents = array();
        while (!empty($parentId))
        {
            $tokensParent = Profile::model()->find('user__id = :user__id', array(':user__id' => $parentId));
            if (!empty($tokensParent))
            {
                if ($tokensParent->user->profilebonamor->options->alias != self::CLIENT_COMPANY)
                {
                    $listParents [] = $tokensParent->user__id;
                }
                $parentId = $tokensParent->sponsor__id;
            }
            else
            {
                break;
            }
        }

        return $listParents;
    }

	//выбор вышестоящей группы для расчета объема личной группы (ОЛГ)
	
    public function getUplineParentsForVPG($userId)
    {
        if (empty($userId))
        {
            throw new CException('Не задан пользователь35', E_USER_ERROR);
        }
        $user = Users::model()->findByPk($userId);
		$parentRankPosition = $user->profilebonamor->rank->position;
		$parentDirectorPosition = (int)FALSE;
		if(!empty($user->profilebonamor->director))
		{
			$parentDirectorPosition = $user->profilebonamor->director->position;
		}
		
		if($user->profilebonamor->options->alias == UsersOptions::CLIENT_COMPANY)
		{
			$parentId = $user->profile->sponsor__id;
			$listParents = array();
			while (!empty($parentId))
			{
				$tokensParent = Profile::model()->find('user__id = :user__id', array(':user__id' => $parentId));
				
				if (!empty($tokensParent->user->profilebonamor->rank->position))
				{
					if($tokensParent->user->profilebonamor->rank->position > $parentRankPosition)
					{
						$listParents [] = $tokensParent->user__id;
						$parentRankPosition = $tokensParent->user->profilebonamor->rank->position;
					}
					$parentId = $tokensParent->sponsor__id;
				}
				
				else
				{
					break;
				}
			}
			$parentUser = $this->getUplineNotClientCompany($userId);
			if(!empty($listParents) && !empty($parentUser))
			{
				if(!in_array($parentUser, $listParents))
				{
					$listParents[] = $parentUser;
				}
			}
			elseif(!empty($parentUser))
			{
				$listParents[] = $parentUser;
			}
		}
		else
		{
			$parentId = $user->profile->sponsor__id;
			$listParents = array();
			while (!empty($parentId))
			{
				$tokensParent = Profile::model()->find('user__id = :user__id', array(':user__id' => $parentId));
				
				if (!empty($tokensParent->user->profilebonamor->rank->position) && empty($tokensParent->user->profilebonamor->director))
				{
					if($tokensParent->user->profilebonamor->rank->position > $parentRankPosition)
					{
					
						$listParents [] = $tokensParent->user__id;
						$parentRankPosition = $tokensParent->user->profilebonamor->rank->position;
						
					}
					$parentId = $tokensParent->sponsor__id;
				}
				elseif(!empty($tokensParent->user->profilebonamor->rank->position) && !empty($tokensParent->user->profilebonamor->director))
				{
					if($tokensParent->user->profilebonamor->director->position > $parentDirectorPosition)
					{
						$listParents [] = $tokensParent->user__id;
						$parentDirectorPosition = $tokensParent->user->profilebonamor->director->position;
						
					}
					$parentId = $tokensParent->sponsor__id;
				}
				else
				{
					break;
				}
			}
		}
		if($userId == 444444444444440)
		{
			vg($listParents); //die;
		} //die("111111");
        return $listParents;
    }

	//выбор первого вышестоящего не клиента компании (БО)
	
    public function getUplineNotClientCompany($userId)
    {
        if (empty($userId))
        {
            throw new CException('Не задан пользователь36', E_USER_ERROR);
        }
        Yii::import('application.modules.admin.modules.matrix.models.*');
        $tokens = Profile::model()->find('user__id = :user__id', array(':user__id' => $userId));
        $parentId = $tokens->sponsor__id;

        while (!empty($parentId))
        {
            $tokensParent = Profile::model()->find('user__id = :user__id', array(':user__id' => $parentId));
            if (!empty($tokensParent))
            {
                if ($tokensParent->user->profilebonamor->options->alias != self::CLIENT_COMPANY)
                {
                    return $tokensParent->user__id;
                }
                $parentId = $tokensParent->sponsor__id;
            }
            else
            {
                break;
            }
        }

        return FALSE;
    }
	
	//выбор первого вышестоящего партнера компании (БО)
	
	public function getUplinePartnerCompany($userId)
    {
        if (empty($userId))
        {
            throw new CException('Не задан пользователь37', E_USER_ERROR);
        }
        Yii::import('application.modules.admin.modules.matrix.models.*');
        $tokens = Profile::model()->find('user__id = :user__id', array(':user__id' => $userId));
        $parentId = $tokens->sponsor__id;

        while (!empty($parentId))
        {
            $tokensParent = Profile::model()->find('user__id = :user__id', array(':user__id' => $parentId));
            if (!empty($tokensParent))
            {
                if ($tokensParent->user->profilebonamor->options->alias == self::PARTNER_COMPANY)
                {
                    return $tokensParent->user__id;
                }
                $parentId = $tokensParent->sponsor__id;
            }
            else
            {
                break;
            }
        }

        return 0;
    }
	
	//выбор первого вышестоящего с большей бизнес-опцией
	
	public function getUplineElderOptions($userId)
    {
        if (empty($userId))
        {
            throw new CException('Не задан пользователь38', E_USER_ERROR);
        }
        Yii::import('application.modules.admin.modules.matrix.models.*');
        $tokens = Profile::model()->find('user__id = :user__id', array(':user__id' => $userId));
        $parentId = $tokens->sponsor__id;

        while (!empty($parentId))
        {
            $tokensParent = Profile::model()->find('user__id = :user__id', array(':user__id' => $parentId));
            if (!empty($tokensParent))
            {
                if ($tokensParent->user->profilebonamor->options->position > $tokens->user->profilebonamor->options->position)
                {
                    return $tokensParent->user__id;
                }
                $parentId = $tokensParent->sponsor__id;
            }
            else
            {
                break;
            }
        }

        return 0;
    }

    //--------------------------------------------------Автомобильный бонус------------------------------------------------------------------------------

	//выбор группы для автомобильного и директорского бонуса
	
    public function getGroupForAutoHouseBonus()
    {
        $user = Users::model()->findAll();
        $listUsers = array();
        foreach ($user as $value)
        {
            if ($value->username != 'superadmin')
            {
                if ($value->profilebonamor->options->alias == UsersOptions::PARTNER_COMPANY)
                {
                    if ($value->profilebonamor->rank->alias == UsersRank::SPONSOR || $value->profilebonamor->rank->alias == UsersRank::MANAGER)
                    {
                        $listUsers[] = $value->id;
                    }
                    if ($value->profilebonamor->rank->alias == UsersRank::DIRECTOR)
                    {
                        if ($value->profilebonamor->director->alias == UsersDirectorRank::SILVER_DIRECTOR || $value->profilebonamor->director->alias == UsersDirectorRank::PEARL_DIRECTOR || $value->profilebonamor->director->alias == UsersDirectorRank::GOLD_DIRECTOR || $value->profilebonamor->director->alias == UsersDirectorRank::RUBIN_DIRECTOR)
                        {
                            $listUsers[] = $value->id;
                        }
                    }
                }
            }
        }

        return $listUsers;
    }

	//сумма всех заказов по пользователю за период 
	
    public function getSumPersonalHordersPerPeriode($userId)
    {
		Yii::import('application.modules.store.models.*');
        if (empty($userId))
        {
            throw new CException('Не задан пользователь39', E_USER_ERROR);
        }
        $sumHorders = 0;
        $dateStart = $this->getPeriode()->date_begin;
        $dateEnd = $this->getPeriode()->date_end;
        $horderModel = Horders::model()->findAll('users__id = :users__id and closed_at >= :dateBegin and closed_at <= :dateEnd and register IS NULL', array(':users__id' => $userId, ':dateBegin' => $dateStart, ':dateEnd' => $dateEnd));

        if (!empty($horderModel))
        {
            foreach ($horderModel as $horder)
            {
                $sumHorders += $horder->total_price;
            }
        }
        return $sumHorders;
    }

	//расчет автомобильного бонуса
	
    public function setAutoBonusValue($userId = FALSE)
    {
		$autoForRank = 0;
		$silverDirector = UsersDirectorRank::model()->find('alias = :alias', array(':alias' => UsersDirectorRank::SILVER_DIRECTOR));
        if ($userId === FALSE)
        {
            $user = Users::model()->findAll();
            foreach ($user as $users)
            {	
				$autoForRank = (int)FALSE;
				$autoAll = (int)FALSE;
				$persentAll = (int)FALSE;
				$autoForRank = (int)FALSE;
				$autoPersentCurentUserModel = (int)FALSE;
				$autoPersentDirectorUserModel = (int)FALSE;
				$userId = $users->id;
                if ($users->username != 'superadmin')
                {
                    if (!empty($users->profilebonamor) && $users->profilebonamor->options->alias == UsersOptions::PARTNER_COMPANY)
                    {
                       $autoPersentAllUserModel = ProfileAutoHouseBonusesPersents::model()->find('alias = :alias', array(':alias' => self::ALL_USER_ALIAS));
						$autoPersentOnlyDirectorUserModel = ProfileAutoHouseBonusesPersents::model()->find('alias = :alias', array(':alias' => self::ONLY_DIRECTOR_USER_ALIAS));
						
						$rankHistory = ProfileRankHistory::model()->find('users__id = :users__id and periode__id = :periode__id', array(':users__id' => $users->id, ':periode__id' => $this->getPeriode()->id));
						
						if($rankHistory instanceof ProfileRankHistory && $rankHistory->is_riese == (int)TRUE)
						{
						
							$autoPersentCurentUserModel = ProfileAutoHouseBonusesPersents::model()->find('alias = :alias', array(':alias' => $users->profilebonamor->rank->alias));
						}
						
						if ($users->profilebonamor->director instanceof UsersDirectorRank && $rankHistory instanceof ProfileRankHistory && $rankHistory->is_riese == (int)TRUE)
                        {
						
                            $autoPersentDirectorUserModel = ProfileAutoHouseBonusesPersents::model()->find('alias = :alias', array(':alias' => $users->profilebonamor->director->alias));
                        }
                        $amountAllFrom = $this->getSumPersonalHordersPerPeriode($users->id);
                        $persentAll = $autoPersentAllUserModel->auto_value;
                        $autoAll = $amountAllFrom * $persentAll / 100;
                        if ($autoPersentCurentUserModel instanceof ProfileAutoHouseBonusesPersents)
                        {
                            $autoForRank = $autoPersentCurentUserModel->auto_value;
                        }
						 if ($autoPersentDirectorUserModel instanceof ProfileAutoHouseBonusesPersents)
						{
							$autoForRank = $autoPersentDirectorUserModel->auto_value;
						}
						
						if (!$this->addAutoBonusValue($users, $autoAll, $amountAllFrom, $persentAll, $autoForRank))
						{
							throw new CException('Ошибка начисления автомобильного бонуса', E_USER_ERROR);
						}
						
                    }
                }
            }
        }
        else
        {
            $users = Users::model()->findByPk($userId);
            if (!empty($users->profilebonamor) && $users->profilebonamor->options->alias == UsersOptions::PARTNER_COMPANY)
            {
                $autoPersentAllUserModel = ProfileAutoHouseBonusesPersents::model()->find('alias = :alias', array(':alias' => self::ALL_USER_ALIAS));
                $autoPersentOnlyDirectorUserModel = ProfileAutoHouseBonusesPersents::model()->find('alias = :alias', array(':alias' => self::ONLY_DIRECTOR_USER_ALIAS));
                $autoPersentCurentUserModel = ProfileAutoHouseBonusesPersents::model()->find('alias = :alias', array(':alias' => $users->profilebonamor->rank->alias));
                if (!empty($users->profilebonamor->director__id))
                {
                    $autoPersentDirectorUserModel = ProfileAutoHouseBonusesPersents::model()->find('alias = :alias', array(':alias' => $users->profilebonamor->director->alias));
                }
                $amountAllFrom = $this->getSumPersonalHordersPerPeriode($users->id);
                $persentAll = $autoPersentAllUserModel->auto_value;
                $autoAll = $amountAllFrom * $persentAll / 100;
                if (!empty($autoPersentCurentUserModel))
                {
                    $autoForRank = $autoPersentCurentUserModel->auto_value;
                    if (!empty($autoPersentDirectorUserModel))
                    {
                        $autoForRank = $autoPersentDirectorUserModel->auto_value;
                    }
                }
                
				if (!$this->addAutoBonusValue($users, $autoAll, $amountAllFrom, $persentAll, $autoForRank))
				{
					throw new CException('Ошибка начисления автомобильного бонуса', E_USER_ERROR);
				}
			
            }
        }
       // die("0000000000");
		return TRUE;
    }
	
	public function setAutoBonusForDirectors()
	{	
		$autoPersentOnlyDirectorUserModel = ProfileAutoHouseBonusesPersents::model()->find('alias = :alias', array(':alias' => self::ONLY_DIRECTOR_USER_ALIAS));
		$users = Users::model()->findAll('username != :username', array(':username' => 'superadmin'));
		$cntOfDirectors = (int)FALSE;
		$silverDirector = UsersDirectorRank::model()->find('alias = :alias', array(':alias' => UsersDirectorRank::SILVER_DIRECTOR));
		
		foreach($users as $user)
		{
			$sumOfAllBonuses = $this->getSumOfAllBonusesForUser($user->id);
			
			if ($sumOfAllBonuses >= $autoPersentOnlyDirectorUserModel->auto_value)
			{
				if (!empty($user->profilebonamor->director__id) && $user->profilebonamor->is_director_completed > $silverDirector->position)
				{
					$cntOfDirectors ++;
				}
			}
		}
		 if ($cntOfDirectors > (int)FALSE)
        {
            $valueOfCompany = $this->getGroupValueOfCompany();
            $amountAutoForDirectors = $valueOfCompany * self::PERSENT_OF_AUTO_BONUS / ($cntOfDirectors*100);
			$amountHouseForDirectors = $valueOfCompany * self::PERSENT_OF_HOUSE_BONUS / ($cntOfDirectors*100);
			
							
			
            if (!$this->addAutoBonusForDirector($amountAutoForDirectors))
            {
                throw new CException('Ошибка начисления автомобильного бонуса1', E_USER_ERROR);
            }
			if (!$this->addHouseBonusForDirector($amountHouseForDirectors))
            {
                throw new CException('Ошибка начисления автомобильного бонуса1', E_USER_ERROR);
            }
        } //die;
		return TRUE;
	}

	//создание автомобильного бонуса
	
    public function addAutoBonusValue($users, $autoAll, $amountAllFrom, $persentAll, $autoForRank = FALSE)
    {
        if (empty($users))
        {
            throw new CException('Не задан пользователь40', E_USER_ERROR);
        }
		
		$userId = $users->id;
        if (!empty($autoAll) && !empty($persentAll))
        {
			$sumOfAllBonuses = $this->getSumOfAllBonusesForUser($userId);
            $transaction = $this->setFinanceTransactionAutoBonuses($userId, round($autoAll));
            $transactionModel = $transaction->getModelTransactions();
			$transactionId = $transactionModel->id;
			
            $autoBonusModel = new ProfileAutoBonuses();
            $autoBonusModel->users__id = $users->id;
            $autoBonusModel->amount = round($autoAll);
            $autoBonusModel->amount_from = $sumOfAllBonuses;
            $autoBonusModel->persents = $persentAll;
            $autoBonusModel->periode_date = app_date("Y.m.d");
			if(!empty($users->profilebonamor->director))
			{
				$autoBonusModel->rank = $users->profilebonamor->director->lang->name;
			}
			else
			{
				$autoBonusModel->rank = $users->profilebonamor->rank->lang->name;
			}
            $autoBonusModel->transactions__id = $transactionId;
            $autoBonusModel->periode__id = $this->getPeriode()->id;

					
            if ($autoBonusModel->validate())
            {
                if (!$autoBonusModel->save())
                {
                    throw new CException('Ошибка сохраниния данных для начисления автомобилного бонуса', E_USER_ERROR);
                }
                if (!ProfileBonuses::model()->updateReportFinal($autoBonusModel, self::AUTO_BONUS_ALIAS))
                {
                    throw new CException('Ошибка создания сводной таблицы16', E_USER_ERROR);
                }
            }
        }
        if ($autoForRank != FALSE)
        {
            $transaction = $this->setFinanceTransactionAutoBonuses($userId, round($autoForRank));
            $transactionId = $transaction->getModelTransactions()->id;
            $autoBonusRankModel = new ProfileAutoBonuses();
            $autoBonusRankModel->users__id = $userId;
            $autoBonusRankModel->amount = round((int)$autoForRank);
			if(!empty($users->profilebonamor->director))
			{
				$autoBonusRankModel->rank = $users->profilebonamor->director->lang->name;
			}
			else
			{
				$autoBonusRankModel->rank = $users->profilebonamor->rank->lang->name;
			}
            $autoBonusRankModel->periode_date = app_date("Y.m.d");
            $autoBonusRankModel->transactions__id = $transactionId;
            $autoBonusRankModel->periode__id = $this->getPeriode()->id;

					
            if ($autoBonusRankModel->validate())
            {
                if (!$autoBonusRankModel->save())
                {
                    throw new CException('Ошибка сохраниния данных для начисления автомобилного бонуса', E_USER_ERROR);
                }
                if (!ProfileBonuses::model()->updateReportFinal($autoBonusRankModel, self::AUTO_BONUS_ALIAS))
                {
                    throw new CException('Ошибка создания сводной таблицы17', E_USER_ERROR);
                }
            }
        }
        return TRUE;
    }
	
	//создание автомобильного бонуса для директора

    public function addAutoBonusForDirector($amountAutoForDirectors)
    {
        if (empty($amountAutoForDirectors))
        {
            throw new CException('Не задана сумма для автомобильного бонуса', E_USER_ERROR);
        }
		$silverDirector = UsersDirectorRank::model()->find('alias = :alias', array(':alias' => UsersDirectorRank::SILVER_DIRECTOR));
		
        $user = Users::model()->findAll();
        $listUsers = array();
        foreach ($user as $value)
        {
            if ($value->username != 'superadmin')
            {
                if (!empty($value->profilebonamor->director__id) && $value->profilebonamor->is_director_completed > $silverDirector->position)
                {
					$sumOfAllBonuses = $this->getSumOfAllBonusesForUser($value->id);
                    $transaction = $this->setFinanceTransactionAutoBonuses($value->id, round($amountAutoForDirectors));
                    $transactionId = $transaction->getModelTransactions()->id;
                    $autoBonus = new ProfileAutoBonuses();
                    $autoBonus->amount = round($amountAutoForDirectors);
					$autoBonus->amount_from = $sumOfAllBonuses;
					$autoBonus->users__id = $value->id;
					$autoBonus->rank = $value->profilebonamor->director->lang->name;
                    $autoBonus->periode_date = date("Y.m.d");
                    $autoBonus->transactions__id = $transactionId;
                    $autoBonus->periode__id = $this->getPeriode()->id;

                    if ($autoBonus->validate())
                    {
                        if (!$autoBonus->save())
                        {
                            return FALSE;
                        }
                        if (!ProfileBonuses::model()->updateReportFinal($autoBonus, self::AUTO_BONUS_ALIAS))
                        {
                            throw new CException('Ошибка создания сводной таблицы18', E_USER_ERROR);
                        }
                    }
                }
            }
        }
		return TRUE;
    }

	//создание финтранзакции для автомобильного бонуса
	
    public function setFinanceTransactionAutoBonuses($userId, $amount)
    {
        if (empty($userId) || empty($amount))
        {
            throw new CException('Не заданы данные для создания финансовой операции', E_USER_ERROR);
        }

        if (!$this->getUserRoleAuto($userId))
        {
            $transaction = new FinanceTransaction('system');

            $transaction->initMainCurrency();
            $transaction->setSpecificationByAlias('wallet_out_auto_bonus');

            $transaction->initProperties();
            $transaction->initDebitWalletByObjectAndIdAndPurpose('users', $userId, 'auto_bonus');
            $transaction->initCreditWalletByObjectAndIdAndPurpose('company', 1, 'bonus_out');

            $transaction->amount = $amount;
			
			$transaction->modelsTransactionsObjects['redirect_confirm_after_paymentsystem']->value = '/office/default/payresult';
			$transaction->modelsTransactionsObjects['redirect_decline_after_paymentsystem']->value = '/office/default/payresult';
			$transaction->modelsTransactionsObjects['redirect_open_after_paymentsystem']->value = '/paymentsystem/yandexmoney/pay/index';
			$transaction->modelsTransactionsObjects['comments_money_out']->value = ' ';

			$transaction->objectsAttributes = array(
				'redirect_confirm_after_paymentsystem' => array('alias' => 'redirect_confirm_after_paymentsystem', 'value' => '/office/default/payresult'),
				'redirect_decline_after_paymentsystem' => array('alias' => 'redirect_decline_after_paymentsystem', 'value' => '/office/default/payresult'),
				'redirect_open_after_paymentsystem' => array('alias' => 'redirect_open_after_paymentsystem', 'value' => '/paymentsystem/yandexmoney/pay/index'),
				'comments_money_out' => array('alias' => 'comments_money_out', 'value' => '')
        );

            if ($transaction->open())
            {
                return $transaction;
            }
            else
            {
                throw new CException('Ошибка создания финансовой операции', E_USER_ERROR);
            }
        }
        else
        {
            $transaction = new FinanceTransaction('system');

            $transaction->initMainCurrency();
            $transaction->setSpecificationByAlias('wallet_out_auto_is_bonus');

            $transaction->initProperties();
            $transaction->initDebitMainWalletByObjectAndId('users', $userId);
            $transaction->initCreditWalletByObjectAndIdAndPurpose('company', 1, 'bonus_out');

            $transaction->amount = $amount;
			
			$transaction->modelsTransactionsObjects['redirect_confirm_after_paymentsystem']->value = '/office/default/payresult';
			$transaction->modelsTransactionsObjects['redirect_decline_after_paymentsystem']->value = '/office/default/payresult';
			$transaction->modelsTransactionsObjects['redirect_open_after_paymentsystem']->value = '/paymentsystem/yandexmoney/pay/index';
			$transaction->modelsTransactionsObjects['comments_money_out']->value = ' ';

			$transaction->objectsAttributes = array(
				'redirect_confirm_after_paymentsystem' => array('alias' => 'redirect_confirm_after_paymentsystem', 'value' => '/office/default/payresult'),
				'redirect_decline_after_paymentsystem' => array('alias' => 'redirect_decline_after_paymentsystem', 'value' => '/office/default/payresult'),
				'redirect_open_after_paymentsystem' => array('alias' => 'redirect_open_after_paymentsystem', 'value' => '/paymentsystem/yandexmoney/pay/index'),
				'comments_money_out' => array('alias' => 'comments_money_out', 'value' => '')
        );
            if ($transaction->open())
            {
                return $transaction;
            }
            else
            {
                throw new CException('Ошибка создания финансовой операции', E_USER_ERROR);
            }
        }
        return true;
    }

	//считаем групповой объем компании
	
    public function getGroupValueOfCompany()
    {
		Yii::import('application.modules.store.models.*');
        $user = Users::model()->findAll();
        $groupValueOfCompany = 0;
        $groupValueOfCompanyUsers = 0;
        $dateStart = $this->getPeriode()->date_begin;
        $dateEnd = $this->getPeriode()->date_end;
		$horders = Horders::model()->findAll('closed_at >= :date_start and closed_at <= :date_end and register IS NULL', array(':date_start' => $dateStart, ':date_end' => $dateEnd));
        foreach ($horders as $horder)
        {
            $groupValueOfCompanyUsers += $horder->total_points;
        }
        //$groupValueOfCompany = $groupValueOfCompanyUsers * self::PERSENT_OF_AUTO_BONUS / 100;

        return $groupValueOfCompanyUsers;
    }

	//считаем сумму всех бонусов для пользователя
	
    public function getSumOfAllBonusesForUser($userId, $periodeId = FALSE)
    {
        if (empty($userId))
        {
            throw new CException('Не задан пользователь41', E_USER_ERROR);
        }
		if($periodeId == FALSE)
		{
			$periode = $this->getPeriode()->id;
		}
		else
		{
			$periode = $periodeId;
		}
        
        $instantBonus = ProfileInstantBonuses::model()->findAll('users__id = :users__id and periode__id = :periode', array(':users__id' => $userId, ':periode' => $periode));
        $instantBonusValue = 0;
        foreach ($instantBonus as $instant)
        {
            $instantBonusValue += $instant->amount;
        }

        $linearBonus = ProfileLinearBonuses::model()->findAll('users__id = :users__id and periode__id = :periode', array(':users__id' => $userId, ':periode' => $periode));
        $linearBonusValue = 0;
        foreach ($linearBonus as $linear)
        {
            $linearBonusValue += $linear->amount;
        }

        $stairBonus = ProfileStairBonuses::model()->findAll('users__id = :users__id and periode__id = :periode', array(':users__id' => $userId, ':periode' => $periode));
        $stairBonusValue = 0;
        foreach ($stairBonus as $stair)
        {
            $stairBonusValue += $stair->amount;
        }

        $directorBonus = ProfileDirectorBonuses::model()->findAll('users__id = :users__id and periode__id = :periode', array(':users__id' => $userId, ':periode' => $periode));
        $directorBonusValue = 0;
        foreach ($directorBonus as $director)
        {
            $directorBonusValue += $director->amount;
        }

        $infinityBonus = ProfileDirectorInfinityBonuses::model()->findAll('users__id = :users__id and periode__id = :periode', array(':users__id' => $userId, ':periode' => $periode));
        $infinityBonusValue = 0;
        foreach ($infinityBonus as $infinity)
        {
            $infinityBonusValue += $infinity->amount;
        }

        $leaderBonus = ProfileLeaderBonuses::model()->findAll('users__id = :users__id and periode__id = :periode', array(':users__id' => $userId, ':periode' => $periode));
        $leaderBonusValue = 0;
        foreach ($leaderBonus as $leader)
        {
            $leaderBonusValue += $leader->amount;
        }
		
		$houseBonus = ProfileHouseBonuses::model()->findAll('users__id = :users__id and periode__id = :periode', array(':users__id' => $userId, ':periode' => $periode));
        $houseBonusValue = 0;
        foreach ($houseBonus as $house)
        {
            $houseBonusValue += $house->amount;
        }
		
		$autoBonus = ProfileAutoBonuses::model()->findAll('users__id = :users__id and periode__id = :periode', array(':users__id' => $userId, ':periode' => $periode));
        $autoBonusValue = 0;
        foreach ($autoBonus as $auto)
        {
            $autoBonusValue += $auto->amount;
        }

        return $instantBonusValue + $linearBonusValue *100+ $stairBonusValue*100 + $directorBonusValue *100+ $infinityBonusValue*100 + $leaderBonusValue+$autoBonusValue+$houseBonusValue;
    }

	public function getSumOfAllBonusesForUserAllTime($userId)
    {
        if (empty($userId))
        {
            throw new CException('Не задан пользователь41', E_USER_ERROR);
        }
		
        $instantBonus = ProfileInstantBonuses::model()->findAll('users__id = :users__id', array(':users__id' => $userId));
        $instantBonusValue = 0;
        foreach ($instantBonus as $instant)
        {
            $instantBonusValue += $instant->amount;
        }

        $linearBonus = ProfileLinearBonuses::model()->findAll('users__id = :users__id', array(':users__id' => $userId));
        $linearBonusValue = 0;
        foreach ($linearBonus as $linear)
        {
            $linearBonusValue += $linear->amount;
        }

        $stairBonus = ProfileStairBonuses::model()->findAll('users__id = :users__id', array(':users__id' => $userId));
        $stairBonusValue = 0;
        foreach ($stairBonus as $stair)
        {
            $stairBonusValue += $stair->amount;
        }

        $directorBonus = ProfileDirectorBonuses::model()->findAll('users__id = :users__id', array(':users__id' => $userId));
        $directorBonusValue = 0;
        foreach ($directorBonus as $director)
        {
            $directorBonusValue += $director->amount;
        }

        $infinityBonus = ProfileDirectorInfinityBonuses::model()->findAll('users__id = :users__id', array(':users__id' => $userId));
        $infinityBonusValue = 0;
        foreach ($infinityBonus as $infinity)
        {
            $infinityBonusValue += $infinity->amount;
        }

        $leaderBonus = ProfileLeaderBonuses::model()->findAll('users__id = :users__id', array(':users__id' => $userId));
        $leaderBonusValue = 0;
        foreach ($leaderBonus as $leader)
        {
            $leaderBonusValue += $leader->amount;
        }
		
		$houseBonus = ProfileHouseBonuses::model()->findAll('users__id = :users__id', array(':users__id' => $userId));
        $houseBonusValue = 0;
        foreach ($houseBonus as $house)
        {
            $houseBonusValue += $house->amount;
        }
		
		$autoBonus = ProfileAutoBonuses::model()->findAll('users__id = :users__id', array(':users__id' => $userId));
        $autoBonusValue = 0;
        foreach ($autoBonus as $auto)
        {
            $autoBonusValue += $auto->amount;
        }

        return $instantBonusValue + $linearBonusValue *100+ $stairBonusValue*100 + $directorBonusValue *100+ $infinityBonusValue*100 + $leaderBonusValue+$autoBonusValue+$houseBonusValue;
    }
	
    //---------------------------------------Жилищный бонус----------------------------------------------------------------------------------------------

	//расчет жилищного бонуса (стартует при закрытие периода/расчет бонусов из админки)
	
    public function setHouseBonusValue($userId = FALSE)
    {
		$houseForRank = 0;
		$houseAll = 0;
		$amountAllFrom = 0;
		$persentAll = 0;
		$silverDirector = UsersDirectorRank::model()->find('alias = :alias', array(':alias' => UsersDirectorRank::SILVER_DIRECTOR));
        if ($userId === FALSE)
        {
            $user = Users::model()->findAll();
            foreach ($user as $users)
            {
				$userId= $users->id;
				$houseForRank = (int)FALSE;
				$houseAll = (int)FALSE;
				$persentAll = (int)FALSE;
				$housePersentCurentUserModel = (int)FALSE;
				$housePersentDirectorUserModel = (int)FALSE;
                if ($users->username != 'superadmin')
                {
                    if (!empty($users->profilebonamor) && $users->profilebonamor->options->alias == UsersOptions::PARTNER_COMPANY)
                    {
                       $housePersentAllUserModel = ProfileAutoHouseBonusesPersents::model()->find('alias = :alias', array(':alias' => self::ALL_USER_ALIAS));
						$housePersentOnlyDirectorUserModel = ProfileAutoHouseBonusesPersents::model()->find('alias = :alias', array(':alias' => self::ONLY_DIRECTOR_USER_ALIAS));
						//$housePersentCurentUserModel = ProfileAutoHouseBonusesPersents::model()->find('alias = :alias', array(':alias' => $users->profilebonamor->rank->alias));
						$rankHistory = ProfileRankHistory::model()->find('users__id = :users__id and periode__id = :periode__id', array(':users__id' => $users->id, ':periode__id' => $this->getPeriode()->id));
                        if ($rankHistory instanceof ProfileRankHistory && $rankHistory->is_riese == (int)TRUE)
                        {
                            $housePersentCurentUserModel = ProfileAutoHouseBonusesPersents::model()->find('alias = :alias', array(':alias' => $users->profilebonamor->rank->alias));
                        }
						if ($users->profilebonamor->director instanceof UsersDirectorRank && $rankHistory instanceof ProfileRankHistory && $rankHistory->is_riese == (int)TRUE)
                        {
                            $housePersentDirectorUserModel = ProfileAutoHouseBonusesPersents::model()->find('alias = :alias', array(':alias' => $users->profilebonamor->director->alias));
                        }
                        $amountAllFrom = $this->getSumPersonalHordersPerPeriode($users->id);
                        $persentAll = $housePersentAllUserModel->house_value;
                        $houseAll = $amountAllFrom * $persentAll / 100;
                        if ($housePersentCurentUserModel instanceof ProfileAutoHouseBonusesPersents)
                        {
                            $houseForRank = $housePersentCurentUserModel->house_value;
                        }
						 if ($housePersentDirectorUserModel instanceof ProfileAutoHouseBonusesPersents)
						{
							$houseForRank = $housePersentDirectorUserModel->house_value;
						}
                        
						
						if (!$this->addHouseBonusValue($users, $houseAll, $amountAllFrom, $persentAll, $houseForRank))
						{
							throw new CException('Ошибка начисления жилищного бонуса', E_USER_ERROR);
						}
                    }
                }
            }
        }
        else
        {
            $users = Users::model()->findByPk($userId);
            if (!empty($users->profilebonamor) && $users->profilebonamor->options->alias == UsersOptions::PARTNER_COMPANY)
            {
                $housePersentAllUserModel = ProfileAutoHouseBonusesPersents::model()->find('alias = :alias', array(':alias' => self::ALL_USER_ALIAS));
                $housePersentOnlyDirectorUserModel = ProfileAutoHouseBonusesPersents::model()->find('alias = :alias', array(':alias' => self::ONLY_DIRECTOR_USER_ALIAS));
                $housePersentCurentUserModel = ProfileAutoHouseBonusesPersents::model()->find('alias = :alias', array(':alias' => $users->profilebonamor->rank->alias));
                if (!empty($users->profilebonamor->director__id))
                {
                    $housePersentDirectorUserModel = ProfileAutoHouseBonusesPersents::model()->find('alias = :alias', array(':alias' => $users->profilebonamor->director->alias));
                }
                $amountAllFrom = $this->getSumPersonalHordersPerPeriode($users->id);
                $persentAll = $housePersentAllUserModel->auto_value;
                $houseAll = $amountAllFrom * $persentAll / 100;
                if (!empty($housePersentCurentUserModel))
                {
                    $houseForRank = $housePersentCurentUserModel->house_value;
                    if (!empty($autoPersentDirectorUserModel))
                    {
                        $houseForRank = $housePersentDirectorUserModel->house_value;
                    }
                }
                
				if(!empty($houseAll) && !empty($amountAllFrom) && !empty($persentAll) && !empty($houseForRank))
				{
					if (!$this->addHouseBonusValue($users, $houseAll, $amountAllFrom, $persentAll, $houseForRank))
					{
						throw new CException('Ошибка начисления жилищного бонуса', E_USER_ERROR);
					}
				}
            }
        }
        //die;
		return TRUE;
    }

	//создание жилищного бонуса
	
    public function addHouseBonusValue($users, $houseAll, $amountAllFrom, $persentAll, $houseForRank = FALSE)
    {
        if (empty($users))
        {
            throw new CException('Не задан пользователь42', E_USER_ERROR);
        }
       
		$userId = $users->id;
        if (!empty($houseAll) && !empty($persentAll))
        {
			$sumOfAllBonuses = $this->getSumOfAllBonusesForUser($userId);
            $transaction = $this->setFinanceTransactionHouseBonuses($userId, round($houseAll));
            $transactionId = $transaction->getModelTransactions()->id;
            $houseBonusModel = new ProfileHouseBonuses();
            $houseBonusModel->users__id = $userId;
            $houseBonusModel->amount = round($houseAll);
            $houseBonusModel->amount_from = $sumOfAllBonuses;
            $houseBonusModel->persents = $persentAll;
			if(!empty($users->profilebonamor->director))
			{
				$houseBonusModel->rank = $users->profilebonamor->director->lang->name;
			}
			else
			{
				$houseBonusModel->rank = $users->profilebonamor->rank->lang->name;
			}
            $houseBonusModel->periode_date = app_date("Y.m.d");
            $houseBonusModel->transactions__id = $transactionId;
            $houseBonusModel->periode__id = $this->getPeriode()->id;

			/*if($users->id == 356 || $users->id == 357)
			{
				vg($houseBonusModel);
			}*/
			
			
            if ($houseBonusModel->validate())
            {
                if (!$houseBonusModel->save())
                {
                    throw new CException('Ошибка сохраниния данных для начисления жилищного бонуса', E_USER_ERROR);
                }
                if (!ProfileBonuses::model()->updateReportFinal($houseBonusModel, self::HOUSE_BONUS_ALIAS))
                {
                    throw new CException('Ошибка создания сводной таблицы19', E_USER_ERROR);
                }
            }
        }
        if ($houseForRank != FALSE)
        {
            $transaction = $this->setFinanceTransactionHouseBonuses($userId, round($houseForRank));
            $transactionId = $transaction->getModelTransactions()->id;
            $houseBonusRankModel = new ProfileHouseBonuses();
            $houseBonusRankModel->users__id = $userId;
            $houseBonusRankModel->amount = round($houseForRank);
			if(!empty($users->profilebonamor->director))
			{
				$houseBonusRankModel->rank = $users->profilebonamor->director->lang->name;
			}
			else
			{
				$houseBonusRankModel->rank = $users->profilebonamor->rank->lang->name;
			}
            $houseBonusRankModel->periode_date = app_date("Y.m.d");
            $houseBonusRankModel->transactions__id = $transactionId;
            $houseBonusRankModel->periode__id = $this->getPeriode()->id;

			/*if($users->id == 356 || $users->id == 357)
			{
				vg($houseBonusRankModel);
			}*/
			
			
            if ($houseBonusRankModel->validate())
            {
                if (!$houseBonusRankModel->save())
                {
                    throw new CException('Ошибка сохраниния данных для начисления жилищного бонуса', E_USER_ERROR);
                }
                if (!ProfileBonuses::model()->updateReportFinal($houseBonusRankModel, self::HOUSE_BONUS_ALIAS))
                {
                    throw new CException('Ошибка создания сводной таблицы20', E_USER_ERROR);
                }
            }
        }
        return TRUE;
    }
 
	//создание жилищного бонуса для директора
	
    public function addHouseBonusForDirector($amountHouseForDirectors)
    {
        if (empty($amountHouseForDirectors))
        {
            throw new CException('Не задана сумма для жилищного бонуса', E_USER_ERROR);
        }
		$silverDirector = UsersDirectorRank::model()->find('alias = :alias', array(':alias' => UsersDirectorRank::SILVER_DIRECTOR));
        $user = Users::model()->findAll();
        $listUsers = array();
        foreach ($user as $value)
        {
            if ($value->username != 'superadmin')
            {
                if (!empty($value->profilebonamor->director__id) && $value->profilebonamor->is_director_completed > $silverDirector->position)
                {	$sumOfAllBonuses = $this->getSumOfAllBonusesForUser($value->id);
                    $transaction = $this->setFinanceTransactionHouseBonuses($value->id, round($amountHouseForDirectors));
                    $transactionId = $transaction->getModelTransactions()->id;
					
                    $houseBonus = new ProfileHouseBonuses();
                    $houseBonus->amount = round($amountHouseForDirectors);
                    $houseBonus->users__id = $value->id;
					$houseBonus->amount_from = $sumOfAllBonuses;
					$houseBonus->rank = $value->profilebonamor->director->lang->name;
                    $houseBonus->periode_date = app_date("Y.m.d");
                    $houseBonus->transactions__id = $transactionId;
                    $houseBonus->periode__id = $this->getPeriode()->id;

                    if ($houseBonus->validate())
                    {
                        if (!$houseBonus->save())
                        {
                            return FALSE;
                        }
                        if (!ProfileBonuses::model()->updateReportFinal($houseBonus, self::HOUSE_BONUS_ALIAS))
                        {
                            throw new CException('Ошибка создания сводной таблицы21', E_USER_ERROR);
                        }
                    }
                }
            }
        } return TRUE;
    }

	//старт финтранзакции для жилищного бонуса
	
    public function setFinanceTransactionHouseBonuses($userId, $amount)
    {
        if (empty($userId) || empty($amount))
        {
            throw new CException('Не заданы данные для создания финансовой операции1', E_USER_ERROR);
        }

        if (!$this->getUserRoleHouse($userId))
        {
            $transaction = new FinanceTransaction('system');

            $transaction->initMainCurrency();
            $transaction->setSpecificationByAlias('wallet_out_house_bonus');

            $transaction->initProperties();
            $transaction->initDebitWalletByObjectAndIdAndPurpose('users', $userId, 'house_bonus');
            $transaction->initCreditWalletByObjectAndIdAndPurpose('company', 1, 'bonus_out');

            $transaction->amount = $amount;
			
			$transaction->modelsTransactionsObjects['redirect_confirm_after_paymentsystem']->value = '/office/default/payresult';
			$transaction->modelsTransactionsObjects['redirect_decline_after_paymentsystem']->value = '/office/default/payresult';
			$transaction->modelsTransactionsObjects['redirect_open_after_paymentsystem']->value = '/paymentsystem/yandexmoney/pay/index';
			$transaction->modelsTransactionsObjects['comments_money_out']->value = ' ';

			$transaction->objectsAttributes = array(
				'redirect_confirm_after_paymentsystem' => array('alias' => 'redirect_confirm_after_paymentsystem', 'value' => '/office/default/payresult'),
				'redirect_decline_after_paymentsystem' => array('alias' => 'redirect_decline_after_paymentsystem', 'value' => '/office/default/payresult'),
				'redirect_open_after_paymentsystem' => array('alias' => 'redirect_open_after_paymentsystem', 'value' => '/paymentsystem/yandexmoney/pay/index'),
				'comments_money_out' => array('alias' => 'comments_money_out', 'value' => ' ')
					);

            if ($transaction->open())
            {
                return $transaction;
            }
            else
            {
                throw new CException('Ошибка создания финансовой операции', E_USER_ERROR);
            }
        }
        else
        {
            $transaction = new FinanceTransaction('system');

            $transaction->initMainCurrency();
            $transaction->setSpecificationByAlias('wallet_out_house_is_bonus');

            $transaction->initProperties();
            $transaction->initDebitMainWalletByObjectAndId('users', $userId);
            $transaction->initCreditWalletByObjectAndIdAndPurpose('company', 1, 'bonus_out');

            $transaction->amount = $amount;

			$transaction->modelsTransactionsObjects['redirect_confirm_after_paymentsystem']->value = '/office/default/payresult';
			$transaction->modelsTransactionsObjects['redirect_decline_after_paymentsystem']->value = '/office/default/payresult';
			$transaction->modelsTransactionsObjects['redirect_open_after_paymentsystem']->value = '/paymentsystem/yandexmoney/pay/index';
			$transaction->modelsTransactionsObjects['comments_money_out']->value = ' ';

			$transaction->objectsAttributes = array(
				'redirect_confirm_after_paymentsystem' => array('alias' => 'redirect_confirm_after_paymentsystem', 'value' => '/office/default/payresult'),
				'redirect_decline_after_paymentsystem' => array('alias' => 'redirect_decline_after_paymentsystem', 'value' => '/office/default/payresult'),
				'redirect_open_after_paymentsystem' => array('alias' => 'redirect_open_after_paymentsystem', 'value' => '/paymentsystem/yandexmoney/pay/index'),
				'comments_money_out' => array('alias' => 'comments_money_out', 'value' => ' ')
					);
            if ($transaction->open())
            {
                return $transaction;
            }
            else
            {
                throw new CException('Ошибка создания финансовой операции', E_USER_ERROR);
            }
        }
        return true;
    }

	//проверяем есть ли у пользователя роль "Купил автомобиль"
	
    public function getUserRoleAuto($userId)
    {
		Yii::import('application.modules.admin.modules.roles.models.*');
        if (empty($userId))
        {
            throw new CException('Не заданы данные для создания финансовой операции', E_USER_ERROR);
        }
        $user = Authassignment::model()->findAll('userid = :userid', array(':userid' => $userId));
        foreach ($user as $users)
        {
            if ($users->itemname == self::HAVE_AUTO)
            {
                return TRUE;
            }
        }
        return FALSE;
    }

	//проверяем есть ли у пользователя роль "Купил дом"
	
    public function getUserRoleHouse($userId)
    {
        if (empty($userId))
        {
            throw new CException('Не заданы данные для создания финансовой операции', E_USER_ERROR);
        }
        $user = Authassignment::model()->findAll('userid = :userid', array(':userid' => $userId));
        foreach ($user as $users)
        {
            if ($users->itemname == self::HAVE_HOUSE)
            {
                return TRUE;
            }
        }
        return FALSE;
    }
	
//---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

	//создаем личный объем (стартует при закрытие периода/расчет бонусов из админки)
	
    public function createNewPersonalVolume($dateStart, $dateEnd)
    {
        $users = Users::model()->findAll('username != :username', array(':username' => 'superadmin'));
        foreach ($users as $user)
        { 
            $userPVExist = ProfileBonamorPv::model()->find('users__id = :users__id and date_end > :date_end', array(':users__id' => $user->id, ':date_end' => $dateEnd));
            if (!empty($userPVExist))
            {
                continue;
            }
            $userPV = new ProfileBonamorPv();
            $userPV->users__id = $user->id;
            $userPV->value = 0;
            $userPV->date_start = $dateEnd;
            if (!$userPV->validate())
            {
                throw new CException('Не удалось создать личный объем пользователю', E_USER_ERROR);
            }
            if (!$userPV->save())
            {
                throw new CException('Не удалось создать личный объем пользователю', E_USER_ERROR);
            }
        } 
        return true;
    }
	
	//закрываем личный объем (стартует при закрытие периода/расчет бонусов из админки)
	
    public function closePersonalVolume($dateEnd)
    {
        $users = Users::model()->findAll('username != :username', array(':username' => 'superadmin'));
        foreach ($users as $user)
        {
            $userPV = ProfileBonamorPv::model()->find('users__id = :users__id and date_end is NULL', array(':users__id' => $user->id));
            if (!empty($userPV))
            {
                $dateClose = '' . app_date("Y", strtotime($dateEnd)) . '-' . +app_date("m", strtotime($dateEnd)) . '-' . +((string) app_date("d", strtotime($dateEnd)) - 1);
                $userPV->date_end = $dateClose;

                if (!$userPV->validate())
                {
                    throw new CException('Не удалось закрыть личный объем пользователю', E_USER_ERROR);
                }
                if (!$userPV->save())
                {
                    throw new CException('Не удалось закрыть личный объем пользователю', E_USER_ERROR);
                }
            }
        }
        return true;
    }
	
	//создаем пустой объем личной группы (стартует при закрытие периода/расчет бонусов из админки)

    public function createNewVolumeOfPersonalGroup($dateStart, $dateEnd)
    {
        $users = Users::model()->findAll('username != :username', array(':username' => 'superadmin'));
        foreach ($users as $user)
        {
            $userPVExist = ProfileBonamorVpg::model()->find('users__id = :users__id and date_end > :date_end', array(':users__id' => $user->id, ':date_end' => $dateEnd));
            if (!empty($userPVExist))
            {
                continue;
            }
            $userPV = new ProfileBonamorVpg();
            $userPV->users__id = $user->id;
            $userPV->value = 0;
            $userPV->date_start = $dateEnd;
            if (!$userPV->validate())
            {
                throw new CException('Не удалось создать "Объем личной группы" ', E_USER_ERROR);
            }
            if (!$userPV->save())
            {
                throw new CException('Не удалось создать "Объем личной группы" ', E_USER_ERROR);
            }
        }
        return true;
    }
	
	//закрываем объем личной группы (стартует при закрытие периода/расчет бонусов из админки)

    public function closePersonalVolumeOfPersonalGroup($dateEnd)
    {
        $users = Users::model()->findAll('username != :username', array(':username' => 'superadmin'));
        foreach ($users as $user)
        {
            $userPV = ProfileBonamorVpg::model()->find('users__id = :users__id and date_end is NULL', array(':users__id' => $user->id));
            if (!empty($userPV))
            {
                $dateClose = '' . app_date("Y", strtotime($dateEnd)) . '-' . +app_date("m", strtotime($dateEnd)) . '-' . +((string) app_date("d", strtotime($dateEnd)) - 1);
                $userPV->date_end = $dateClose;
				
                if (!$userPV->validate())
                {
                    throw new CException('Не удалось закрыть "Объем личной группы" ', E_USER_ERROR);
                }
                if (!$userPV->save())
                {
                    throw new CException('Не удалось закрыть "Объем личной группы" ', E_USER_ERROR);
                }
            }
        }
        return true;
    }

	// записываем в сводную таблицу бонусы по сетевой структуре (стартует при закрытие периода/расчет бонусов из админки)
	
    public function updateReportFinal($atributes, $bonus)
    {
        if (empty($atributes))
        {
            throw new CException('Не заданы аттрибуты для создания сводной таблицы', E_USER_ERROR);
        }

        $bonuses = UsersBonuses::model()->find('alias = :alias', array(':alias' => $bonus));
        $finalReport = new ProfileReportFinal();
        $finalReport->attributes = $atributes->attributes;

        $finalReport->bonuses__id = $bonuses->id;

        if ($finalReport->validate())
        {
            if (!$finalReport->save())
            {
                throw new CException('Ошибка создания сводной таблицы22', E_USER_ERROR);
            }
            return TRUE;
        }
        return FALSE;
    }
	
	// записываем в сводную таблицу бонусы по бинару (стартует при закрытие периода/расчет бонусов из админки)
	
	public function updateReportFinalBinar($atributes, $bonus)
    {
        if (empty($atributes))
        {
            throw new CException('Не заданы аттрибуты для создания сводной таблицы', E_USER_ERROR);
        }

        $bonuses = UsersBonuses::model()->find('alias = :alias', array(':alias' => $bonus));
        $finalReport = new ProfileReportFinalBinar();
        $finalReport->attributes = $atributes->attributes;
        $finalReport->bonuses__id = $bonuses->id;
		
        if ($finalReport->validate())
        {
            if (!$finalReport->save())
            {
                throw new CException('Ошибка создания сводной таблицы22', E_USER_ERROR);
            }
            return TRUE;
        }
        return FALSE;
    }

	// личный объем за предыдущий период (стартует при закрытие периода/расчет бонусов из админки)
	
    public function getPersonalVolumePrevious($userId)
    {
        if (empty($userId))
        {
            throw new CException('Не задан пользователь43', E_USER_ERROR);
        }
        $personalVolume = 0;
        $userPVMaxPeriode = ProfileBonamorPv::model()->findAll('users__id = :users__id and date_end is not NULL', array(':users__id' => $userId));
        if (!empty($userPVMaxPeriode))
        {
            $datePeriode = 0;
            foreach ($userPVMaxPeriode as $value)
            {
                if ($datePeriode < $value->date_end)
                {
                    $datePeriode = $value->date_end;
                    $personalVolume = $value->value;
                }
            }
        }
        $_pv = $personalVolume;
        return $_pv;
    }

	// объем личной группы за предыдущий период (стартует при закрытие периода/расчет бонусов из админки)
	
    public function getVolumeOfPersonalGroupPrevious($userId)
    {
        if (empty($userId))
        {
            throw new CException('Не задан пользователь44', E_USER_ERROR);
        }
        $personalVolume = 0;
        $userVPGMaxPeriode = ProfileBonamorVpg::model()->findAll('users__id = :users__id and date_end is not NULL', array(':users__id' => $userId));
        if (!empty($userVPGMaxPeriode))
        {
            $datePeriode = 0;
            foreach ($userVPGMaxPeriode as $value)
            {
                if ($datePeriode < $value->date_end)
                {
                    $datePeriode = $value->date_end;
                    $personalVolume = $value->value;
                }
            }
        }
		$_vpg = $personalVolume;
        return $_vpg;
    }
	
	public function getVolumeOfPersonalGroupPreviousForDirector($userId, $closed = FALSE)
    {
        if (empty($userId))
        {
            throw new CException('Не задан пользователь44', E_USER_ERROR);
        }
		$user = Users::model()->findByPk($userId);
		
		$vpg = (int)FALSE;
		$vpgSelf = (int)FALSE;
		if($closed != FALSE)
		{
			$periodeId = $this->getPeriode()->id;
			if(!empty($user->profilebonamor))
			{
				$dirCompleted = $user->profilebonamor->is_director_completed;
			}
			else
			{
				$dirCompleted = (INT)FALSE;
			}
		}
		else
		{
			$periodeId = $this->getPeriodeCurrent()->id;
			$dirCompleted = (int)TRUE;
		}
		
		$crProfile = new CDbCriteria();
		$crProfile->select = 'sum(amount) as amount';
		$crProfile->condition = 'users__id = :users__id and periode__id = :periode__id';
		$crProfile->params = array(':users__id' => $userId, ':periode__id' => $periodeId);
		
		$vpgModel = ProfileDirectorVpg::model()->find($crProfile);
		$vpg = (int)FALSE;
		if(!empty($vpgModel))
		{
			$vpg = $vpgModel->amount;
		}
		$vpgSelf = $this->getVolumeOfPersonalGroupPrevious($userId);
		
		if(!empty($user->profilebonamor) && $dirCompleted > (int)FALSE)
		{
			$vpgAll = $vpgSelf + $vpg;
		}
		else
		{
			$vpgAll = $vpg;
		}
		
		
        return $vpgAll;
    }
	
	//считаем ранги  (стартует при закрытие периода/расчет бонусов из админки)
	
    public function setRankToUser($dateStart, $dateEnd)
    {
		Yii::import('application.modules.register.models.*');
        $user = Users::model()->findAll('username != :username', array(':username' => 'superadmin'));
        foreach ($user as $users)
        {
            $userId = $users->id;
			
			if(empty($users->profilebonamor))
			{
				continue;
			}
			$this->updateBizOptionsToUser($userId); //пересчитываем бизнес опции
			
            $userPV = $this->getPersonalVolumePrevious($userId);
            $userAGV = $this->getAccumulatedGroupVolume($userId);
            $userVPG = $this->getVolumeOfPersonalGroupPrevious($userId);

            $usersRank = UsersRank::model()->findAll('pv is not NULL');
            $usersClientRank = UsersRank::model()->find('alias = :alias', array(':alias' => UsersRank::CLIENT));
            $usersDirectorRank = UsersDirectorRank::model()->find('alias = :alias', array(':alias' => ProfileBonuses::DIRECTOR));
            $profileBonamor = ProfileBonamor::model()->find('user__id = :user__id', array(':user__id' => $userId));
			
            $profileBonamorHistory = new ProfileBonamorHistory();
            foreach ($usersRank as $rank)
            {
			
                if ($rank->pv <= $userPV && $rank->agv <= $userAGV && $rank->vpg <= $userVPG)
                {
				
					if($profileBonamor->rank->position < $rank->position)
					{
						$profileBonamor->rank__id = $rank->id;
						
						if (($rank->alias == ProfileBonuses::DIRECTOR || $rank->alias == UsersRank::ENERGY_DIRECTOR) && ($profileBonamor->director__id < (int)TRUE))
						{
						
							$profileBonamor->director__id = $usersDirectorRank->id;
						
						}
						$i = TRUE;
					}
					/*if($rank->alias == ProfileBonuses::DIRECTOR || $rank->alias == UsersRank::ENERGY_DIRECTOR)
					{
						$profileBonamor->is_director_completed = (int)TRUE;
					}*/
                }
            }
			
			
			if (isset($i))
            {
                if (!$profileBonamor->validate())
                {
                    throw new CException('Не удалось обновить ранг пользователя, ошибка валидации', E_USER_ERROR);
                }
                if (!$profileBonamor->save())
                {
                    throw new CException('Не удалось обновить ранг пользователя', E_USER_ERROR);
                }

				$this->setRankHistory($profileBonamor, $userPV, $userAGV, $userVPG, TRUE);
				
                $profileBonamorHistory->attributes = $profileBonamor->attributes;
                //$profileBonamorHistory->date_update = app_date("Y-m-d H:i:s");
				
					if(!empty($profileBonamor->director__id))
					{
						$profileBonamorHistory->director_date = $dateStart;
						
						
					}
				
                if ($profileBonamorHistory->validate())
                {
                    if (!$profileBonamorHistory->save())
                    {
                        throw new CException('Не удалось обновить историю пользователя', E_USER_ERROR);
                    }
                }
					
            }
			
        } 
		
        return TRUE;
    }
	
	public function setGiftsForRank($model, $rankHistory)
	{
		Yii::import('application.modules.admin.modules.marketing.models.*');
		if($model instanceof ProfileBonamor)
		{
			if($rankHistory instanceof ProfileRankHistory && $rankHistory->is_riese == (int)TRUE)
			{
				$rank = UsersRank::model()->findByPk($model->rank__id);
				$alias = $rank->alias;
				
				if($alias == 'energy_sponsor')
				{
					$alias = 'sponsor';
				}
				elseif($alias == 'energy_manager')
				{
					$alias = 'manager';
				}
				elseif($alias == 'energy_director')
				{
					$alias = 'director';
				}
				if($model->director instanceof UsersDirectorRank)
				{
					$director = UsersDirectorRank::model()->findByPk($model->director__id);
					$alias = $director->alias;
					/*if($model->user__id > 1082 )
					{
						echo"<bR>---1------------".$model->user__id."---------<br>";
						vg($model->director__id);
						vg($alias);
						
						
					}*/
				}
				
				$amount = ProfileBonamorMarketingSettings::getValueByAlias($alias);
					
				if($amount instanceof ProfileBonamorMarketingSettings)
				{
					/*if($modelGift->user__id >1082)
					{
						vg($amount->value);
						echo"<bR>---------".$modelGift->user__id."---------------<br>";
					}*/
					$gifts = ProfileGiftsBonuses::model()->findAll('users__id = :users__id and periode__id = :periode__id and is_rank =:is_rank', 
																array(':users__id' => $model->user__id, ':periode__id' => $this->getPeriodeCurrent()->id, ':is_rank' =>(int)TRUE));
					
					$bonusGifts = '';
					
					if(count($gifts) > (int)FALSE)
					{
						foreach($gifts as $gift)
						{
							$bonusGifts = $gift;
						}
					}
					else
					{
						$bonusGifts = new ProfileGiftsBonuses();
						
					}
					
					$userId = $model->user__id;
					
					$bonusGifts->users__id = $userId;
					//$bonusGifts->persents = $amount->value;
					$bonusGifts->amount = round($amount->value);
					$bonusGifts->periode_date = app_date("Y-m-d");
					$bonusGifts->periode__id = $this->getPeriodeCurrent()->id;
					$bonusGifts->is_rank = (int)TRUE;
				
				
					if ($bonusGifts->validate())
					{
						$isNew = $bonusGifts->isNewRecord;
						if($isNew)
						{
							$transaction = new FinanceTransaction('system');
							$transaction->initMainCurrency();
							$transaction->setSpecificationByAlias('wallet_out_gifts_bonus');

							$transaction->initProperties();
							$transaction->initDebitWalletByObjectAndIdAndPurpose('users', $userId, 'gifts_bonus');
							$transaction->initCreditWalletByObjectAndIdAndPurpose('company', 1, 'bonus_out');

							$transaction->amount = $amount->value;

							if ($amount->value > 0)
							{
								if(!$transaction->open())
								{
									throw new CException('Не создана транзакция для Гифт бонуса', E_USER_ERROR);
								}
							
								$bonusGifts->transactions__id = $transaction->getModelTransactions()->id;
							}
							
							if (!$bonusGifts->save())
							{
								throw new CException('Не удалось обновить гифт пользователя', E_USER_ERROR);
							}
							
							if (!ProfileBonuses::model()->updateReportFinal($bonusGifts, ProfileBonuses::GIFTS_BONUS_ALIAS))
							{
								throw new CException('Ошибка создания сводной таблицы3', E_USER_ERROR);
							}
						}
						elseif ($amount->value > 0)
						{
							$transaction = FinanceTransactions::model()->findByPk($bonusGifts->transactions__id);
							$transaction->amount = $amount->value;
							$transaction->save();
							$bonusGifts->transactions__id = $transaction->id;
							
							if (!$bonusGifts->save())
							{
								throw new CException('Не удалось обновить гифт пользователя', E_USER_ERROR);
							}
							
							$bonuses = UsersBonuses::model()->find('alias = :alias', array(':alias' => 'gifts'));
							$criteria = new CDbCriteria();
							$criteria->condition = 'users__id = :users__id and bonuses__id = :bonuses__id and periode__id = :periode__id and persents is NULL';
							$criteria->params = array(
									':users__id' => $bonusGifts->users__id,
									':bonuses__id' => $bonuses->id,
									':periode__id' => $bonusGifts->periode__id,
								);
							$giftsModel = ProfileReportFinal::model()->find($criteria);
							$giftsModel->amount = $bonusGifts->amount;
							$giftsModel->save();
						}
					
					}
				}
			}
		}
	}
	
	//--------------------------------------наполнение таблицы для отчета по рангам---------------------------------------------------
	
	public function setRankHistory($profileBonamor = FALSE, $userPV = FALSE, $userAGV = FALSE, $userVPG = FALSE, $riese = FALSE)
	{
		Yii::import('application.modules.register.models.*');
		if($profileBonamor != FALSE && $userPV != FALSE && $userAGV != FALSE && $userVPG != FALSE && $riese != FALSE)
		{
			$userId = $profileBonamor->user__id;
			
			if($userPV == TRUE)
			{
				$userPV = $this->getPersonalVolume($userId);
			}
			if($userVPG == TRUE)
			{
				$userVPG = $this->getVolumeOfPersonalGroup($userId);
			}
			if($userAGV == TRUE)
			{
				$userAGV = $this->getAccumulatedGroupVolume($userId);
			}
			$gv = $this->getGroupValue($profileBonamor->user__id);
			
			$periodeId = $this->getPeriodeCurrent()->id;
			$rankHistory = ProfileRankHistory::model()->find('users__id = :users__id and periode__id = :periode__id', array(':users__id' => $userId, ':periode__id' => $periodeId));
			if(!$rankHistory instanceof ProfileRankHistory)
			{
				$profileRankHistory = new ProfileRankHistory();
			}
			else
			{
				$profileRankHistory = $rankHistory;
			}
			
			$profileRankHistory->users__id = $profileBonamor->user__id;
			$profileRankHistory->sponsor__id = $profileBonamor->user->profile->sponsor__id;
			$profileRankHistory->periode__id = $this->getPeriodeCurrent()->id;
			$profileRankHistory->pv = $userPV;
			$profileRankHistory->agv = $userAGV;
			$profileRankHistory->vpg = $userVPG;
			$profileRankHistory->gv = $gv;
			if(!empty($profileBonamor->director))
			{
				$profileRankHistory->director__id = $profileBonamor->director__id;
			}
			$profileRankHistory->rank__id = $profileBonamor->rank__id;
			
			
			$profileRankHistory->pi = self::countPersonalInvitedKvalified($profileBonamor->user__id);
			$profileRankHistory->is_riese = (int)TRUE;
			
			$this->setGiftsForRank($profileBonamor, $profileRankHistory);
			if(!$profileRankHistory->save())
			{
				throw new CException('Не удалось обновить историю рангов пользователя (повышение)', E_USER_ERROR);
			}
		}
		if ($profileBonamor != TRUE && $userPV != TRUE && $userAGV != TRUE && $userVPG != TRUE && $riese != TRUE)
		{
			$users = Users::model()->findAll('username != :username', array(':username' => 'superadmin'));
			$periodeId = $this->getPeriodeCurrent()->id;
			
			foreach($users as $user)
			{
			
				$rankHistory = ProfileRankHistory::model()->find('users__id = :users__id and periode__id = :periode__id', array(':users__id' => $user->id, ':periode__id' => $periodeId));
				
				if(empty($rankHistory) && !empty($user->profilebonamor))
				{
					$rankHistory = new ProfileRankHistory();
					$rankHistory->users__id = $user->id;
					$rankHistory->sponsor__id = $user->profile->sponsor__id;
					$rankHistory->periode__id = $periodeId;
					$rankHistory->pv = $this->getPersonalVolumePrevious($user->id);
					$rankHistory->agv = $this->getAccumulatedGroupVolume($user->id);
					$rankHistory->vpg = $this->getVolumeOfPersonalGroupPrevious($user->id);
					$rankHistory->gv = $this->getGroupValue($user->id);
					if(!empty($profileBonamor->director))
					{
						$profileRankHistory->director__id = $profileBonamor->director__id;
					}
					$rankHistory->rank__id = $user->profilebonamor->rank__id;
										
					
					$rankHistory->pi = self::countPersonalInvitedKvalified($user->id);
					$rankHistory->is_riese = (int)FALSE;
					
					if(!$rankHistory->save())
					{
						throw new CException('Не удалось обновить историю рангов пользователя', E_USER_ERROR);
					}
				}
				elseif(!empty($user->profilebonamor))
				{
					$rankHistory->pv = $this->getPersonalVolumePrevious($user->id);
					$rankHistory->agv = $this->getAccumulatedGroupVolume($user->id);
					$rankHistory->vpg = $this->getVolumeOfPersonalGroupPrevious($user->id);
					$rankHistory->gv = $this->getGroupValue($user->id);
					if(!empty($profileBonamor->director))
					{
						$profileRankHistory->director__id = $profileBonamor->director__id;
					}
					$rankHistory->rank__id = $user->profilebonamor->rank__id;
					
					$rankHistory->pi = self::countPersonalInvitedKvalified($user->id);
										
					if(!$rankHistory->save())
					{
						throw new CException('Не удалось обновить историю рангов пользователя', E_USER_ERROR);
					}
				}
				
				
			}
		
					
		}
		return TRUE;
	}
	//----------------------------------подсчет квалифицированных лично-приглашенных(не КК)-----------------------------------------
	
	
	public static function countPersonalInvitedKvalified($userId)
	{
		if (empty($userId))
		{
			throw new CException('Не задан пользователь (подсчет квалифицированных лично-приглашенных(не КК))', E_USER_ERROR);
		}
		
		$profile = Profile::model()->findAll('sponsor__id = :sponsor__id', array(':sponsor__id' => $userId));
		$i = (int)FALSE;
		if(!empty($profile))
		{
			foreach($profile as $value)
			{
			
				if(!empty($value->user->profilebonamor) && $value->user->profilebonamor->options->alias != UsersOptions::CLIENT_COMPANY)
				{
					$i++;
				}
			}
		}
		return $i;
	}
	
	
	
	//+--------------------------------пересчитываем бизнес опции (стартует при закрытие периода/расчет бонусов из админки)
	
	 public function updateBizOptionsToUser($userId)
    {
        $optionVIP = UsersOptions::model()->find('alias = :alias', array(':alias' => self::VIP_CLIENT_COMPANY));
        $optionPC = UsersOptions::model()->find('alias = :alias', array(':alias' => self::PARTNER_COMPANY));
        Yii::import('application.modules.register.models.*');
        $optionsUser = ProfileBonamor::model()->find('user__id = :user__id', array(':user__id' => $userId));
		$pv = $this->getPersonalVolumePrevious($userId);
		
		$bonamorHistory = new ProfileBonamorHistory();
		
	    if ($optionsUser->options__id == $optionPC->id)
        {	
			$activity = ProfileBonuses::checkBizOptions($userId);
			
            if ($pv < self::MIN_POINTS_FOR_PC && $activity->date_update <= app_date("Y-m-d H:m:i"))
            {
                $optionsUser->options__id = $optionVIP->id;
				
				$bonamorHistory->attributes = $optionsUser->attributes;
				$bonamorHistory->amount_vcc = -(int) TRUE;
				
                if (!$optionsUser->validate())
                {
                    throw new CException('Не удалось обновить бизнес-опцию для VIP пользователя', E_USER_ERROR);
                }
                if (!$optionsUser->save() && $bonamorHistory->save())
                {
                    throw new CException('Не удалось обновить бизнес-опцию для VIP пользователя', E_USER_ERROR);
                }
            }
        }
		

	}
	
	//выборка объема личной группы по аплайну профайла за прошедший период
	
	public function getEnergyGroupValue($userId, $dateStart = FALSE)
	{
		if (empty($userId))
        {
            throw new CException('Не задан пользователь45', E_USER_ERROR);
        }
        $group = $this->getUserGroupByUpline($userId);
		$gv = 0;
		foreach($group as $value)
		{
			$gv += $this->getPersonalVolumePrevious($value->user__id);
		}		
		return $gv;
	}
	
	//выборка объема личной группы по аплайну профайла за текущий период
	
	public function getEnergyGroupValuePresent($userId, $dateStart = FALSE)
	{
		if (empty($userId))
        {
            throw new CException('Не задан пользователь46', E_USER_ERROR);
        }
        $group = $this->getUserGroupByUpline($userId);
		$gv = 0;
		foreach($group as $value)
		{
			$gv += $this->getPersonalVolume($value->user__id);
		}		
		return $gv;
	}
	
	//выборка личной группы по аплайну профайла
	
	public function getUserGroupByUpline($userId, $dateStart = FALSE, $dateEnd = FALSE)
	{
		if (empty($userId))
        {
            throw new CException('Не задан пользователь47', E_USER_ERROR);
        }
		$profile = Profile::model()->find('user__id = :user__id', array(':user__id' => $userId));
		$currentGroup = array();
		$currentGroup = substr($profile->upline,-8,8);
		$profileGroup = array();
		$profileGroup = Profile::model()->findAll('upline like "%'.$currentGroup.'%" ');
		
		return $profileGroup;
	}
	
	//выборка личной группы по аплайну профайла для лидерского бонуса
	
	public function getUserGroupByUplineForLeader($userId, $uplineCurrentUser)
	{
		if (empty($userId))
        {
            throw new CException('Не задан пользователь555', E_USER_ERROR);
        }
		$profile = Profile::model()->find('user__id = :user__id', array(':user__id' => $userId));
		$currentGroup = array();
		$currentGroup = substr($profile->upline,-8,8);
		$profileGroup = array();
		$profileGroup = Profile::model()->findAll('upline like "%'.$currentGroup.'%" and instr(upline, :upline) = 0', array(':upline' => $uplineCurrentUser));
		
		return $profileGroup;
	}
	
	//выборка группы лично-приглашенных
	
	public function getUserGroupPersonal($userId, $dateStart = FALSE, $dateEnd = FALSE)
	{
		if (empty($userId))
        {
            throw new CException('Не задан пользователь48', E_USER_ERROR);
        }
		$profile = array();
		$profile = Profile::model()->findAll('sponsor__id = :sponsor__id', array(':sponsor__id' => $userId));
				
		return $profile;
	}
	
	//выборка активных лично-приглашенных
	public static function getActiveGroupPersonal($userId)
	{
		if (empty($userId))
        {
            throw new CException('Не задан пользователь481', E_USER_ERROR);
        }
		$profile = array();
		$profile = Profile::model()->findAll('sponsor__id = :sponsor__id', array(':sponsor__id' => $userId));
		$cnt = (int)FALSE;
		foreach($profile as $value)
		{
			$activity = self::checkActivity($value->user__id);
			if(!empty($activity) && $activity->date_end > app_date("Y-m-d H:m:s"))
			{
				$cnt++;
			}
		}
			
		return $cnt;
	}
		
	//считаем энергичные ранги  (стартует при закрытие периода/расчет бонусов из админки)

	public function setEnergyRankToUser($dateStart, $dateEnd)
    {
		$criteria = new CDbCriteria();
		$criteria->select = 'users__id';
		$criteria->distinct = true;
		$criteria->condition = 'date_start >= :dateStart';
		$criteria->params = array(':dateStart' => $dateStart);
        $user = ProfileBonamorPv::model()->findAll($criteria);
		$usersDirectorRank = UsersDirectorRank::model()->find('alias = :alias', array(':alias' => ProfileBonuses::DIRECTOR));
		
		if((app_date("m")-3) == -2)
		{
			$month = 10; 
			$year = app_date("Y") - 1;
		}
		elseif((app_date("m")-3) == -1)
		{
			$month = 11;
			$year = app_date("Y") - 1;
		}
		elseif((app_date("m")-3) == 0)
		{
			$month = 12;
			$year = app_date("Y") - 1;
		}
		else
		{
			$month = app_date("m")-3;
			$year = app_date("Y");
		}
		
		$dateRegister = app_date("Y-m-d", strtotime($year."-".$month."-". 1));

        foreach ($user as $users)
        {
			if($users->user->created_at < $dateRegister)
			{
				continue;
			}
			
            $userId = $users->user->id;
			
			$profileEnergyBonamor = ProfileBonamor::model()->find('user__id = :user__id', array(':user__id' => $userId));
			
			if(empty($profileEnergyBonamor) || $profileEnergyBonamor->options->alias == self::CLIENT_COMPANY)
			{
				continue;
			}
            $value = ProfileBonuses::model()->getEnergyGroupValue($userId, $dateStart);
			
			$userRankEnergy = UsersRank::model()->findAll('pv is NULL and agv <= :agv', array(':agv' => $value));	
			
			if (!empty($userRankEnergy))
			{	
				$position = 0;
				foreach($userRankEnergy as $rankEnergy)
				{
					if($position < $rankEnergy->position)
					{
						$rank = $rankEnergy;
						$position = $rankEnergy->position;
					}
				}
				$energy = $rank->alias;
				
				if($profileEnergyBonamor->rank->position >= $rank->position)
				{
					continue;
				}
				$profileEnergyBonamor->rank__id = $rank->id;
				
				if (($rank->alias == ProfileBonuses::DIRECTOR || $rank->alias == UsersRank::ENERGY_DIRECTOR) && ($profileEnergyBonamor->director__id < (int)TRUE))
				{
					$profileEnergyBonamor->director__id = $usersDirectorRank->id;
				}
				if (!$profileEnergyBonamor->validate())
				{
					throw new CException('Не удалось обновить ранг энергичного пользователя', E_USER_ERROR);
				}
				if (!$profileEnergyBonamor->save())
				{
					throw new CException('Не удалось обновить ранг энергичного пользователя', E_USER_ERROR);
				}
				$profileBonamorHistory = new ProfileBonamorHistory();
				$profileBonamorHistory->attributes = $profileEnergyBonamor->attributes;
				//$profileBonamorHistory->date_update = app_date("Y-m-d H:i:s");
				if($rank->alias == UsersRank::ENERGY_DIRECTOR)
				{
					$profileBonamorHistory->director_date = $dateStart;
				}
				if ($profileBonamorHistory->validate())
				{
					if (!$profileBonamorHistory->save())
					{
						throw new CException('Не удалось обновить историю пользователя', E_USER_ERROR);
					}
				}	
				
				$profileEnergyBonamor = ProfileBonamor::model()->find('user__id = :user__id', array(':user__id' => $userId));
				
				$this->setRankHistory($profileEnergyBonamor, TRUE, TRUE, TRUE, TRUE);
				if (!ProfileBonuses::model()->setFastStartValue($userId, $energy, $value))
				{
					throw new CException('Не удалось обновить накопленный групповой объем', E_USER_ERROR);
				}
			
			}
		}
        return TRUE;
    }
	
	//обновляем энергичные ранги (для проверки условия по лично-приглашенным) (стартует при закрытие периода/расчет бонусов из админки)
	
	public function updateEnergyRankToUser($dateStart, $dateEnd)
    {
		$criteria = new CDbCriteria();
		$criteria->select = 'users__id';
		$criteria->distinct = true;
		$criteria->condition = 'date_start >= :dateStart';
		$criteria->params = array(':dateStart' => $dateStart);
        $user = ProfileBonamorPv::model()->findAll($criteria);
		$manager = UsersRank::model()->find('alias = :alias', array(':alias' => UsersRank::ENERGY_MANAGER));
		$director = UsersRank::model()->find('alias = :alias', array(':alias' => UsersRank::ENERGY_DIRECTOR));
		$usersDirectorRank = UsersDirectorRank::model()->find('alias = :alias', array(':alias' => ProfileBonuses::DIRECTOR));
		if((app_date("m")-3) == -2)
		{
			$month = 10; 
			$year = app_date("Y") - 1;
		}
		elseif((app_date("m")-3) == -1)
		{
			$month = 11;
			$year = app_date("Y") - 1;
		}
		elseif((app_date("m")-3) == 0)
		{
			$month = 12;
			$year = app_date("Y") - 1;
		}
		else
		{
			$month = app_date("m")-3;
			$year = app_date("Y");
		}
		
		$dateRegister = app_date("Y-m-d", strtotime($year."-".$month."-". 1));
		
        foreach ($user as $users)
        {
			if($users->user->created_at < $dateRegister)
			{
				continue;
			}
			
            $userId = $users->user->id;
			$profileEnergyBonamor = ProfileBonamor::model()->find('user__id = :user__id', array(':user__id' => $userId));
			if(empty($profileEnergyBonamor) || $profileEnergyBonamor->options->alias == self::CLIENT_COMPANY)
			{
				continue;
			}
			$group = ProfileBonuses::model()->getUserGroupPersonal($userId);
			$value = ProfileBonuses::model()->getEnergyGroupValue($userId, $dateStart);
			if($users->user->profilebonamor->rank->alias == UsersRank::ENERGY_SPONSOR)
			{
				$energyClient = 0;
				foreach($group as $groupValue)
				{
					$gvClient = ProfileBonuses::model()->getEnergyGroupValue($groupValue->user__id);
					if(empty($groupValue->user->profilebonamor))
					{
						continue;
					}
					if($groupValue->user->profilebonamor->rank->alias == UsersRank::ENERGY_SPONSOR && $gvClient >= self::ENERGY_SPONSOR_VALUE_GROUP)
					{
						$energyClient++;
					}
				}
				if($energyClient > 1 )
				{	
					if($profileEnergyBonamor->rank->position >= $manager->position)
					{
						continue;
					}
					$profileEnergyBonamor->rank__id = $manager->id;
					
					if (!$profileEnergyBonamor->validate())
					{
						throw new CException('Не удалось обновить ранг энергичного пользователя', E_USER_ERROR);
					}
					if (!$profileEnergyBonamor->save())
					{
						throw new CException('Не удалось обновить ранг энергичного пользователя', E_USER_ERROR);
					}
					$profileBonamorHistory = new ProfileBonamorHistory();
					$profileBonamorHistory->attributes = $profileEnergyBonamor->attributes;
					//$profileBonamorHistory->date_update = app_date("Y-m-d H:i:s");
					if($rank->alias == UsersRank::ENERGY_DIRECTOR)
					{
						$profileBonamorHistory->director_date = $dateStart;
					}
					if ($profileBonamorHistory->validate())
					{
						if (!$profileBonamorHistory->save())
						{
							throw new CException('Не удалось обновить историю пользователя', E_USER_ERROR);
						}
					}		
					
					$this->setRankHistory($profileEnergyBonamor, TRUE, TRUE, TRUE, TRUE);					
					
					if (!ProfileBonuses::model()->updateFastStartValue($userId, $manager->alias, $value))
					{
						throw new CException('Не удалось обновить накопленный групповой объем', E_USER_ERROR);
					}
				}
			}
			
			elseif($users->user->profilebonamor->rank->alias == UsersRank::ENERGY_MANAGER)
			{
				$energyClient = 0;
				foreach($group as $groupValue)
				{
					$gvClient = ProfileBonuses::model()->getEnergyGroupValue($groupValue->user__id);
					if(!empty($groupValue->user->profilebonamor) && $groupValue->user->profilebonamor->rank->alias == UsersRank::ENERGY_MANAGER && $gvClient >= self::ENERGY_MANGER_VALUE_GROUP)
					{
						$energyClient++;
					}
				}
				if($energyClient > 1 )
				{
				
					if($profileEnergyBonamor->rank->position >= $director->position)
					{
						continue;
					}
					$profileEnergyBonamor->rank__id = $director->id;
					$profileEnergyBonamor->director__id = $usersDirectorRank->id;
		
					if (!$profileEnergyBonamor->validate())
					{
						throw new CException('Не удалось обновить ранг энергичного пользователя', E_USER_ERROR);
					}
					if (!$profileEnergyBonamor->save())
					{
						throw new CException('Не удалось обновить ранг энергичного пользователя', E_USER_ERROR);
					}
					$profileBonamorHistory = new ProfileBonamorHistory();
					$profileBonamorHistory->attributes = $profileEnergyBonamor->attributes;
					//$profileBonamorHistory->date_update = app_date("Y-m-d H:i:s");
					if($rank->alias == UsersRank::ENERGY_DIRECTOR)
					{
						$profileBonamorHistory->director_date = $dateStart;
					}
					if ($profileBonamorHistory->validate())
					{
						if (!$profileBonamorHistory->save())
						{
							throw new CException('Не удалось обновить историю пользователя', E_USER_ERROR);
						}
					}	
					$this->setRankHistory($profileEnergyBonamor, TRUE, TRUE, TRUE, TRUE);
					
					if (!ProfileBonuses::model()->updateFastStartValue($userId, $director->alias, $value))
					{
						throw new CException('Не удалось обновить накопленный групповой объем', E_USER_ERROR);
					}
				}
			}
		} 
        return TRUE;
    }
	
	
	  //------------------------------------------------------------------------------------------------------------------
    //------------------------------ДиректорскаЯ часть------------------------------------------------------------------

	public function getUserGroupByUplineForDirector($userId, $dateStart = FALSE, $dateEnd = FALSE)
	{
		Yii::import('application.modules.register.models.*');
        if (empty($userId))
        {
            throw new CException('Не задан пользователь19', E_USER_ERROR);
        }
		$users = Users::model()->findByPk($userId);
		$upline = $users->profile->user__id;
		
		$criteria = new CDbCriteria();
		$criteria->with = array(
					'user' => array(
						'with' => array(
							'profilebonamor' => array(
									'condition' => 'profilebonamor.director__id is not NULL',
									),
								),
					),
				);
		$criteria->condition = 't.sponsor__id = :sponsor__id';
		$criteria->params = array(':sponsor__id' => $users->id);

		$group = Profile::model()->findAll($criteria);
		
		$datePeriode = $this->getPeriode();
		if($dateStart == FALSE)
		{
			$start = $datePeriode->date_begin;
		}
		else
		{
			$start = $dateStart;
		}
		if($dateEnd == FALSE)
		{
			$end = $datePeriode->date_end;
		}
		else
		{
			$end = $dateEnd;
		}
	
		$directorCriteria = new CDbCriteria();
		$directorCriteria->condition = 'is_director_completed > :is_director_completed';
		$directorCriteria->params = array('is_director_completed' => (int)FALSE);
		
		$result =array();
		
		foreach($group as $value)
		{
			$directorCriteria->addCondition('user__id = :user__id');
			$directorCriteria->params = array_merge($directorCriteria->params, array(':user__id' => $value->user__id));
			$history = ProfileBonamor::model()->find($directorCriteria);
			if(!empty($history))
			{
				$result[] = $history;
			}
		}
		
		
		return $result;

	}
	
    public function getUserGroupForDirectorBonus($userId, $dateStart = FALSE, $dateEnd = FALSE)
    {
	Yii::import('application.modules.register.models.*');
        if (empty($userId))
        {
            throw new CException('Не задан пользователь19', E_USER_ERROR);
        }
		
        $stepToken = $this->getUserGroupByUplineForDirector($userId, $dateStart, $dateEnd);
				
		$usersList = array();
		if(empty($stepToken))
		{
			return $usersList;
		}
        $profileBonamorHistory = array();
       
        $profileBonamor = ProfileBonamor::model()->find('user__id = :user__id', array(':user__id' => $userId));
		$levelMine = $profileBonamor->user->profile->tree_level;
        if ($profileBonamor->director__id != NULL)
        {
          
            foreach ($stepToken as $director)
            {
			
                $matrixModel = $director->user->profile;
                if ($director->director_completed->alias == UsersDirectorRank::EMERALD_DIRECTOR)
                {
                    $usersList[] = [
                        'id' => $director->user__id,
                        'level' => $matrixModel->tree_level -$levelMine,
						'sponsor__id' => $matrixModel->sponsor__id,
                        'alias' => UsersDirectorRank::EMERALD_DIRECTOR,
                    ];
                }
                elseif ($director->director_completed->alias == UsersDirectorRank::PLATINUM_DIRECTOR)
                {
                    $usersList[] = [
                        'id' => $director->user__id,
                        'level' => $matrixModel->tree_level - $levelMine,
						'sponsor__id' => $matrixModel->sponsor__id,
                        'alias' => UsersDirectorRank::PLATINUM_DIRECTOR,
                    ];
                }
                elseif ($director->director_completed->alias == UsersDirectorRank::RUBIN_DIRECTOR)
                {
                    $usersList[] = [
                        'id' => $director->user__id,
                        'level' => $matrixModel->tree_level - $levelMine,
						'sponsor__id' => $matrixModel->sponsor__id,
                        'alias' => UsersDirectorRank::RUBIN_DIRECTOR,
                    ];
                }
                else
                {
                    $usersList[] = [
                        'id' => $director->user__id,
                        'level' => $matrixModel->tree_level - $levelMine,
						'sponsor__id' => $matrixModel->sponsor__id,
                        'alias' => UsersDirectorRank::DIRECTOR,
                    ];
                }
            }

			
            return $usersList;
        }

        return;
    }
	
	public function getUserGroupForDirector($user)
    {
	Yii::import('application.modules.register.models.*');
        if (empty($user))
        {
            throw new CException('Не задан пользователь19', E_USER_ERROR);
        }
		
        $stepToken = Profile::model()->findAll('upline like :upline', array(':upline' => '%'.$user->profile->upline.'%'));
				
		$usersList = array();
		if(empty($stepToken))
		{
			return $usersList;
		}
		
		$levelMine = $user->profile->tree_level;
        if (!empty($user->profilebonamor->director))
        {
          
            foreach ($stepToken as $director)
            {
				if(empty($director->user->profilebonamor->director))
				{
					continue;
				}
                $matrixModel = $director;
                if ($director->user->profilebonamor->director->alias == UsersDirectorRank::EMERALD_DIRECTOR)
                {
                    $usersList[] = [
                        'id' => $director->user__id,
                        'level' => $matrixModel->tree_level -$levelMine,
						'sponsor__id' => $matrixModel->sponsor__id,
                        'alias' => UsersDirectorRank::EMERALD_DIRECTOR,
                    ];
                }
                elseif ($director->user->profilebonamor->director->alias == UsersDirectorRank::PLATINUM_DIRECTOR)
                {
                    $usersList[] = [
                        'id' => $director->user__id,
                        'level' => $matrixModel->tree_level - $levelMine,
						'sponsor__id' => $matrixModel->sponsor__id,
                        'alias' => UsersDirectorRank::PLATINUM_DIRECTOR,
                    ];
                }
                elseif ($director->user->profilebonamor->director->alias == UsersDirectorRank::RUBIN_DIRECTOR)
                {
                    $usersList[] = [
                        'id' => $director->user__id,
                        'level' => $matrixModel->tree_level - $levelMine,
						'sponsor__id' => $matrixModel->sponsor__id,
                        'alias' => UsersDirectorRank::RUBIN_DIRECTOR,
                    ];
                }
                else
                {
                    $usersList[] = [
                        'id' => $director->user__id,
                        'level' => $matrixModel->tree_level - $levelMine,
						'sponsor__id' => $matrixModel->sponsor__id,
                        'alias' => UsersDirectorRank::DIRECTOR,
                    ];
                }
            }

				
            return $usersList;
        }

        return;
    }

    public function setDirectorBonusRank($userId, $dateStart = FALSE, $dateEnd = FALSE)
    {
        if (empty($userId))
        {
            throw new CException('Не задан пользователь20', E_USER_ERROR);
        }
		
        $rubin_director = 0;
        $emerald_director = 0;
        $platinum_director = 0;
        $directorSimple = 0;
		$pearl_director = 0;
								
        $usersDirectorRank = UsersDirectorRank::model()->findAll();
        $userAGV = $this->getAccumulatedGroupVolume($userId);
        $userVPG = $this->getVolumeOfPersonalGroupPreviousForDirector($userId);
			
		$group = array();
        $group = $this->getUserGroupForDirectorBonus($userId, $dateStart, $dateEnd);
		if(count($group) < (int)TRUE)
		{
			$group = array();
		}
		$rank = '';
		
		foreach ($group as $value)
        {
            if ($value['alias'] == UsersDirectorRank::RUBIN_DIRECTOR && $value['sponsor__id'] == $userId)
            {
                $rubin_director++;
            }
            elseif ($value['alias'] == UsersDirectorRank::EMERALD_DIRECTOR && $value['sponsor__id'] == $userId)
            {
                $emerald_director++;
            }
            elseif ($value['alias'] == UsersDirectorRank::PLATINUM_DIRECTOR && $value['sponsor__id'] == $userId)
            {
                $platinum_director++;
            }
			elseif ($value['alias'] == UsersDirectorRank::PEARL_DIRECTOR && $value['sponsor__id'] == $userId)
            {
                $pearl_director++;
            }
            else
            {
                $directorSimple++;
            }
        }
			
        foreach ($usersDirectorRank as $director)
        {
            if ($userAGV >= $director->agv && $userVPG >= $director->vpg)
            {
                if ($director->personal_invited <= $directorSimple && $director->personal_invited_director <= $rubin_director && $director->personal_invited_director > (int) FALSE)
                    {
                        $rank = UsersDirectorRank::EMERALD_DIRECTOR;
                    }
                elseif ($director->personal_invited <= $directorSimple && $director->personal_invited_director <= $emerald_director && $director->personal_invited_director > (int) FALSE)
                    {
                        $rank = UsersDirectorRank::PLATINUM_DIRECTOR;
                    }
                elseif ($director->personal_invited <= $directorSimple && $director->personal_invited_director <= $platinum_director && $director->personal_invited_director > (int) FALSE)
                    {
                        $rank = UsersDirectorRank::BRILLIANCE_DIRECTOR;
                    }
				elseif($director->personal_invited <= $directorSimple && $director->personal_invited_director < (int) TRUE)
				{
			
					$rank = $director->alias;
				}
            }
        }
		
		
        return $rank;
    }

    public function setDirectorBonusValue($userId)
    {
        if (empty($userId))
        {
            throw new CException('Не задан пользователь21', E_USER_ERROR);
        }
		$director = UsersRank::model()->find('alias = :alias', array(':alias' => self::DIRECTOR));
		
        $user = Users::model()->findByPk($userId);
        if (empty($user->profilebonamor) || $user->profilebonamor->rank->position < $director->position)
        {
		    return;
        }
        $group = $this->getUserGroupForDirector($user);

        $rankModel = ProfileBonamor::model()->find('user__id = :user__id', array(':user__id' => $userId));
		if(!empty($rankModel->director))
		{
			$rank = $rankModel->director->alias;
		}
		else
		{
			return;
		}
		
			
		
		$valueDirectorBonuses = array();
        $bonusesValuePerLevel = array();

        if (!empty($rank) && $rankModel->is_director_completed >= (int)TRUE)
        {
            foreach ($group as $value)
            {
                $directorModel = UsersDirectorRank::model()->findByPk($rankModel->is_director_completed);
                $diretorModelValue = ProfileDirectorBonusesPersents::model()->find('director__id = :director__id and director_level = :level', array(':director__id' => $rankModel->is_director_completed, ':level' => $value['level']));
                $valueOfDirectors = $this->getVolumeOfPersonalGroupPreviousForDirector($value['id'], TRUE);
				
				if(empty($diretorModelValue->director_value))
				{
					continue;
				}
				else
				{
					$persent = $diretorModelValue->director_value;
				}
                $bonusesValue = $valueOfDirectors / 2 * $persent / 100;
				
				$this->setDirectorBonusHistory($value['level'], $user, $value['id'], $valueOfDirectors, $bonusesValue);
				
				if(!isset($bonusesValuePerLevel[$value['level']]['amount']))
				{
					$bonusesValuePerLevel[$value['level']]['amount'] = 0;
				}
                $bonusesValuePerLevel[$value['level']]['amount'] += $bonusesValue;
            }
        }
				
        return $bonusesValuePerLevel;
    }
	
	public function setDirectorBonusHistory($position, $user, $childId, $valueOfDirectors, $bonusesValue)
	{
		if(empty($position) || empty($user) || empty($childId))
		{
			throw new CException('Не заданы параметры для сохранения истории по директорскому бонусу', E_USER_ERROR);
		}
		$child = Users::model()->findByPk($childId);
		
		$director = new ProfileDirectorBonusesHistory();
		$director->users__id = $user->id;
		$director->child__id__from = $child->id;
		$director->periode__id = $this->getPeriode()->id;
		$director->level = $position;
		if($child->profilebonamor->director instanceof UsersDirectorRank && $child->profilebonamor->director->position > (int)TRUE)
		{
			$director->rank = $child->profilebonamor->director->lang->name;
		}
		else
		{
			$director->rank = $child->profilebonamor->rank->lang->name;
		}
		$director->vpg = $valueOfDirectors;
		$director->amount = $bonusesValue;
		
		if(!$director->save())
		{
			throw new CException('Ошибка сохранения истории по директорскому бонусу', E_USER_ERROR);
		}
	}

    public function setDirectorInfinityBonusValue($userId)
    {
        if (empty($userId))
        {
            throw new CException('Не задан пользователь22', E_USER_ERROR);
        }
		
        $user = Users::model()->findByPk($userId);
		$director = UsersRank::model()->find('alias = :alias', array(':alias' => self::DIRECTOR));
		$vpg = $this->getVolumeOfPersonalGroupPreviousForDirector($userId, TRUE);
		
        if (empty($user->profilebonamor) || $user->profilebonamor->rank->position < $director->position || $vpg < 1500)
        {
            return;
        }
         $group = $this->getUserGroupForDirector($user);

        $rankModel = $user->profilebonamor;
		if(!empty($rankModel->director))
		{
			$rank = $rankModel->director->alias;
		}
		else
		{
			return;
		}
        $bonusesInfinityValue = 0;
        $groupVolume = 0;

        if (!empty($rank) && !empty($group))
        {
            $directorModel = UsersDirectorRank::model()->find('alias = :alias', array(':alias' => $rank));
            foreach ($group as $value)
            {
                $groupVolume += $this->getPersonalVolumePrevious($value['id']);
            }
            $bonusesInfinityValue = [
                'persent' => $directorModel->director_infinity,
                'amount' => $groupVolume / 2 * $directorModel->director_infinity / 100,
            ];
        }

        return $bonusesInfinityValue;
    }

    public function addBonusesDirector($userId = false)
    {
        if (empty($userId))
        {
            $users = Users::model()->findAll();
            for ($j = count($users); $j >= (int)FALSE; $j--)
            {
				if(empty($users[$j]))
				{
					continue;
				}
				
				$user = $users[$j];

                if ($user->username != 'superadmin')
                {
                    $resultAll = ProfileBonuses::model()->setDirectorBonusValue($user->id);
					
                    $cntResult = count($resultAll);
                    if (!empty($resultAll) && $user->profilebonamor->is_director_completed >= (int)TRUE)
                    {
                        for ($i = 1; $i <= $cntResult+1; $i++)
                        {
                            if (array_key_exists($i,$resultAll) && round($resultAll[$i]['amount']) > 0)
                            {
						
								$group = $this->getUserGroupForDirectorBonus($user->id);
                                $transactionBonus = ProfileBonuses::model()->setFinanceTransactionDirectorBonuses($resultAll[$i]['amount'], $i, $user->id);
                                $transactionId = $transactionBonus->getModelTransactions()->id;
                                $bonusDirector = new ProfileDirectorBonuses();
                                $bonusDirector->amount = $resultAll[$i]['amount'];
                                $bonusDirector->users__id = $user->id;
                                $bonusDirector->periode_date = date("Y.m.d");
                                $bonusDirector->level = $i;
                                $bonusDirector->transactions__id = $transactionId;
                                $bonusDirector->periode__id = $this->getPeriode()->id;
								$bonusDirector->pv = $this->getPersonalVolumePrevious($user->id);
								$bonusDirector->vpg = $this->getVolumeOfPersonalGroupPreviousForDirector($user->id, TRUE);
								$bonusDirector->directors_cnt = count($group);
								if($user->profilebonamor->director->position > (int)TRUE)
								{
									$bonusDirector->rank__id = $user->profilebonamor->director->lang->name;
								}
								else
								{
									$bonusDirector->rank__id = $user->profilebonamor->rank->lang->name;
								}
					
                                if (!$bonusDirector->save())
                                {
                                    throw new CException('Ошибка сохранения данных', E_USER_ERROR);
                                }
                                if (!ProfileBonuses::model()->updateReportFinal($bonusDirector, self::DIRECTOR_BONUS_ALIAS))
                                {
                                    throw new CException('Ошибка создания сводной таблицы11', E_USER_ERROR);
                                }
                            }
                        }
                    }
                }
            }
        }
        else
        {
            $resultAll = ProfileBonuses::model()->setDirectorBonusValue($userId);
            $cntResult = count($resultAll);
            if (!empty($resultAll))
            {
                for ($i = 1; $i < $cntResult; $i++)
                {
                    if (array_key_exists($i,$resultAll) && round($resultAll[$i]['amount']) > 0)
                    {
					
						$group = $this->getUserGroupForDirectorBonus($userId);
                        $transactionBonus = ProfileBonuses::model()->setFinanceTransactionDirectorBonuses($resultAll[$i]['amount'], $i, $userId);
                        $transactionId = $transactionBonus->getModelTransactions()->id;
                        $bonusDirector = new ProfileDirectorBonuses();
                        $bonusDirector->amount = $resultAll[$i]['amount'];
                        $bonusDirector->users__id = $userId;
                        $bonusDirector->periode_date = date("Y.m.d");
                        $bonusDirector->level = $i;
                        $bonusDirector->transactions__id = $transactionId;
                        $bonusDirector->periode__id = $this->getPeriode()->id;
						$bonusDirector->pv = $this->getPersonalVolumePrevious($user->id);
						$bonusDirector->vpg = $this->getVolumeOfPersonalGroupPreviousForDirector($user->id, TRUE);
						$bonusDirector->directors_cnt = count($group);
						$bonusDirector->rank__id = $user->profilebonamor->rank->lang->name;

                        if (!$bonusDirector->save())
                        {
                            throw new CException('Ошибка сохранения данных', E_USER_ERROR);
                        }
                        if (!ProfileBonuses::model()->updateReportFinal($bonusDirector, self::DIRECTOR_BONUS_ALIAS))
                        {
                            throw new CException('Ошибка создания сводной таблицы12', E_USER_ERROR);
                        }
                    }
                }
            }
        } //die;
		return TRUE;
    }

    public function addBonusesDirectorInfinity($userId = false)
    {
		$rankForInfinity = UsersDirectorRank::model()->find('alias = :alias', array(':alias' => UsersDirectorRank::PEARL_DIRECTOR));
        if ($userId == false)
        {
			$criteria = new CDbCriteria();
			$criteria->condition = 'username != :username';
			$criteria->params = array(':username' => 'superadmin');
			
            $users = Users::model()->findAll($criteria);
			
            for ($i = count($users); $i >(int)FALSE; $i--)
            {
				if(empty($users[$i]))
				{
					continue;
				}
				
				$user = $users[$i];
				
                if ($user->username != 'superadmin')
                {
                    $result = ProfileBonuses::model()->setDirectorInfinityBonusValue($user->id);
					
                    if (!empty($result) && $user->profilebonamor->is_director_completed >= $rankForInfinity->id)
                    {
					
                        if (round($result['amount']) > 0)
                        {
							$infinitys = ProfileDirectorInfinityBonuses::model()->findAll('periode__id = :periode__id', array(':periode__id' => $this->getPeriode()->id));
							
							foreach($infinitys as $infinity)
							{
								if($user->profile->upline == substr($infinity->user->profile->upline,0,mb_strlen($user->profile->upline)))
								{
									$result['amount'] -= $infinity->amount;
								}
							}
                            $transactionBonus = ProfileBonuses::model()->setFinanceTransactionDirectorInfinityBonuses($result['amount'], $user->id, $result['persent']);
                            $transactionId = $transactionBonus->getModelTransactions()->id;
                            $bonusDirector = new ProfileDirectorInfinityBonuses();
                            $bonusDirector->amount = $result['amount'];
                            $bonusDirector->users__id = $user->id;
                            $bonusDirector->persents = $result['persent'];
                            $bonusDirector->periode_date = date("Y.m.d");
                            $bonusDirector->transactions__id = $transactionId;
                            $bonusDirector->periode__id = $this->getPeriode()->id;

                            if (!$bonusDirector->save())
                            {
                                throw new CException('Ошибка сохранения данных', E_USER_ERROR);
                            }
                            if (!ProfileBonuses::model()->updateReportFinal($bonusDirector, self::INFINITY_BONUS_ALIAS))
                            {
                                throw new CException('Ошибка создания сводной таблицы13', E_USER_ERROR);
                            }
                        }
                    }
                }
            }
        }
        else
        {
            $result = ProfileBonuses::model()->setDirectorInfinityBonusValue($userId);
            if (!empty($result))
            {
                if (round($result['amount']) > 0)
                {
                    $transactionBonus = ProfileBonuses::model()->setFinanceTransactionDirectorInfinityBonuses($result['amount'], $userId, $result['persent']);
                    $transactionId = $transactionBonus->getModelTransactions()->id;
                    $bonusDirector = new ProfileDirectorInfinityBonuses();
                    $bonusDirector->amount = $result['amount'];
                    $bonusDirector->users__id = $userId;
                    $bonusDirector->persents = $result['persent'];
                    $bonusDirector->periode_date = date("Y.m.d");
                    $bonusDirector->transactions__id = $transactionId;
                    $bonusDirector->periode__id = $this->getPeriode()->id;

                    if (!$bonusDirector->save())
                    {
                        throw new CException('Ошибка сохранения данных', E_USER_ERROR);
                    }
                    if (!ProfileBonuses::model()->updateReportFinal($bonusDirector, self::INFINITY_BONUS_ALIAS))
                    {
                        throw new CException('Ошибка создания сводной таблицы14', E_USER_ERROR);
                    }
                }
            }
        } //die("00000");
		return TRUE;
    }

    public function setFinanceTransactionDirectorBonuses($amount, $level, $userId)
    {
        if (empty($userId))
        {
            throw new CException('Не задан пользователь23', E_USER_ERROR);
        }

        $transaction = new FinanceTransaction('system');

        $transaction->initMainCurrency();
        $transaction->setSpecificationByAlias('wallet_out_director_bonus');

        $transaction->initProperties();
        $transaction->initDebitMainWalletByObjectAndId('users', $userId);
        $transaction->initCreditWalletByObjectAndIdAndPurpose('company', 1, 'bonus_out');

        $transaction->amount = round($amount * ProfileBonuses::COEF_WALLET_OUT);

        $transaction->modelsTransactionsObjects['level']->value = $level;
        $transaction->objectsAttributes = array('level' => array(
                'alias' => 'level',
                'value' => $level,
        ));

        if ($transaction->open())
        {
            return $transaction;
        }
        else
        {
            throw new CException('Ошибка создания транзакции', E_USER_ERROR);
        }
    }

    public function setFinanceTransactionDirectorInfinityBonuses($amount, $userId, $persent)
    {
        if (empty($userId))
        {
            throw new CException('Не задан пользователь24', E_USER_ERROR);
        }

        $transaction = new FinanceTransaction('system');

        $transaction->initMainCurrency();
        $transaction->setSpecificationByAlias('wallet_out_director_infinity_bonus');

        $transaction->initProperties();
        $transaction->initDebitMainWalletByObjectAndId('users', $userId);
        $transaction->initCreditWalletByObjectAndIdAndPurpose('company', 1, 'bonus_out');

        $transaction->modelsTransactionsObjects['persent']->value = $persent;
		 $transaction->modelsTransactionsObjects['comments_money_out']->value = '';
		 $transaction->modelsTransactionsObjects['redirect_confirm_after_paymentsystem']->value = '/office/default/payresult';
        $transaction->modelsTransactionsObjects['redirect_decline_after_paymentsystem']->value = '/office/default/payresult';
        $transaction->modelsTransactionsObjects['redirect_open_after_paymentsystem']->value = '/paymentsystem/yandexmoney/pay/index';
		
        $transaction->objectsAttributes = array(
				'persent' => array('alias' => 'persent', 'value' => $persent),
				'redirect_confirm_after_paymentsystem' => array('alias' => 'redirect_confirm_after_paymentsystem', 'value' => '/office/default/payresult'),
				'redirect_decline_after_paymentsystem' => array('alias' => 'redirect_decline_after_paymentsystem', 'value' => '/office/default/payresult'),
				'redirect_open_after_paymentsystem' => array('alias' => 'redirect_open_after_paymentsystem', 'value' => '/paymentsystem/yandexmoney/pay/index'),
				'comments_money_out' => array('alias' => 'comments_money_out', 'value' => 'x'),
        );

        $transaction->amount = round($amount * ProfileBonuses::COEF_WALLET_OUT);

        if ($transaction->open())
        {
            return $transaction;
        }
        else
        {
		
            throw new CException('Ошибка создания транзакции', E_USER_ERROR);
        }
    }

	//считаем директорские ранги  (стартует при закрытие периода/расчет бонусов из админки)
	
    public function setDirectorRankToUser($dateStart, $dateEnd)
    {
        $user = Users::model()->findAll('username != :username', array(':username' => 'superadmin'));
		
        for ($i = count($user); $i >= (int)FALSE; $i--)
        {
			if(empty($user[$i]))
			{
				continue;
			}
            $userId = $user[$i]->id;
			
            if (!empty($user[$i]->profilebonamor))
            {
                if ($user[$i]->profilebonamor->rank->alias != self::DIRECTOR_BONUS_ALIAS && $user[$i]->profilebonamor->rank->alias != self::ENERGY_DIRECTOR_BONUS_ALIAS)
                {
				
				    continue;
                }
            }
            else
            { 
                continue;
            }
			
			
            $rank = ProfileBonuses::model()->setDirectorBonusRank($userId, $dateStart, $dateEnd);
			
			
			$directorRank = UsersDirectorRank::model()->find('alias = :alias', array(':alias' => $rank));
			$usersDirector = ProfileBonamor::model()->find('user__id = :user__id', array(':user__id' => $userId));
			$usersDirector->is_director_completed = (int)FALSE;
			if($directorRank instanceof UsersDirectorRank)
			{
				
				$usersDirector->is_director_completed = $directorRank->id;
			}
						
			if($usersDirector->director instanceof UsersDirectorRank)
			{
				if($directorRank instanceof UsersDirectorRank && $directorRank->position > $usersDirector->director->position)
				{
					$usersDirector->director__id = $directorRank->id;
					
					$this->setRankHistory($usersDirector, TRUE, TRUE, TRUE, TRUE);
				}
			}
			else
			{
				if($directorRank instanceof UsersDirectorRank)
				{
					$usersDirector->director__id = $directorRank->id;
					
					$this->setRankHistory($usersDirector, TRUE, TRUE, TRUE, TRUE);
				}
			}
			if($usersDirector->is_director_completed < (int)TRUE)
			{
				
				$this->setVpgForDirector($usersDirector->user);
			}
			
			
			if(!$usersDirector->validate())
			{
				throw new CException('Не удалось директорский ранг', E_USER_ERROR);
			}
			if(!$usersDirector->save())
			{
				throw new CException('Не удалось директорский ранг1', E_USER_ERROR);
			}
        } 
        return TRUE;
    }
	
	public function setVpgForDirector($user)
	{
		if(!($user instanceof Users))
		{
			 throw new CException('Не задан пользователь52', E_USER_ERROR);
		}
		$directorId = self::getDirectorUpline($user->id);
		//$vpg = $this->getVolumeOfPersonalGroupPrevious($user->id);
		$vpgRef = $this->getVolumeOfPersonalGroupPreviousForDirector($user->id);
		
		$periodeId = $this->getPeriodeCurrent()->id;
		if($directorId > (int)FALSE && $vpgRef > (int)FALSE)
		{
			$vpgModel = new ProfileDirectorVpg();
			$vpgModel->users__id = $directorId;
			$vpgModel->users__id__from = $user->id;
			$vpgModel->periode__id = $periodeId;
			$vpgModel->amount = $vpgRef;
			
			if(!$vpgModel->validate())
			{
				vg($vpgModel->getErrors());
				 throw new CException('Ошибка валидации ОЛГ для директорского бонуса', E_USER_ERROR);
			}
			if(!$vpgModel->save())
			{
				throw new CException('Ошибка сохранения ОЛГ для директорского бонуса', E_USER_ERROR);
			}
			
		}
		$vpgCurrent = ProfileDirectorVpg::model()->findAll('users__id = :users__id and periode__id = :periode__id', array(':periode__id' => $periodeId, ':users__id' => $user->id));
		if(count($vpgCurrent) > (int)FALSE)
		{
			foreach($vpgCurrent as $val)
			{
				$val->amount = (int)FALSE;
				$val->save();
			}
		}
		return TRUE;
		
	}
	
	public static function getDirectorUpline($userId)
	{
	
		if(empty($userId))
		{
			 throw new CException('Не задан пользователь53', E_USER_ERROR);
		}
	
		$profile = Profile::model()->find('user__id = :user__id', array(':user__id' => $userId));
        $parentId = $profile->sponsor__id;
		
		while (!empty($parentId))
        {
            $tokensParent = Profile::model()->find('user__id = :user__id', array(':user__id' => $parentId));
            if (!empty($tokensParent))
            {
                if ($tokensParent->user->profilebonamor->director__id > (int)FALSE)
                {
                    return $tokensParent->user__id;
                }
                $parentId = $tokensParent->sponsor__id;
            }
            else
            {
                break;
            }
        }

        return 0;
	}
	
	
	//-------------------------------------------История по бинару-------------------------------------------------------------------
	
	public function fillBinarSummury($userId, $dateBegin, $dateEnd)
	{
		$weightStepsOfBinar = $this->stepStructureBonuseCalculate($dateBegin, $dateEnd);
		$usersBonuses = UsersBonuses::model()->find('alias = :alias', array(':alias' => self::STRUCTURE_BONUS_ALIAS));
		$periodeId = $this->getPeriodeBinar()->id;
		if($userId == NULL)
		{
			$users = Users::model()->findAll('username != :username', array(':username' => 'superadmin'));
			
			foreach($users as $user)
			{
				$structureBonusModel = ProfileBonuses::model()->find('users__id = :users__id and periode__id = :periode__id and bonuses__id = :bonuses__id', 
																	array(':users__id' => $userId, ':periode__id' => $periodeId, ':bonuses__id' => $usersBonuses->id));
			
				if(empty($structureBonusModel))
				{
					$structureBonus = (int)FALSE;
				}
				else
				{
					$structureBonus = $structureBonusModel->amount;
				}
				
				$userId = $user->id;
				
				$binar = new ProfilePeriodeBinarSummury();
				$binar->users__id = $userId;
				$binar->periode__id = $periodeId;
				$binar->ll_count = MatrixTokensWrapper::model()->cntOfLeftLegTokens($userId);
				$binar->rl_count = MatrixTokensWrapper::model()->cntOfRightLegTokens($userId);
				$binar->pi_ll_total_count = MatrixTokensWrapper::model()->cntOfLeftLegTokensProfile($userId);
				$binar->pi_rl_total_count = MatrixTokensWrapper::model()->cntOfRightLegTokensProfile($userId);
				$binar->pi_ll_total_count_paid = MatrixTokensWrapper::model()->cntOfLeftLegTokensProfilePackages($userId);
				$binar->pi_rl_total_count_paid = MatrixTokensWrapper::model()->cntOfRightLegTokensProfilePackages($userId);
				$binar->steps_count = MatrixTokensWrapper::model()->cntOfStepsCurrent($userId, $dateBegin, $dateEnd);
				$binar->pi_bonus = ProfileBonuses::model()->getCurrentPISum($userId, TRUE);
				$binar->new_ll_count = MatrixTokensWrapper::model()->newUsersLeft($userId, TRUE);
				$binar->new_rl_count = MatrixTokensWrapper::model()->newUsersRight($userId, TRUE);
				$binar->pi_ll_count = MatrixTokensWrapper::model()->cntOfLeftLegTokensProfile($userId, 2);
				$binar->pi_rl_count = MatrixTokensWrapper::model()->cntOfRightLegTokensProfile($userId, 2);
				$binar->pi_ll_count_paid = MatrixTokensWrapper::model()->cntOfLeftLegTokensProfilePackages($userId, 2);
				$binar->pi_rl_count_paid = MatrixTokensWrapper::model()->cntOfRightLegTokensProfilePackages($userId, 2);
				$binar->paid_ll_count = MatrixTokensWrapper::model()->cntOfLeftLegPackages($userId, 2);
				$binar->paid_rl_count = MatrixTokensWrapper::model()->cntOfRightLegPackages($userId, 2);
				$binar->weight_step = $weightStepsOfBinar;
				
				if(self::checkForStructureBonuse($userId))
				{
					$binar->structure_bonus = round($binar->steps_count * $binar->weight_step);
				}
				else
				{
					$binar->structure_bonus = (int)FALSE;
				}
				
				
				if(!$binar->save())
				{	
					
					throw new CException('Ошибка сохранения истории по бинару', E_USER_ERROR);
				}
				
			}
			
			
		}
		else
		{
		
				$structureBonusModel = ProfileBonuses::model()->find('users__id = :users__id and periode__id = :periode__id and bonuses__id = :bonuses__id', 
																	array(':users__id' => $userId, ':periode__id' => $periodeId, ':bonuses__id' => $usersBonuses->id));
			
				if(empty($structureBonusModel))
				{
					$structureBonus = (int)FALSE;
				}
				else
				{
					$structureBonus = $structureBonusModel->amount;
				}
				
				$userId = $user->id;
				$binar = new ProfilePeriodeBinarSummury();
				$binar->users__id = $userId;
				$binar->periode__id = $periodeId;
				$binar->ll_count = MatrixTokensWrapper::model()->cntOfLeftLegTokens($userId);
				$binar->rl_count = MatrixTokensWrapper::model()->cntOfRightLegTokens($userId);
				$binar->pi_ll_total_count = MatrixTokensWrapper::model()->cntOfLeftLegTokensProfile($userId);
				$binar->pi_rl_total_count = MatrixTokensWrapper::model()->cntOfRightLegTokensProfile($userId);
				$binar->pi_ll_total_count_paid = MatrixTokensWrapper::model()->cntOfLeftLegTokensProfilePackages($userId);
				$binar->pi_rl_total_count_paid = MatrixTokensWrapper::model()->cntOfRightLegTokensProfilePackages($userId);
				$binar->steps_count = MatrixTokensWrapper::model()->cntOfStepsCurrent($userId);
				$binar->pi_bonus = ProfileBonuses::model()->getCurrentPISum($userId, TRUE);
				$binar->new_ll_count = MatrixTokensWrapper::model()->newUsersLeft($userId);
				$binar->new_rl_count = MatrixTokensWrapper::model()->newUsersRight($userId);
				$binar->pi_ll_count = MatrixTokensWrapper::model()->cntOfLeftLegTokensProfile($userId, TRUE);
				$binar->pi_rl_count = MatrixTokensWrapper::model()->cntOfRightLegTokensProfile($userId, TRUE);
				$binar->pi_ll_count_paid = MatrixTokensWrapper::model()->cntOfLeftLegTokensProfilePackages($userId, TRUE);
				$binar->pi_rl_count_paid = MatrixTokensWrapper::model()->cntOfRightLegTokensProfilePackages($userId, TRUE);
				$binar->paid_ll_count = MatrixTokensWrapper::model()->cntOfLeftLegPackages($userId);
				$binar->paid_rl_count = MatrixTokensWrapper::model()->cntOfRightLegPackages($userId);
				$binar->weight_step = $weightStepsOfBinar;
				
				if(self::checkForStructureBonuse($userId))
				{
					$binar->structure_bonus = round($binar->steps_count * $binar->weight_step);
				}
				else
				{
					$binar->structure_bonus = (int)FALSE;
				}
				
				if(!$binar->save())
				{
					throw new CException('Ошибка сохранения истории по бинару', E_USER_ERROR);
				}
			
		}
	}
	
	public static function getCountActiveCurrent($user)
	{
		if(empty($user) || !($user instanceof Users))
		{
			 throw new CException('Не задан пользователь113', E_USER_ERROR);
		}
		
		$count = (int)FALSE;
		
		$criteria = new CDbCriteria();
		$criteria->condition = 'upline LIKE :upline';
		$criteria->params = array(':upline' => $user->profile->upline . '.%');
		
		$structures = Profile::model()->findAll($criteria);
				
		foreach($structures as $structure)
		{
			$userPV = ProfileBonuses::model()->getPersonalVolume($structure->user__id);
			if($userPV >= self::LINEAR_BONUS_MIN_PV && ((int)$structure->tree_level - (int)$user->profile->tree_level == (int)TRUE))
			{
				$count++;
			}
		}
		 
		 return $count;
	}
	
	public static function getCountActivePrevious($user)
	{
		if(empty($user) || !($user instanceof Users))
		{
			 throw new CException('Не задан пользователь113', E_USER_ERROR);
		}
		
		$count = (int)FALSE;
		
		$criteria = new CDbCriteria();
		$criteria->condition = 'upline LIKE :upline';
		$criteria->params = array(':upline' => $user->profile->upline . '.%');
		
		$structures = Profile::model()->findAll($criteria);
				
		foreach($structures as $structure)
		{
			$userPV = ProfileBonuses::model()->getPersonalVolumePrevious($structure->user__id);
			if($userPV >= self::LINEAR_BONUS_MIN_PV && ((int)$structure->tree_level - (int)$user->profile->tree_level == (int)TRUE))
			{
				$count++;
			}
		}
		 
		 return $count;
	}
	

}
