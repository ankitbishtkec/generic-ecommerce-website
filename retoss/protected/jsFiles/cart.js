var lastAjaxRequestForCart;
var goBackToFullCartModal = false;


function clearCart( successFunction, failureFunction )
{
	if( lastAjaxRequestForCart && lastAjaxRequestForCart.readystate != 4 )
	{
        lastAjaxRequestForCart.abort();
    }
	//add code to start visual effects of loading contents
	lastAjaxRequestForCart = $.ajax({
							method: "POST",
							data: { csrf_token: csrfTokenValue,},//L.H.S. "csrf_token" depends on config file in server
							url: globalUrl +"/cart/clearcart?ajax=1",
							error: function(xhr, status, error) {
								if( failureFunction != null )
									failureFunction( );
							},
							success:function(response){
								if( successFunction != null )
									successFunction( response );
							}
						});
}

function getCartData( location, successFunction, failureFunction )
{
	var urlString;
	if( location != null )
		urlString = globalUrl +"/cart/GetCart/location/" + location + "?ajax=1";
	else
		urlString = globalUrl +"/cart/GetCart?ajax=1";
	
	if( lastAjaxRequestForCart && lastAjaxRequestForCart.readystate != 4 )
	{
        lastAjaxRequestForCart.abort();
    }
	//add code to start visual effects of loading contents
	lastAjaxRequestForCart = $.ajax({
							method: "POST",
							data: { csrf_token: csrfTokenValue,},//L.H.S. "csrf_token" depends on config file in server
							url: urlString,
							error: function(xhr, status, error) {
								if( failureFunction != null )
									failureFunction( );
							},
							success:function(response){
								if( successFunction != null )
									successFunction( response );
							}
						});
}

function getTiffinQuantity( id, successFunction, failureFunction )
{
	if( lastAjaxRequestForCart && lastAjaxRequestForCart.readystate != 4 )
	{
        lastAjaxRequestForCart.abort();
    }
	//add code to start visual effects of loading contents
	lastAjaxRequestForCart = $.ajax({
							method: "POST",
							data: { csrf_token: csrfTokenValue,},//L.H.S. "csrf_token" depends on config file in server
							url: globalUrl +"/cart/GetQuantity/id/" + id.toString() + '?ajax=1',
							error: function(xhr, status, error) {
								if( failureFunction != null )
									failureFunction( );
							},
							success:function(response){
								if( successFunction != null )
									successFunction( response );
							}
						});
}

function addToCart( id, quantity, successFunction, failureFunction )
{
	if( quantity <= 0 )
	{
		if( failureFunction != null )
			failureFunction( );
		return;
	}
	else if( lastAjaxRequestForCart && lastAjaxRequestForCart.readystate != 4 )
	{
        lastAjaxRequestForCart.abort();
    }
	//add code to start visual effects of loading contents
	lastAjaxRequestForCart = $.ajax({
							method: "POST",
							data: { csrf_token: csrfTokenValue,},//L.H.S. "csrf_token" depends on config file in server
							url: globalUrl +"/cart/AddtoCart/id/" + id.toString() + "/quantity/" + quantity.toString() +'?ajax=1',
							error: function(xhr, status, error) {
								if( failureFunction != null )
									failureFunction( );
							},
							success:function(response){
								if( successFunction != null )
									successFunction( response );
							}
						});
}

function removeFromCart( id, successFunction, failureFunction )
{
	if( lastAjaxRequestForCart && lastAjaxRequestForCart.readystate != 4 )
	{
        lastAjaxRequestForCart.abort();
    }
	//add code to start visual effects of loading contents
	lastAjaxRequestForCart = $.ajax({
							method: "POST",
							data: { csrf_token: csrfTokenValue,},//L.H.S. "csrf_token" depends on config file in server
							url: globalUrl +"/cart/deletefromcart/id/" + id.toString() + '?ajax=1',
							error: function(xhr, status, error) {
								if( failureFunction != null )
									failureFunction( );
							},
							success:function(response){
								if( successFunction != null )
									successFunction( response );
							}
						});
}

