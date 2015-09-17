<?php

//handles operations on wallet
/**
 * ApplicationCommonCoupon class store those methods which are commonly used by the application for coupon codes
 * author: ankit
 */
class AppCommonWallet
{
	//gets total Amount In Wallet for a user
	//return amount
	public static function getTotalAmountInWalletForUser( $userId )
	{
		$response = 0;
		$currDateTime = new DateTime();
		$currDateTime = $currDateTime->format('Y-m-d H:i:s');
		$selectedRecords = null;
		if( isset( $userId ) )
		{
			$sql = 'SELECT SUM( curr_available_amnt_if_credit_row ) FROM a_wallet WHERE 
			is_deleted = "no" AND debit_or_credit = "credit" AND wallet2user_details = '.$userId.
			' AND use_table_for = "wallet" AND expiry_time_of_credited_amount > "'.$currDateTime.
			'" ;';	
			$list= Yii::app()->db->createCommand( $sql )->queryAll();
			if( isset( $list[ 0 ]['SUM( curr_available_amnt_if_credit_row )'] ) )	//not null
				$response = $list[ 0 ]['SUM( curr_available_amnt_if_credit_row )'] ;
		}
		
		return $response;
	}
	
	//create credit and debit pair records which null each other
	//caller is responsible for exception handling 
	//return void
	public static function createCreditDebitPairRecords( $amount, $transactionMethodName, $currDate,
		$transactionMethodRecordUniqueId, $useTableFor, $userDetailsId )
	{
		if( isset( $userDetailsId ) && $userDetailsId )
		{
			$ExpDate = DateTime::createFromFormat( 'Y-m-d H:i:s', $currDate);
			$ExpDate = $ExpDate->add(new DateInterval('PT1S'));//increase by 1 sec
			$ExpDate = $ExpDate->format('Y-m-d H:i:s') ;
			$creditRecId = AppCommonWallet::createWalletRecord( 'credit', $amount, 0, $transactionMethodName, 
				null, $transactionMethodRecordUniqueId, $currDate, $ExpDate, null, $userDetailsId, $useTableFor);
				
			AppCommonWallet::createWalletRecord('debit', $amount, 0, $transactionMethodName, 
				null, $transactionMethodRecordUniqueId, $currDate, $currDate, $creditRecId, $userDetailsId, $useTableFor);
		}
		return;
	}
	
	//update HMAC of wallet record 
	//id, transaction_amount, transaction_time, wallet2user_details
	//caller is responsible for exception handling 
	//return
	public static function updateHmacOfWalletRecord( $walletRec )
	{
		if( isset( $walletRec ) && !$walletRec->getIsNewRecord() )
		{
			$walletRec->hmac_or_checksum = Yii::app()->getSecurityManager()->hashData( $walletRec->id.
				$walletRec->transaction_amount.$walletRec->transaction_time.$walletRec->wallet2user_details );
			$walletRec->save();
		}
		return;
	}
	
	//debits given amount from wallet
	//caller is responsible for exception handling 
	//return true if done false if could not
	public static function debitAmountFromWallet( $amount, $transactionMethodName, $currDate,
		$transactionMethodRecordUniqueId, $useTableFor, $userDetailsId )
	{
		if( $amount == 0)
			return true;
		$response = false;
		$amountToDeduct = $amount;
		if( isset( $userDetailsId ) && $userDetailsId )
		{
			$walletRecords = AWallet::model()->findAll( array(
			'condition'=>'t.is_deleted = "no" AND t.debit_or_credit = "credit" AND t.wallet2user_details = '.$userDetailsId.
				' AND t.use_table_for = "wallet" AND t.expiry_time_of_credited_amount > "'.$currDate.
				'" AND t.curr_available_amnt_if_credit_row > 0 ' ,
			'order'=> 't.expiry_time_of_credited_amount ASC, t.id ASC' ,
			));
			$availableAmount = 0;
			if( isset( $walletRecords ) )
			foreach( $walletRecords as $key=>$value )
			{
				$availableAmount += $value->curr_available_amnt_if_credit_row;
			}
			
			if( isset( $walletRecords ) )
			if( $availableAmount >= $amountToDeduct )
			foreach( $walletRecords as $key=>$value )
			{
				if( $amountToDeduct == 0 )
					break;
				if( $value->curr_available_amnt_if_credit_row >= $amountToDeduct )
				{
					$value->curr_available_amnt_if_credit_row = 
						$value->curr_available_amnt_if_credit_row - $amountToDeduct;
					$value->save();
					//create debit record
					AppCommonWallet::createWalletRecord('debit', $amountToDeduct, 0, $transactionMethodName, 
						null, $transactionMethodRecordUniqueId, $currDate, $currDate, 
						$value->id, $userDetailsId, $useTableFor);
					$amountToDeduct = 0;
				}
				else
				{
					$amountToDeduct = $amountToDeduct - $value->curr_available_amnt_if_credit_row;
					//create debit record
					AppCommonWallet::createWalletRecord('debit', $value->curr_available_amnt_if_credit_row, 0, 
						$transactionMethodName, null, $transactionMethodRecordUniqueId, $currDate, $currDate, 
						$value->id, $userDetailsId, $useTableFor);
					$value->curr_available_amnt_if_credit_row = 0;
					$value->save();
				}
			}
		}
		if( $amountToDeduct == 0)
			$response = true;
		return $response;
	}
	
	//create wallet
	//caller is responsible for exception handling 
	//return id or false
	public static function createWalletRecord( $debit_or_credit, $transaction_amount, $curr_available_amnt_if_credit_row,
		$transaction_method_name, $transaction_method_remarks, $transaction_method_record_unique_id, $transaction_time,
		$expiry_time_of_credited_amount, $wallet_debit_record2wallet_credit_record, $wallet2user_details,
		$use_table_for )
	{
		if( isset( $wallet2user_details ) && $wallet2user_details )
		{
			$creditRec = new AWallet();
			$creditRec->debit_or_credit = $debit_or_credit;
			$creditRec->transaction_amount = $transaction_amount;
			$creditRec->curr_available_amnt_if_credit_row = $curr_available_amnt_if_credit_row;
			$creditRec->transaction_method_name = $transaction_method_name;
			$creditRec->transaction_method_remarks = $transaction_method_remarks;
			$creditRec->transaction_method_record_unique_id = $transaction_method_record_unique_id;
			$creditRec->transaction_time = $transaction_time;
			$creditRec->expiry_time_of_credited_amount = $expiry_time_of_credited_amount;
			$creditRec->wallet_debit_record2wallet_credit_record = $wallet_debit_record2wallet_credit_record;
			$creditRec->wallet2user_details = $wallet2user_details;
			$creditRec->use_table_for = $use_table_for;
			$creditRec->hmac_or_checksum = "fake";
			$creditRec->save();
			AppCommonWallet::updateHmacOfWalletRecord( $creditRec );
			return $creditRec->id;
		}
		return false;
	}
}

