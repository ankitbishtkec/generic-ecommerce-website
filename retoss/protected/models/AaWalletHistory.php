<?php

/**
 * This is the model class for table "aa_wallet_history".
 *
 * The followings are the available columns in table 'aa_wallet_history':
 * @property string $wallet_history2wallet
 * @property string $wallet_history2all_process_queues
 * @property string $wallet_history2time_details
 * @property string $is_deleted
 *
 * The followings are the available model relations:
 * @property AAllProcessQueues $walletHistory2allProcessQueues
 * @property TimeDetails $walletHistory2timeDetails
 * @property AWallet $walletHistory2wallet
 */
class AaWalletHistory extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'aa_wallet_history';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('wallet_history2wallet, wallet_history2all_process_queues, wallet_history2time_details', 'length', 'max'=>20),
			array('is_deleted', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('wallet_history2wallet, wallet_history2all_process_queues, wallet_history2time_details, is_deleted', 'safe', 'on'=>'search'),
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
			'walletHistory2allProcessQueues' => array(self::BELONGS_TO, 'AAllProcessQueues', 'wallet_history2all_process_queues'),
			'walletHistory2timeDetails' => array(self::BELONGS_TO, 'TimeDetails', 'wallet_history2time_details'),
			'walletHistory2wallet' => array(self::BELONGS_TO, 'AWallet', 'wallet_history2wallet'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'wallet_history2wallet' => 'Wallet History2wallet',
			'wallet_history2all_process_queues' => 'Wallet History2all Process Queues',
			'wallet_history2time_details' => 'Wallet History2time Details',
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

		$criteria->compare('wallet_history2wallet',$this->wallet_history2wallet,true);
		$criteria->compare('wallet_history2all_process_queues',$this->wallet_history2all_process_queues,true);
		$criteria->compare('wallet_history2time_details',$this->wallet_history2time_details,true);
		$criteria->compare('is_deleted',$this->is_deleted,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AaWalletHistory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
