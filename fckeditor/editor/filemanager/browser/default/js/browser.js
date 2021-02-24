window.onbeforeunload = function() { };
var CurrentDWikiUser = opener.oDokuWiki_FCKEditorInstance.dwiki_user; // use this variable to pass into frame (frmupload.html)
var CurrentDWikiClient = opener.oDokuWiki_FCKEditorInstance.dwiki_client; // use this variable to pass into frame (frmupload.html)
var isLocalDwikiBrowser = opener.oDokuWiki_FCKEditorInstance.isLocalDwikiBrowser ? true : false;
var CreateDwikiFolder = opener.oDokuWiki_FCKEditorInstance.dwiki_create_folder;  // use this variable to pass into frame (frmupload.html)
var DwikiFNencode = opener.oDokuWiki_FCKEditorInstance.dwiki_fnencode;
var isDwikiUrlExtern = opener.oDokuWiki_FCKEditorInstance.isUrlExtern ? true: false;
var DwikiImageUploadAllowedExtensions = opener.oDokuWiki_FCKEditorInstance.imageUploadAllowedExtensions;
var isDwikiMediaFile = opener.oDokuWiki_FCKEditorInstance.isDwikiMediaFile;
var isDwikiImage = opener.oDokuWiki_FCKEditorInstance.isDwikiImage;
var fbsz_increment =opener.oDokuWiki_FCKEditorInstance.fbsz_increment;


// Automatically detect the correct document.domain (#1919).
(function()
{
	var d = document.domain ;

	while ( true )
	{
		// Test if we can access a parent property.
		try
		{
			var test = window.opener.document.domain ;
			break ;
		}
		catch( e )
		{}

		// Remove a domain part: www.mytest.example.com => mytest.example.com => example.com ...
		d = d.replace( /.*?(?:\.|$)/, '' ) ;

		if ( d.length == 0 )
			break ;		// It was not able to detect the domain.

		try
		{
			document.domain = d ;
		}
		catch (e)
		{
			break ;
		}
	}
})() ;


window.onload = function()
{
   window.top.IsLoadedCreateFolder = true ;
  setupLanguage();

   if(CurrentDWikiUser == 'visitor' || isLocalDwikiBrowser || !CurrentDWikiUser) {
     document.getElementById("btn__create_folder").disabled = true;    
     document.getElementById("create_folder").innerHTML = "";
   }
  else document.getElementById("create_folder").style.display='block';

   if(CreateDwikiFolder == 'n') {
        document.getElementById('create_folder').style.display = 'none';  
}

 if(navigator.userAgent.match(/macintosh/i)) {
       document.getElementById('is_mac').innerHTML = 'Cmd';
 }
  if(navigator.userAgent.indexOf('MSIE') != -1 ||  navigator.userAgent.indexOf('Trident') != -1) {
      document.getElementById('adustfbbuttons').style.display='none';
  }
  if(fbsz_increment > 0) {
      var isIE = navigator.userAgent.indexOf('MSIE') >= 0 ? true : false;     
      var fbl = document.getElementById("frmResourcesList");
      var frmfolders = document.getElementById("frmFolders");
      fbl['height']  = 400 + (400*(fbsz_increment/100));
      frmfolders['height'] = 490 + (490*(fbsz_increment/100));
      if(!isIE) {
          var fbaf = document.getElementById("frmActualFolder");
          var width = 750 + (750*(fbsz_increment/100));      
          fbl['width']  = width;          
          fbaf['width']  = width;
          frmfolders['width'] = 180 + (180*(fbsz_increment/100));      
          var fbmatter = document.getElementById("bottom_matter");
          fbmatter.style.width = width;  
       }
      var whichsz = document.getElementById("adjfbsz" + fbsz_increment);
      whichsz.checked=true;

  }   
}
function GetUrlParam( paramName )
{
	var oRegex = new RegExp( '[\?&]' + paramName + '=([^&]+)', 'i' ) ;
	var oMatch = oRegex.exec( window.top.location.search ) ;

	if ( oMatch && oMatch.length > 1 ) {
       // alert(paramName + ' ' + decodeURIComponent( oMatch[1] ) );
		return decodeURIComponent( oMatch[1] ) ;
      // return dwikiUTF8_decodeFN( oMatch[1],DwikiFNencode);
	}
	else
		return '' ;
}

var oConnector = new Object() ;
oConnector.CurrentFolder	= '/' ;

var sConnUrl = GetUrlParam( 'Connector' ) ;

// Gecko has some problems when using relative URLs (not starting with slash).
if ( sConnUrl.substr(0,1) != '/' && sConnUrl.indexOf( '://' ) < 0 )
	sConnUrl = window.location.href.replace( /browser.html.*$/, '' ) + sConnUrl ;

oConnector.ConnectorUrl = sConnUrl + ( sConnUrl.indexOf('?') != -1 ? '&' : '?' ) ;

var sServerPath = GetUrlParam( 'ServerPath' ) ;

if ( sServerPath.length > 0 )
	oConnector.ConnectorUrl += 'ServerPath=' + dwikiUTF8_encodeFN(sServerPath, 'url') + '&' ;

oConnector.ResourceType		= GetUrlParam( 'Type' ) ;
oConnector.ShowAllTypes		= ( oConnector.ResourceType.length == 0 ) ;

if ( oConnector.ShowAllTypes )
	oConnector.ResourceType = 'File' ;

