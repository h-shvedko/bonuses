<?php

class BonusesControllerBase extends UTIController
{

    public function __construct($id, $module = null)
    {
        parent::__construct($id, $module);

        $this->layout = 'office';
    }
	
	public function Warehouse()
    {
		Yii::import('application.modules.admin.modules.warehouse.models.*');
		Yii::import('application.modules.admin.modules.invoice.models.*');
		WarTurnover::model()->setTurnoverForWarehouses('2029-05-01 00:00:00', '2029-08-31 00:00:00', ProfileBonuses::model()->getPeriode()->id);
        /*$warehouses = WarWarehouse::model()->findAll();
		$volume = array();
		$periode = ProfileBonuses::model()->getPeriodeCurrent();
		$dateStart = $periode->date_begin;
		$dateEnd = app_date("Y-m-d", strtotime("2099-01-01"));

		foreach($warehouses as $warehouse)
		{
			if(!empty($warehouse->users__id))
			{
				$volume[$warehouse->id] = array(
					'value' => ProfileBonuses::model()->getVolumeOfWarehouse($warehouse->users__id, $dateStart, $dateEnd),
					'model' => $warehouse,
				);
			}
		}
		
        $this->render('warehouse', array(
            'volume' => $volume,
        ));*/
    }

    public function Instant()
    {
        $instant = ProfileInstantBonuses::model()->findAll();
        $this->render('instant', array(
            'instant' => $instant,
        ));
    }

    public function Linear()
    {
        if (isset($_POST['btn']))
        {
            ProfileBonuses::model()->addBonusesLinear();
        }
        $linear = ProfileLinearBonuses::model()->findAll();
        $this->render('linear', array(
            'linear' => $linear,
        ));
    }

    public function Stair()
    {
        if (isset($_POST['btn']))
        {
            ProfileBonuses::model()->addBonusesStair();
        }
        $stair = ProfileStairBonuses::model()->findAll();
        $this->render('stair', array(
            'stair' => $stair,
        ));
    }

    public function Director()
    {
        if (isset($_POST['btn']))
        {
            ProfileBonuses::model()->addBonusesDirector();
        }
        $director = ProfileDirectorBonuses::model()->findAll();
        $this->render('director', array(
            'director' => $director,
        ));
    }

    public function Infinity()
    {
        if (isset($_POST['btn']))
        {
            ProfileBonuses::model()->addBonusesDirectorInfinity();
        }
        $infinity = ProfileDirectorInfinityBonuses::model()->findAll();
        $this->render('infinity', array(
            'infinity' => $infinity,
        ));
    }

    public function Leader()
    {
        if (isset($_POST['btn']))
        {
            ProfileBonuses::model()->setLeaderBonusesValue();
        }

        $leader = ProfileLeaderBonuses::model()->findAll();
        $this->render('leader', array(
            'leader' => $leader,
        ));
    }

    public function Auto()
    {
        if (isset($_POST['btn']))
        {
            ProfileBonuses::model()->setAutoBonusValue();
        }
        $auto = ProfileAutoBonuses::model()->findAll();
        $this->render('auto', array(
            'auto' => $auto,
        ));
    }

    public function House()
    {
        if (isset($_POST['btn']))
        {
            ProfileBonuses::model()->setHouseBonusValue();
        }
        $house = ProfileHouseBonuses::model()->findAll();
        $this->render('house', array(
            'house' => $house,
        ));
    }

    public function Gifts()
    {
        $gifts = ProfileGiftsBonuses::model()->findAll();
        $this->render('gifts', array(
            'gifts' => $gifts,
        ));
    }
    
    public function Binar()
    {
        $binar = ProfileActivity::model()->findAll();
        $this->render('binar', array(
            'binar' => $binar,
        ));
    }
    
    public function Pv()
    {
        $this->pageTitle = Yii::t('app', 'Личный объем');
        $binar = ProfileBonamorPv::model()->findAll(array('order' => 'users__id'));
        $this->render('pv', array(
            'binar' => $binar,
        ));
    }
    
    public function Agv()
    {
        $this->pageTitle = Yii::t('app', 'Накопленный групповой объем');
        $binar = ProfileBonamorAgv::model()->findAll(array('order' => 'users__id'));
        $this->render('agv', array(
            'binar' => $binar,
        ));
    }
    
