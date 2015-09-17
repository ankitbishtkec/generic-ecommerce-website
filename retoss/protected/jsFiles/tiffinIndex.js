var lastAjaxRequest;

function initializePage()
{
	//if hash containing url comes reload the page
	if( ( window.location.hash ).length > 0 )
		window.location.href = ( globalUrl + '/tiffin/index/filters/' + ( window.location.hash ).substr( 1 ) );

	$("#content").on("change","#result_table #advanced_search",function( e ){
	var url = getFiltersString();
	if ( history.pushState ) //feature detection
	//if ( false ) //for testing
	{
		url  =  globalUrl + '/tiffin/index/filters/' + url;				
		// HISTORY.PUSHSTATE
		history.pushState('', 'New URL: '+ url, url);
		getResultsAndDisplay( url );
	}
	else
	{
		window.location.hash = url;
	}
	//e.preventDefault();//IE does not ticks tickboxes if uncommented
	});
	
	if ( history.pushState )
	//if ( false ) //for testing
	{
		// THIS EVENT MAKES SURE THAT THE BACK/FORWARD BUTTONS WORK AS WELL
		window.onpopstate = function(event) {
			getResultsAndDisplay( $(location).attr('href') );
		};
	}
	else
	{
		//hash change event
		window.onhashchange = function(event) {
		if( ( window.location.hash ).length > 0 )
			getResultsAndDisplay( globalUrl + '/tiffin/index/filters/' + ( window.location.hash ).substr( 1 ) );
		else
			getResultsAndDisplay( $(location).attr('href') );
		};
	}
	
	//addEventHandlersForFloatingCart( ); //instruction moved to onLoad function of jquery using server main layout page
}

function addLoadingvisualEffects()
{
	$('#loading').show();//$("#id").css("display", "none");
}

function removeLoadingvisualEffects()
{
	$('#loading').hide();//$("#id").css("display", "block");
}

function getResultsAndDisplay( url )
{
	url = url + '?ajax=1';
	if( lastAjaxRequest && lastAjaxRequest.readystate != 4 )
	{
        lastAjaxRequest.abort();
    }
	//add code to start visual effects of loading contents
	addLoadingvisualEffects();
	lastAjaxRequest = $.ajax({							
							method: "POST",
							data: { csrf_token: csrfTokenValue,},//L.H.S. "csrf_token" depends on config file in server
							url: url,
							error: function(xhr, status, error) {
								//console.log("Allllrighty then! " + xhr.responseText + "( " + error +" )" );
								//removed as this is not a make or break feature so one or two request error out is fine
								removeLoadingvisualEffects();
								//add code to end visual effects of loading contents
							},
							success:function(response){
								//add code to end visual effects of loading contents
								//removed without parsing response as this is not a make or break feature so one or two parsing error out is fine
								removeLoadingvisualEffects();
								loadPageElementsfromJson( response, function( htmlCode )
								{
									$( "#results_grid" ).html( htmlCode );
								});
							}
						});
}
 
//location=abc,xyz|date-start=2014-09-25 00:59:20|date-end=2014-09-26 00:59:20|tags=spicy,punjabi|chefs=abc,dce|discount=yes|sort=rating
function getFiltersString()
{
	var response;
	response = 'location=' + $("#tech_park").val() + '|';
	response = response + 'sort=' + $("#sort_name").val() + '|';
	response = response + 'date-start=' + $("#from_delivery_date").val() + '|';
	response = response + 'date-end=' + $("#to_delivery_date").val() + '|';
	
	var allCheckboxes = $( "input:checkbox:checked" );
	
	var tempStr = '';
	allCheckboxes.filter( "#tags_filter_checkbox" ).each(function( index ) {
		tempStr = tempStr + $( this ).attr('data-value') + ',';
	});
	if( tempStr.length > 0)
		response = response + 'tags=' + tempStr + '|';
	
	tempStr = '';
	allCheckboxes.filter( "#chefs_filter_checkbox" ).each(function( index ) {
		tempStr = tempStr + $( this ).attr('data-value') + ',';
	});
	if( tempStr.length > 0)
		response = response + 'chefs=' + tempStr + '|';

	return response;
}
    