function cartOperationFailureFunc( message, htmlElementId, htmlElementContentId, title )
{
	var htmlCode = '<div class="modal-header"><h4 class="modal-title" id="exampleModalLabel">' + title +'</h4></div><div class="modal-body"><div class="container-fluid"><div class="row"><div class="alert alert-danger text-center wordwrap" role="alert"><b>'+ message +'</b></div></div></div></div><div class="modal-footer"><button type="button" class="btn btn-default" id="modal_close" data-modalid="' + htmlElementId + '">Close</button></div>';
	$( "#" + htmlElementContentId ).html( htmlCode );
	$( "#" + htmlElementId ).modal('show');
}

function tiffinQuantitySuccessFunc( response, htmlElementId, htmlElementContentId, title )
{
	var jsonObj = jQuery.parseJSON( response );
	if( jsonObj.quantity <= 0 || jsonObj.message != 'ok' )
	{
		cartOperationFailureFunc( 'Alrighty then!!! Data on current page is outdated, kindly refresh the page.',
			htmlElementId, htmlElementContentId, "Add to Cart" );
			return;
	}
	response = '<div class="well wordwrap" style="padding: 5px; overflow:auto; height: 120px; margin-top: 5px; margin-bottom: 0px;"><b style="font-size: 110%;">' + jsonObj.name + '</b><br><p style="font-size: 90%;">' + jsonObj.contents + '</p><i class="fa fa-inr"></i>'+ ' ' + jsonObj.discounted_price + '<br>';
	response += '<select id="add_cart_selected_quantity" class="form-control">';
	for( var i = 0; i <= jsonObj.quantity; i++ )
	{
		response += '<option value="' + i.toString();
		if( i == jsonObj.selected_value || i == 1 )
			response += '" selected>' + i.toString() + '</option>';
		else
			response += '" >' + i.toString() + '</option>';
	}
	response += '</select></div>';

	var htmlCode = '<div class="modal-header"><h4 class="modal-title" id="exampleModalLabel">' + title +'</h4></div><div class="modal-body"><div class="container-fluid"><div class="row"><div class="text-center wordwrap" role="alert">' + response + '</div></div></div></div><div class="modal-footer"><button type="button" id="add_cart_1" data-tiffinid="'+ jsonObj.id.toString() +'" class="btn btn-primary">Update cart</button><button type="button" class="btn btn-default" id="modal_close" data-modalid="' + htmlElementId + '">Cancel</button></div>';
	$( "#" + htmlElementContentId ).html( htmlCode );
	$( "#" + htmlElementId ).modal('show');
	changeCartButtonValueAndUiEffect( parseInt( jsonObj.total_items ) );
}

function addToCartSuccessFunc( response, htmlElementId, htmlElementContentId, title )
{
	var jsonObj = jQuery.parseJSON( response );
	if( jsonObj.message != 'ok' )
	{
		cartOperationFailureFunc( 'Alrighty then!!! Data on current page is outdated, kindly refresh the page.',
			htmlElementId, htmlElementContentId, title);
			return;
	}

	var changedQuantity = parseInt( jsonObj.change ) ;
	if( changedQuantity == 0 )//if not change no ui effects should be done
		return;
	changeCartButtonValueAndUiEffect( parseInt( jsonObj.total_items ) );
}

function removeFromCartSuccessFunc( response, htmlElementId, htmlElementContentId, title )
{
	addToCartSuccessFunc( response, htmlElementId, htmlElementContentId, title );
}

function clearCartSuccessFunc( response, htmlElementId, htmlElementContentId, title )
{
	addToCartSuccessFunc( response, htmlElementId, htmlElementContentId, title );
}

function getCartSuccessFunc( response, location, htmlElementId, htmlElementContentId, title, allowButton )
{
	response = getCartHtmlTableStringFromJson( response, true );
	if( response == null )
	{
		cartOperationFailureFunc( 'Alrighty then!!! Data on current page is outdated, kindly refresh the page.',
			htmlElementId, htmlElementContentId, "Add to Cart" );
			return;
	}
	var buttonHtmlCode = '';
	if( allowButton )
		buttonHtmlCode = '<button type="button" class="btn btn-danger" id="clear_cart">Clear cart</button><button type="button" class="btn btn-success" id="place_order">Place order</button>';
	var htmlCode = '<div class="modal-header"><h4 class="modal-title" id="exampleModalLabel">' + title +'</h4></div><div class="modal-body"><div class="container-fluid"><div class="row"><div class="wordwrap" role="alert">' + response + '</div></div></div></div><div class="modal-footer">' + buttonHtmlCode + '<button type="button" class="btn btn-default" id="modal_close" data-modalid="' + htmlElementId + '">Close</button></div>';
	$( "#" + htmlElementContentId ).html( htmlCode );
	$( "#" + htmlElementId ).modal('show');
}

