/**
 * @license Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

 CKEDITOR.editorConfig = function( config ) {
config.keystrokes = [

   // [ CKEDITOR.CTRL + 76, null ],                       // CTRL + L
      [ CKEDITOR.ALT  + CKEDITOR.SHIFT + 56, 'bulletedlist' ],       // CTRL + *    
      [ CKEDITOR.ALT + 56, 'bulletedlist' ],                                    // ALT + 8
      [ CKEDITOR.ALT + 173, 'numberedlist' ],                               // ALT + -
      [ CKEDITOR.ALT + 48, 'ckgundoheader' ],                               // ALT + 0
      [ CKEDITOR.ALT + 49, 'ckginsheaderone' ],                          // ALT + 1
      [ CKEDITOR.ALT + 50, 'ckginsheadertwo' ],                          // ALT + 2
      [ CKEDITOR.ALT + 51, 'ckginsheaderthree' ],                          // ALT + 4
      [ CKEDITOR.ALT + 52, 'ckginsheaderfour' ],                          // ALT +4 
      [ CKEDITOR.ALT + 53, 'ckginsheaderfive' ],                          // ALT + 5
      [ CKEDITOR.ALT + 77, 'ckginscode' ],          //ALT +m
   

];

config.colors = new Array(
'000000','000033','000066','000099','0000CC','0000CE','0000FF','003300','003333','003366','003399','0033CC','0033FF','006600','006633',
'006666','006699','0066CC','0066FF','009900','009933','009966','009999','0099CC','0099FF','00CC00','00CC33','00CC66','00CC99','00CCCC','00CCFF',
'00FF00','00FF33','00FF66','00FF99','00FFCC','00FFFF','01F33E','01FCEF','03EBA6','03F3AB','06DCFB','0AFE47','111111','1F88A7','1FCB4A','1FFEF3',
'222222','23819C','24E0FB','25A0C5','27DE55','2897B7','2966B8','29AFD6','2DC800','2F74D0','2FAACE','32DF00','330000','330033','330066','330099',
'3300CC','3300FF','333300','333333','333333','333366','333399','3333CC','3333FF','336600','336633','336666','336699','3366CC','3366FF','339900',
'339933','339966','339999','3399CC','3399FF','33CC00','33CC33','33CC66','33CC99','33CCCC','33CCFF','33FDC0','33FF00','33FF33','33FF66','33FF99',
'33FFCC','33FFFF','36F200','3923D6','3DE4FC','444444','44B4D5','48FB0D','4985D6','4A9586','4AE371','4BFE78','4FBDDD','52FF20','555555','5757FF',
'57BCD9','59955C','59DF00','5B5BFF','5EAE9E','5FFEF7','6094DB','61F200','62A9FF','62D0FF','62FDCE','63E9FC','660000','660033','660066','660099',
'6600CC','6600FF','663300','663333','663366','663399','6633CC','6633FF','666600','666633','666666','666666','666699','6666CC','6666FF','669900',
'669933','669966','669999','6699CC','6699FF','66CC00','66CC33','66CC66','66CC99','66CCCC','66CCFF','66FF00','66FF00','66FF33','66FF66','66FF99',
'66FFCC','66FFFF','6755E3','67C7E2','6A6AFF','6CA870','6FFF44','72FE95','7373FF','74138C','74BAAC','74FEF8','75B4FF','75D6FF','75ECFD','777777',
'7979FF','79FC4E','7BA7E1','7BCAE1','7CEB98','7DFDD7','800080','80B584','8282FF','8678E9','86BCFF','872187','888888','892EE4','89FC63','8ADCFF',
'8BFEA8','8C8CFF','8CD1E6','8CEFFD','8D18AB','8DC7BB','8EB4E6','8ED6EA','8FFEDD','8FFF6F','9191FF','92FEF9','93BF96','93EEAA','9588EC','95FF4F',
'9669FE','990000','990033','990066','990099','990099','9900CC','9900FF','993300','993333','993366','993399','9933CC','9933FF','996600','996633',
'996666','996699','9966CC','9966FF','999900','999933','999966','999999','999999','9999CC','9999FF','9999FF','99C7FF','99C7FF','99CC00','99CC33',
'99CC66','99CC99','99CCCC','99CCFF','99E0FF','99FD77','99FF00','99FF33','99FF66','99FF99','99FFCC','99FFFF','9A03FE','9B4EE9','9D9D00','A095EE',
'A27AFE','A3FEBA','A41CC6','A4F0B7','A55FEB','A5D3CA','A5DBEB','A5FEE3','A5FEFA','A5FF8A','A6CAA9','A6DEEE','A827FE','A8A8FF','A8CFFF','A8E4FF',
'A9C5EB','AAAAAA','AAAAFF','AAFD8E','ABFF73','ACF3FD','AD8BFE','AE70ED','AE70ED','B05F3C','B0A7F1','B300B3','B3FF99','B445FE','B4D1B6','B5FFC8',
'B5FFFC','B6BA18','B7B7FF','B89AFE','B8E2EF','B9264F','B96F6F','BA21E0','BABA21','BAD0EF','BAFEA3','BBBBBB','BBBBFF','BBDAFF','BBEBFF','BC2EBC',
'BCB4F3','BD5CFE','BDF4CB','BDFFEA','BEFEEB','BF00BF','C06A45','C0A545','C0E0DA','C0E7F3','C0F7FE','C0F7FE','C0FF97','C17753','C269FE','C27E3A',
'C47557','C48484','C4ABFE','C6C6FF','C79BF2','C87C5B','C88E8E','C8B400','C8C800','C98767','C98A4B','C9DECB','C9EAF3','CA00CA','CACAFF','CAFEB8',
'CAFFD8','CB59E8','CB59E8','CB876D','CBC5F5','CC0000','CC0033','CC0066','CC0099','CC00CC','CC00FF','CC3300','CC3333','CC3366','CC3399','CC33CC',
'CC33FF','CC6600','CC6633','CC6666','CC6699','CC66CC','CC66FF','CC9900','CC9933','CC9966','CC9999','CC99CC','CC99FF','CCCC00','CCCC33','CCCC66',
'CCCC99','CCCCCC','CCCCCC','CCCCFF','CCFF00','CCFF33','CCFF66','CCFF99','CCFFCC','CCFFFF','CD85FE','CDD11B','CEA8F4','CEB86C','CEDEF4','CEF0FF',
'CEFFFD','CF8D72','CFE7E2','CFFEF0','D0977B','D0BCFE','D0E6FF','D19C67','D1A0A0','D1D17A','D1FFB3','D29680','D2FFC4','D54FD5','D568FD','D698FE',
'D69E87','D6C485','D6F8DE','D73E68','D7ACAC','D7D1F8','D7D78A','D881ED','D8F0F8','D900D9','D97BFD','D9C400','D9F3FF','DAA794','DAAC96','DAAF85',
'DB00DB','DB9900','DBBFF7','DBDB97','DBDBFF','DBEADC','DBEBFF','DBF0F7','DCEDEA','DD597D','DD75DD','DD75DD','DD88FD','DDB791','DDB9B9','DDCEFF',
'DDDDDD','DDFED1','DEB19E','DECF9C','DFA800','DFB0FF','DFB4A4','DFDF00','DFE32D','DFFFCA','E0BBA9','E0E04E','E0EAF8','E1CAF9','E1E1A8','E1E1FF',
'E1FFFE','E29BFD','E37795','E3D6AA','E3E0FA','E3FBE9','E3FBE9','E469FE','E4C0B1','E4C6A7','E697E6','E6C5B9','E6CCCC','E6CE00','E6DBFF','E6E671',
'E6FCFF','E77AFE','E7A9FE','E7F3F1','E7FFDF','E8C6FF','E8CCBF','E8FFD9','E994AB','E9D0B6','E9E9BE','E9E9C0','E9F1EA','EA8DFE','EAA400','EAA6EA',
'EACDC1','EADFBF','EAEA8A','EAF1FB','EAF7FB','EAFEE2','EAFFEF','EAFFEF','EBD0C7','ECD5CA','ECD9D9','ECF4FF','ECFAFF','ED9EFE','EDA9BC','EDBEFE',
'EDDFFB','EDE4C9','EDEF85','EEBBEE','EEDCC8','EEEEA2','EEEECE','EEEECE','EEEEEE','EEEEFF','EEEEFF','EEF093','EFA9FE','EFCDF8','EFCDF8','EFD7FF',
'EFE7CF','EFEDFC','EFF9FC','F0B9C8','F0C4F0','F0CBFE','F0DCD5','F0DDD5','F0DDD5','F1ECFF','F1F1B1','F1F1D6','F1FEED','F206FF','F2BCFE','F2E4D5',
'F2F4B3','F2F9F8','F2FFEA','F2FFFE','F3E7E7','F3F8F4','F4CAD6','F4D2F4','F4D2F4','F4DCFE','F4F4BF','F5CAFF','F5E7E2','F5E8E2','F5E8E2','F5EEFD',
'F5EFE0','F5F5E2','F5F7C4','F5FFF2','F70000','F7DE00','F7F5FE','F7F7CE','F7F9D0','F7FBFA','F7FFFD','F8DAE2','F8E9FC','F8F1F1','F8FBFE','F900F9',
'F9BB00','F9D9FF','F9EEFF','F9EFEC','F9F3EC','F9F5EC','F9F9DD','F9F9FF','F9FCFF','F9FDFF','F9FEFF','F9FFFB','FAE7EC','FAECFF','FAF2EF','FAFBDF',
'FAFDFE','FAFEFB','FAFFF7','FBF9FF','FBFBE8','FBFDFB','FCF7F5','FCF9F5','FCFCE9','FDF2FF','FDF9FD','FDF9FF','FDFAF9','FDFAF9','FDFBFB','FDFCF9',
'FDFDF0','FDFDF9','FDFDFF','FDFEFF','FDFFFD','FDFFFF','FE67EB','FE67EB','FE8BF0','FE98F1','FEA9F3','FEFAFB','FEFDFF','FEFDFF','FEFEFA','FF0000',
'FF0033','FF0066','FF0099','FF00CC','FF00FF','FF2626','FF2DFF','FF3300','FF3333','FF3366','FF3399','FF33CC','FF33FF','FF4848','FF4AFF','FF5353',
'FF62B0','FF6600','FF6633','FF6666','FF6699','FF66CC','FF66FF','FF68DD','FF7373','FF73B9','FF7575','FF79E1','FF7DFF','FF800D','FF86C2','FF86E3',
'FF86FF','FF8A8A','FF8E8E','FF9331','FF9797','FF97CB','FF97E8','FF9900','FF9933','FF9966','FF9999','FF99CC','FF99FF','FF9C42','FFA04A','FFA4A4',
'FFA4FF','FFA8A8','FFA8D3','FFA8FF','FFAB60','FFAC62','FFACEC','FFACEC','FFB428','FFB5B5','FFB60B','FFBB7D','FFBBBB','FFBBDD','FFBBF7','FFBBFF',
'FFBD82','FFBE28','FFBF48','FFC48E','FFC4FF','FFC65B','FFC848','FFC895','FFC8C8','FFC8E3','FFC8F2','FFCAF9','FFCB2F','FFCC00','FFCC33','FFCC66',
'FFCC99','FFCCCC','FFCCFF','FFCE73','FFCEA2','FFCECE','FFCEFF','FFCFA4','FFD062','FFD34F','FFD586','FFD7B3','FFD9B7','FFDBFB','FFDD75','FFDEA2',
'FFDFDF','FFDFEF','FFDFF8','FFDFFF','FFE099','FFE1C6','FFE2C8','FFE3FF','FFE699','FFE6B5','FFE6D0','FFE920','FFEAB7','FFEAC4','FFEAEA','FFEAEA',
'FFEBD9','FFECB0','FFECEC','FFECF5','FFECFF','FFEEFB','FFEEFD','FFF06A','FFF1C6','FFF1E6','FFF284','FFF2D2','FFF2D9','FFF2F2','FFF4EA','FFF5D7',
'FFF7B7','FFF7E6','FFF9CE','FFF9EA','FFF9F4','FFF9FC','FFF9FE','FFF9FF','FFFAEA','FFFBDF','FFFDF7','FFFDF9','FFFDF9','FFFDFD','FFFDFF','FFFDFF',
'FFFEF7','FFFEFB','FFFEFD','FFFF00','FFFF33','FFFF66','FFFF84','FFFF99','FFFF99','FFFFAA','FFFFB5','FFFFC8','FFFFCC','FFFFD7','FFFFE3','FFFFFD',
'FFFFFF','FFFFFF','FFFFFF'
);



function sack(file) {
	this.xmlhttp = null;

	this.resetData = function() {
		this.method = "POST";
  		this.queryStringSeparator = "?";
		this.argumentSeparator = "&";
		this.URLString = "";
		this.encodeURIString = true;
  		this.execute = false;
  		this.element = null;
		this.elementObj = null;
		this.requestFile = file;
		this.vars = new Object();
		this.responseStatus = new Array(2);
  	};

	this.resetFunctions = function() {
  		this.onLoading = function() { };
  		this.onLoaded = function() { };
  		this.onInteractive = function() { };
  		this.onCompletion = function() { };
  		this.onError = function() { };
		this.onFail = function() { };
	};

	this.reset = function() {
		this.resetFunctions();
		this.resetData();
	};

	this.createAJAX = function() {
		try {
			this.xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
		} catch (e1) {
			try {
				this.xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			} catch (e2) {
				this.xmlhttp = null;
			}
		}

		if (! this.xmlhttp) {
			if (typeof XMLHttpRequest != "undefined") {
				this.xmlhttp = new XMLHttpRequest();
			} else {
				this.failed = true;
			}
		}
	};

	this.setVar = function(name, value){
		this.vars[name] = Array(value, false);
	};

	this.encVar = function(name, value, returnvars) {
		if (true == returnvars) {
			return Array(encodeURIComponent(name), encodeURIComponent(value));
		} else {
			this.vars[encodeURIComponent(name)] = Array(encodeURIComponent(value), true);
		}
	}

	this.processURLString = function(string, encode) {
		encoded = encodeURIComponent(this.argumentSeparator);
		regexp = new RegExp(this.argumentSeparator + "|" + encoded);
		varArray = string.split(regexp);
		for (i = 0; i < varArray.length; i++){
			urlVars = varArray[i].split("=");
			if (true == encode){
				this.encVar(urlVars[0], urlVars[1]);
			} else {
				this.setVar(urlVars[0], urlVars[1]);
			}
		}
	}

	this.createURLString = function(urlstring) {
		if (this.encodeURIString && this.URLString.length) {
			this.processURLString(this.URLString, true);
		}

		if (urlstring) {
			if (this.URLString.length) {
				this.URLString += this.argumentSeparator + urlstring;
			} else {
				this.URLString = urlstring;
			}
		}

		// prevents caching of URLString
		this.setVar("rndval", new Date().getTime());

		urlstringtemp = new Array();
		for (key in this.vars) {
			if (false == this.vars[key][1] && true == this.encodeURIString) {
				encoded = this.encVar(key, this.vars[key][0], true);
				delete this.vars[key];
				this.vars[encoded[0]] = Array(encoded[1], true);
				key = encoded[0];
			}

			urlstringtemp[urlstringtemp.length] = key + "=" + this.vars[key][0];
		}
		if (urlstring){
			this.URLString += this.argumentSeparator + urlstringtemp.join(this.argumentSeparator);
		} else {
			this.URLString += urlstringtemp.join(this.argumentSeparator);
		}
	}

	this.runResponse = function() {
		eval(this.response);
	}

	this.runAJAX = function(urlstring) {
		if (this.failed) {
			this.onFail();
		} else {
			this.createURLString(urlstring);
			if (this.element) {
				this.elementObj = document.getElementById(this.element);
			}
			if (this.xmlhttp) {
				var self = this;
				if (this.method == "GET") {
					totalurlstring = this.requestFile + this.queryStringSeparator + this.URLString;
					this.xmlhttp.open(this.method, totalurlstring, true);
				} else {
					this.xmlhttp.open(this.method, this.requestFile, true);
					try {
						this.xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded")
					} catch (e) { }
				}

				this.xmlhttp.onreadystatechange = function() {
					switch (self.xmlhttp.readyState) {
						case 1:
							self.onLoading();
							break;
						case 2:
							self.onLoaded();
							break;
						case 3:
							self.onInteractive();
							break;
						case 4:
							self.response = self.xmlhttp.responseText;
							self.responseXML = self.xmlhttp.responseXML;
							self.responseStatus[0] = self.xmlhttp.status;
							self.responseStatus[1] = self.xmlhttp.statusText;

							if (self.execute) {
								self.runResponse();
							}

							if (self.elementObj) {
								elemNodeName = self.elementObj.nodeName;
								elemNodeName.toLowerCase();
								if (elemNodeName == "input"
								|| elemNodeName == "select"
								|| elemNodeName == "option"
								|| elemNodeName == "textarea") {
									self.elementObj.value = self.response;
								} else {
									self.elementObj.innerHTML = self.response;
								}
							}
							if (self.responseStatus[0] == "200") {
								self.onCompletion();
							} else {
								self.onError();
							}

							self.URLString = "";
							break;
					}
				};

				this.xmlhttp.send(this.URLString);
			}
		}
	};

	this.reset();
	this.createAJAX();
}
     
      var ckedit_path =  window.location.protocol +'//' + top.dokuBase + 'lib/plugins/ckgedit/ckeditor/';
      config.doku_url = window.location.protocol+ '//' + top.dokuBase;
      
    //  config.format_code = { element : 'code', attributes : { 'class' : 'dwcode' } };
	// Define changes to default configuration here.
	// For the complete reference:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config
      config.scayt_autoStartup = true; 
      config.format_tags = 'p;h1;h2;h3;h4;h5'; 
      config.extraSpecialChars  = ['↔'];
      config.extraPlugins = 'signature,footnote,shortcuts,fontAssist'; //,devtools';
      config.contentsLangDirection = '';
      if( top.ckgedit_isRTL()) config.contentsLangDirection = 'rtl';
     
    config.toolbar_Dokuwiki =
	[
    	{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
		{ name: 'editing', items : [ 'Find','Replace','-','SelectAll','-','Scayt' ] },        
		{ name: 'insert', items : [ 'Image','Table','HorizontalRule','Smiley','SpecialChar',  'Signature' ,'Footnotes'] },           
   		{ name: 'links', items : [ 'Link','Unlink' ] },
		{ name: 'styles', items : [ 'Format', 'Styles' ,'Font','FontSize'] },
    	{ name: 'colors',      items : [ 'TextColor','BGColor', 'FontAssist' ] },		
		{ name: 'paragraph', items : [ 'NumberedList','BulletedList','Indent','Outdent'] },
   		{ name: 'clipboard', items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
    	{ name: 'basicstyles', items: [ 'basicstyles', 'cleanup' ] },
		{ name: 'tools', items : ['Source', 'Maximize','-','About'] },
       
	];
    
        config.toolbar_DokuwikiNoGuest =
	[
		{ name: 'styles', items : [ 'Source'] },
		{ name: 'tools', items : [ 'About' ] }
	];
   
   
    config.toolbar_DokuwikiGuest =
	[
    	{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
		{ name: 'editing', items : [ 'Find','Replace','-','SelectAll','-','Scayt' ] },        
		{ name: 'insert', items : [ 'Table','HorizontalRule','Smiley','SpecialChar', 'Footnotes'] },              		
		{ name: 'styles', items : [ 'Format', 'Styles' ] },
		{ name: 'paragraph', items : [ 'NumberedList','BulletedList','Indent','Outdent'] },
   		{ name: 'clipboard', items : [ 'Cut','Copy','Paste','PasteText','-','Undo','Redo' ] },
    	{ name: 'basicstyles', items: [ 'basicstyles', 'cleanup' ] },
		{ name: 'tools', items : [ 'Maximize','-','About' ] },
	];
	
config.dokuSmileyPath = 'http://' + top.dokuBase + 'lib/images/smileys/';    
config.dokuSmileyImages	=
                          [['8-)','icon_cool.gif'],
                      	  ['8-O','icon_eek.gif'],                      	
                      	  [':-(','icon_sad.gif'],
                      	  [':-)','icon_smile.gif'],
                      	  ['=)','icon_smile2.gif'],
                      	  [':-/','icon_doubt.gif'],                      	  
                      	  [':-?','icon_confused.gif'],
                      	  [':-D','icon_biggrin.gif'],
                      	  [':-P','icon_razz.gif'],
                      	
                      	  [':-O','icon_surprised.gif'],
                      	  [':-X','icon_silenced.gif'],
                      	 
                      	  [':-|','icon_neutral.gif'],
                      	  [';-)','icon_wink.gif'],
                      	  ['^_^','icon_fun.gif'],
                      	  [':?:','icon_question.gif'],
                      	  [':!:','icon_exclaim.gif'],
                      	  ['LOL','icon_lol.gif']];


                          
function do_smileys(){
	ajax.requestFile =  ckedit_path + "dwsmileys.php";
	ajax.method = 'POST';
	ajax.onCompletion = whenCompleted;
	ajax.runAJAX();
}

config.dokuFixmeSmiley = new Array();

function whenCompleted(){
    
    if(ajax.responseStatus && ajax.responseStatus[0] == 200) {

       config.dokuSmileyConfImages = new Array();
       smileys = ajax.response.replace(/#.*?\n/g,"");
       smileys = smileys.replace(/^[\s\n]+$/mg,"");
       smileys=smileys.split(/\n/);
       if(!smileys[0]) smileys.shift();
       if(!smileys[smileys.length-1]) smileys.pop();   
       for(var i=0; i < smileys.length; i++) {            
            var a = smileys[i].split(/\s+/);
            if(a[0].match(/DELETEME/) || a[0].match(/FIXME/)) { 
               config.dokuFixmeSmiley.push( a);
               continue;
            }
             config.dokuSmileyConfImages[i] = a;
      }      
    }
}


config.dokuSmileyConfImages;
try {
var ajax = new sack();
   do_smileys();
}catch(ex){

}
config.sack =sack;
config.ckgEditorVer;
var get_ckgeditor_version = function() {
    var ajax = new sack();  
	ajax.requestFile =  ckedit_path + "get_version.php";
	ajax.method = 'POST';
	ajax.onCompletion = function() {
	    if(ajax.responseStatus && ajax.responseStatus[0] == 200) {
		   config.ckgEditorVer=ajax.response;		   
        }
	};
	ajax.runAJAX();

}

get_ckgeditor_version();   
	      
//	config.removeButtons = 'Underline,Subscript,Superscript,Anchor';
// This is actually the default value.
config.toolbar_Full =
[
    { name: 'document',    items : [ 'Source','-','Save','NewPage','DocProps','Preview','Print','-','Templates' ] },
    { name: 'clipboard',   items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
    { name: 'editing',     items : [ 'Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt' ] },
    { name: 'forms',       items : [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
    '/',
    { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
    { name: 'paragraph',   items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ] },
    { name: 'links',       items : [ 'Link','Unlink','Anchor' ] },
    { name: 'insert',      items : [ 'Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak' ] },
    '/',
    { name: 'styles',      items : [ 'Styles','Format','Font','FontSize' ] },
    { name: 'colors',      items : [ 'TextColor','BGColor' ] },
    { name: 'tools',       items : [ 'Maximize', 'ShowBlocks','-','About' ] }
];
};
