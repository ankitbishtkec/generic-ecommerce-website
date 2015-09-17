function initializePage()
{
	$("table#pricetimetable").on("click", (".deletebutton"), function( event ) {
		var rowId = $(this).attr("data-rowid");
		$('#'+rowId).remove();
  		event.preventDefault();
	});
	$("#GetPriceTimeUI").click(function( event ) {
		$.ajax({
        url: globalUrl +"/tiffin/GetPriceTimeUI/index/" + globalIndex.toString(),
        error: function(xhr, status, error) {
  			alert("Allllrighty then! " + xhr.responseText + "( " + error +" )" );
		},
        success:function(response){
        	loadPageElementsfromJson( response, function( htmlCode )
        		{
        			$('#pricetimetable tr:last').after( htmlCode );
        		});
        }
    });
    globalIndex++;
  	event.preventDefault();
	});
}
    