    public function Vpg()
    {
        $this->pageTitle = Yii::t('app', 'Объем личной группы');
        $binar = ProfileBonamorVpg::model()->findAll(array('order' => 'users__id'));
        $this->render('vpg', array(
            'binar' => $binar,
        ));
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
	
	public function close()
	{
        Yii::import('application.modules.register.models.*');
		$per = ProfileBonuses::model()->getPeriodeCurrent();
		
		 $dateStart = app_date("Y-m-d 00:00:00",strtotime($per->date_begin));
		if((app_date("m",strtotime($per->date_begin))+1) > 12)
		{
			$dateEnd = app_date("Y-m-d 23:59:59",  strtotime((app_date("Y", strtotime($dateStart)))."-12-31"));
			$nextStart = app_date("Y-m-d 00:00:00",  strtotime((app_date("Y", strtotime($dateStart))+1)."-01-01"));
		}
		else
		{
			$dateEnd = app_date("Y-m-d 23:59:59",  strtotime(app_date("Y", strtotime($dateStart))."-".app_date("m", strtotime($dateStart))."-".self::getDay(app_date("m", strtotime($dateStart)))));
			$nextStart = app_date("Y-m-d 00:00:00",  strtotime((app_date("Y",strtotime($per->date_begin)))."-".(app_date("m",strtotime($per->date_begin))+1)."-01"));
		}


		$transaction = Yii::app()->db->beginTransaction();
		try
		{
				
			$periodeExist = ProfilePeriode::model()->findAll('date_end > :date_end', array(':date_end' => $dateStart));
			if (!empty($periodeExist))
			{
				throw new CException('Данный период не может быть создат, т.к. уже существует период с такими  датами', E_USER_ERROR);
			}
			$periode = ProfilePeriode::model()->find('date_end is NULL');
			
			if (!empty($periode))
			{
				$periode->date_end = $dateEnd;

				if (!ProfileBonuses::model()->closePersonalVolume($dateEnd))
				{
					throw new CException('Старый период не сохранен1', E_USER_ERROR);
				}
				if(!ProfileBonuses::model()->createNewPersonalVolume($dateStart, $dateEnd) )
				{
					throw new CException('Старый период не сохранен2', E_USER_ERROR);
				}
				if(!ProfileBonuses::model()->closePersonalVolumeOfPersonalGroup($dateEnd))
				{
					throw new CException('Старый период не сохранен3', E_USER_ERROR);
				}
				if(!ProfileBonuses::model()->createNewVolumeOfPersonalGroup($dateStart, $dateEnd))
				{
					throw new CException('Старый период не сохранен4', E_USER_ERROR);
				}
				if(!ProfileBonuses::model()->setRankToUser($dateStart, $dateEnd))
				{
					throw new CException('Старый период не сохранен5', E_USER_ERROR);
				}
				
				if(!ProfileBonuses::model()->setEnergyRankToUser($dateStart, $dateEnd))
				{
					throw new CException('Старый период не сохранен7', E_USER_ERROR);
				}
				if(!ProfileBonuses::model()->updateEnergyRankToUser($dateStart, $dateEnd))
				{
					throw new CException('Старый период не сохранен70', E_USER_ERROR);
				}
				if(!ProfileBonuses::model()->setDirectorRankToUser($dateStart, $dateEnd))
				{
					throw new CException('Старый период не сохранен6', E_USER_ERROR);
				}
				if(!ProfileBonuses::model()->setRankHistory())
				{
					throw new CException('Старый период не сохранен71', E_USER_ERROR);
				}
				
				if ($periode->validate())
				{
					if (!$periode->save())
					{
						throw new CException('Старый период не сохранен', E_USER_ERROR);
					}
				}
				else
				{
					throw new CException('Старый период не сохраненVal', E_USER_ERROR);
				}
				
//vg($periode);
			}
			$profilePeriode = new ProfilePeriode();
			$profilePeriode->date_begin = $nextStart;

			if ($profilePeriode->validate())
			{
				if (!$profilePeriode->save())
				{
					throw new CException('Новый период не создан', E_USER_ERROR);
				}
			}
			//vg($periode);
			$transaction->commit();
			
		}
		catch (Exception $e)
		{
			if ($transaction->getActive())
			{
				$transaction->rollback();
			}
			
			throw new CException($e->getMessage());
		} 
		vg($profilePeriode->date_begin);
		echo"OK";
	}
	
	

	public function rollbak1()
	{
		Yii::import('application.modules.admin.modules.finance.models.*');
		$period = ProfilePeriode::model()->findByPk(3);
		
		$fintr = ProfileReportFinal::model()->findAll('periode__id = :periode__id and bonuses__id != :bonuses__id', array(':periode__id' => $period->id, ':bonuses__id' => 7));
		
		$transaction = Yii::app()->db->beginTransaction();
		try
		{
			
		foreach($fintr as $value)
		{
			$object = FinanceTransactionsObjects::model()->findAll('finance_transactions__id = :transactions__id', array(':transactions__id' => $value->transactions__id));
			if(count($object) > (int)FALSE)
			{
				if(!FinanceTransactionsObjects::model()->deleteAll('finance_transactions__id = :transactions__id', array(':transactions__id' => $value->transactions__id)))
				{
					vg($value->transactions__id);
					throw new CException('111111111', E_USER_ERROR);
					die("1");
				}
			}
			$history = FinanceTransactionsHistory::model()->findAll('finance_transactions__id = :transactions__id', array(':transactions__id' => $value->transactions__id));
			if(count($history) > (int)FALSE)
			{
				if(!FinanceTransactionsHistory::model()->deleteAll('finance_transactions__id = :transactions__id', array(':transactions__id' => $value->transactions__id)))
				{
					vg($value->transactions__id);
					throw new CException('222222222', E_USER_ERROR);
					die("2");
				}
			}
			$tr = FinanceTransactions::model()->findByPk($value->transactions__id);
			if(count($tr) > (int)FALSE)
			{
				if(!FinanceTransactions::model()->deleteByPk($value->transactions__id))
				{
					vg($value->transactions__id);
					throw new CException('3333333', E_USER_ERROR);
					die("3");
				}
			}
		}
		
		if(!ProfileReportFinal::model()->deleteAll('periode__id = :periode__id and bonuses__id != :bonuses__id', array(':periode__id' => $period->id, ':bonuses__id' => 7)))
		{
			throw new CException('4444444', E_USER_ERROR);
				die("4");
		}
		$transaction->commit();
			
		$this->redirect('/office');
			
		}
		catch (Exception $e)
		{
			if ($transaction->getActive())
			{
				$transaction->rollback();
			}
			
			throw new CException($e->getMessage());
		}
	}	
	
	
	public function balanceRecount1()
	{
		Yii::import('application.modules.admin.modules.finance.models.*');
		$wallets = FinanceWallets::model()->findAll('object_alias = :object_alias',array(':object_alias' =>'users'));
		
		$i = (int)FALSE;
		
		foreach($wallets as $wallet)
		{
			$criteriaDebit = new CDBCriteria();
			$criteriaDebit->select = 'sum(amount) as amount';
			$criteriaDebit->condition = 'debit_wallet_id = :debit_wallet_id and status_alias = :status';
			$criteriaDebit->params = array(':debit_wallet_id' => $wallet->id, ':status' => 'open');
			
			$balance_unapproved = FinanceTransactions::model()->find($criteriaDebit)->amount;
			
			$criteriaCredit = new CDBCriteria();
			$criteriaCredit->select = 'sum(amount) as amount';
			$criteriaCredit->condition = 'credit_wallet_id = :credit_wallet_id and status_alias = :status';
			$criteriaCredit->params = array(':credit_wallet_id' => $wallet->id, ':status' => 'open');
			
			$balance_blocked = FinanceTransactions::model()->find($criteriaCredit)->amount;
			
			$wallet->balance_unapproved = $balance_unapproved;
			$wallet->balance_blocked = $balance_blocked;
			$wallet->save();
			
			$i++;
		}
		
		echo $i."OK";
	}
	
	public function closeRegisterOperations1()
	{
		$periode = ProfileBonuses::model()->getPeriodeCurrent();
		$horders = array();
		$finances = array();
		$result = array();
		$hordersModel = Horders::model()->findAll('created_at >= :start and register=:register', array(':start' => $periode->date_begin, ':register' => (int)TRUE));
		
		foreach($hordersModel as $model)
		{
			$financeObject = FinanceTransactionsObjects::model()->find('alias = :alias and value = :value', array(':alias' => 'horders__id', ':value' => $model->id));
			$finances[] = $financeObject->finance_transactions__id;
			$result[]=array(
				'Horders' => $model->id,
				'date' => $model->created_at,
				'register' => $model->register,
			);
		}
		
		
		foreach($finances as $transact)
		{
			$modelTransaction = FinanceTransactions::model()->findByPk($transact);
							
			if ($modelTransaction->status_alias != 'closed')
			{
				$transaction = new FinanceTransaction('admin');
				$transaction->initAllByTransactionId($modelTransaction->id);
					
				if (!$transaction->confirmAdmin())
				{
					throw new CHttpException(403, Yii::t('app', 'Ошибка создания финансовых операций для накладной'));
				}
			}
		}
		
		vg($result);
		echo"Ура!!!! Оплаты регпакетов закрыли!!!!";
	}
	
	
	public function closeOperations1()
	{
		$periode = ProfileBonuses::model()->getPeriodeCurrent();
		$horders = array();
		$finances = array();
		$result = array();
		$hordersModel = Horders::model()->findAll('created_at >= :start', array(':start' => $periode->date_begin));
		//vg($periode->date_begin);
		foreach($hordersModel as $model)
		{
			$financeObject = FinanceTransactionsObjects::model()->find('alias = :alias and value = :value', array(':alias' => 'horders__id', ':value' => $model->id));
			$finances[] = $financeObject->finance_transactions__id;
			$result[]=array(
				'Horders' => $model->id,
				'date' => $model->created_at,
				'register' => $model->register,
			);
		}
		
		
		foreach($finances as $transact)
		{
			$modelTransaction = FinanceTransactions::model()->findByPk($transact);
							
			if ($modelTransaction->status_alias != 'closed')
			{
				$transaction = new FinanceTransaction('admin');
				$transaction->initAllByTransactionId($modelTransaction->id);
					
				if (!$transaction->confirmAdmin())
				{
					throw new CHttpException(403, Yii::t('app', 'Ошибка создания финансовых операций для накладной'));
				}
			}
		}
		
		vg($result);
		echo"Ура!!!! Оплаты из магазина закрыли!!!!";
	}
	
	public function closeAllOperations1()
	{
		$i=(int)FALSE;
		
		$models = FinanceTransactions::model()->findAll('status_alias = :status_alias', array(':status_alias' => 'open'));
		foreach($models as $modelTransaction)
		{
			
				$transaction = new FinanceTransaction('admin');
				$transaction->initAllByTransactionId($modelTransaction->id);
					
				if (!$transaction->confirmAdmin())
				{
					throw new CHttpException(403, Yii::t('app', 'Ошибка создания финансовых операций для накладной'));
				}

		}
		
		vg($i);
		echo"<br>Ура!!!! Все операции закрыли!!!!";
	}
	
	public function recountBO()
	{
	
		$users = Users::model()->findAll('username != :username', array(':username' => 'superadmin'));
		$i = (int)FALSE;
		foreach($users as $user)
		{	
			if(!empty($user->profilebonamor))
			{
				$oldOptions = $user->profilebonamor->options__id;
			}
			else
			{
				continue;
			}
				$activity = ProfileBonuses::checkBizOptions($user->id);
				$pv = ProfileBonuses::model()->getPersonalVolumePrevious($user->id);
				
				if(!empty($activity) && $pv >= 20)
				{	
					$hist = new ProfileBonamorHistory();
					$hist->attributes = $user->profilebonamor->attributes;
					$hist->date_update = app_date('Y-m-d H:i:s', strtotime('2015-02-28 23:59:58'));
					$user->profilebonamor->options__id = 3;
					if($user->profilebonamor->save())
					{
						$hist->save();	
						echo"<br>---------<br>";
						vg($user->username);
						vg($oldOptions);
						vg($pv);
						vg($user->profilebonamor->options__id);
						vg($activity->date_update);
						vg($hist->date_update);
						echo"<br>---------<br>";
						$i++;
					}
				}
				
			
		}
		
		
		vg($i);
		echo"<br>Ура!!!! Все опции обновили!!!!";
	}

}
