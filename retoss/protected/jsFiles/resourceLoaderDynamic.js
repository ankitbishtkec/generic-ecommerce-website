//loads resources files dynamically from json and executes user
//supplied function with html code as argument
var preLoadedFiles = new Object();

function loadPageElementsfromJson( jsonString, userSuppliedFunc )
{
	var jsonObj = jQuery.parseJSON( jsonString );
	
	var cssFilesArray = jsonObj.css_files;
	var jsFilesArray = jsonObj.js_files;
	var cssCode = jsonObj.css_code;
	var jsCode = jsonObj.js_code;
	
	loadCssFileAndRunCssCode( cssFilesArray, cssCode );
	
	userSuppliedFunc ( jsonObj.html_code );
	
	var jsLoaderObj = new JsFilesLoader( jsFilesArray, jsCode);
	jsLoaderObj.initLoader();
}

//currently cssCode is not executed.
function loadCssFileAndRunCssCode( cssFilesArray, cssCode )
{
	if( cssFilesArray )
	{
		var arrayLength = cssFilesArray.length;
		for (var i = 0; i < arrayLength; i++) 
		{
    		var cssFilename = cssFilesArray[i];
    		if( preLoadedFiles[ cssFilename ] )//already loaded
    			continue;
    		else
    		{
				var cssLink = $("<link rel='stylesheet' type='text/css' href='"+cssFilename+"'>");
     			$("head").append(cssLink);
     			preLoadedFiles[ cssFilename ] = true;
    		}
		}
    }
}

//this class loads multiple js files and executes the passed js code when every
//file is loaded properly otherwise error gets displayed
function JsFilesLoader ( jsFilesArray, jsCode) {
    this.jsFilesArray = jsFilesArray;
    this.jsCode = jsCode;
    this.numOfFiles = (jsFilesArray)? jsFilesArray.length : 0;
}
 
JsFilesLoader.prototype.runJsCode = function() {
    if( this.numOfFiles == 0)
    	if( this.jsCode )
    		eval( this.jsCode );
};
 
JsFilesLoader.prototype.initLoader = function() {
	if(this.jsFilesArray)
	{
		var count = this.numOfFiles;
    	for (var i = 0; i < count; i++) 
		{
			var jsFileName = this.jsFilesArray[i];
    		if( preLoadedFiles[ jsFileName ] )//already loaded
    		{
    			var currObject = this;
  				currObject.numOfFiles--;
  				currObject.runJsCode();
    			continue;
    		}
    		else
    		{
				var currObject = this;
				$.getScript( this.jsFilesArray[i] , function() {
  					currObject.numOfFiles--;
  					currObject.runJsCode();
     				preLoadedFiles[ jsFileName ] = true;
				})
				.fail(function( jqxhr, settings, exception ) {
    				alert("Error: Javascript file could not be loaded.please refresh the page.");
				});
			}
		}
	}
	else
		this.runJsCode();
};
	