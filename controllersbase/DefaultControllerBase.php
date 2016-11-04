<?php

class DefaultControllerBase extends UTIController
{

    public $breadcrumbs = array('Кабинет');

    public function __construct($id, $module = null)
    {
        parent::__construct($id, $module);
		 CHtml::asset(Yii::getPathOfAlias('application.modules.office.js.controllers.default.zclip'));
        $this->layout = 'office';
    }

    public function Index()
    {
		
        if (Yii::app()->user->checkAccess(Stats::ROLE_NOTCOMPLITEDUSER))
        {
            $this->redirect($this->createUrl('/register/register/index/step/2/'));
        }

        $this->checkAccess();
		
		
        $this->pageTitle = Yii::t('app', 'Кабинет');
        $this->include_jquery();
		
		if (array_key_exists('btn_pak', $_POST))
        {
            $this->redirect($this->createUrl('/office/packages'));
        }
		
		$userId = Yii::app()->user->id;
		
		$bonamorStructureSettings = ProfileBonamorStructureSettings::model()->find('user__id=:user__id', array(':user__id' => $userId));
		if(empty($bonamorStructureSettings))
		{
			$bonamorStructureSettings = new ProfileBonamorStructureSettings();
			$bonamorStructureSettings->user__id = $userId;
			$bonamorStructureSettings->referal_register_type = (int) TRUE;
			$bonamorStructureSettings->profile_bonamor__contract_no = $userId;
			$bonamorStructureSettings->register_leg = (int) TRUE;
			$bonamorStructureSettings->register_filltype = (int) TRUE;
			$bonamorStructureSettings->save();
			
		}
				
		
        $userPV = ProfileBonuses::model()->getPersonalVolume($userId);
		
		$userPVprev = ProfileBonuses::model()->getPersonalVolumePrevious($userId);
		
		$userGOprev = ProfileBonuses::model()->getEnergyGroupValue($userId);
		
		$userGO = ProfileBonuses::model()->getEnergyGroupValuePresent($userId);
        
		$userAGV = ProfileBonuses::model()->getAccumulatedGroupVolume($userId);
        $userAGVprev = ProfileBonuses::model()->getAccumulatedGroupVolumePrevious($userId);
		$userVPG = ProfileBonuses::model()->getVolumeOfPersonalGroup(Yii::app()->user->id);
		
		$userVPGprev = ProfileBonuses::model()->getVolumeOfPersonalGroupPrevious(Yii::app()->user->id);
		
		$stepCount = MatrixTokensWrapper::model()->cntOfSteps(Yii::app()->user->id);
		$stepCountCurrent = MatrixTokensWrapper::model()->cntOfStepsCurrent(Yii::app()->user->id);

		$leftLegAllClient = MatrixTokensWrapper::model()->cntOfLeftLegTokensClients(Yii::app()->user->id);
		
		$leftLegAllVip = MatrixTokensWrapper::model()->cntOfLeftLegTokensVipClients(Yii::app()->user->id);

		$rightLegAllClient = MatrixTokensWrapper::model()->cntOfRightLegTokensClients(Yii::app()->user->id);

		$rightLegAllVip = MatrixTokensWrapper::model()->cntOfRightLegTokensVipClients(Yii::app()->user->id);

		$wallets = array();

		$wallets = ProfileBonuses::getWalletsBalance($userId);
		
		$leftLegAllNow = FALSE;
		
		$binarSum = ProfileBonuses::model()->getCurrentBinarSum($userId);
		
		$instantSum = ProfileBonuses::model()->getCurrentInstantSum($userId);
		
		$mlmSum = ProfileBonuses::model()->getCurrentAllSum($userId);
		
		$allSum = $binarSum + $instantSum + $mlmSum;
		
		$sumAllTime = ProfileBonuses::model()->getAllSum($userId);
		
		$activity = ProfileBonuses::checkActivity($userId);
		
		$periodeInstant = ProfilePeriode::model()->find('date_end is NULL');
		$instantCriteria = new CDBCriteria();
		$instantCriteria->condition = 'users__id = :users__id and periode__id = :periode__id';
		$instantCriteria->params = array(':users__id' => $userId, ':periode__id' => $periodeInstant->id);
		$instantCriteria->order = 'id DESC';
				
		$count = ProfileInstantBonuses::model()->count($instantCriteria);
		$pages = new CPagination($count);
        $pages->pageSize = 5;//$limitInstant;
        $pages->applyLimit($instantCriteria);
		
		$instantBonuses = ProfileInstantBonuses::model()->findAll($instantCriteria);
		
        $user = Users::model()->findByPk(Yii::app()->user->id);
		
		$activeNow = ProfileBonuses::getCountActiveCurrent($user);
		
		$activePrev = ProfileBonuses::getCountActivePrevious($user);
		
		$modal = FALSE;
		$balanceGifts = array();
		$contentModal = '';
		if(!empty($_SERVER['HTTP_REFERER']) && strstr($_SERVER['HTTP_REFERER'],'/site/login') =='/site/login')
		{
			$walletGift = $user->wallets;
			$balance = array();
        
			foreach ($walletGift as $wallet)
			{
				if($wallet->purpose_alias == 'gifts_bonus')
				{
					$balanceGifts['gifts'] = number_format($wallet->balance,0, ',','');
				}
			}
			$criteriaGift = new CDbCriteria();
			$criteriaGift->condition = 'price <= :price';
			$criteriaGift->params = array(':price' => $balanceGifts['gifts']);
			$criteriaGift->order = 'price DESC';
			
			$contentModal =  GiftsProducts::model()->findAll($criteriaGift);
			
			if($balanceGifts['gifts'] > (int)FALSE && count($contentModal) > (int)FALSE)
			{
				$modal = TRUE;
			}
		}
		
		
		$token = $user->matrix_tokens;
        $userBO = $user->profilebonamor->options->lang->name;
        $userRank = $user->profilebonamor->rank->lang->name;
		
		$directorPosition = UsersDirectorRank::model()->find('alias = :alias', array(':alias' => UsersRank::DIRECTOR));
		if (!empty($user->profilebonamor->director) && $user->profilebonamor->director->position > $directorPosition->position)
		{
			$userRank = $user->profilebonamor->director->lang->name;
			$directorRank = $userRank;
		}
		else
		{
			$directorRank = '';
		}
        $stat = Stats::getStatsForOffice($user);

        $this->assign_global('user', $user);
        $this->assign_global('stat', $stat);

		$leftLegAllClientCurrent = MatrixTokensWrapper::model()->cntOfLeftLegTokensClientsCurrentPeriode(Yii::app()->user->id);
		$rightLegAllClientCurrent = MatrixTokensWrapper::model()->cntOfRightLegTokensClientsCurrentPeriode(Yii::app()->user->id);
		
		$leftLegAllVipCurrent = MatrixTokensWrapper::model()->cntOfLeftLegTokensVipClientsCurrentPeriode(Yii::app()->user->id);
		$rightLegAllVipCurrent = MatrixTokensWrapper::model()->cntOfRightLegTokensVipClientsCurrentPeriode(Yii::app()->user->id);
		
        $this->render('index', array(
			'leftLegAllClientCurrent' => $leftLegAllClientCurrent,
			'rightLegAllClientCurrent' => $rightLegAllClientCurrent,
			'rightLegAllVipCurrent' => $rightLegAllVipCurrent,
			'leftLegAllVipCurrent' => $leftLegAllVipCurrent,
			'stepCountCurrent' => $stepCountCurrent,
            'userPV' => $userPV,
            'userAGV' => $userAGV,
            'userBO' => $userBO,
            'userRank' => $userRank,
			'directorRank' => $directorRank,
            'userVPG' => $userVPG,
			'userGOprev' =>$userGOprev,
			'userGO' => $userGO,
			'activity' => $activity,
			'userPVprev' => $userPVprev,
			'userVPGprev' => $userVPGprev,
			'activeNow' => $activeNow,
			'activePrev' => $activePrev,
			'leftLegAllClient' => $leftLegAllClient,
			'leftLegAllVip' => $leftLegAllVip,
			'rightLegAllClient' => $rightLegAllClient,
			'rightLegAllVip' => $rightLegAllVip,
			//'rightLegAll' => $rightLegAll,
			'stepCount' => $stepCount,
			'leftLegAllNow' => $leftLegAllNow,
			'wallets' => $wallets,
			'binarSum' => $binarSum,
			'instantSum' => $instantSum,
			'mlmSum' => $mlmSum,
			'allSum' => $allSum,
			'sumAllTime' => $sumAllTime,
			'instantBonuses' => $instantBonuses,
			'pages' => $pages,
			'userAGVprev' => $userAGVprev,
			'token' => $token[0],
			'modal' => $modal,
			'contentModal' => $contentModal,
        ));
    }