function getCartHtmlTableStringFromJson( jsonString, showButton )//it also changes cart button value if it exists
{
	var response = null;
	try
	{	
		var jsonObj = jQuery.parseJSON( jsonString );
		var totalItems = jsonObj.total_items;
		var totalItemsAtLocality = jsonObj.total_items_at_locality;
		var totalPrice = jsonObj.total_price;
		var location = jsonObj.location;
		var cartHasChanged = jsonObj.has_changed;
		response = "";
		
		if( jsonObj.has_changed )
			response += '<p class="bg-danger" style="font-size: 110%;">Cart has changed. For more details, kindly read the comments, if any. Comments can be seen in "Item" column of all rows having red background in the table below.</b>';
			
		response += '<p class="bg-info" style="font-size: 110%;">Cart has <b>' + totalItemsAtLocality + ' items</b>';
		if( jsonObj.location )
			response += " available at locality <b>" + jsonObj.location + "</b>";
		response += '. Total amount payable is <b><i class="fa fa-inr"></i>' + ' ' + totalPrice + '  </b>.';
		response += '</p>';
		
		changeCartButtonValueAndUiEffect( parseInt( totalItems ) );
		
		//remove not needed js object propoerties from js object- start	
		delete jsonObj.total_items;
		delete jsonObj.total_items_at_locality;
		delete jsonObj.total_price;
		delete jsonObj.location;
		delete jsonObj.has_changed;
		//remove not needed js object propoerties from js object- stop
		
		response += '<table class="table table-condensed" style="table-layout: fixed;"><tr><th class="wordwrap" style="width: 60%;">Item</th><th class="wordwrap" style="width: 10%;">Qty</th><th class="wordwrap" style="width: 15%;">Price</th><th class="wordwrap" style="width: 15%;">Subtotal</th></tr>';
		//if( totalItemsAtLocality == 0 && !cartHasChanged )//cart has no item and cart has not been modified i.e. server has not removed the items
		if( totalItems == 0 && !cartHasChanged )//cart has no item and cart has not been modified i.e. server has not removed the items
			response += '<tr><td>There are no items in this cart.</td><td></td><td></td><td></td></tr>';
		else
		{
			$.each( jsonObj, function( key, value ) {
				response += getCartUiTableRowHtmlCodeString( key, value, showButton);
			});
		}
		response += '</table><p style="font-size: 80%; text-align: center;" >Select date and time of delivery during checkout.</p>';
		return response;
	}
	catch( err )
	{
		return response;
	}
}

