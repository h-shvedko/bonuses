<?php

class Bonuses
{

    const CLIENT_COMPANY = 'client_company';
    const VIP_CLIENT_COMPANY = 'vip_client_company';
    const PARTNER_COMPANY = 'partner_company';
    const ENERGY_SPONSOR_VALUE_GROUP = 250;
    const ENERGY_MANGER_VALUE_GROUP = 500;
    const NOT_ACTIVE_USER = 'UserNotActive';

    private $_financeTransaction;
    private $_i = 0;

    public function initFinanceTransaction($financeTransaction)
    {
        $this->_financeTransaction = $financeTransaction;
    }

    public function init()
    {
        parent::init();
        Yii::import('application.modules.office.models.*');
        Yii::import('application.modules.admin.modules.matrix.models.*');
        Yii::import('application.modules.admin.modules.user.models.*');
    }

    public static function model($className = __CLASS__)
    {
        Yii::import('application.modules.office.models.*');
        return parent::model($className);
    }

    public function getParameters()
    {
        if ($this->_financeTransaction == NULL)
        {
            throw new CException('Свойство transaction не инициализировано!', E_USER_ERROR);
        }

        $objectTransaction = $this->_financeTransaction->modelsTransactionsObjects;
        $transactions = $this->_financeTransaction->getModelTransactions();
        $transactValue = $this->_financeTransaction;
        if ($transactions == NULL)
        {
            throw new CException('Экземпляр объекта transaction не найден!', E_USER_ERROR);
        }
        $userId = $transactions->credit_object_alias == 'users' ? $transactions->credit_object_id : (int) FALSE;
        $user = Users::model()->findByPk($userId);
        $periode = ProfilePeriode::model()->find('date_end is NULL');
        $periodeBinar = ProfilePeriodeBinar::model()->find('date_end is NULL');

        return array($transactions, $userId, $user, $objectTransaction, $transactValue, $periode, $periodeBinar);
    }

//-------------------------Бонусы Бинара----------------------------------------

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

    public function addBonusesPersonalInvated() //Бонус 10% за лично приглашенного
    {
        Yii::import('application.modules.office.models.*');
        $result = ProfileBonuses::model()->checkFirstRegisterPay($this->_financeTransaction);
        if (!$result)
        {
            return;
        }
        list($transactions, $userId, $user, $objectTransaction, $transactValue, $periode, $periodeBinar) = $this->getParameters();
		
		$activity = ProfileBonuses::checkActivity($user->profile->sponsor__id);
		
		if(empty($activity))
		{
			return;
		}
		else
		{
			$dateend = ProfileBonuses::checkActivity($user->profile->sponsor__id)->date_end;
			if($dateend < app_date("Y-m-d"))
			{
				return;
			}
		}
        $amount = $transactions->amount * UsersBonuses::LP_BONUS_VALUE;

        $bonusPI = new ProfileBonuses();
        $bonusType = UsersBonuses::model()->find('alias = :alias', array(':alias' => UsersBonuses::LP_BONUS));
        $bonusPI->bonuses__id = $bonusType->id;
        $bonusPI->users__id = $user->profile->sponsor__id;
        $bonusPI->sponsor__id = $user->id;
       
		$amountSponsor = (int)ProfileBonuses::model()->getBinarAmountForUserPersonal($user->profile->sponsor__id);
		if(($amountSponsor + (int)$amount) > ProfileBonuses::BINAR_STOP || $amountSponsor > ProfileBonuses::BINAR_STOP)
		{
			$amount = ProfileBonuses::BINAR_STOP - $amountSponsor;
			if($amount < 0)
			{
				$amount = (int) FALSE;
			}
		}
		
        $bonusPI->amount_from = $transactions->amount;
        $bonusPI->amount = round($amount);
        $bonusPI->date_periode = app_date("Y-m-d H:i:s");
        $bonusPI->periode__id = $periodeBinar->id;

        if ($bonusPI->validate())
        {
            if (!$bonusPI->save())
            {
                throw new CException('Не создан бонус за приглашенного', E_USER_ERROR);
            }
			if($amount > (int) FALSE)
			{
				$transact = $this->setFinanceTransactionPrivateInvited($bonusPI);
				$bonusPI->transactions__id = $transact->getModelTransactions()->id;
				if (!$bonusPI->save())
				{
					throw new CException('Не создан бонус за приглашенного', E_USER_ERROR);
				}
			}
            if (!ProfileBonuses::model()->updateReportFinalBinar($bonusPI, ProfileBonuses::PRIVATE_INVITED_ALIAS))
            {
                throw new CException('Ошибка создания сводной таблицы1', E_USER_ERROR);
            }
        }
    }
	
		//метод устанавливает активность пользователя и наставника

    public function setActivity() 
    {
        Yii::import('application.modules.office.models.*');
        Yii::import('application.modules.register.models.*');

        list($transactions, $userId, $user) = $this->getParameters();
        $bonus = ProfileBonuses::model()->find('transactions__id = :transactions__id', array('transactions__id' => $transactions->id));
		
		$result = ProfileBonuses::model()->checkFirstRegisterPay($this->_financeTransaction);

		if($user->profilebonamor->options->alias == ProfileBonuses::CLIENT_COMPANY && !$result)
		{
			return;
		}
		

        //активность в бинаре при покупке регистрационного пакета
       
	   if((app_date("m")+2) <= 12)
		{
			$dateUserActivity = strtotime(app_date("Y")."-".(app_date("m")+2)."-01");
		}
		else
		{
			$dateUserActivity = strtotime((app_date("Y")+1)."-".(app_date("m")+2 - 12)."-01");
		}
        
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

        $activityUser = new ProfileActivity();
        $activityUser->user__id = $userId;
        $activityUser->date_begin = app_date("Y-m-d H:i:s");
        $activityUser->date_end = app_date("Y-m-d H:i:s", $dateUserActivity);

        if (!$activityUser->save())
        {
            throw new CException('Не удалось обновить активность пользователя', E_USER_ERROR);
        }

		$sponsorId= $user->profile->sponsor__id;
		$profileBonamorSponsor = ProfileBonamor::model()->find('user__id = :user__id', array(':user__id' => $sponsorId));
		
		if(empty($profileBonamorSponsor))
		{
			return;
		}
		elseif($profileBonamorSponsor->options->alias == ProfileBonuses::CLIENT_COMPANY)
		{
			return;
		}
		
        $activitySponsor = new ProfileActivity();

        $activitySponsor->user__id = $sponsorId;
        $activitySponsor->date_begin = app_date("Y-m-d H:i:s");
        $activitySponsor->date_end = app_date("Y-m-d H:i:s", $dataSponsorActivity);

        if (!$activitySponsor->save())
        {
            throw new CException('Не удалось обновить активность наставника', E_USER_ERROR);
        }
        return true;
    }