    public function Packages()
    {
        Yii::import('application.modules.admin.modules.packagesbase.models.*');
        $typePackages = PackagesStoreType::model()->find('alias = :alias', array(':alias' => PackagesStoreType::REGISTER_PACKAGES));
        $packagesModel = PackagesStore::model()->findAll('visibility = :visibility and flag = :flag', array(':visibility' => (int)TRUE, ':flag' => (int)TRUE));
        
        if (array_key_exists('btn_buy', $_POST))
        {
			
            Yii::import('application.modules.admin.modules.finance.models.*');
            Yii::import('application.modules.store.models.*');
            /*$register = (int)TRUE;
            $ordersStart = ProfileBonuses::model()->setOrdersToRegister($_POST['PackagesStore']['id'], $register);
            if (empty($ordersStart))
            {
                throw new CException('Не удалось создать заказ', E_USER_ERROR);
            }*/

			$this->redirect('/store/order/package/guid/'.$_POST['PackagesStore']['id']);
            /*$transaction = new FinanceTransaction('system');

            $transaction->initMainCurrency();
            $transaction->setSpecificationByAlias('wallet_in_for_order_pay_yandexmoney');

            $horder = Horders::model()->findAll('users__id = :users__id', array(':users__id' => Yii::app()->user->id));
            $horderId = 0;
            foreach ($horder as $key => $value)
            {
                if ($value->id > $horderId)
                {
                    $horderId = $key;
                }
            }
            $horderModel = $horder[$horderId];

            $transaction->initProperties();
            $transaction->initDebitMainWalletByObjectAndId('users', Yii::app()->user->id);
            $transaction->initCreditWalletByObjectAndIdAndPurpose('company', 1, 'yandexmoney');
            $transaction->amount = $horderModel->total_price;
            $transaction->modelsTransactionsObjects['horders__id']->value = $horderModel->getPrimaryKey();
            $transaction->modelsTransactionsObjects['redirect_confirm_after_paymentsystem']->value = $this->createUrl('');
            $transaction->modelsTransactionsObjects['redirect_decline_after_paymentsystem']->value = $this->createUrl('');
            $transaction->modelsTransactionsObjects['redirect_open_after_paymentsystem']->value = $this->createUrl('');

            $transaction->objectsAttributes = array(
                'horders__id' => $horderModel->getPrimaryKey(),
                'redirect_confirm_after_paymentsystem' => array('alias' => 'redirect_confirm_after_paymentsystem', 'value' => $this->createUrl('')),
                'redirect_decline_after_paymentsystem' => array('alias' => 'redirect_decline_after_paymentsystem', 'value' => $this->createUrl('')),
                'redirect_open_after_paymentsystem' => array('alias' => 'redirect_open_after_paymentsystem', 'value' => $this->createUrl(''))
            );

            if ($transaction->open())
            {
                if ($transaction->getModelTransactions()->status_alias == FinanceTransactions::status_open)
                {
                    if (empty($transaction->getModelTransactions()->redirect_open))
                    {
                        throw new CHttpException(500, 'Финансовая операция открыта. Неизвестно куда перенаправить браузер после открытия операции.');
                    }

                    $this->redirect($this->createUrl($transaction->getModelTransactions()->redirect_open, array('guid' => $transaction->getModelTransactions()->guid)));
                }
                if ($transaction->getModelTransactions()->status_alias == FinanceTransactions::status_closed)
                {
                    if (empty($transaction->getModelTransactions()->redirect_confirm))
                    {
                        throw new CHttpException(500, 'Финансовая операция подтверждена. Неизвестно куда перенаправить браузер после подтверждения операции.');
                    }

                    $this->redirect($this->createUrl($transaction->getModelTransactions()->redirect_confirm, array('guid' => $transaction->getModelTransactions()->guid)));
                }
                if ($transaction->getModelTransactions()->status_alias == FinanceTransactions::status_decline)
                {
                    if (empty($transaction->getModelTransactions()->redirect_decline))
                    {
                        throw new CHttpException(500, 'Финансовая операция отклонена. Неизвестно куда перенаправить браузер после отклонения операции.');
                    }

                    $this->redirect($this->createUrl($transaction->getModelTransactions()->redirect_decline, array('guid' => $transaction->getModelTransactions()->guid)));
                }
            }*/
        }
        
        $this->render('packages', array(
            'packages' => $packagesModel,
        ));
    }
	
	
	public function Referal()
    {

        $this->pageTitle = Yii::t('app', 'Настройки реферальной ссылки');
        
        $user = Users::model()->findByPk(Yii::app()->user->id);
		if(empty($user))
		{
			$this->redirect('/site/login');
		}
        $bonamorStructureSettings = ProfileBonamorStructureSettings::model()->find('user__id=:user__id', array(':user__id' => $user->id));
		if(empty($bonamorStructureSettings))
		{
			$bonamorStructureSettings = new ProfileBonamorStructureSettings();
			$bonamorStructureSettings->user__id = Yii::app()->user->id;
		}
		$userName = '';
        if ((array_key_exists('btn-save', $_POST)) && (array_key_exists('ProfileBonamorStructureSettings', $_POST)))
        {
			//$userReferal = Users::model()->find('username = :username', array(':username' => $_POST['input_login']);
            $bonamorStructureSettings->attributes = $_POST['ProfileBonamorStructureSettings'];
			//$bonamorStructureSettings->profile_bonamor__contract_no = $userReferal->id;

			if($_POST['ProfileBonamorStructureSettings']['referal_register_type'] == (int)TRUE)
			{
				$userName = $user->username;
			}
			else
			{
				$userName = array_key_exists('username_other', $_POST) ? $_POST['username_other'] : 0;
			}
			$userChoose = Users::model()->find('username=:username AND username !=:superadmin', array(':username' => $userName, ':superadmin' => Yii::app()->params['superAdminInfo']['username']));
				
			if (($userChoose == NULL) || ($userChoose->profilebonamor == NULL))
			{
				$bonamorStructureSettings->addError('profile_bonamor__contract_no', Yii::t('app', 'Пользователь с логином "' . $userName . '" не найден'));
			}
			else
			{
				$bonamorStructureSettings->profile_bonamor__contract_no = $userChoose->id;
			}

			
            if  (!$bonamorStructureSettings->getErrors() && ($bonamorStructureSettings->save()))
            {
				$bonamorStructureSettingsHistory = new ProfileBonamorStructureSettingsHistory();
				$bonamorStructureSettingsHistory->profile_bonamor_structure_settings__id	= $bonamorStructureSettings->id;
				$bonamorStructureSettingsHistory->user__id 									= $bonamorStructureSettings->user__id;
				$bonamorStructureSettingsHistory->referal_register_type 					= $bonamorStructureSettings->referal_register_type;
				$bonamorStructureSettingsHistory->profile_bonamor__contract_no 				= $bonamorStructureSettings->profile_bonamor__contract_no;
				$bonamorStructureSettingsHistory->register_leg 								= $bonamorStructureSettings->register_leg;
				$bonamorStructureSettingsHistory->register_filltype 						= $bonamorStructureSettings->register_filltype;			
			
				if (!$bonamorStructureSettingsHistory->save())
				{
					throw new CHttpException(403, Yii::t('app', 'Ошибка при сохранении реферальной ссылки: ' . var_export($bonamorStructureSettingsHistory, true)));
				}
			
                $this->redirect('/office');
            }

        }        
        
        $referal_link = $this->createAbsoluteUrl('/');
        $parseurl = parse_url($referal_link);

        $referal_link = $parseurl['scheme'] . '://' . Yii::app()->user->username . '.' . $parseurl['host'];
        
        $this->assign_global('user', $user);
		$refUser = Users::model()->findByPk($bonamorStructureSettings->profile_bonamor__contract_no);
		$this->assign_global('referal', $refUser);
        
		CHtml::asset(Yii::getPathOfAlias('application.modules.office.js.controllers.default.zclip'));
		
        $this->render('referal', array('referal_link' => $referal_link, 'bonamorStructureSettings' => $bonamorStructureSettings, 'userName' => $userName));
    }

