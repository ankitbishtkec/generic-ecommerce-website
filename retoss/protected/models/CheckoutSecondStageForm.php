<?php

/**
 * CheckoutSecondStageForm class.
 * CheckoutSecondStageForm is the data structure for keeping
 * tifin's price time, paymentMethod, Coupon code and amount to be used from wallet.
 */
class CheckoutSecondStageForm extends CFormModel
{
	//make it continous from 1 to n so that range can be used to check if the values are allowed
	//currently 1- complete payment from wallet
	//2- payment gateway PayU money
	//3- cash on delivery
	public $paymentMethod;
	
	//coupon code
	public $couponCode;
	
	//amount Used From Wallet
	public $amountUsedFromWallet = 0;
	
	//price-time selection array for all tiffins
	//array of TiffinPriceTimeSelectionForm objects
	public $tiffinPriceTimeSelectionArr = array();
	
	//***
	
	//added just to show error messages which cannot be a part of any input field
	//it also allows us to add errors to any input field
	//never add any other validator besides 'customInputValidator' for checking this
	//and never display its value to user screen it might contain some values which can be used for optimisation
	public $extraErrorMessages;
	
	//total items in order
	public $totalItemsInOrder;
	
	//total amount in Wallet
	public $totalAmountInWallet;
	
	//array( 
	// sum of all tiffin and quantity ,
	// discount from coupon code, 
	// cashback from coupon code,
	// ( sum of all tiffin and quantity + discount from coupon code ) as total 
	// )
	//filled only after validation $this->validate()
	public $billArray = null ;
	
	//order id
	public $orderId;
	
	//encrypted order id
	public $encryptedOrderId;
	
	//destination locality
	public $destinationLocality;	
	
	//userId
	public $userId;	
	
	/**
	 * constructor with arguments
	 */
	public function __construct( $orderId, $userId )
	{
		parent::__construct();
		
		$this->orderId = $orderId;
		$this->encryptedOrderId = Yii::app()->getSecurityManager()->hashData( $orderId );
		
		$selectedOrders = null;
		
		//if order id belongs to current user and is in 'order_start' status
		//(other status mean order has already crossed the checkout process once)
		//as order id's input has been added to checkout action to facilitate the 
		//order resumption. Note: As order is being modified or created in this function
		//do check before any POST or GET if order can be modified. Order can be modified
		//only and only if it is in 'order-start' status.
		$selectedOrders = AOrder::model()->findAll( array(
				'order'=> 'id' ,
        		'condition'=>'is_deleted = "no" AND ordered_by2user_details = '.$userId.
        		' AND  order_unique_id = "'.$orderId.'" '.
        		' AND  status = "order_start" ',//'order_start' status
    			) 
			);
		if( !( isset( $selectedOrders ) ) || count( $selectedOrders ) < 1 )//no orders selected
		{
			$this->render('cart_error',array('errorMessage'=>"Either this page does not exists or has expired or you are not allowed to view this page.", 
				'link'=>CHtml::normalizeUrl( array('cart/checkout') ) ) );
			Yii::app()->end();
		}
		
		$this->totalItemsInOrder = 0;
		foreach ( $selectedOrders as $row )
		{
			$this->tiffinPriceTimeSelectionArr[] = new TiffinPriceTimeSelectionForm( 
				$row,
				$this->encryptedOrderId
			);
			$this->destinationLocality = $row->destination_locality;
			$this->totalItemsInOrder = $this->totalItemsInOrder + $row->num_of_units;
		}
		
		$this->totalAmountInWallet = AppCommonWallet::getTotalAmountInWalletForUser( $userId );		
		$this->amountUsedFromWallet = 0;
		$this->userId = $userId;
	}
	
	/**
	 * private function: to make sure it is not called from outside
	 *
	 * returns price array
	 * discount coupon is also calculated inside it
	 * return array( 
	 * sum of all tiffin and quantity ,
	 * discount from coupon code, 
	 * cashback from coupon code,
	 * ( sum of all tiffin and quantity + discount from coupon code ) as total 
	 * )
	 */
	private function calculateBillAndItsComponents( $ignoreDiscounts = false )
	{
		$response = array(0, 0, 0, 0);
		$sum = 0;
		foreach( $this->tiffinPriceTimeSelectionArr as $row )
		{
			$sum = $sum + $row->totalPrice;
		}
		$response[ 0 ] = $sum;
		
		if( !$ignoreDiscounts )//do not ignore discounts
		if( !AppCommon::isEmpty( $this->couponCode ))
		{
			if( ( $discount = AppCommonCoupon::getDiscountFromCoupon( $this->couponCode, $this ) ) )
			{
				if( $discount[ 0 ] )//return to wallet i.e. cashback
				{
					$response[ 2 ] = $discount[ 1 ];
				}
				else//subtract discount right away 
				{
					$response[ 1 ] = $discount[ 1 ] * ( -1 );
				}
			}
			else//coupon code is invalid 
			{
				$this->addError("couponCode",
					CHtml::encode("Invalid or expired coupon code."));	
			}
		}
			
		
		
		$response[ 3 ] = $response[ 0 ] + $response[ 1 ];
		
		return $response;
	}

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('paymentMethod', 'required'),
			