    public function setFinanceTransactionPrivateInvited($amount)
    {
        Yii::import('application.modules.office.models.*');
		list($transactions, $userId, $user, $objectTransaction) = $this->getParameters();
        if (!ProfileBonuses::model()->checkFirstRegisterPay($this->_financeTransaction))
        {
            return;
        }
        if ($this->_financeTransaction == NULL)
        {
            throw new CException('Свойство transaction не инициализировано!', E_USER_ERROR);
        }

        if ($transactions == NULL)
        {
            throw new CException('Экземпляр объекта transaction не найден!', E_USER_ERROR);
        }
        
        $transaction = new FinanceTransaction('system');

        $profile = Profile::model()->find('user__id = :user_id', array(':user_id' => $userId));
        $transaction->initMainCurrency();
        $transaction->setSpecificationByAlias('wallet_out_bonus_private_invited');

        $transaction->initProperties();
        $transaction->initDebitMainWalletByObjectAndId('users', $profile->sponsor__id);
        $transaction->initCreditWalletByObjectAndIdAndPurpose('company', 1, 'bonus_out');

        $transaction->amount = $amount->amount;
		
		$horders_id = array_key_exists('horders__id', $objectTransaction) ? $objectTransaction['horders__id'] : '';
		
        $transaction->modelsTransactionsObjects['redirect_confirm_after_paymentsystem']->value = '/office/default/payresult';
        $transaction->modelsTransactionsObjects['redirect_decline_after_paymentsystem']->value = '/office/default/payresult';
        $transaction->modelsTransactionsObjects['redirect_open_after_paymentsystem']->value = '/paymentsystem/yandexmoney/pay/index';
		//$transaction->modelsTransactionsObjects['horders__id']->value = $horders_id->value;

        $transaction->objectsAttributes = array(
            'redirect_confirm_after_paymentsystem' => array('alias' => 'redirect_confirm_after_paymentsystem', 'value' => '/office/default/payresult'),
            'redirect_decline_after_paymentsystem' => array('alias' => 'redirect_decline_after_paymentsystem', 'value' => '/office/default/payresult'),
            'redirect_open_after_paymentsystem' => array('alias' => 'redirect_open_after_paymentsystem', 'value' => '/paymentsystem/yandexmoney/pay/index'),
			//'horders__id' => array('alias' => 'horders__id', 'value' => $horders_id->value),
        );

        if (!$transaction->open())
        {		
            throw new CException('Не создана транзакция для бонуса за личное приглашение', E_USER_ERROR);
        }
		
		$transactionAuto = new FinanceTransaction('admin');
		$transactionAuto->initAllByTransactionId($transaction->getModelTransactions()->id);
			
		if (!$transactionAuto->confirmAdmin())
		{
			throw new CHttpException(403, Yii::t('app', 'Ошибка автоматического подтверждения финоперации (бонус за личное приглашение)'));
		}
		return $transaction;
    }
	
//--------------------------------подсчет шага в бинаре-------------------------------------------------------------

	public function setStep()
	{
		list($transactions, $userId, $user, $objectTransaction) = $this->getParameters();
		
		$tokenParentId = $user->matrix_tokens[0]->parent_id;
		$rank = $user->matrix_tokens[0]->rank;
		
		while($tokenParentId != (int)FALSE)
		{
			$parentToken = MatrixTokens::model()->findByPk($tokenParentId);
			$right = MatrixTokensWrapper::listOfRightLegPackages($parentToken);
			$left = MatrixTokensWrapper::listOfLeftLegPackages($parentToken);
			
			$cntLeft = count($left);
			$cntRight = count($right);
			$periode = ProfileBonuses::model()->getPeriodeBinar();
			
			if($cntLeft != $cntRight)
			{
				if($rank == (int)TRUE && $cntLeft < $cntRight)
				{
					$stepBinar = ProfileStep::model()->find('users__id = :users__id and periode__id = :periode__id', array(':users__id' => $parentToken->users__id, ':periode__id' => $periode->id));
					if(empty($stepBinar))
					{
						$stepBinar = new ProfileStep();
						$stepBinar->users__id = $parentToken->users__id;
						$stepBinar->step = (int)TRUE;
						$stepBinar->periode__id = $periode->id;
						$stepBinar->save();
					}
					else
					{
						$stepBinar->step += (int)TRUE;
						$stepBinar->save();
					}
				}
				elseif($rank == 2 && $cntLeft > $cntRight)
				{
					$stepBinar = ProfileStep::model()->find('users__id = :users__id and periode__id = :periode__id', array(':users__id' => $parentToken->users__id, ':periode__id' => $periode->id));
					if(empty($stepBinar))
					{
						$stepBinar = new ProfileStep();
						$stepBinar->users__id = $parentToken->users__id;
						$stepBinar->step = (int)TRUE;
						$stepBinar->periode__id = $periode->id;
						$stepBinar->save();
					}
					else
					{
						$stepBinar->step += (int)TRUE;
						$stepBinar->save();
					}
				}
			}
			$tokenParentId = $parentToken->parent__id;
			$rank = $tokenParentId->rank;
		}
	}

//-------------------------Бонусы сетевой структуры-------------------------------------------------------------------
    public function getStartPeriodeMLM()
    {
        $start = strtotime("First day of previous month");
        return strftime('%Y-%m-%d', $start);
    }

    public function getEndPeriodeMLM()
    {
        $end = strtotime("last day of previous month");
        return strftime('%Y-%m-%d', $end);
    }

    public function getUserGroup($userId)
    {
        Yii::import('application.modules.admin.modules.matrix.models.*');
        if (empty($userId))
        {
            throw new CException('Не задан пользовательb2', E_USER_ERROR);
        }
        $valueToken = MatrixTokens::model()->findAll();
        $stepToken = array();
        $lenUpline = strpos($valueToken[1]->upline, '.');
        $startPosition = $lenUpline + 1;
        $cnt = count($valueToken);
        $model = MatrixTokens::model()->find('users__id = :users__id', array(':users__id' => $userId));
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
            throw new CException('Не задан пользовательb3', E_USER_ERROR);
        }
		$group = $this->getUserGroupByUpline($userId);
		$rankUser = ProfileBonamor::model()->find('user__id = :user__id', array(':user__id' => $userId));
		$groupCompression = array();
		foreach($group as $value)
		{
			if($value->users->profilebonamor->rank->position < $rankUser->rank->position)
			{
				$groupCompression[] = $value->users__id;
			}
		}
	
