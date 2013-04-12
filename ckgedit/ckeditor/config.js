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
      config.extraPlugins = 'signature,footnote,shortcuts';
     
    config.toolbar_Dokuwiki =
	[
    	{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
		{ name: 'editing', items : [ 'Find','Replace','-','SelectAll','-','Scayt' ] },        
		{ name: 'insert', items : [ 'Image','Table','HorizontalRule','Smiley','SpecialChar',  'Signature' ,'Footnotes'] },           
   		{ name: 'links', items : [ 'Link','Unlink' ] },
		{ name: 'styles', items : [ 'Format', 'Styles' ,'Font','FontSize', 'Source'] },
    	{ name: 'colors',      items : [ 'TextColor','BGColor' ] },		
		{ name: 'paragraph', items : [ 'NumberedList','BulletedList','Indent','Outdent'] },
   		{ name: 'clipboard', items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
    	{ name: 'basicstyles', items: [ 'basicstyles', 'cleanup' ] },
		{ name: 'tools', items : [ 'Maximize','-','About', 'Timestamp' ] },
          //{ name: 'bibliography', items : [ 'showtime' ] }
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
	// The toolbar groups arrangement, optimized for two toolbar rows.    
	config.toolbarGroups = [
    	{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },
		{ name: 'links' },
		{ name: 'insert' },
		{ name: 'forms' },
		{ name: 'tools' },
		{ name: 'document',	   groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'others' },
	//	'/',
		{ name: 'paragraph',   groups: [ 'list', 'indent' ] },
	//	{ name: 'styles' },
		{ name: 'colors' },
		{ name: 'about' }
	];
    
	// Remove some buttons, provided by the standard plugins, which we don't
	// need to have in the Standard(s) toolbar.
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
