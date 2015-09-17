<?php

/**
 * TiffinPriceTimeSelectionForm class.
 * TiffinPriceTimeSelectionForm is the data structure for keeping
 * tiffin id, its quantity, its selected pricetime id and 
 * array of pricetime ids which are acceptable for given tiffin id and quantity
 * 
 */
class TiffinPriceTimeSelectionForm extends CFormModel
{
	//selected pricetime id
	public $selectedPriceTimeId;
		
	//***

	//tiffin id
	public $tiffinId;
	
	//quantity
	public $quantity;
	
	//aOrder Object
	/* @var $aOrderObj AOrder */
	public $aOrderObj;
	
	//per unit price 
	public $perUnitPrice = null;//filled after successful validation
	
	//total price 
	public $totalPrice = 0;//filled after successful validation
	
	//selected APriceTime object
	/* @var $selectedAPriceTimeObj APriceTime */
	public $selectedAPriceTimeObj = null;//filled after successful validation
	
	//allowed APriceTime objects array ordered by delivey time increasing
	public $allowedAPriceTimeObjArray = array();
	
	//encrypted order id
	public $encryptedOrderId;	
	
	/**
	 * constructor with arguments
	 */
	public function __construct( $aOrderObj, $encryptedOrderId )
	{
		parent::__construct();
		
		$this->aOrderObj = $aOrderObj;
		$this->tiffinId = $aOrderObj->order2tiffin;
		$this->quantity = $aOrderObj->num_of_units;
		$this->encryptedOrderId = $encryptedOrderId;
		$this->allowedAPriceTimeObjArray = AppCommon::getAllowedAPriceTimeObjForGivenTiffinAndQuantity( $this->tiffinId, 
			$this->quantity );
		if( !isset( $this->allowedAPriceTimeObjArray ) || count( $this->allowedAPriceTimeObjArray ) < 1 )
		{
			//redirect to first checkout stage screen for order editing
			Yii::app()->getRequest()->redirect( 
				Yii::app()->getRequest()->getHostInfo().
				Yii::app()->getRequest()->getScriptUrl().
				'/cart/checkout/id/'.
				$this->encryptedOrderId
			);
		}
	}

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('selectedPriceTimeId,', 'required'),
				
			array('selectedPriceTimeId', 'customInputValidator'),
		);
	}

	/**
	 * Authenticates all the inputs and there relations with each other
	 * returning true false does not stops proceeding to action. to stop add error to attribute.
	 */
	public function customInputValidator($attribute,$params)
	{
		//check if selectedPriceTimeId has been passed
		if( isset( $this->selectedPriceTimeId ) &&  !( AppCommon::isEmpty( $this->selectedPriceTimeId ) ) )
		{
			if( isset( $this->allowedAPriceTimeObjArray ) && count( $this->allowedAPriceTimeObjArray ) > 0 )
			{
				$this->selectedAPriceTimeObj = null;
				$this->perUnitPrice = null;
				$this->totalPrice = 0;
				foreach ( $this->allowedAPriceTimeObjArray as $row ) 
				{
					if( $row->id == $this->selectedPriceTimeId )
					{
						$this->selectedAPriceTimeObj = $row;//set TiffinPriceTimeSelectionForm to selected APriceTime object
						$this->perUnitPrice = $row->price_after_discount;
						$this->totalPrice = $row->price_after_discount * $this->quantity;
						break;
					}
				}
				
				if( !isset( $this->selectedAPriceTimeObj ) )//if it is null
				{
					$this->addError("selectedPriceTimeId",CHtml::encode("Kindly select a valid delivery time."));
				}
			}
			else 
			{
				//here the control will not reach as this condition has been checked in constructor.
				//$this->addError("selectedPriceTimeId",CHtml::encode("This tiffin is not available now. Kindly press the edit button."));
				$this->addError("selectedPriceTimeId",CHtml::encode("Some error has occured. Kindly press the edit order button."));
			}	
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
			'selectedPriceTimeId'=>'Delivery time',
		);
	}
}