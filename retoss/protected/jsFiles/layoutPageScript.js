function initializeLayout()
{
	$('html').mouseleave(function(){
    	$( '#contactUsFull' ).show();
    	});
	$('html').mouseenter(function(){
    	$( '#contactUsFull' ).hide();
    	});
}