        return $groupCompression;
    }
	
	public function getUserGroupByUpline($userId)
	{
		if (empty($userId))
        {
            throw new CException('Не задан пользовательb4', E_USER_ERROR);
        }
		$profile = Profile::model()->find('user__id = :user__id', array(':user__id' => $userId));
		
		$profileGroup = Profile::model()->findAll('upline like "%'.substr($profile->upline, -8).'%" ');
		
		return $profileGroup;
	}
	
//----------------------Личный объем----------------------------------------------------------------------

    public function createPersonalVolume($userId)
    {
        if (empty($userId))
        {
            throw new CException('Не задан пользовательb5', E_USER_ERROR);
        }
        $totalPointsUser = $this->setPersonalVolume();
        $userPVExist = ProfileBonamorPv::model()->findAll('users__id = :users__id and date_end is NULL', array(':users__id' => $userId));
        if (!empty($userPVExist))
        {
            throw new CException('Не удалось создать личный объем пользователю, т.к. уже существует', E_USER_ERROR);
        }
        $dateStart = ProfilePeriode::model()->find('date_end is null');
        $userPV = new ProfileBonamorPv();
        $userPV->users__id = $userId;
        $userPV->value = $totalPointsUser;
        $userPV->periode = app_date("Y-m-d");
        $userPV->date_start = $dateStart->date_begin;
        if (!$userPV->validate())
        {
            throw new CException('Не удалось создать личный объем пользователю', E_USER_ERROR);
        }
        if (!$userPV->save())
        {
            throw new CException('Не удалось создать личный объем пользователю', E_USER_ERROR);
        }
        return true;
    }

    public function updatePersonalVolume()
    {
        list($transaction, $userId, $user, $objectTransaction) = $this->getParameters();
        $horders_id = array_key_exists('horders__id', $objectTransaction) ? $objectTransaction['horders__id'] : '';
        $horder = Horders::model()->findByPk($horders_id->value);
        $totalPointsUser = $horder->total_points;
        
        if ($totalPointsUser > 0)
        {
            if ($user->profilebonamor->options->alias == UsersOptions::CLIENT_COMPANY && $user->username!='admin')
            {
                $userId = ProfileBonuses::model()->getUplineNotClientCompany($userId);
            }

            $userPVMaxPeriode = ProfileBonamorPv::model()->find('users__id = :users__id and date_end is NULL', array(':users__id' => $userId));
            if (empty($userPVMaxPeriode))
            {
                if ($this->createPersonalVolume($userId))
                {
                    return;
                }
            }
            $userPVMaxPeriode->value += $totalPointsUser;
            $userPVMaxPeriode->periode = app_date("Y-m-d");

            if (!$userPVMaxPeriode->validate())
            {
                throw new CException('Не удалось обновить личный объем', E_USER_ERROR);
            }
            if (!$userPVMaxPeriode->save())
            {
                throw new CException('Не удалось обновить личный объем', E_USER_ERROR);
            }
            $userPVHistory = new ProfileBonamorPvHistory();
            $userPVHistory->attributes = $userPVMaxPeriode->attributes;

            if (!$userPVHistory->save())
            {
                throw new CException('Не удалось обновить историю личного объема', E_USER_ERROR);
            }
        }
        else
        {
            return FALSE;
        }
    }

    public function setPersonalVolume($userId = FALSE)
    {
        list($transaction, $userId, $user, $objectTransaction) = $this->getParameters();
        $totalPointsUser = 0;
        if (empty($userId))
        {
            throw new CException('Не задан пользовательb6', E_USER_ERROR);
        }
        $horders_id = array_key_exists('horders__id', $objectTransaction) ? $objectTransaction['horders__id'] : '';
        $horder = Horders::model()->findByPk($horders_id->value);
        $totalPointsUser = $horder->total_points;

        return $totalPointsUser;
    }

    public function getPersonalVolume($userId)
    {
        if (empty($userId))
        {
            throw new CException('Не задан пользовательb7', E_USER_ERROR);
        }

        $userPVMaxPeriode = ProfileBonamorPv::model()->find('users__id = :users__id  and date_end is NULL', array(':users__id' => $userId));
        if (isset($userPVMaxPeriode))
        {
            return $userPVMaxPeriode->value;
        }
        else
        {
            return false;
        }
    }

