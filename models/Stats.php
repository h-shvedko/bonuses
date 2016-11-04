<?php
class Stats
{
    const ROLE_NOTCONFIRMEDUSER = 'NotConfirmedUser';
    const ROLE_NOTCOMPLITEDUSER = 'NotComplitedUser';
    const ROLE_CONFIRMEDUSER = 'ConfirmedUser';
    const ROLE_ACTIVEUSER = 'User';
    const ROLE_NOTACTIVEUSER = 'UserNotActive';
    const ROLE_LIMITEDGUEST = 'LimitedGuest';
    const ALIAS_START_PACKEGE = 'payment_shop_order_registered_users';
	const WALLET_PURPOSE_GIFT = 'gifts_bonus';
	const WALLET_PURPOSE_HOUSE = 'house_bonus';
	const WALLET_PURPOSE_AUTO = 'auto_bonus';
	
    const URL = 'http://bonamortest.loc/answer.php';
          

	 public static function getStatsForOffice($user)
    {        
//	AlexXanDOR Метод для получения статистики пользователя по офису	

        return array(

        );
    }
	
    public static function getMainWalletBalance($user)
    {        
		if(empty($user))
		{
			throw new CException('Не задан пользователь', E_USER_ERROR);
		}
		$model = Users::model()->findByPk($user);
		$modelWallet = $model->walletsmain->balance;
		
		return $modelWallet;
				
    }
	
	public static function getWalletBalanceByAlias($user, $walletAlias)
    {        
		if(empty($user))
		{
			throw new CException('Не задан пользователь', E_USER_ERROR);
		}
		$model = Users::model()->findByPk($user);
		$modelWallet = $model->wallets;
		$balance = 0;
		foreach($modelWallet as $wallet)
		{
			if( $wallet->purpose_alias == $walletAlias)
			{
				$balance = $wallet->balance;
			}
		}
		
		return $balance;
				
    }
}