function getCartUiTableRowHtmlCodeString( key, value, showButton)//add button enable disable argument here
{
	if (typeof( showButton ) === "undefined")//setting default value 
	{ 
		showButton = true; 
	}
	var response = null;
	var buttonEdit = " ";
	var buttonRemove = " ";
	try
	{
		if( showButton )
		{
			buttonEdit = '<br><br><i class="fa fa-3x fa-edit" style="color: #EAEAE4; cursor: pointer;" id="floating_cart_modal_content_edit" data-tiffinid="' + value.id +'"></i>';
			buttonRemove = '<br><br><i class="fa fa-3x fa-times" style="color: #EAEAE4; cursor: pointer;" id="floating_cart_modal_content_remove" data-tiffinid="' + value.id +'"></i>';
		}
		response = "";
		var classString = "";
		var tiffinAvailablityStatus = "";
		if( value.is_available_at_current_locality == false )
		{
			classString = ' class="warning"';
			tiffinAvailablityStatus = '<p style="font-size: 80%; color:red;"><b>Availability status: </b>' + cartErrorMsgTiffinNotAvailableInCurrLocality + '</p>';
		}
		if( value.has_changed == false )//no issue
		{
			response += '<tr' + classString +'><td><a target="_blank" href="' + globalUrl + "/tiffin/view/id/" 
			+ value.tiffin_name + "-" + key +'"><img src="' + value.image_link 
			+ '" alt="Loading..." style="width: 70px; float: left; height: 70px; margin-right: 5px; margin-bottom: 5px;"></a><b>' + 
			value.tiffin_name + '</b>' + /*'<p style="font-size: 80%;">' + value.tiffin_content + 
			'</p>'*/ '<p style="font-size: 80%;">Earliest delivery: <span style="color:rgba( 0, 0, 255, 0.75);"><b>' + value.delivery_time + 
			'</b></span>.</p>' 
			+ tiffinAvailablityStatus +
			'</td><td>  ' + value.quantity + '</td><td><i class="fa fa-inr"></i>' + ' ' + 
			value.per_unit_price + ' ' + buttonEdit +'</td><td><b><i class="fa fa-inr"></i>' + ' ' + ( parseInt( value.quantity ) * parseInt( value.per_unit_price ) ) +
			' </b>' + buttonRemove + '</td></tr>';
		}
		else if( value.error_msg == cartErrorMsgTiffinQuanCappedToLimits )
		{
			response += '<tr class="danger" ><td><a target="_blank" href="' + globalUrl + "/tiffin/view/id/" + value.tiffin_name + "-" + key +'"><img src="' + 
			value.image_link + '" alt="Loading..." style="width: 70px; float: left; height: 70px; margin-right: 5px; margin-bottom: 5px;"></a><b>' + 
			value.tiffin_name + '</b><p style="font-size: 80%;">' + value.tiffin_content + 
			'</p><p style="font-size: 80%;">Earliest delivery: <span style="color:blue;"><b>' + value.delivery_time + 
			'</b></span>.</p>' + tiffinAvailablityStatus 
			+ '<p style="font-size: 80%; color:red;"><b>Comments: </b>' + value.error_msg + 
			'</p></td><td>  ' + value.quantity + '</td><td><i class="fa fa-inr"></i>' + ' ' + 
			value.per_unit_price + ' ' + buttonEdit +'</td><td><b><i class="fa fa-inr"></i>' + ' ' + ( parseInt( value.quantity ) * parseInt( value.per_unit_price ) ) +
			' </b>' + buttonRemove + '</td></tr>';
		}
		else if( value.error_msg == cartErrorMsgTiffinNotAvailable )
		{
			response += '<tr class="danger" ><td><a target="_blank" href="' + globalUrl + "/tiffin/view/id/" + value.tiffin_name + "-" + key +'"><img src="' + 
			value.image_link + '" alt="Loading..." style="width: 70px; float: left; height: 70px; margin-right: 5px; margin-bottom: 5px;"></a><b>' + 
			value.tiffin_name + '</b><p style="font-size: 80%;">' + value.tiffin_content + 
			'</p>' + tiffinAvailablityStatus + '<p style="font-size: 80%; color:red;"><b>Comments: </b>'
			+ value.error_msg + 
			'</p></td><td></td><td></td><td></td></tr>';
		}
		// cartErrorMsgTiffinNotExist condition has not been used here intentionally.
		
		return response;
	}
	catch( err )
	{
		return response;
	}
}

function changeCartButtonValueAndUiEffect( value, isInputValueRelative )
{
	if (typeof( isInputValueRelative ) === "undefined")//setting default value 
	{ 
		isInputValueRelative = false; 
	}
	
	if( ( $( "#floatingCartButton" ).length > 0 ) && ( $( "#floatingCartButtonValue" ).length > 0 ) )//if both element exists
	{
		$( "#floatingCartButton" ).effect( "highlight" , "slow");
		$( "#floatingCartButton" ).effect( "highlight" , "slow");
		$( "#floatingCartButton" ).effect( "highlight" , "slow");
		var currentValue = 0;
		if( isInputValueRelative )
			currentValue = parseInt( $( "#floatingCartButtonValue" ).html() );
		var newValue = currentValue + value;
		$( "#floatingCartButtonValue" ).html( newValue );
	}
}