//--------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------Накопленный групповой объем-------------------------------------------------------------------------------------------

    public function createAccumulatedGroupVolume($userId, $personalVolume, $flag = FALSE)
    {
        if (empty($userId))
        {
            throw new CException('Не задан пользовательb8', E_USER_ERROR);
        }

        $userAGVExist = ProfileBonamorAgv::model()->findAll('users__id = :users__id', array(':users__id' => $userId));
        if (!empty($userAGVExist))
        {
            throw new CException('Не удалось создать накопленны групповой объем пользователю, т.к. уже существует', E_USER_ERROR);
        }

        $userAGV = new ProfileBonamorAgv();
        $userAGV->users__id = $userId;
        $userAGV->value = $personalVolume;
        $userAGV->periode = app_date("Y-m-d");
        $userAGV->total_value = $personalVolume;
					
        if (!$userAGV->validate())
        {
            throw new CException('Не удалось обновить ранг пользователю', E_USER_ERROR);
        }
        if (!$userAGV->save())
        {
            throw new CException('Не удалось обновить ранг пользователю', E_USER_ERROR);
        }
		
		$userAGVHistory = new ProfileBonamorAgvHistory();
		$userAGVHistory->attributes = $userAGV->attributes;
		if (!$userAGVHistory->save())
		{
			throw new CException('Не удалось обновить историю накопленного группового объема', E_USER_ERROR);
		}
		
		if($flag != TRUE)
		{
			$this->updateAccumulatedGroupVolumeForParent($userId, $personalVolume);
		}
        return true;
    }

    public function updateAccumulatedGroupVolume($userIn = FALSE)
    {
        list($transaction, $userId, $user, $objectTransaction) = $this->getParameters();
        $horders_id = array_key_exists('horders__id', $objectTransaction) ? $objectTransaction['horders__id'] : '';
        $horder = Horders::model()->findByPk($horders_id->value);
        $totalPointsUser = $horder->total_points;
        if ($userIn != FALSE)
        {
            $userId = $userIn;
            $user = Users::model()->findByPk($userId);
        }
        if ($totalPointsUser > 0)
        {
            if ($user->profilebonamor->options->alias == UsersOptions::CLIENT_COMPANY  && $user->username!='admin')
            {
                $userId = ProfileBonuses::model()->getUplineNotClientCompany($userId);
            }

            $userAGVMaxPeriode = ProfileBonamorAgv::model()->find('users__id = :users__id', array(':users__id' => $userId));

            if (!empty($userAGVMaxPeriode))
            {
                $userAGVMaxPeriode->value += $totalPointsUser;
                $userAGVMaxPeriode->periode = app_date("Y-m-d");
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
            }
            else
            {
                $this->createAccumulatedGroupVolume($userId, $totalPointsUser);
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

                if (!empty($userAGVMaxPeriode))
                {
                    $userAGVMaxPeriode->value += $totalPointsUser;
                    $userAGVMaxPeriode->periode = app_date("Y-m-d");
					
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
                else
                {
                    $this->createAccumulatedGroupVolume($parent, $amount, TRUE);
                }
            }
        }
    }

    public function getAccumulatedGroupVolume($userId)
    {
        if (empty($userId))
        {
            throw new CException('Не задан пользовательb9', E_USER_ERROR);
        }

        $userAGVMaxPeriode = ProfileBonamorPv::model()->find('users__id = :users__id', array(':users__id' => $userId));

        if (isset($userAGVMaxPeriode))
        {
            return $userAGVMaxPeriode->value;
        }
        else
        {
            return false;
        }
    }

    public function setAccumulatedGroupVolume($userId)
    {
        if (empty($userId))
        {
            throw new CException('Не задан пользовательb10', E_USER_ERROR);
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

//--------------------------------------------------------------------------------------------------------------------------------------------------
//----------------------------Объем личной группы-------------------------------------------------------------------------------------------   

    public function createVolumeOfPersonalGroup($userId, $totalPointsUser)
    {
        if (empty($userId))
        {
            throw new CException('Не задан пользовательb11', E_USER_ERROR);
        }
        $dateStart = ProfilePeriode::model()->find('date_end is null');
        $userVPG = new ProfileBonamorVpg();
        $userVPG->users__id = $userId;
        $userVPG->value = $totalPointsUser;
        $userVPG->periode = app_date("Y-m-d");
        $userVPG->date_start = $dateStart->date_begin;

        if (!$userVPG->validate())
        {
            throw new CException('Не удалось создать "Объем личной группы" ', E_USER_ERROR);
        }
        if (!$userVPG->save())
        {
            throw new CException('Не удалось создать "Объем личной группы" ', E_USER_ERROR);
        }
        $this->updateVolumeOfPersonalGroupForParent($userId, $totalPointsUser);
        return true;
    }

    public function updateVolumeOfPersonalGroup($userIn = FALSE)
    {
        list($transaction, $userId, $user, $objectTransaction) = $this->getParameters();
        $horders_id = array_key_exists('horders__id', $objectTransaction) ? $objectTransaction['horders__id'] : '';
        $horder = Horders::model()->findByPk($horders_id->value);
        $totalPointsUser = $horder->total_points;

        if ($userIn != FALSE)
        {
            $userId = $userIn;
            $user = Users::model()->findByPk($userId);
        }

        if ($totalPointsUser > 0)
        {
            if ($user->profilebonamor->options->alias == UsersOptions::CLIENT_COMPANY  && $user->username!='admin')
            {
                 $this->updateVolumeOfPersonalGroupForParent($userId, $totalPointsUser);
				 return true;
            }

            $userVPGMaxPeriode = ProfileBonamorVpg::model()->find('users__id = :users__id and date_end is NULL', array(':users__id' => $userId));

            if (!empty($userVPGMaxPeriode))
            {
                $userVPGMaxPeriode->value += $totalPointsUser;
                $userVPGMaxPeriode->periode = app_date("Y-m-d");
                if (!$userVPGMaxPeriode->validate())
                {
                    throw new CException('Не удалось обновить личный групповой объем', E_USER_ERROR);
                }
                if (!$userVPGMaxPeriode->save())
                {
                    throw new CException('Не удалось обновить личный групповой объем', E_USER_ERROR);
                }

                $userVPGHistory = new ProfileBonamorVpgHistory();
                $userVPGHistory->attributes = $userVPGMaxPeriode->attributes;

                if (!$userVPGHistory->save())
                {
                    throw new CException('Не удалось обновить историю личного группового объема', E_USER_ERROR);
                }

                $this->updateVolumeOfPersonalGroupForParent($userId, $totalPointsUser);
            }
            else
            {
                $this->createVolumeOfPersonalGroup($userId, $totalPointsUser);
            }
            return true;
        }
        else
        {
            return FALSE;
        }
    }

    public function updateVolumeOfPersonalGroupForParent($userId, $amount)
    {
        if (empty($userId) || empty($amount))
        {
            return FALSE;
        }
        $user = Users::model()->findByPk($userId);

        $totalPointsUser = $amount;
        $uplineParents = ProfileBonuses::model()->getUplineParentsForVPG($userId);

        if ($totalPointsUser > 0 && !empty($uplineParents))
        {
            foreach ($uplineParents as $parent)
            {
                $userVPGMaxPeriode = ProfileBonamorVpg::model()->find('users__id = :users__id and date_end is NULL', array(':users__id' => $parent));

                if (empty($userVPGMaxPeriode))
                {
                    $this->createVolumeOfPersonalGroup($parent, $amount);
                    return;
                }
                else
                {
                    $userVPGMaxPeriode->value += $totalPointsUser;
                    $userVPGMaxPeriode->periode = app_date("Y-m-d");

                    if (!$userVPGMaxPeriode->validate())
                    {
                        throw new CException('Не удалось обновить личный групповой объем', E_USER_ERROR);
                    }
                    if (!$userVPGMaxPeriode->save())
                    {
                        throw new CException('Не удалось обновить личный групповой объем', E_USER_ERROR);
                    }
                    $userVPGHistory = new ProfileBonamorVpgHistory();
                    $userVPGHistory->attributes = $userVPGMaxPeriode->attributes;

                    if (!$userVPGHistory->save())
                    {
                        throw new CException('Не удалось обновить историю личного группового объема', E_USER_ERROR);
                    }
                }
            }
        }
    }

    public function getVolumeOfPersonalGroup($userId)
    {
        if (empty($userId))
        {
            throw new CException('Не задан пользовательb12', E_USER_ERROR);
        }
        $userVPGMaxPeriode = ProfileBonamorVpg::model()->find('users__id = :users__id and date_end is NULL', array(':users__id' => $userId));

        if (isset($userVPGMaxPeriode))
        {
            return $userVPGMaxPeriode->value;
        }
        else
        {
            return false;
        }
    }

    public function setVolumeOfPersonalGroup($userId)
    {
        if (empty($userId))
        {
            throw new CException('Не задан пользовательb13', E_USER_ERROR);
        }
        $stepToken = $this->getUserGroupCompression($userId);
        if (!empty($stepToken))
        {
            $hordersUsers = 0;
            foreach ($stepToken as $value)
            {
                $hordersUsers += ProfileBonuses::model()->getGroupValue($value);
            }
            return $hordersUsers;
        }
        else
        {
            return 0;
        }
    }

//--------------------------------------------------------------------------------------------------------------------------------------------------


	// ---------------- обновление роли для клиента компании (стартует вло время оплаты из магазина)--------------------------------
	
    public function updateRoles()
    {
        Yii::import('application.modules.office.models.*');
        Yii::import('application.modules.admin.modules.user.models.*');
		list($transactionss, $userId, $user, $objectTransaction) = $this->getParameters();
        $user = Users::model()->find('id = :id', array(':id' => $userId));
        $transaction = $this->_financeTransaction->getModelTransactions();

        if (ProfileBonuses::model()->checkFirstRegisterPay($this->_financeTransaction))
        {

            if (!ProfileBonuses::model()->_updateRoles($transaction))
            {
                throw new CHttpException('400', 'Ошибочный запрос, не удалось обновить статус пользователя.');
            }

            Yii::import('application.modules.admin.modules.matrix.models.*');
/*            if (!MatrixTokensWrapper::model()->tokenUpdateReservWrapper($user, $transaction))
            {
                throw new CHttpException('400', 'Ошибочный запрос, не удалось обновить статус ячейки в бинаре.');
            }*/
        }
    }

	public function setPeriodeBizOptions($userId)
    {
		if (empty($userId))
        {
            throw new CException('Не задан пользовательb1', E_USER_ERROR);
        }
		$criteria = new CDBCriteria();
		$criteria->select = 'max(date_update) as date_update';
		$criteria->condition = 'user__id = :user__id and amount_vcc = :amount_vcc';
		$criteria->params = array(':user__id' => $userId, ':amount_vcc' => (int) FALSE);		
		
		$bonamorHistoryAmountVcc = ProfileBonamorHistory::model()->find($criteria);
			
		$dateCreate = $bonamorHistoryAmountVcc->date_update;
				
		$datePeriod = strtotime($dateCreate);
		
		return $datePeriod;
	}
	
	//--------------обновление бизнес-опции для пользователя (стартует вло время оплаты из магазина)--------------------------------
	
    public function setBizOptionsToUser()
    {
        list($transactions, $userId, $user, $objectTransaction, $transactValue) = $this->getParameters();

        $dateStart = $this->getStartPeriodeMLM();
        $dateEnd = $this->getEndPeriodeMLM();

        $optionCC = UsersOptions::model()->find('alias = :alias', array(':alias' => self::CLIENT_COMPANY));
        $optionVIP = UsersOptions::model()->find('alias = :alias', array(':alias' => self::VIP_CLIENT_COMPANY));
        $optionPC = UsersOptions::model()->find('alias = :alias', array(':alias' => self::PARTNER_COMPANY));
        Yii::import('application.modules.register.models.*');
        $optionsUser = ProfileBonamor::model()->find('user__id = :user__id', array(':user__id' => $user->id));
		
		$criteria = new CDBCriteria();
		$criteria->select = 'max(date_update) as date_update, amount_vcc';
		$criteria->condition = 'user__id = :user__id and amount_vcc > :amount_vcc';
		$criteria->params = array(':user__id' => $userId, ':amount_vcc' => (int) TRUE);		
		
		$bonamorHistoryAmountVcc = ProfileBonamorHistory::model()->find($criteria);
		$bonamorHistory = new ProfileBonamorHistory();
		
        $horders_id = array_key_exists('horders__id', $objectTransaction) ? $objectTransaction['horders__id'] : '';
        $horder = Horders::model()->findByPk($horders_id->value);
		$totalPointsUser = $horder->total_points;
        $amount_vcc = (int) TRUE;
	
        if ($optionsUser->options__id == $optionPC->id)
        {	
			$activity = ProfileBonuses::checkBizOptions($userId);
			
            if ($this->getPersonalVolume($userId) < $optionPC->points && $activity->date_update <= app_date("Y-m-d H:m:i"))
            {
                $optionsUser->options__id = $optionVIP->id;
				$bonamorHistory->amount_vcc = -$amount_vcc;
                if (!$optionsUser->validate())
                {
                    throw new CException('Не удалось обновить бизнес-опцию для VIP пользователя', E_USER_ERROR);
                }
                if (!$optionsUser->save())
                {
                    throw new CException('Не удалось обновить бизнес-опцию для VIP пользователя', E_USER_ERROR);
                }
            }
			if($this->getPersonalVolume($userId) >= $optionPC->points)
			{
				$bonamorHistory->amount_vcc = (int) FALSE;
				$bonamorHistory->date_update = app_date("Y-m-d 23:59:58",ProfileBonuses::getDate((int)TRUE));
			}
        }
		
		$amountVIP = (int)FALSE;
		
		if(!empty($bonamorHistoryAmountVcc) && $bonamorHistoryAmountVcc->amount_vcc > (int) FALSE)
		{
			$amountVIP = $bonamorHistoryAmountVcc->amount_vcc;
		}
		
        if ($optionsUser->options__id == $optionVIP->id)
        {
            if (($this->getPersonalVolume($userId)) >= $optionPC->points)
            {
                $optionsUser->options__id = $optionPC->id;
				$bonamorHistory->amount_vcc = (int) FALSE;
				$bonamorHistory->date_update = app_date("Y-m-d 23:59:58",ProfileBonuses::getDate((int)TRUE));
				
                if (!$optionsUser->validate())
                {
                    throw new CException('Не удалось обновить бизнес-опцию для VIP пользователя', E_USER_ERROR);
                }
                if (!$optionsUser->save())
                {
                    throw new CException('Не удалось обновить бизнес-опцию для VIP пользователя', E_USER_ERROR);
                }
            }
        }

        if ($optionsUser->options__id == $optionCC->id)
        {  
                if (ProfileBonuses::model()->checkFirstRegisterPay($this->_financeTransaction))
                {
			
					$optionsUser->options__id = $optionVIP->id;
					$bonamorHistory->amount_vcc = $amount_vcc;
					if (!$optionsUser->validate())
					{
						throw new CException('Не удалось обновить бизнес-опцию для пользователя', E_USER_ERROR);
					}
					if (!$optionsUser->save())
					{
						throw new CException('Не удалось обновить бизнес-опцию для пользователя', E_USER_ERROR);
					}
                }
            
			
        }
		$bonamorHistory->attributes = $optionsUser->attributes;
		
		if($bonamorHistory->validate())
		{
			if(!$bonamorHistory->save())
			{
				throw new CException('Не удалось обновить историю для бизнес-опций пользователя', E_USER_ERROR);
			}
		}
		$this->setBizOptionsToParentUser($userId, $totalPointsUser);
    }
	
	//--------------обновление бизнес-опции для вышестоящего пользователя (стартует вло время оплаты из магазина)--------------------------------
	
	public function setBizOptionsToParentUser($userId, $totalPointsUser)
    {
		$sponsors = ProfileBonuses::model()->getUplineParentsForVPG($userId);
	
		foreach($sponsors as $userId)
		{
			$optionsUser = ProfileBonamor::model()->find('user__id = :user__id', array(':user__id' => $userId));

			$optionCC = UsersOptions::model()->find('alias = :alias', array(':alias' => self::CLIENT_COMPANY));
			$optionVIP = UsersOptions::model()->find('alias = :alias', array(':alias' => self::VIP_CLIENT_COMPANY));
			$optionPC = UsersOptions::model()->find('alias = :alias', array(':alias' => self::PARTNER_COMPANY));
			Yii::import('application.modules.register.models.*');
			
			$criteria = new CDBCriteria();
			$criteria->select = 'max(date_update) as date_update, amount_vcc';
			$criteria->condition = 'user__id = :user__id and amount_vcc > :amount_vcc';
			$criteria->params = array(':user__id' => $userId, ':amount_vcc' => (int) FALSE);		
			
			$bonamorHistoryAmountVcc = ProfileBonamorHistory::model()->find($criteria);
			$bonamorHistory = new ProfileBonamorHistory();
			 if ($optionsUser->options__id == $optionPC->id)
			{
				$activity = ProfileBonuses::checkBizOptions($userId);
				if ($this->getPersonalVolume($userId) < $optionPC->points && $activity->date_update <= app_date("Y-m-d H:m:i"))
				{
				
					$optionsUser->options__id = $optionVIP->id;
					$bonamorHistory->amount_vcc = -$totalPointsUser;
					if (!$optionsUser->validate())
					{
						throw new CException('Не удалось обновить бизнес-опцию для VIP пользователя', E_USER_ERROR);
					}
					if (!$optionsUser->save())
					{
						throw new CException('Не удалось обновить бизнес-опцию для VIP пользователя', E_USER_ERROR);
					}
				}
				if($this->getPersonalVolume($userId) > $optionPC->points)
				{
					$bonamorHistory->amount_vcc = (int) FALSE;
					$bonamorHistory->date_update = app_date("Y-m-d 23:59:58",ProfileBonuses::getDate((int)TRUE));
				}
			}
			
			$amountVIP=0;
		
			if(!empty($bonamorHistoryAmountVcc) && $bonamorHistoryAmountVcc->amount_vcc > (int) FALSE)
			{
				$amountVIP = $bonamorHistoryAmountVcc->amount_vcc;
			}
			
			if ($optionsUser->options__id == $optionVIP->id)
			{
			/*echo"<br>-----------------1--------------------------<br>";
			vg($optionsUser->user__id);
			echo"<br>-------------------------------------------<br>";*/
			
			/*echo"<br>-----------------2--------------------------<br>";
				vg($this->getPersonalVolume($userId));
				vg($amountVIP);
				vg($optionPC->points);
				echo"<br>-------------------------------------------<br>";*/
				if ($this->getPersonalVolume($userId) > $optionPC->points)
				{
				
					$optionsUser->options__id = $optionPC->id;
					$bonamorHistory->amount_vcc = (int) FALSE;
					$bonamorHistory->date_update = app_date("Y-m-d 23:59:58",ProfileBonuses::getDate((int)TRUE));
					if (!$optionsUser->validate())
					{
						throw new CException('Не удалось обновить бизнес-опцию для VIP пользователя', E_USER_ERROR);
					}
					if (!$optionsUser->save())
					{
						throw new CException('Не удалось обновить бизнес-опцию для VIP пользователя', E_USER_ERROR);
					}
			
				}
			}

			$bonamorHistory->attributes = $optionsUser->attributes;
			
			if($bonamorHistory->validate())
			{
				if(!$bonamorHistory->save())
				{
					throw new CException('Не удалось обновить историю для бизнес-опций пользователя', E_USER_ERROR);
				}
			}
		}
		
    }

    

//--------------------------------------------Мгновенный бонус-------------------------------------------------------

    public function addBonusesInstant()
    {
        list($transactions, $userId, $user, $objectTransaction, $transactValue, $periode) = $this->getParameters();
		
		$sponsor = ProfileBonuses::model()->getUplineElderOptions($userId);
		$sponsorModel = Users::model()->findByPk($sponsor);
		

        $amount = ProfileBonuses::model()->setInstantBonusValue($transactions, $userId, $objectTransaction);
		
		$register = ProfileBonuses::model()->checkRegisterPay($transactValue);
        if ($amount === FALSE || $amount <=0 || $register == TRUE)
        {
            return;
        }
	
        $bonusInstant = new ProfileInstantBonuses();

        $bonusInstant->users__id = $sponsor;
        $bonusInstant->users__id__from = $userId;
        
        $bonusInstant->amount_from = $transactions->amount;
        $bonusInstant->amount = round($amount);
        $bonusInstant->periode_date = app_date("Y-m-d");
        $bonusInstant->periode__id = $periode->id;

        if ($bonusInstant->validate())
        {
            if (!$bonusInstant->save())
            {
                throw new CException('Ошибка создания мгновенного бонуса', E_USER_ERROR);
            }
			$transact = $this->setFinanceTransactionInstantBonuses($bonusInstant);
			
			$bonusInstant->transactions__id = $transact->getModelTransactions()->id;
			if (!$bonusInstant->save())
            {
                throw new CException('Ошибка создания мгновенного бонуса', E_USER_ERROR);
            }
            if (!ProfileBonuses::model()->updateReportFinal($bonusInstant, ProfileBonuses::INSTANT_BONUS_ALIAS))
            {
                throw new CException('Ошибка создания сводной таблицы2', E_USER_ERROR);
            }
        }
		
		if($user->profilebonamor->options->alias == ProfileBonuses::CLIENT_COMPANY && $sponsorModel->profilebonamor->options->alias == ProfileBonuses::VIP_CLIENT_COMPANY)
		{
		

			$amountPK = ProfileBonuses::model()->setInstantBonusValueForPK($transactions, $sponsorModel->id, $amount, $objectTransaction);
 
			if ($amountPK === FALSE || $amountPK <=0)
			{
				return;
			}
			$partner = ProfileBonuses::model()->getUplinePartnerCompany($userId);


			$bonusInstantPK = new ProfileInstantBonuses();

			$bonusInstantPK->users__id = $partner;
			$bonusInstantPK->users__id__from = $userId;
			
			$bonusInstantPK->amount_from = $transactions->amount;
			$bonusInstantPK->amount = round($amountPK);
			$bonusInstantPK->periode_date = app_date("Y-m-d");
			$bonusInstantPK->periode__id = $periode->id;
			if ($bonusInstantPK->validate())
			{
				if (!$bonusInstantPK->save())
				{
					throw new CException('Ошибка создания мгновенного бонуса', E_USER_ERROR);
				}
				$transact = $this->setFinanceTransactionInstantBonuses($bonusInstantPK);
				$bonusInstantPK->transactions__id = $transact->getModelTransactions()->id;
				if (!$bonusInstant->save())
				{
					throw new CException('Ошибка создания мгновенного бонуса', E_USER_ERROR);
				}
				if (!ProfileBonuses::model()->updateReportFinal($bonusInstantPK, ProfileBonuses::INSTANT_BONUS_ALIAS))
				{
					throw new CException('Ошибка создания сводной таблицы2', E_USER_ERROR);
				}
				
			} 
			return TRUE;
		}	 
		if((isset($bonusInstantPK) && !$bonusInstantPK->validate()) || !$bonusInstant->validate())
		{
			return false;
		}
		else
		{
			return TRUE;
		}
    }

    public function setFinanceTransactionInstantBonuses($amount)
    {
        list($transactions, $userId, $user, $objectTransaction) = $this->getParameters();
        
        if (empty($amount))
        {
            return;
        }
        $transaction = new FinanceTransaction('system');
		$userId = $amount->users__id;
        $profile = Profile::model()->find('user__id = :user_id', array(':user_id' => $userId));
		$partnerProfile = Profile::model()->find('user__id = :user_id', array(':user_id' => $amount->users__id__from));
        $transaction->initMainCurrency();
		
		if($profile->user->profilebonamor->options->alias == ProfileBonuses::PARTNER_COMPANY && $partnerProfile->user->profilebonamor->options->alias == ProfileBonuses::CLIENT_COMPANY)
		{
			$transaction->setSpecificationByAlias('wallet_out_instant_bonus_for_pk_from_kk');
		}
		elseif ($profile->user->profilebonamor->options->alias == ProfileBonuses::PARTNER_COMPANY && $partnerProfile->user->profilebonamor->options->alias == ProfileBonuses::VIP_CLIENT_COMPANY)
		{
			$transaction->setSpecificationByAlias('wallet_out_instant_bonus_for_pk_from_vkk');
		}
		else
		{
			$transaction->setSpecificationByAlias('wallet_out_instant_bonus');
		}
		
        $transaction->initProperties();
        $transaction->initDebitMainWalletByObjectAndId('users', $amount->users__id);
        $transaction->initCreditWalletByObjectAndIdAndPurpose('company', 1, 'bonus_out');

        $transaction->amount = $amount->amount;
		$horders_id = array_key_exists('horders__id', $objectTransaction) ? $objectTransaction['horders__id'] : '';
		
        $transaction->modelsTransactionsObjects['redirect_confirm_after_paymentsystem']->value = '/office/default/payresult';
        $transaction->modelsTransactionsObjects['redirect_decline_after_paymentsystem']->value = '/office/default/payresult';
        $transaction->modelsTransactionsObjects['redirect_open_after_paymentsystem']->value = '/paymentsystem/yandexmoney/pay/index';
		$transaction->modelsTransactionsObjects['horders__id']->value = $horders_id->value;

        $transaction->objectsAttributes = array(
            'redirect_confirm_after_paymentsystem' => array('alias' => 'redirect_confirm_after_paymentsystem', 'value' => '/office/default/payresult'),
            'redirect_decline_after_paymentsystem' => array('alias' => 'redirect_decline_after_paymentsystem', 'value' => '/office/default/payresult'),
            'redirect_open_after_paymentsystem' => array('alias' => 'redirect_open_after_paymentsystem', 'value' => '/paymentsystem/yandexmoney/pay/index'),
			'horders__id' => array('alias' => 'horders__id', 'value' => $horders_id->value)
        );
        if ($amount->amount > 0)
        {
            if(!$transaction->open())
			{ 
				throw new CException('Не создана транзакция для мгновенного бонуса', E_USER_ERROR);
			}
			
			$transactionAuto = new FinanceTransaction('admin');
			$transactionAuto->initAllByTransactionId($transaction->getModelTransactions()->id);
				
			if (!$transactionAuto->confirmAdmin())
			{
				throw new CHttpException(403, Yii::t('app', 'Ошибка автоматического подтверждения финоперации (мгновенный бонус)'));
			}
			return $transaction;
        }
    }

//-----------------------------------------------------Гифт-бонус------------------------------------------------------------------------------------------

    public function addGiftsBonuses()
    {
        list($transactions, $userId, $user, $objectTransaction, $transactValue, $periode) = $this->getParameters();

        $directorId = ProfileBonuses::model()->getUplineDirector($userId);
        if ($directorId != FALSE)
        {
            $directorModel = Users::model()->findByPk($directorId);
            $valueBonuses = ProfileBonuses::model()->setGiftsBonusesValue($userId, $transactions, $user->profilebonamor->rank->alias, $directorModel->profilebonamor->rank->alias);
			if( round($valueBonuses['user_bonuses']) <= 0)
			{
				return;
			}
            $bonusGifts = new ProfileGiftsBonuses();

            $bonusGifts->users__id = $userId;
            $bonusGifts->persents = $valueBonuses['user_persents'];
            $bonusGifts->amount = round($valueBonuses['user_bonuses']);
            $bonusGifts->periode_date = app_date("Y-m-d");
            $bonusGifts->periode__id = $periode->id;

            if ($bonusGifts->validate())
            {
                if (!$bonusGifts->save())
                {
                    throw new CException('Не удалось обновить гифт пользователя', E_USER_ERROR);
                }
				$transact = $this->setFinanceTransactionGiftsForUserBonuses($bonusGifts);
				$bonusGifts->transactions__id = $transact->getModelTransactions()->id;
				if (!$bonusGifts->save())
                {
                    throw new CException('Не удалось обновить гифт пользователя', E_USER_ERROR);
                }
				
                if (!ProfileBonuses::model()->updateReportFinal($bonusGifts, ProfileBonuses::GIFTS_BONUS_ALIAS))
                {
                    throw new CException('Ошибка создания сводной таблицы3', E_USER_ERROR);
                }
            }
			if( round($valueBonuses['director_bonuses']) <= 0)
			{
				return;
			}
            $bonusGiftsDirector = new ProfileGiftsBonuses();

            $bonusGiftsDirector->users__id = $directorId;
            $bonusGiftsDirector->persents = $valueBonuses['director_persents'];
            $bonusGiftsDirector->transactions__id = $transactions->id;
            $bonusGiftsDirector->amount = round($valueBonuses['director_bonuses']);
            $bonusGiftsDirector->periode_date = app_date("Y-m-d");
            $bonusGiftsDirector->periode__id = $periode->id;

            if ($bonusGiftsDirector->validate())
            {
                if (!$bonusGiftsDirector->save())
                {
                    throw new CException('Не удалось обновить гифт пользователя', E_USER_ERROR);
                }
				$transact = $this->setFinanceTransactionGiftsForDirectorBonuses($bonusGiftsDirector);
				$bonusGifts->transactions__id = $transact->getModelTransactions()->id;
				if (!$bonusGiftsDirector->save())
                {
                    throw new CException('Не удалось обновить гифт пользователя', E_USER_ERROR);
                }
                if (!ProfileBonuses::model()->updateReportFinal($bonusGiftsDirector, ProfileBonuses::GIFTS_BONUS_ALIAS))
                {
                    throw new CException('Ошибка создания сводной таблицы4', E_USER_ERROR);
                }
            }
        }
        else
        {
            $valueBonuses = ProfileBonuses::model()->setGiftsBonusesValue($userId, $transactions, $user->profilebonamor->rank->alias);
			if( round($valueBonuses['user_bonuses']) <= 0)
			{
				return;
			}
            $bonusGifts = new ProfileGiftsBonuses();

            $bonusGifts->users__id = $userId;
            $bonusGifts->persents = $valueBonuses['user_persents'];
            
            $bonusGifts->amount = round($valueBonuses['user_bonuses']);
            $bonusGifts->periode_date = app_date("Y-m-d");
            $bonusGifts->periode__id = $periode->id;

            if ($bonusGifts->validate())
            {
                if (!$bonusGifts->save())
                {
                    throw new CException('Не удалось обновить гифт пользователя', E_USER_ERROR);
                }
				$transact = $this->setFinanceTransactionGiftsForUserBonuses($bonusGifts);
				
				$bonusGifts->transactions__id = $transact->getModelTransactions()->id;
				if (!$bonusGifts->save())
                {
                    throw new CException('Не удалось обновить гифт пользователя', E_USER_ERROR);
                }
                if (!ProfileBonuses::model()->updateReportFinal($bonusGifts, ProfileBonuses::GIFTS_BONUS_ALIAS))
                {
                    throw new CException('Ошибка создания сводной таблицы5', E_USER_ERROR);
                }
                return true;
            }
            return false;
        }
    }

    public function setFinanceTransactionGiftsForUserBonuses($amount)
    {
        list($transactions, $userId, $user) = $this->getParameters();

        $persentsUser = ProfileGiftsBonusesPersents::model()->find('alias = :alias', array(':alias' => $user->profilebonamor->rank->alias));

        $transaction = new FinanceTransaction('system');

        $transaction->initMainCurrency();
        $transaction->setSpecificationByAlias('wallet_out_gifts_bonus');

        $transaction->initProperties();
        $transaction->initDebitWalletByObjectAndIdAndPurpose('users', $userId, 'gifts_bonus');
        $transaction->initCreditWalletByObjectAndIdAndPurpose('company', 1, 'bonus_out');

        $transaction->amount = $amount->amount;

        if ($amount->amount > 0)
        {
            if(!$transaction->open())
			{
				throw new CException('Не создана транзакция для Гифт бонуса', E_USER_ERROR);
			}
			$transactionAuto = new FinanceTransaction('admin');
			$transactionAuto->initAllByTransactionId($transaction->getModelTransactions()->id);
				
			if (!$transactionAuto->confirmAdmin())
			{
				throw new CHttpException(403, Yii::t('app', 'Ошибка автоматического подтверждения финоперации (Гифт бонус для пользователя)'));
			}
			return $transaction;
        }
		
    }

    public function setFinanceTransactionGiftsForDirectorBonuses($amount)
    {
        list($transactions, $userId, $user) = $this->getParameters();

        $directorId = ProfileBonuses::model()->getUplineDirector($userId);
        if ($directorId == FALSE)
        {
            return;
        }
        $directorModel = Users::model()->findByPk($directorId);

        $persentsUser = ProfileGiftsBonusesPersents::model()->find('alias = :alias', array(':alias' => $directorModel->profilebonamor->rank->alias));

        $transaction = new FinanceTransaction('system');

        $transaction->initMainCurrency();
        $transaction->setSpecificationByAlias('wallet_out_gifts_director_bonus');

        $transaction->initProperties();
        $transaction->initDebitWalletByObjectAndIdAndPurpose('users', $amount->users__id, 'gifts_bonus');
        $transaction->initCreditWalletByObjectAndIdAndPurpose('company', 1, 'bonus_out');

        $transaction->amount = $amount->amount;

        if ($amount->amount > 0)
        {
            if(!$transaction->open())
			{
				throw new CException('Не создана транзакция для бонуса диреткора', E_USER_ERROR);
			}
			
			$transactionAuto = new FinanceTransaction('admin');
			$transactionAuto->initAllByTransactionId($transaction->getModelTransactions()->id);
				
			if (!$transactionAuto->confirmAdmin())
			{
				throw new CHttpException(403, Yii::t('app', 'Ошибка автоматического подтверждения финоперации (Гифт бонус для директора)'));
			}
			return $transaction;
        }
    }

}