    public function Confirmemail($guid)
    {
//        $this->checkAccess('OfficeDefaultConfirmemail');

        $this->pageTitle = Yii::t('app', 'Подтверждение Email-адреса');
        $this->breadcrumbs = array(Yii::t('app', 'Подтверждение Email-адреса'));

        $profile = Profile::model()->find('guid=:guid', array(':guid' => $guid));

        if ($profile == NULL)
        {
            throw new CHttpException(403, 'Forbidden');
        }

        $user = $profile->user;

        if (($user == NULL) ||
            ($user->profile == NULL) ||
            (($user->username == Yii::app()->params['adminUsername'])))
        {
            throw new CHttpException(403, 'Forbidden');
        }

        if ((!Yii::app()->user->isGuest) && (Yii::app()->user->id != $user->id))
        {
            throw new CHttpException(403, Yii::t('app', 'Вы прошли по ссылке подтверждения Email-а другого пользователя. Для подтверждения Email-а пользователя Вам необходимо выйти из текущего аккаунта'));
        }

        if (Yii::app()->user->isGuest)
        {
            $model = new LoginForm();
            $model->username = $user->username;
            $model->password = $user->password;
            $model->allowedByHash = TRUE;

            if (!$model->login())
            {
                throw new CHttpException(403, Yii::t('app', 'Ошибка при авторизации'));
            }
        }

        Yii::import('application.modules.admin.modules.roles.models.*');

        if (Yii::app()->user->checkAccess(Stats::ROLE_NOTCONFIRMEDUSER))
        {
            $profileTransaction = Yii::app()->db->beginTransaction();
            try
            {
                $newRole = new Authassignment();
                $newRole->userid = $user->id;
                $newRole->itemname = Stats::ROLE_CONFIRMEDUSER;
                if (!$newRole->save())
                {
                    throw new CHttpException(403, Yii::t('app', 'Ошибка при обновлении данных пользователя'));
                }

                $profile->is_confirm_email = (int) TRUE;

                if (!$profile->save())
                {
                    throw new CHttpException(403, Yii::t('app', 'Ошибка при обновлении данных пользователя'));
                }

                Authassignment::model()->deleteAll('userid=:userid AND itemname=:notConfirmed', array(':userid' => $user->id, ':notConfirmed' => Stats::ROLE_NOTCONFIRMEDUSER));

                $profileTransaction->commit();

                $this->redirect($this->createUrl('/office'));
            }
            catch (Exception $e)
            {
                if ($profileTransaction->getActive())
                {
                    $profileTransaction->rollback();
                }
                throw new CException($e->getMessage());
            }
        }

        $prob2b = $this->subscribeProb2b($guid);
        if (!$prob2b)
        {
            throw new CHttpException(403, 'Ваш e-mail уже существует в базе ProB2B.Бонамор');
        }

        throw new CHttpException(403, 'Forbidden');
    }