function addEventHandlersForFloatingCart( )//add event handlers only if elements are present
{
	if( ( $( "#content" ).length > 0 ) )
	$("#content").on("click","#add_cart",function( e ){
		if( $(this).attr("data-tiffinid") )
			getTiffinQuantity( $(this).attr("data-tiffinid"), 
				function( response ){
					tiffinQuantitySuccessFunc( response, "cartAddEditModal", "cartAddEditModalContent", "Add to Cart" );
				}, 
				function(){
					cartOperationFailureFunc( 'Alrighty then!!! Some error has occured, kindly refresh the page.',
					"cartAddEditModal", "cartAddEditModalContent", "Add to Cart" );
				}
				);
	});
	
	if( ( $( "#cartAddEditModalContent" ).length > 0 ) )//quantity edit modal add to cart btton click handler
	$("#cartAddEditModalContent").on("click","#add_cart_1",function( e ){
		if( $(this).attr("data-tiffinid") )
		if( $("#cartAddEditModal #add_cart_selected_quantity").val() <= 0)//remove the tiffin
			removeFromCart( $(this).attr("data-tiffinid"),
				function( response ){
					removeFromCartSuccessFunc( response, "cartAddEditModal", "cartAddEditModalContent", "Add to Cart" );
					$( "#cartAddEditModal" ).modal('hide');//hide the modal now
				}, 
				function(){
					cartOperationFailureFunc( 'Alrighty then!!! Some error has occured, kindly refresh the page.',
					"cartAddEditModal", "cartAddEditModalContent", "Add to Cart" );
				}
				);
		else//add to cart
			addToCart( $(this).attr("data-tiffinid"), $("#cartAddEditModal #add_cart_selected_quantity").val(),
				function( response ){
					addToCartSuccessFunc( response, "cartAddEditModal", "cartAddEditModalContent", "Add to Cart" );
					$( "#cartAddEditModal" ).modal('hide');//hide the modal now
				}, 
				function(){
					cartOperationFailureFunc( 'Alrighty then!!! Some error has occured, kindly refresh the page.',
					"cartAddEditModal", "cartAddEditModalContent", "Add to Cart" );
				}
				);
	});
	
	if( ( $( "#floatingCartButton" ).length > 0 ) )
		$("#floatingCartButton").on("click", function( e ){
			goBackToFullCartModal = false;//opened by cart button click no need to go back to cart
			var location = null;
			getCartData( location, 
				function( response ){
					getCartSuccessFunc( response, location, "floatingCartModal", "floatingCartModalContent", "Cart", true );
				}, 
				function(){
					cartOperationFailureFunc( 'Alrighty then!!! Some error has occured, kindly refresh the page.',
					"floatingCartModal", "floatingCartModalContent", "Cart" );
				}
				);
		});
		
	if( ( $( "#floatingCartModalContent" ).length > 0 ) )//event handler for edit button in cart modal
	$("#floatingCartModalContent").on("click","#floating_cart_modal_content_edit",function( e ){
		if( $(this).attr("data-tiffinid") )
		{
			goBackToFullCartModal = true;//opening the editin modal from cart modal so making goBackToFullCartModal true
			getTiffinQuantity( $(this).attr("data-tiffinid"), 
				function( response ){
					tiffinQuantitySuccessFunc( response, "floatingCartModal", "floatingCartModalContent", "Add to Cart" );
				}, 
				function(){
					cartOperationFailureFunc( 'Alrighty then!!! Some error has occured, kindly refresh the page.',
					"floatingCartModal", "floatingCartModalContent", "Add to Cart" );
				}
				);
		}
	});
		
	if( ( $( "#floatingCartModalContent" ).length > 0 ) )//event handler for remove button in cart modal
	$("#floatingCartModalContent").on("click","#floating_cart_modal_content_remove",function( e ){
		if( $(this).attr("data-tiffinid") )
		{
			goBackToFullCartModal = true;//opening the editin modal from cart modal so making goBackToFullCartModal true
			removeFromCart( $(this).attr("data-tiffinid"),
				function( response ){
					removeFromCartSuccessFunc( response, "floatingCartModal", "floatingCartModalContent", "Remove from Cart" );
					//$( "#cartAddEditModal" ).modal('hide');//do not hide rather notify user
					//cartOperationFailureFunc( 'Selected item removed !!!',
					//"floatingCartModal", "floatingCartModalContent", "Remove from Cart" );
					{
						goBackToFullCartModal = false;//this else operation takes back to cart modal so making goBackToFullCartModal as false
						var location = null;
						//added to make sure cart returns to same cartdata w.r.t. location selected
						if( ( $( "#selected_locality" ).length > 0 ) )
						location = $( "#selected_locality" ).val( );
						if( location == "")
						{
							//console.log("made null");
							location = null;
						}
						
						var allowButton = true;
						if( location != null )
							allowButton = false;
							
						getCartData( location, 
							function( response ){
								getCartSuccessFunc( response, location, "floatingCartModal", "floatingCartModalContent", "Cart", allowButton );
							}, 
							function(){
								cartOperationFailureFunc( 'Alrighty then!!! Some error has occured, kindly refresh the page.',
								"floatingCartModal", "floatingCartModalContent", "Cart" );
							}
							);
					}
				}, 
				function(){
					cartOperationFailureFunc( 'Alrighty then!!! Some error has occured, kindly refresh the page.',
					"floatingCartModal", "floatingCartModalContent", "Remove from Cart" );
				}
			);
		}
	});
	
	if( ( $( "#cartAddEditModalContent" ).length > 0 ) )//close second modal's button handler
	$("#cartAddEditModalContent").on("click","#modal_close",function( e ){
		if( $(this).attr("data-modalid") )
			$( "#" + $(this).attr("data-modalid") ).modal('hide');
	});
	
	if( ( $( "#floatingCartModalContent" ).length > 0 ) )//close first modal's button handler
	$("#floatingCartModalContent").on("click","#modal_close",function( e ){
		if( goBackToFullCartModal == false )
		{
			if( $(this).attr("data-modalid") )
				$( "#" + $(this).attr("data-modalid") ).modal('hide');
		}
		else
		{
			goBackToFullCartModal = false;//this else operation takes back to cart modal so making goBackToFullCartModal as false
			var location = null;
			//added to make sure cart returns to same cartdata w.r.t. location selected
			if( ( $( "#selected_locality" ).length > 0 ) )
			location = $( "#selected_locality" ).val( );
			if( location == "")
			{
				//console.log("made null");
				location = null;
			}
			
			var allowButton = true;
			if( location != null )
				allowButton = false;
				
			getCartData( location, 
				function( response ){
					getCartSuccessFunc( response, location, "floatingCartModal", "floatingCartModalContent", "Cart", allowButton );
				}, 
				function(){
					cartOperationFailureFunc( 'Alrighty then!!! Some error has occured, kindly refresh the page.',
					"floatingCartModal", "floatingCartModalContent", "Cart" );
				}
				);
		}
	});
	
	if( ( $( "#floatingCartModalContent" ).length > 0 ) )//quantity edit modal ( inside floatingCartModalContent) add to cart btton click handler
	$("#floatingCartModalContent").on("click","#add_cart_1",function( e ){
		if( $(this).attr("data-tiffinid") )
		if( $("#floatingCartModal #add_cart_selected_quantity").val() <= 0)//remove the tiffin
			removeFromCart( $(this).attr("data-tiffinid"),
				function( response ){
					removeFromCartSuccessFunc( response, "floatingCartModal", "floatingCartModalContent", "Add to Cart" );
					//$( "#cartAddEditModal" ).modal('hide');//do not hide rather notify user
					
					//cartOperationFailureFunc( 'Selected item removed !!!',
					//"floatingCartModal", "floatingCartModalContent", "Remove from Cart" );
					{
						goBackToFullCartModal = false;//this else operation takes back to cart modal so making goBackToFullCartModal as false
						var location = null;
						//added to make sure cart returns to same cartdata w.r.t. location selected
						if( ( $( "#selected_locality" ).length > 0 ) )
						location = $( "#selected_locality" ).val( );
						if( location == "")
						{
							//console.log("made null");
							location = null;
						}
						
						var allowButton = true;
						if( location != null )
							allowButton = false;
							
						getCartData( location, 
							function( response ){
								getCartSuccessFunc( response, location, "floatingCartModal", "floatingCartModalContent", "Cart", allowButton );
							}, 
							function(){
								cartOperationFailureFunc( 'Alrighty then!!! Some error has occured, kindly refresh the page.',
								"floatingCartModal", "floatingCartModalContent", "Cart" );
							}
							);
					}
				}, 
				function(){
					cartOperationFailureFunc( 'Alrighty then!!! Some error has occured, kindly refresh the page.',
					"floatingCartModal", "floatingCartModalContent", "Add to Cart" );
				}
				);
		else//add to cart
			addToCart( $(this).attr("data-tiffinid"), $("#floatingCartModal #add_cart_selected_quantity").val(),
				function( response ){
					addToCartSuccessFunc( response, "floatingCartModal", "floatingCartModalContent", "Add to Cart" );
					//$( "#cartAddEditModal" ).modal('hide');//do not hide rather notify user
					//cartOperationFailureFunc( 'Selected quantity updated !!!',
					//"floatingCartModal", "floatingCartModalContent", "Add to Cart" );
					{
						goBackToFullCartModal = false;//this else operation takes back to cart modal so making goBackToFullCartModal as false
						var location = null;
						//added to make sure cart returns to same cartdata w.r.t. location selected
						if( ( $( "#selected_locality" ).length > 0 ) )
						location = $( "#selected_locality" ).val( );
						if( location == "")
						{
							//console.log("made null");
							location = null;
						}
						
						var allowButton = true;
						if( location != null )
							allowButton = false;
							
						getCartData( location, 
							function( response ){
								getCartSuccessFunc( response, location, "floatingCartModal", "floatingCartModalContent", "Cart", allowButton );
							}, 
							function(){
								cartOperationFailureFunc( 'Alrighty then!!! Some error has occured, kindly refresh the page.',
								"floatingCartModal", "floatingCartModalContent", "Cart" );
							}
							);
					}
				}, 
				function(){
					cartOperationFailureFunc( 'Alrighty then!!! Some error has occured, kindly refresh the page.',
					"floatingCartModal", "floatingCartModalContent", "Add to Cart" );
				}
				);
	});
	
	if( ( $( "#floatingCartModalContent" ).length > 0 ) )//close first modal's button handler
	$("#floatingCartModalContent").on("click","#clear_cart",function( e ){
		goBackToFullCartModal = true;//opening the editin modal from cart modal so making goBackToFullCartModal true
		clearCart( 
			function( response ){
					clearCartSuccessFunc( response, "floatingCartModal", "floatingCartModalContent", "Clear cart" );
					//cartOperationFailureFunc( 'Cart cleared !!!',
					//"floatingCartModal", "floatingCartModalContent", "Clear cart" );
					{
						goBackToFullCartModal = false;//this else operation takes back to cart modal so making goBackToFullCartModal as false
						var location = null;
						//added to make sure cart returns to same cartdata w.r.t. location selected
						if( ( $( "#selected_locality" ).length > 0 ) )
						location = $( "#selected_locality" ).val( );
						if( location == "")
						{
							//console.log("made null");
							location = null;
						}
						
						var allowButton = true;
						if( location != null )
							allowButton = false;
							
						getCartData( location, 
							function( response ){
								getCartSuccessFunc( response, location, "floatingCartModal", "floatingCartModalContent", "Cart", allowButton );
							}, 
							function(){
								cartOperationFailureFunc( 'Alrighty then!!! Some error has occured, kindly refresh the page.',
								"floatingCartModal", "floatingCartModalContent", "Cart" );
							}
							);
					}

				}, 
				function(){
					cartOperationFailureFunc( 'Alrighty then!!! Some error has occured, kindly refresh the page.',
					"floatingCartModal", "floatingCartModalContent", "Clear cart" );
				}
			);
	});
	
	if( ( $( "#floatingCartModalContent" ).length > 0 ) )//close first modal's button handler
	$("#floatingCartModalContent").on("click","#place_order",function( e ){
		var url = globalUrl + "/cart/checkout";
  		window.location.href = url ;
  		event.preventDefault();
	});
}
