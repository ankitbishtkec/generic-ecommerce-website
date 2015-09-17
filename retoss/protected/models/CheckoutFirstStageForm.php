<?php

/**
 * CheckoutFirstStageForm class.
 * CheckoutFirstStageForm is the data structure for keeping
 * address and phone number for a order..
 */
class CheckoutFirstStageForm extends CFormModel
{
	public $phone;
	public $address;
	//added just to show error messages which cannot be a part of any input field
	//it also allows us to add errors to any input field
	//never add any other validator besides 'customInputValidator' for checking this
	//and never display its value to user screen it might contain some values which can be used for optimisation
	public $extraErrorMessages;
	public $customerLocality;//not saved, real locality is extracted from "$address" above
	
	public $getCartArray = array();//not used in view or displaying
	//used to store the getCart() array return during custom validation.
	//the array is reused and reusing save some query computation cost
	
	public $getAddressData = array();//not used in view or displaying
	//used to store the selected address details array( addrId => array( locality, addrText ) ) 
	//returned during custom validation.
	//the array is reused and reusing save some query computation cost

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('phone, address,', 'required'),
			array('phone', 'numerical'),
			array('phone', 'length', 'min'=>10, 'max'=>10,),
			array('extraErrorMessages', 'customInputValidator'),
			array('customerLocality', 'safe'),//adding customerLocality member to a validator to allow mass assignment
			array('phone', 'match', 'pattern' => '/^[789]\d{9}$/u','message' => CHtml::encode("Kindly enter correct mobile number( without country code ).")),
		);
	}

	/**
	 * Authenticates the all inputs and there relations with each other
	 * returning true false does not stops proceeding to action. to stop add error to attribute.
	 */
	public function customInputValidator($attribute,$params)
	{
		//check if address has been passed
		if( isset( $this->address ) &&  !( AppCommon::isEmpty( $this->address ) ) )
		{
			//if passed check if address passed is allowed for the given user
			//array( addrId => array( locality, addrText ) )
			$allowedAddresses = AAddress::model()->getAllowedAddressForUser( AppCommon::getUserDetailsId() );
			if( ! isset( $allowedAddresses[ $this->address] ) )
			{
				$this->addError("address",CHtml::encode("Kindly select a valid address."));
				return;
			}
			//continue to check more errors only if address selected is valid 
			//as cart depends on a valid address
			
			//set customerLocality a valid value taken from selected address this will override
			//upon the value passed by user and thus will be more reliable value
			$this->customerLocality = $allowedAddresses[ $this->address][ 0 ];
			
			$this->getAddressData[ $this->address] = $allowedAddresses[ $this->address];
			
			$this->getCartArray = ACart::getCart( $this->customerLocality, 0 );
			
			//check if cart has rows > 0 for the selected locality 
			if( isset( $this->getCartArray ) && isset( $this->getCartArray["total_items_at_locality"] ) 
			&& $this->getCartArray["total_items_at_locality"] <= 0 )
				$this->addError("extraErrorMessages",
				CHtml::encode("Error: The cart contains no tiffins which are available at the selected address's locality. Kindly, either add tiffins available at selected address's locality to the cart or select addresses with different locality."));
			
			//check if for selected locality cart has not changed 	
			if( AppCommon::hasCartChanged( $this->getCartArray ) )	
				$this->addError("extraErrorMessages",
				CHtml::encode("Notification: The cart has changed. Kindly retry."));
			
		}
	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'phone'=>'Mobile number( without country code )',
			'address'=>'Address( Choose any one below or add a new address)',
		);
	}
}