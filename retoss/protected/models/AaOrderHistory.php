<?php

/**
 * This is the model class for table "aa_order_history".
 *
 * The followings are the available columns in table 'aa_order_history':
 * @property string $id
 * @property string $order_history2order
 * @property string $status
 * @property string $time
 * @property string $comments
 * @property string $order_history2all_process_queues
 * @property string $meta_data
 * @property string $is_deleted
 *
 * The followings are the available model relations:
 * @property AAllProcessQueues $orderHistory2allProcessQueues
 * @property AOrder $orderHistory2order
 */
class AaOrderHistory extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'aa_order_history';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('order_history2order, order_history2all_process_queues', 'length', 'max'=>20),
			array('status, comments, meta_data', 'length', 'max'=>200),
			array('is_deleted', 'length', 'max'=>45),
			array('time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, order_history2order, status, time, comments, order_history2all_process_queues, meta_data, is_deleted', 'safe', 'on'=>'search'),
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
			'orderHistory2allProcessQueues' => array(self::BELONGS_TO, 'AAllProcessQueues', 'order_history2all_process_queues'),
			'orderHistory2order' => array(self::BELONGS_TO, 'AOrder', 'order_history2order'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'order_history2order' => 'Order History2order',
			'status' => 'Status',
			'time' => 'Time',
			'comments' => 'Comments',
			'order_history2all_process_queues' => 'Order History2all Process Queues',
			'meta_data' => 'Meta Data',
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
		$criteria->compare('order_history2order',$this->order_history2order,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('time',$this->time,true);
		$criteria->compare('comments',$this->comments,true);
		$criteria->compare('order_history2all_process_queues',$this->order_history2all_process_queues,true);
		$criteria->compare('meta_data',$this->meta_data,true);
		$criteria->compare('is_deleted',$this->is_deleted,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AaOrderHistory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
