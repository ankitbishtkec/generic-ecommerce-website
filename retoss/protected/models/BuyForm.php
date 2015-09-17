<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class BuyForm extends CFormModel
{
	public $name;
	public $quantity;
	public $email;
	public $phone;
	public $techpark;
	public $address;
	public $paymentMode;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
			array('phone, techpark, address, quantity, paymentMode', 'required'),
			array('phone', 'numerical'),
			array('phone', 'length', 'min'=>10, 'max'=>10,),
			array('techpark, address', 'length', 'min'=>10,),
			array('quantity', 'numerical', 'min'=>1, 'max'=>20,),
			// email has to be a valid email address
			array('email', 'email'),
			//setting default values
			array('paymentMode', 'default', 'value'=>'CASH ON DELIVERY'),
			array('name', 'default', 'value'=>Yii::app()->user->name),
			array('email', 'default', 'value'=>AppCommon::getEmail( )),
		);
	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'name'=>'Name',
			'phone'=>'Mobile number( without country code )',
			'paymentMode'=>'Payment mode( please select any one )',
		);
	}
}