			array('amountUsedFromWallet', 'required', 'message' => "Kindly fill this field. In case of no balance in wallet, kindly fill the field with zero." ),
			
			array('amountUsedFromWallet', 'numerical', 'min'=>0, 'tooSmall'=>'Amount cannot be negative.',),
			
			array('paymentMethod','numerical', 'integerOnly'=>true, 'min'=>1, 'max'=>3,
				'tooSmall'=>'Kindly select a valid payment method.', 
				'tooBig'=>'Kindly select a valid payment method.'),
				
			array('couponCode', 'safe'),//adding couponCode member to a validator to allow mass assignment
				
			array('extraErrorMessages', 'customInputValidator'),
		);
	}

	/**
	 * Authenticates all the inputs and there relations with each other
	 * returning true false does not stops proceeding to action. to stop add error to attribute.
	 */
	public function customInputValidator($attribute,$params)
	{
		//check if order's tiffin and quantity is still available or has changed - start
			//no need to check here as when CheckoutSecondStageForm object is created it also creates 
			//TiffinPriceTimeSelectionForm objects for each tiffin and if the returned pricetime rows,
			//which shows the availability of the tiffin for the given quantity at given time, is zero 
			//it is redirected from the constructor to stage first of checkout
		//check if order's tiffin and quantity is still available or has changed - stop
		
		
		$isAllTiffinPriceTimeSelectionFormValid = true;
		foreach( $this->tiffinPriceTimeSelectionArr as $row )
		{
			if( ! $row->validate() )
				$isAllTiffinPriceTimeSelectionFormValid = false;
		}
		
		//check if all the TiffinPriceTimeSelectionForm are valid
		if( $isAllTiffinPriceTimeSelectionFormValid )
		{
			//check if low level errors in payment method and amountUsedFromWallet is not there
			if( ! $this->hasErrors( 'paymentMethod' ) && ! $this->hasErrors( 'amountUsedFromWallet' ) )
			{	
				if( $this->amountUsedFromWallet > $this->totalAmountInWallet )
					$this->addError("amountUsedFromWallet",
						CHtml::encode("The input amount exceeds your wallet."));
				
				//first discount from coupon should be calculated
				//then additional validation on wallet amount used etc should be done on CheckoutSecondStageForm object	
				$this->billArray = $this->calculateBillAndItsComponents();
				$payableAmount = $this->billArray[ 3 ];
				if( $this->paymentMethod == 1 )//wallet
				{	
					if( $this->amountUsedFromWallet != $payableAmount )
						$this->addError("amountUsedFromWallet",
							CHtml::encode("For payment by wallet, input amount must be equal to the payable amount. Kindly correct the amount."));
				}
				else if( $this->paymentMethod == 2 || $this->paymentMethod == 3 )//online payment or COD
				{								
					if( $this->amountUsedFromWallet >= $payableAmount )//equal to or more than
						$this->addError("amountUsedFromWallet",
							CHtml::encode("For online payment or cash on delivery, input amount must be less than the payable amount. Kindly correct the amount."));
				}
			}	
		}
		else 
		{
			$this->billArray = $this->calculateBillAndItsComponents( true );//calculate bill
			$this->addError("extraErrorMessages",
				CHtml::encode("Kindly re-select delivery time for each recipe."));
		}
	}

	/**
	 * Overloaded function
	 *
	 * Removes errors for all attributes or a single attribute.
	 * @param string $attribute attribute name. Use null to remove errors for all attribute.
	 */
	public function clearErrors($attribute=null)
	{
		parent::clearErrors( $attribute );
		foreach( $this->tiffinPriceTimeSelectionArr as $row )
			$row->clearErrors( $attribute );
	}
	
	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'paymentMethod'=>'Payment method( Choose any one below )',
			'couponCode'=>'Coupon code( Apply coupon code, if any )',
			'amountUsedFromWallet'=>'Amount to be used from tw.in wallet',
		);
	}
}