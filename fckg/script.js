/*
 * HTML Parser By John Resig (ejohn.org)
 * Original code by Erik Arvidsson, Mozilla Public License
 * http://erik.eae.net/simplehtmlparser/simplehtmlparser.js
 * @license    GPL 3 or later (http://www.gnu.org/licenses/gpl.html)
*/

var HTMLParser;
var HTMLParserInstalled=true;
var HTMLParser_Elements = new Array(); 
(function(){

	// Regular Expressions for parsing tags and attributes
	var startTag = /^<(\w+)((?:\s+\w+(?:\s*=\s*(?:(?:"[^"]*")|(?:'[^']*')|[^>\s]+))?)*)\s*(\/?)>/,
		endTag = /^<\/(\w+)[^>]*>/,
		attr = /(\w+)(?:\s*=\s*(?:(?:"((?:\\.|[^"])*)")|(?:'((?:\\.|[^'])*)')|([^>\s]+)))?/g;
		
	// Empty Elements - HTML 4.01
	var empty = makeMap("br,col,hr,img");
   // HTMLParser_Elements['empty'] = empty;

	// Block Elements - HTML 4.01
	var block = makeMap("blockquote,center,del,div,dl,dt,hr,iframe,ins,li,ol,p,pre,table,tbody,td,tfoot,th,thead,tr,ul");
  //  HTMLParser_Elements['block'] = block;

	// Inline Elements - HTML 4.01
	var inline = makeMap("a,abbr,acronym,b,big,br,cite,code,del,em,font,h1,h2,h3,h4,h5,h6,i,img,ins,kbd,q,s,samp,small,span,strike,strong,sub,sup,tt,u,var");

	// Elements that you can, intentionally, leave open
	// (and which close themselves)
	var closeSelf = makeMap("colgroup,dd,dt,li,options,p,td,tfoot,th,thead,tr");

	// Attributes that have their values filled in disabled="disabled"
	var fillAttrs = makeMap("checked,disabled,ismap,noresize,nowrap,readonly,selected");

	// Special Elements (can contain anything)
	var special = makeMap("script,style");
 
   
	HTMLParser = this.HTMLParser = function( html, handler ) {
		var index, chars, match, stack = [], last = html;      

		stack.last = function(){
			return this[ this.length - 1 ];
		};

		while ( html ) {
			chars = true;

			// Make sure we're not in a script or style element
			if ( !stack.last() || !special[ stack.last() ] ) {

				// Comment
				if ( html.indexOf("<!--") == 0 ) {
					index = html.indexOf("-->");
	
					if ( index >= 0 ) {
						if ( handler.comment )
							handler.comment( html.substring( 4, index ) );
						html = html.substring( index + 3 );
						chars = false;
					}
	
				// end tag
				} else if ( html.indexOf("</") == 0 ) {
					match = html.match( endTag );
	
					if ( match ) {
						html = html.substring( match[0].length );
						match[0].replace( endTag, parseEndTag );
						chars = false;
					}
	
				// start tag
				} else if ( html.indexOf("<") == 0 ) {
					match = html.match( startTag );
	
					if ( match ) {
						html = html.substring( match[0].length );
						match[0].replace( startTag, parseStartTag );
						chars = false;
					}
				}

				if ( chars ) {
					index = html.indexOf("<");
					
					var text = index < 0 ? html : html.substring( 0, index );
					html = index < 0 ? "" : html.substring( index );
					
					if ( handler.chars )
						handler.chars( text );
				}

			} else {
				html = html.replace(new RegExp("(.*)<\/" + stack.last() + "[^>]*>"), function(all, text){
					text = text.replace(/<!--(.*?)-->/g, "$1")
						.replace(/<!\[CDATA\[(.*?)]]>/g, "$1");

					if ( handler.chars )
						handler.chars( text );

					return "";
				});

				parseEndTag( "", stack.last() );
			}

			if ( html == last )
				throw "Parse Error: " + html;
			last = html;
		}
		
		// Clean up any remaining tags
		parseEndTag();

		function parseStartTag( tag, tagName, rest, unary ) {
			if ( block[ tagName ] ) {
				while ( stack.last() && inline[ stack.last() ] ) {
					parseEndTag( "", stack.last() );
				}
			}

			if ( closeSelf[ tagName ] && stack.last() == tagName ) {
				parseEndTag( "", tagName );
			}

			unary = empty[ tagName ] || !!unary;

			if ( !unary )
				stack.push( tagName );
			
			if ( handler.start ) {
				var attrs = [];
	
				rest.replace(attr, function(match, name) {
					var value = arguments[2] ? arguments[2] :
						arguments[3] ? arguments[3] :
						arguments[4] ? arguments[4] :
						fillAttrs[name] ? name : "";
					
					attrs.push({
						name: name,
						value: value,
						escaped: value.replace(/(^|[^\\])"/g, '$1\\\"') //"
					});
				});
	
				if ( handler.start )
					handler.start( tagName, attrs, unary );
			}
		}

		function parseEndTag( tag, tagName ) {
			// If no tag name is provided, clean shop
			if ( !tagName )
				var pos = 0;
				
			// Find the closest opened tag of the same type
			else
				for ( var pos = stack.length - 1; pos >= 0; pos-- )
					if ( stack[ pos ] == tagName )
						break;
			
			if ( pos >= 0 ) {
				// Close all the open elements, up the stack
				for ( var i = stack.length - 1; i >= pos; i-- )
					if ( handler.end )
						handler.end( stack[ i ] );
				
				// Remove the open elements from the stack
				stack.length = pos;
			}
		}
	};
	

	function makeMap(str){
		var obj = {}, items = str.split(",");
		for ( var i = 0; i < items.length; i++ )
			obj[ items[i] ] = true;
		return obj;
	}
})();


function HTMLParser_test_result(results) {

var test_str = "";
for ( i=0; i < results.length; i++) {
   var character = results.charAt(i);
   if(results.charCodeAt(i) == 10)
         character ='\\n';
   if(results.charCodeAt(i) == 32)  
         character ='SP';
   var entry =  character + ' ';
    
  test_str += entry;  
  if(results.charCodeAt(i) == 10) {
       test_str += "\n";
   }
}

if(!confirm(test_str)) return false;
return true;

}

function hide_backup_msg() {
  document.getElementById("backup_msg").style.display="none";
  return false;
}

function show_backup_msg(msg) {
  document.getElementById("backup_msg").style.display="block";
  document.getElementById("backup_msg_area").innerHTML = "Backed up to: " + msg;
  
  return false;
}

  // legacy function 
  function remove_draft(){
 }

function dwedit_draft_delete(cname) {
        var debug = false;
        var params = "draft_id=" +cname;
        jQuery.ajax({
           url: DOKU_BASE + 'lib/plugins/fckg/scripts/prev_delete.php',
           async: false,
           data: params,    
           type: 'POST',
           dataType: 'html',         
           success: function(data){                 
               if(debug) {            
                  alert(data);
               }
              
    }
    });

}


  if(!window.jQuery) {
     var jQuery = {
      ajax: function(obj) {
         var s = new sack(obj.url); 
         s.asynchronous = obj.async;
         s.onCompletion = function() {
        	if (s.responseStatus && s.responseStatus[0] == 200) {   
                  obj.success(s.response);
        	}
         };
         s.runAJAX(obj.data);
     
      },
      post: function(url,params,callback,context) {
         var s = new sack(url);
         s.onCompletion = function() {
        	if (s.responseStatus && s.responseStatus[0] == 200) {   
                  callback(s.response);
        	}
         };
         s.runAJAX(params);
      }
     };
  }

  function GetE(e) {
       return  document.getElementById(e);
  }
var dokuBase = location.host + DOKU_BASE;

function _getSelection(textArea) {
if(!textArea) return;
var sel = new selection_class();
sel.obj = textArea;
sel.start = textArea.value.length;
sel.end = textArea.value.length;
textArea.focus();
if(document.getSelection) { // Mozilla et al.
sel.start = textArea.selectionStart;
sel.end = textArea.selectionEnd;
sel.scroll = textArea.scrollTop;
} else if(document.selection) { // MSIE
/*
* This huge lump of code is neccessary to work around two MSIE bugs:
*
* 1. Selections trim newlines at the end of the code
* 2. Selections count newlines as two characters
*/
// The current selection
sel.rangeCopy = document.selection.createRange().duplicate();
if (textArea.tagName === 'INPUT') {
var before_range = textArea.createTextRange();
before_range.expand('textedit'); // Selects all the text
} else {
var before_range = document.body.createTextRange();
before_range.moveToElementText(textArea); // Selects all the text
}
before_range.setEndPoint("EndToStart", sel.rangeCopy); // Moves the end where we need it
var before_finished = false, selection_finished = false;
var before_text, selection_text;
// Load the text values we need to compare
before_text = before_range.text;
selection_text = sel.rangeCopy.text;
sel.start = before_text.length;
sel.end = sel.start + selection_text.length;
// Check each range for trimmed newlines by shrinking the range by 1 character and seeing
// if the text property has changed. If it has not changed then we know that IE has trimmed
// a \r\n from the end.
do {
if (!before_finished) {
if (before_range.compareEndPoints("StartToEnd", before_range) == 0) {
before_finished = true;
} else {
before_range.moveEnd("character", -1);
if (before_range.text == before_text) {
sel.start += 2;
sel.end += 2;
} else {
before_finished = true;
}
}
}
if (!selection_finished) {
if (sel.rangeCopy.compareEndPoints("StartToEnd", sel.rangeCopy) == 0) {
selection_finished = true;
} else {
sel.rangeCopy.moveEnd("character", -1);
if (sel.rangeCopy.text == selection_text) {
sel.end += 2;
} else {
selection_finished = true;
}
}
}
} while ((!before_finished || !selection_finished));
// count number of newlines in str to work around stupid IE selection bug
var countNL = function(str) {
var m = str.split("\r\n");
if (!m || !m.length) return 0;
return m.length-1;
};
sel.fix = countNL(sel.obj.value.substring(0,sel.start));
}
return sel;
}
