/*
 * FCKeditor - The text editor for Internet - http://www.fckeditor.net
 * Copyright (C) 2003-2009 Frederico Caldeira Knabben
 *
 * == BEGIN LICENSE ==
 *
 * Licensed under the terms of any of the following licenses at your
 * choice:
 *
 *  - GNU General Public License Version 2 or later (the "GPL")
 *    http://www.gnu.org/licenses/gpl.html
 *
 *  - GNU Lesser General Public License Version 2.1 or later (the "LGPL")
 *    http://www.gnu.org/licenses/lgpl.html
 *
 *  - Mozilla Public License Version 1.1 or later (the "MPL")
 *    http://www.mozilla.org/MPL/MPL-1.1.html
 *
 * == END LICENSE ==
 *
 * Defines the FCKXml object that is used for XML data calls
 * and XML processing.
 *
 * This script is shared by almost all pages that compose the
 * File Browser frameset.
 */

var FCKXml = function()
{}

FCKXml.prototype.GetHttpRequest = function()
{
	// Gecko / IE7
	try { return new XMLHttpRequest(); }
	catch(e) {}

	// IE6
	try { return new ActiveXObject( 'Msxml2.XMLHTTP' ) ; }
	catch(e) {}

	// IE5
	try { return new ActiveXObject( 'Microsoft.XMLHTTP' ) ; }
	catch(e) {}

	return null ;
}

FCKXml.prototype.LoadUrl = function( urlToCall, asyncFunctionPointer )
{
	var oFCKXml = this ;

	var bAsync = ( typeof(asyncFunctionPointer) == 'function' ) ;

	var oXmlHttp = this.GetHttpRequest() ;

	oXmlHttp.open( "GET", urlToCall, bAsync ) ;
	// For IE 10
    //See: https://blogs.msdn.com/b/ie/archive/2012/07/19/xmlhttprequest-responsexml-in-ie10-release-preview.aspx?Redirected=true
    try { oXmlHttp.responseType = 'msxml-document'; } catch(e){}
    
    this.RespType = oXmlHttp.responseType;

	if ( bAsync )
	{
		oXmlHttp.onreadystatechange = function()
		{
			if ( oXmlHttp.readyState == 4 )
			{
				var oXml ;
				try
				{
					// this is the same test for an FF2 bug as in fckxml_gecko.js
					// but we've moved the responseXML assignment into the try{}
					// so we don't even have to check the return status codes.
					var test = oXmlHttp.responseXML.firstChild ;
					oXml = oXmlHttp.responseXML ;				
				}
				catch ( e )
				{
					try
					{
						oXml = (new DOMParser()).parseFromString( oXmlHttp.responseText, 'text/xml' ) ;
					}
					catch ( e ) {}
				}

				if ( !oXml || !oXml.firstChild || oXml.firstChild.nodeName == 'parsererror' )
				{
					alert( 'The server didn\'t send back a proper XML response. Please contact your system administrator.\n\n' +
							'XML request error: ' + oXmlHttp.statusText + ' (' + oXmlHttp.status + ')\n\n' +
							'Requested URL:\n' + urlToCall + '\n\n' +
							'Response text:\n' + oXmlHttp.responseText ) ;
					return ;
				}

				oFCKXml.DOMDocument = oXml ;
                 var id = getimgid(urlToCall);

                if(id){           
                   id = encodeURIComponent(id);
                   asyncFunctionPointer( oFCKXml,id) ;
               }              
               else  asyncFunctionPointer( oFCKXml ) ;
			}
		}
	}

	oXmlHttp.send( null ) ;

	if ( ! bAsync )
	{
		if ( oXmlHttp.status == 200 || oXmlHttp.status == 304 ) {
			this.DOMDocument = oXmlHttp.responseXML ;				
			}
		else
		{
			alert( 'XML request error: ' + oXmlHttp.statusText + ' (' + oXmlHttp.status + ')' ) ;
		}
	}

}

FCKXml.prototype.SelectNodes = function( xpath )
{
	
    if(this.RespType && this.RespType == 'msxml-document' || navigator.userAgent.indexOf('MSIE') >= 0) 
		return this.DOMDocument.selectNodes( xpath ) ;
	else					// Gecko
	{
		var aNodeArray = new Array();

		var xPathResult = this.DOMDocument.evaluate( xpath, this.DOMDocument,
				this.DOMDocument.createNSResolver(this.DOMDocument.documentElement), XPathResult.ORDERED_NODE_ITERATOR_TYPE, null) ;
		if ( xPathResult )
		{
			var oNode = xPathResult.iterateNext() ;
 			while( oNode )
 			{
 				aNodeArray[aNodeArray.length] = oNode ;
 				oNode = xPathResult.iterateNext();
 			}
		}
		return aNodeArray ;
	}
}

FCKXml.prototype.SelectSingleNode = function( xpath )
{

    if(this.RespType && this.RespType == 'msxml-document' || navigator.userAgent.indexOf('MSIE') >= 0) {
		return this.DOMDocument.selectSingleNode( xpath ) ;
      }  
	else					// Gecko
	{
		var xPathResult = this.DOMDocument.evaluate( xpath, this.DOMDocument,
				this.DOMDocument.createNSResolver(this.DOMDocument.documentElement), 9, null);

		if ( xPathResult && xPathResult.singleNodeValue )
			return xPathResult.singleNodeValue ;
		else
			return null ;
	}
}
function getimgid(url)
{
      urlspl = url.split('?');
      var id = '';
     var folder,file;
     var str = urlspl[1]; 
     if (str.match(/Unlink/)) {
         //alert('str='+str)  ;
         found = str.split(/&/); 
         console.log(found);
     //    alert('ps='+found);
       
         for(i=0; i<found.length; i++) {
         
         if(found[i].match(/Folder/)) {
                 var ar = found[i].split(/=/);
                  folder = ar[1];
             }
             
             if(found[i].match(/file/)) {
                   var ar = found[i].split(/=/);
                   file = ar[1];
          }
        } 

         if(file) {
             id = folder + file;
             console.log(id);
        }
      }
      
      return id;
}

