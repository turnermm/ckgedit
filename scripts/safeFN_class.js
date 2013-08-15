  /**
   * Upgraded
   *  !!Do not modify the above line!!
   */
  /**
  *  SafeFN is a Javascript implementation of Christopher Smith's php
  *  SafeFN class which was written for Dokuwiki 
  *  
  *  @author Myron Turner <turnermm@shaw.ca>
  *  @copyright Myron Turner (C) GPL 2 or greater
  */

var SafeFN = {  
    plain: '-./[_0123456789abcdefghijklmnopqrstuvwxyz', // these characters aren't converted
	pre_indicator: '%',
	post_indicator:']',

    /**
     * convert numbers from base 10 to base 36 and base 36 to base 10
     *
     * @param  string representing an integer or integer   num  number to be converted
     * @param  integer      from    base from which to convert
     * @param  integer      to      base to which to convert
     *   
     * @return  array   int    an array of unicode codepoints
     *
	 * @author   Myron Turner <turnermm02@shaw.ca>
     */

	 changeSafeBase: function(num, from, to)   {  
	      if(isNaN(from) || from < 2 || from > 36 || isNaN(to) || to < 2 || to > 36) {
	        throw (new RangeError("Illegal radix. Radices must be integers between 2 and 36, inclusive."));
	      }
	      num = parseInt(num, from);
	      if(from == 36) return num; 
	      return num.toString(to); 
	  },


    /**
     * convert a UTF8 string into an array of unicode code points  
     *
     * @param   UTF8 string 
     * @return  array   int    an array of unicode codepoints
     *
	 * @author   Myron Turner <turnermm02@shaw.ca>
     */

	get_u_array: function(utf8str) {
	    var unicode_array = new Array();
		for (var i=0; i<utf8str.length; i++) {
	           unicode_array[i] = utf8str.charCodeAt(i);;
		}
	   return unicode_array;
	},


    /**
     * convert a 'safe_filename' string into an array of unicode codepoints
     *
     * @param   string         safe     a filename in 'safe_filename' format
     * @return  array   int    an array of unicode codepoints
  	 * @author   Christopher Smith <chris@jalakai.co.uk>	 
     * @author   Myron Turner<turnermm02@shaw.ca>
     */
	safe_to_unicode: function(safe) {
    	var unicode = new Array();
    	var regex = new RegExp('(?=[' + this.pre_indicator + '\\' + this.post_indicator + '])');   
    	var split_array = safe.split(regex);
    	var converted = false;

    	for (var i = 0; i<split_array.length; i++ ) {
    	    var sub = split_array[i];
    	    if (sub.charAt(0) != this.pre_indicator) { //  i.e. sub.charAt(0) != '%'
    	        var start = converted?1:0;               
    	        for (j=start; j < sub.length; j++) {
    	             unicode.push(sub.charCodeAt(j));
    	        }
    	        converted = false;
    	    } else if (sub.length==1) {
    	        unicode.push(sub.charCodeAt(0));
    	        converted = true;
    	    } else {

    	        unicode.push(32 +  this.changeSafeBase(sub.slice(1),36,10));
    	        converted = true;
    	    }
    	}

    	return unicode;
	},

	/**
	* convert an array of unicode codepoints into 'safe_filename' format
	*  
	* @param    array  int    $unicode    an array of unicode codepoints
	* @return   string        the unicode represented in 'safe_filename' format
	*
	* @author   Christopher Smith <chris@jalakai.co.uk>	 
	* @author   Myron Turner <turnermm02@shaw.ca>
	*/
	unicode_to_safe: function (unicode) {
    	var safe = '';
    	var converted = false;
    	var plain_str = this.plain + this.post_indicator;

    	for (var i=0; i< unicode.length; i++) {
    	     codepoint = unicode[i];  
             var match = ''; 
             if(String.fromCharCode(codepoint) != '\\') {
               var regex = new RegExp(String.fromCharCode(codepoint));
               var match = plain_str.match(regex);
             }

             if (codepoint < 127 && match) {
    	        if (converted) {
    	            safe += this.post_indicator;
    	            converted = false;
    	        }
    	        safe += String.fromCharCode(codepoint);

    	    } else if (codepoint == this.pre_indicator.charCodeAt(0)) {
    	        safe += this.pre_indicator;
    	        converted = true;
    	    } else {                                       
    	        safe += this.pre_indicator + this.changeSafeBase((codepoint-32), 10, 36);   
    	        converted = true;
    	    }          
    	}
        if(converted) safe += this.post_indicator;

    	return safe;
	},

  /**
     * Convert an UTF-8 string to a safe ASCII String
     *
     *
     * @param    string    filename     a utf8 string, should only include printable characters - not 0x00-0x1f
     * @return   string    an encoded representation of filename using only 'safe' ASCII characters
     *
  	 * @author   Myron Turner <turnermm02@shaw.ca>
     */
	encode: function(filename) {      
    	return this.unicode_to_safe(this.get_u_array(filename));
	},

    /**
     * decode a 'safe' encoded file name and return a UTF8 string
     *      
     * @param    string    filename     a 'safe' encoded ASCII string,
     * @return   string    decoded utf8 string
     *
  	 * @author   Myron Turner <turnermm02@shaw.ca>
     */
       
	decode: function (filename) {
		var unic = this.safe_to_unicode(filename);

	    // convert unicode code points to utf8
		var str = new Array();
		for (var i=0; i < unic.length; i++) {
			str[i] = this.code2utf(unic[i]);
		}
        // return the decoded string
		return this.utf8Decode(str.join(''));
	},

/* UTF8 encoding/decoding functions
 * Copyright (c) 2006 by Ali Farhadi.
 * released under the terms of the Gnu Public License.
 * see the GPL for details.
 *
 * Email: ali[at]farhadi[dot]ir
 * Website: http://farhadi.ir/
 */

//an alias of String.fromCharCode
chr: function (code)
{
	return String.fromCharCode(code);
},

//returns utf8 encoded charachter of a unicode value.
//code must be a number indicating the Unicode value.
//returned value is a string between 1 and 4 charachters.
code2utf: function (code)
{
	if (code < 128) return this.chr(code);
	if (code < 2048) return this.chr(192+(code>>6)) + this.chr(128+(code&63));
	if (code < 65536) return this.chr(224+(code>>12)) + this.chr(128+((code>>6)&63)) + this.chr(128+(code&63));
	if (code < 2097152) return this.chr(240+(code>>18)) + this.chr(128+((code>>12)&63)) + this.chr(128+((code>>6)&63)) + this.chr(128+(code&63));
},

//it is a private function for internal use in utf8Decode function 
_utf8Decode: function (utf8str)
{

	var str = new Array();
	var code,code2,code3,code4,j = 0;
	for (var i=0; i<utf8str.length; ) {
		code = utf8str.charCodeAt(i++);


		if (code > 127) code2 = utf8str.charCodeAt(i++);
		if (code > 223) code3 = utf8str.charCodeAt(i++);
		if (code > 239) code4 = utf8str.charCodeAt(i++);
		
		if (code < 128) str[j++]= this.chr(code);
		else if (code < 224) str[j++] = this.chr(((code-192)<<6) + (code2-128));
		else if (code < 240) str[j++] = this.chr(((code-224)<<12) + ((code2-128)<<6) + (code3-128));
		else str[j++] = this.chr(((code-240)<<18) + ((code2-128)<<12) + ((code3-128)<<6) + (code4-128));

	}
	return str.join('');
},

//Decodes a UTF8 formated string
utf8Decode: function (utf8str)
{
	var str = new Array();
	var pos = 0;
	var tmpStr = '';
	var j=0;
	while ((pos = utf8str.search(/[^\x00-\x7F]/)) != -1) {
		tmpStr = utf8str.match(/([^\x00-\x7F]+[\x00-\x7F]{0,10})+/)[0];
		str[j++]= utf8str.substr(0, pos) + this._utf8Decode(tmpStr);
		utf8str = utf8str.substr(pos + tmpStr.length);
	}
	
	str[j++] = utf8str;
	return str.join('');
}

};

function SafeFN_encode(filename) {   
  return SafeFN.encode(filename);  
}

function SafeFN_decode(filename) {   
    return SafeFN.decode(filename);    
}


function dwikiUTF8_encodeFN(file, encoding){
   
    if(encoding == 'utf-8') return file;

    if(file.match(/^[a-zA-Z0-9\/_\-\.%\]]+$/)){
        return file;
    }

    if(encoding == 'safe'){
        return SafeFN_encode(file);
    }

    file =  encodeURIComponent(file);
    file =  file.replace(/%2F/g,'/');
    return file;
}


function dwikiUTF8_decodeFN(file, encoding){

    if(encoding == 'utf-8') return file;

    if(encoding == 'safe'){
        return SafeFN_decode(file);
    }

    return decodeURIComponent(file);
}
