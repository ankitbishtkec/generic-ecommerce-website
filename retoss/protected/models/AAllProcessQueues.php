<?php

/**
 * This is the model class for table "a_all_process_queues".
 *
 * The followings are the available columns in table 'a_all_process_queues':
 * @property string $id
 * @property string $queue_for_process
 * @property string $queue_state_name
 * @property string $queue_state_serial_number
 * @property string $is_deleted
 *
 * The followings are the available model relations:
 * @property AaOrderHistory[] $aaOrderHistories
 * @property AaWalletHistory[] $aaWalletHistories
 */
class AAllProcessQueues extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'a_all_process_queues';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('queue_for_process, queue_state_name, queue_state_serial_number, is_deleted', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, queue_for_process, queue_state_name, queue_state_serial_number, is_deleted', 'safe', 'on'=>'search'),
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
			'aaOrderHistories' => array(self::HAS_MANY, 'AaOrderHistory', 'order_history2all_process_queues'),
			'aaWalletHistories' => array(self::HAS_MANY, 'AaWalletHistory', 'wallet_history2all_process_queues'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'queue_for_process' => 'Queue For Process',
			'queue_state_name' => 'Queue State Name',
			'queue_state_serial_number' => 'Queue State Serial Number',
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
		$criteria->compare('queue_for_process',$this->queue_for_process,true);
		$criteria->compare('queue_state_name',$this->queue_state_name,true);
		$criteria->compare('queue_state_serial_number',$this->queue_state_serial_number,true);
		$criteria->compare('is_deleted',$this->is_deleted,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AAllProcessQueues the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