oConnector.SendCommand = function( command, params, callBackFunction )
{
   /* requires safe_ascii */
   
	var sUrl = this.ConnectorUrl + 'Command=' + command ;
	sUrl += '&Type=' + this.ResourceType ;
	sUrl += '&CurrentFolder=' + dwikiUTF8_encodeFN(this.CurrentFolder, DwikiFNencode);
 
//	sUrl += '&CurrentFolder=' + encodeURIComponent( this.CurrentFolder ) ;

	if ( params ) sUrl += '&' + params ;
    
    // opener takes its values from onload of helper.php
   // alert('opener='+opener.oDokuWiki_FCKEditorInstance.dwiki_usergroups);
   
 //   sUrl += '&DWFCK_Browser=local'; // this opens the local browser

    if(isLocalDwikiBrowser) {
        sUrl += '&DWFCK_Browser=local';
   }
    if(CurrentDWikiClient) {
        sUrl += '&DWFCK_Client=' + CurrentDWikiClient;
   }
    if(CurrentDWikiClient) {
        sUrl += '&DWFCK_usergrps=' + opener.oDokuWiki_FCKEditorInstance.dwiki_usergroups;
   }

	// Add a random salt to avoid getting a cached version of the command execution
	sUrl += '&uuid=' + new Date().getTime() ;

	var oXML = new FCKXml() ;

	if ( callBackFunction )
		oXML.LoadUrl( sUrl, callBackFunction ) ;	// Asynchronous load.
	else
		return oXML.LoadUrl( sUrl ) ;

	return null ;
}
oConnector.CheckError = function( responseXml )
{
	var iErrorNumber = 0 ;
	var oErrorNode = responseXml.SelectSingleNode( 'Connector/Error' ) ;

	if ( oErrorNode )
	{
		iErrorNumber = parseInt( oErrorNode.attributes.getNamedItem('number').value, 10 ) ;

		switch ( iErrorNumber )
		{
			case 0 :
				break ;
			case 1 :	// Custom error. Message placed in the "text" attribute.
				//alert( oErrorNode.attributes.getNamedItem('text').value ) ;
                alert(translateErrorAny(oErrorNode.attributes.getNamedItem('text').value )) ;
				break ;
			case 101 :
                                alert(translateItem('FileBrowserError_101', 'Folder already exists' ));			
				break ;
			case 102 :
                                alert(translateItem('FileBrowserError_102', 'Invalid folder name' ));
				break ;
			case 103 :
                                alert(translateItem('FileBrowserError_103', 'You have no permissions to create the folder' ));
				break ;
			case 110 :
                                alert(translateItem('FileBrowserError_110', 'Unknown error creating folder' ));
				break ;
			case 204 :
                                alert(translateItem('FileBrowserError_204', 'Unable to delete the selected file' ));
				break ;
			case 205 :
                                alert(translateItem('FileBrowserError_205',
                                 'Unable to rename the selected file; check your directory/write permisssions' ));
				break ;
			default :
                                var err_default =  translateItem('FileBrowserError_default', 'Error on your request. Error number: ' );
				alert(err_default + iErrorNumber ) ;
				break ;
		}
	}
	return iErrorNumber ;
}

var oIcons = new Object() ;

oIcons.AvailableIconsArray = [
	'ai','avi','bmp','cs','dll','doc','exe','fla','gif','htm','html','jpg','js',
	'mdb','mp3','pdf','png','ppt','rdp','swf','swt','txt','vsd','xls','xml','zip' ] ;

oIcons.AvailableIcons = new Object() ;

for ( var i = 0 ; i < oIcons.AvailableIconsArray.length ; i++ )
	oIcons.AvailableIcons[ oIcons.AvailableIconsArray[i] ] = true ;

oIcons.GetIcon = function( fileName )
{
	var sExtension = fileName.substr( fileName.lastIndexOf('.') + 1 ).toLowerCase() ;

	if ( this.AvailableIcons[ sExtension ] == true )
		return sExtension ;
	else
		return 'default.icon' ;
}

function OnUploadCompleted( errorNumber, fileUrl, fileName, customMsg )
{
  //  alert( errorNumber +"\nurl="+ fileUrl+"\nfname="+ fileName+"\nmsg="+ customMsg );
    fileUrl = fileUrl.replace(/.*?(media|userfiles\/image|file)\//,"");
 //alert(fileUrl);

	if (errorNumber == "1" || parseInt(errorNumber) > 300) 
		window.frames['frmUpload'].OnUploadCompleted( errorNumber, customMsg ) ;
	else {
		window.frames['frmUpload'].OnUploadCompleted( errorNumber, fileName ) ;
         fileUrl = encodeURIComponent(fileUrl);        
         opener.ckged_setmedia(fileUrl,"") ;
        }
}

function fbsz_inc(val) {  
    var d = new Date();
    if(val == 'reset') {
        document.cookie ="fbsz=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/";    
        alert(translateItem('DlgFileBrowserResizeMsg', "The file browser window will be reset to its default size after your page is reloaded into the editor."));        
       // alert("The file browser window will be reset to its default size after your page is reloaded into the editor.")        
        return;
    }
   d.setTime(d.getTime() + 365*24*60*60*1000);   
   var expires = "expires="+d.toUTCString(); 
   document.cookie =  "fbsz=" + val + "; " + expires + "; path=/";   
   alert("The file browser window will be re-sized by "+  val + "% after your page is reloaded into the editor.")
}

function fb_sort(type) {
    window.frames['frmResourcesList'].sortFileList(type);
}
function  fb_search(f) {
   window.frames['frmResourcesList'].findFiles(f.fsearch.value);
}
function fb_sz_date_order(el) {  
   window.frames['frmResourcesList'].reverseListOrder(el.checked);
}

function onSubmitFn() {
  alert("use the button to submit");
  return false;
}
