<?php

//first discount from coupon should be calculated
//then additional validation on wallet amount used etc should be done on CheckoutSecondStageForm object
/**
 * ApplicationCommonCoupon class store those methods which are commonly used by the application for coupon codes
 * author: ankit
 */
class AppCommonCoupon
{
	//coupon block- start

	/**
	 * returns array of coupon codes
	 * coupon id should be in lower case
	 * format 
	 * array(
	 *	'couponid'=>array(
	 *		'condition_name1'=> array(//all permissible values),
	 *		'condition_name2'=> valueToCompare,
	 *		'condition_name3'=> array( array(//nested array, all values not permissible) ),
	 *		.. ),
	 *	.. )
	 * @return array of coupon codes
	 */
	public static function getCouponCodeArray()
	{
		return array
		(
			'twwalletpay'=> array
			(
				'date_start'=> '2015-08-13 01:00:00',
				'date_end'=> '2016-08-13 01:00:00',
				'min_price'=> 0,//for being applicable
				'max_price'=> 100000,
				'min_quantity'=> 0,//for being applicable
				'max_quantity'=> 100000,
				'discount_percentage'=> 10,
				'max_discount_amount'=> 100,
				'approximate_to_nearest_tenth'=>true,
				'hash_separated rules'=>'10% discount on paying by TW wallet.#maximum upto 100 rupees.',
				
				'payment_method'=>array( 1, ),//wallet only
			),
			'atleasttwo'=> array
			(
				'date_start'=> '2015-08-13 01:00:00',
				'date_end'=> '2016-08-13 01:00:00',
				'min_price'=> 0,//for being applicable
				'max_price'=> 100000,
				'min_quantity'=> 0,//for being applicable
				'max_quantity'=> 100000,
				'discount_percentage'=> 10,
				'max_discount_amount'=> 100,
				'approximate_to_nearest_tenth'=>true,
				'return_to_wallet'=>false,
				'hash_separated rules'=>'10% discount on ordering more that one recipe.#maximum upto 100 rupees.',
			),
			'twoandwallet'=> array
			(
				'date_start'=> '2015-08-13 01:00:00',
				'date_end'=> '2016-08-13 01:00:00',
				'min_price'=> 0,//for being applicable
				'max_price'=> 100000,
				'min_quantity'=> 0,//for being applicable
				'max_quantity'=> 100000,
				'discount_percentage'=> 15,
				'max_discount_amount'=> 100,
				'approximate_to_nearest_tenth'=>true,
				'return_to_wallet'=>false,
				'hash_separated rules'=>'15% discount on ordering more that one recipe and paying by wallet.#maximum upto 100 rupees.',
				
				'payment_method'=>array( 0, ),//wallet only
			),
			'twtaste'=> array
			(
				'date_start'=> '2015-08-13 01:00:00',
				'date_end'=> '2016-08-13 01:00:00',
				'min_price'=> 0,//for being applicable
				'max_price'=> 10000,
				'min_quantity'=> 0,//for being applicable
				'max_quantity'=> 100000,
				'discount_percentage'=> 100,
				'max_discount_amount'=> 150,
				'approximate_to_nearest_tenth'=>true,
				'return_to_wallet'=>true,
				'hash_separated rules'=>'100% discount on order.#maximum upto 150 rupees.',

			),
		);
	}


	//first discount from coupon should be calculated
	//then additional validation on wallet amount used etc should be done on CheckoutSecondStageForm object
	/**
	 * processes the coupon code on CheckoutSecondStageForm object
	 * @return array( return_to_wallet, amount of discount ) or false if invalid coupon code
	 */
	public static function getDiscountFromCoupon( $couponCode =  null, CheckoutSecondStageForm $object = null )
	{
		if( !isset( $couponCode ) || !isset( $object ) )
			return false;
		
		//TODO fill it properly first make coupon code lowercase
		if ( $couponCode == '10cashback' )
			return array( true, 10 );
		else if ( $couponCode == '10discount' )
			return array( false, 10 );
		else
			return false;
	}

	//coupon block- stop
	
}