    public function subscribeProb2b($guid = false)
    {
        if ($guid == FALSE)
        {
            throw new CHttpException(403, 'Forbidden');
        }

        $profile = Profile::model()->find('guid=:guid', array(':guid' => $guid));
        $user = $profile->user;

        $url = Stats::URL;
        $post_data = array(
            "email" => $user->username,
            "first_name" => $profile->lang->first_name,
            "second_name" => $profile->lang->second_name,
            "action" => "Submit"
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

        $output = curl_exec($ch);
        curl_close($ch);

        if ($output === FALSE)
        {
            echo "cURL Error: " . curl_error($ch);
        }
        preg_match('/<text>(.*)<\/text>/', $output, $answer);

        if (trim($answer[1]) == 'OK')
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function Guest()
    {
		Yii::import('application.modules.admin.modules.content.models.*');
		$content = Contents::model()->find('name = :name', array(':name' => 'Сообщение'));
        $this->render('guest',array(
            'content' => $content,
			));
    }

    public function ActivateBinar($guid)
    {
        $this->checkAccess(Stats::ROLE_NOTACTIVEUSER);

        $this->pageTitle = Yii::t('app', 'Оплата специального пакета для активации в бинаре');
        $this->breadcrumbs = array(Yii::t('app', 'Оплата специального пакета'));

        $profile = Profile::model()->find('guid=:guid', array(':guid' => $guid));

        if ($profile == NULL)
        {
            throw new CHttpException(403, 'Forbidden');
        }

        $user = $profile->user;

        if (($user == NULL) ||
            ($user->profile == NULL) ||
            (($user->username == Yii::app()->params['adminUsername'])))
        {
            throw new CHttpException(403, 'Forbidden');
        }

        if (Yii::app()->user->isGuest)
        {
            $model = new LoginForm();
            $model->username = $user->username;
            $model->password = $user->password;
            $model->allowedByHash = TRUE;

            if (!$model->login())
            {
                throw new CHttpException(403, Yii::t('app', 'Ошибка при авторизации'));
            }
        }

        if (isset($_POST['btn_add_binar']))
        {

            Yii::import('application.modules.admin.modules.roles.models.*');

            if (Yii::app()->user->checkAccess(Stats::ROLE_NOTACTIVEUSER))
            {
                $profileTransaction = Yii::app()->db->beginTransaction();
                try
                {
                    $newRole = new Authassignment();
                    $newRole->userid = $user->id;
                    $newRole->itemname = Stats::ROLE_ACTIVEUSER;
                    if (!$newRole->save())
                    {
                        throw new CHttpException(403, Yii::t('app', 'Ошибка при обновлении данных пользователя'));
                    }

                    Authassignment::model()->deleteAll('userid=:userid AND itemname=:notConfirmed', array(':userid' => $user->id, ':notConfirmed' => Stats::ROLE_NOTACTIVEUSER));

                    $profileTransaction->commit();

                    $this->redirect($this->createUrl('/office'));
                }
                catch (Exception $e)
                {
                    if ($profileTransaction->getActive())
                    {
                        $profileTransaction->rollback();
                    }
                    throw new CException($e->getMessage());
                }
            }
        }
        $this->render('ActivateBinar');
    }

    public function Bonusesprint()
    {
        $this->pageTitle = Yii::t('app', 'Страница для тестировщика');
        $this->breadcrumbs = array(Yii::t('app', 'Страница тестирования маркетинга'));

        $this->render('bonusesprint');
    }

}
