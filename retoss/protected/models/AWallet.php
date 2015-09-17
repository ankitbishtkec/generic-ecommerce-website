<?php

/**
 * This is the model class for table "a_wallet".
 *
 * The followings are the available columns in table 'a_wallet':
 * @property string $id
 * @property string $debit_or_credit
 * @property string $transaction_amount
 * @property string $curr_available_amnt_if_credit_row
 * @property string $transaction_method_name
 * @property string $transaction_method_remarks
 * @property string $transaction_method_record_unique_id
 * @property string $transaction_time
 * @property string $expiry_time_of_credited_amount
 * @property string $wallet_debit_record2wallet_credit_record
 * @property string $wallet2user_details
 * @property string $use_table_for
 * @property string $hmac_or_checksum
 * @property string $meta_data_1
 * @property string $meta_data_2
 * @property string $is_deleted
 *
 * The followings are the available model relations:
 * @property AUserDetails $wallet2userDetails
 * @property AWallet $walletDebitRecord2walletCreditRecord
 * @property AWallet[] $aWallets
 * @property AaWalletHistory[] $aaWalletHistories
 */
class AWallet extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'a_wallet';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('debit_or_credit, transaction_amount, curr_available_amnt_if_credit_row, wallet_debit_record2wallet_credit_record, wallet2user_details', 'length', 'max'=>20),
			array('transaction_method_name, is_deleted', 'length', 'max'=>45),
			array('transaction_method_remarks, use_table_for, meta_data_1, meta_data_2', 'length', 'max'=>100),
			array('transaction_method_record_unique_id', 'length', 'max'=>200),
			array('hmac_or_checksum', 'length', 'max'=>500),
			array('transaction_time, expiry_time_of_credited_amount', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, debit_or_credit, transaction_amount, curr_available_amnt_if_credit_row, transaction_method_name, transaction_method_remarks, transaction_method_record_unique_id, transaction_time, expiry_time_of_credited_amount, wallet_debit_record2wallet_credit_record, wallet2user_details, use_table_for, hmac_or_checksum, meta_data_1, meta_data_2, is_deleted', 'safe', 'on'=>'search'),
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
			'wallet2userDetails' => array(self::BELONGS_TO, 'AUserDetails', 'wallet2user_details'),
			'walletDebitRecord2walletCreditRecord' => array(self::BELONGS_TO, 'AWallet', 'wallet_debit_record2wallet_credit_record'),
			'aWallets' => array(self::HAS_MANY, 'AWallet', 'wallet_debit_record2wallet_credit_record'),
			'aaWalletHistories' => array(self::HAS_MANY, 'AaWalletHistory', 'wallet_history2wallet'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'debit_or_credit' => 'Debit Or Credit',
			'transaction_amount' => 'Transaction Amount',
			'curr_available_amnt_if_credit_row' => 'Curr Available Amnt If Credit Row',
			'transaction_method_name' => 'Transaction Method Name',
			'transaction_method_remarks' => 'Transaction Method Remarks',
			'transaction_method_record_unique_id' => 'Transaction Method Record Unique',
			'transaction_time' => 'Transaction Time',
			'expiry_time_of_credited_amount' => 'Expiry Time Of Credited Amount',
			'wallet_debit_record2wallet_credit_record' => 'Wallet Debit Record2wallet Credit Record',
			'wallet2user_details' => 'Wallet2user Details',
			'use_table_for' => 'Use Table For',
			'hmac_or_checksum' => 'Hmac Or Checksum',
			'meta_data_1' => 'Meta Data 1',
			'meta_data_2' => 'Meta Data 2',
			'is_deleted' => 'Is Deleted',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('debit_or_credit',$this->debit_or_credit,true);
		$criteria->compare('transaction_amount',$this->transaction_amount,true);
		$criteria->compare('curr_available_amnt_if_credit_row',$this->curr_available_amnt_if_credit_row,true);
		$criteria->compare('transaction_method_name',$this->transaction_method_name,true);
		$criteria->compare('transaction_method_remarks',$this->transaction_method_remarks,true);
		$criteria->compare('transaction_method_record_unique_id',$this->transaction_method_record_unique_id,true);
		$criteria->compare('transaction_time',$this->transaction_time,true);
		$criteria->compare('expiry_time_of_credited_amount',$this->expiry_time_of_credited_amount,true);
		$criteria->compare('wallet_debit_record2wallet_credit_record',$this->wallet_debit_record2wallet_credit_record,true);
		$criteria->compare('wallet2user_details',$this->wallet2user_details,true);
		$criteria->compare('use_table_for',$this->use_table_for,true);
		$criteria->compare('hmac_or_checksum',$this->hmac_or_checksum,true);
		$criteria->compare('meta_data_1',$this->meta_data_1,true);
		$criteria->compare('meta_data_2',$this->meta_data_2,true);
		$criteria->compare('is_deleted',$this->is_deleted,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AWallet the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
