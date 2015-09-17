var lastAjaxRequestForAddress;

function addAddressGetMethodCall( successFunction, failureFunction )
{
	if( lastAjaxRequestForAddress && lastAjaxRequestForAddress.readystate != 4 )
	{
        lastAjaxRequestForAddress.abort();
    }
	//add code to start visual effects of loading contents
	lastAjaxRequestForAddress = $.ajax({
							method: "GET",
							url: globalUrl +"/address/create?ajax=1",
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

function addAddressPostMethodCall( successFunction, failureFunction, formId )
{
	if( lastAjaxRequestForAddress && lastAjaxRequestForAddress.readystate != 4 )
	{
        lastAjaxRequestForAddress.abort();
    }
	//add code to start visual effects of loading contents
	lastAjaxRequestForAddress = $.ajax({
							method: "POST",
							data: $("#"+formId).serializeArray(),//csrf token not needed here as it is using form element having csrf token
							url: globalUrl +"/address/create?ajax=1",
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

function addressOperationFailureFunc( message, htmlElementId, htmlElementContentId, title )
{
	var htmlCode = '<div class="modal-header"><h4 class="modal-title" id="exampleModalLabel">' + title +'</h4></div><div class="modal-body"><div class="container-fluid"><div class="row"><div class="alert alert-danger text-center wordwrap" role="alert"><b>'+ message +'</b></div></div></div></div><div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal" id="modal_close" data-modalid="' + htmlElementId + '">Close</button></div>';
	$( "#" + htmlElementContentId ).html( htmlCode );
	$( "#" + htmlElementId ).modal('show');
}



function addAddressSuccessFunc( response, htmlElementId, htmlElementContentId, title )
{
	var jsonObj = jQuery.parseJSON( response );
	if( jsonObj["isRecordSaved"] == 0 )
	{
		response = jsonObj["html"];
		var htmlCode = '<div class="modal-header"><h4 class="modal-title" id="exampleModalLabel">' + title +'</h4></div><div class="modal-body"><div 		class="container-fluid"><div class="row"><div class="wordwrap" role="alert">' + response + '</div></div></div></div><div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal" id="modal_close" data-modalid="' + htmlElementId + '">Close</button></div>';
		$( "#" + htmlElementContentId ).html( htmlCode );
		$( "#" + htmlElementId ).modal('show');
	}
	else
	{
		//append the row html code ( with checked radio button) sent by server
		response = jsonObj["html"];
		$('#addressTable tbody').append( response );
		$( "#" + htmlElementId ).modal('hide');
		
		var location = jsonObj["locality"];
		if( ( $( "#selected_locality" ).length > 0 ) )
			$( "#selected_locality" ).val( location );
		getCartData( location, 
			function( response ){
				getCartSuccessFunc( response, location, "floatingCartModal", "floatingCartModalContent", "Cart", false );
			}, 
			function(){
				cartOperationFailureFunc( 'Alrighty then!!! Some error has occured, kindly refresh the page.',
				"floatingCartModal", "floatingCartModalContent", "Cart" );
			}
		);
	}
}