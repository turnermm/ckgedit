/**
 * Copyright (c) 2014-2016, CKSource - Frederico Knabben. All rights reserved.
 * Licensed under the terms of the MIT License (see LICENSE.md).
 *
 * The abbr plugin dialog window definition.
 *
 * Created out of the CKEditor Plugin SDK:
 * http://docs.ckeditor.com/#!/guide/plugin_sdk_sample_1
 */

// Our dialog definition.
CKEDITOR.dialog.add( 'geshiDialog', function( editor ) {
    var radio, ckg_geshi_langopts = new Array();
    var href, id,geshi_dialog, t_display,s_display;
    
    var  getHref = function() {
       var data = window.location.pathname;
       var qs = window.location.search;      
       var matches = data.match(/\/(.*?)\/(doku.php)?\/?(.*)/);
     
       if(qs_match = qs.match(/id=([\w:_\.]+)\b/)) { //none
           id = qs_match[1];
           href = matches[0];           
  }
       else if(!matches[2])
       {
           id = matches[3];
           href = matches[1] + '/doku.php';
       }
       else {
          id = matches[3];  
          href = matches[2] + '/doku.php';
       }  
       if(!href) href='doku.php';
       if(!id) id = 'start';
        return {'href':href, 'id':id};
  };
 
    var downloadable_header = function(type,fname) {   
    var id = 'start';  
    var file = fname ? fname: 'temp.' + type;
    var href_vals = getHref();   
    return  '<dl class="file">' 
    +'<dt><a href="' + href_vals.href + '?do=export_code&id=' + href_vals.id+ '&codeblock=0" title="Download Snippet" class="mediafile mf_' + type +'">' +file +'</a></dt> <dd><pre class="file ' + type+ '">';
 };
 
    var downloadable_footer = function() {   
    return "</pre> </dd></dl>";
  } 
 

     ckg_geshi_langopts = editor.config.geshi_opts;
     if(!ckg_geshi_langopts.match(/ENotfound/)) {
        ckg_geshi_langopts = ckg_geshi_langopts.split(';;');
        var tmp;
        for(var i=0; i<ckg_geshi_langopts.length; i++) {
            tmp = ckg_geshi_langopts[i] ;
            ckg_geshi_langopts[i] = new Array(tmp);        
    }
      ckg_geshi_langopts.unshift(['Not Set']);
        s_display = 'display:block';
        t_display = 'display:none';
    }
    else {
        t_display = 'display:inline';
        s_display = 'display:none';
        ckg_geshi_langopts = [];
    }
	return { 
		// Basic properties of the dialog window: title, minimum size.
		title: 'Abbreviation Properties',
		minWidth: 600,
		minHeight: 350,

		// Dialog window content definition.
		contents: [
			{
				// Definition of the Basic Settings dialog tab (page).
				id: 'tab-basic',
				label: 'Basic Settings',

				// The tab content.
				elements: [
					{
						// Text input field for the abbreviation text.
						type: 'html',
                        html: '<div contenteditable="true" id="ckgedit_mswin" style="width:600px; height:350px; overflow:auto;"> </div>',
                        minWidth: 350,
		               minHeight: 350,                 
						//id: ',
						label: editor.lang.geshi.code,
						// Validation checking whether the field is not empty.
					//	validate: CKEDITOR.dialog.validate.notEmpty(editor.lang.geshi.code_empty)
					},
                    {
                        type: 'hbox',
                        widths: [ '33%', '33%','33%'],
                        children: [
                                        {
                                            type: 'select',
                                             id: 'ckg_geshi_lang',
                                             label: "Select language", //editor.lang.geshi.lang,
                                              items:  ckg_geshi_langopts,  
                                              'default':ckg_geshi_langopts[0], 
                                              style:  s_display,              
                                              onChange: function( api ) {
                                                //  geshi_dialog.getContentElement(  'tab-basic', 'language' ).setValue(this.getValue());                           
                                             }
                                         },     
                                        {                                           
                                            type: 'text',
                                            id: 'language',              
                                            label:   "<html><span title='"+editor.lang.geshi.tooltip+"' style = 'color:blue;text-decoration:underline;'  onmouseover='this.style.cursor=\"pointer\";'>" + editor.lang.geshi.quick_srch+"</span></html>", //editor.lang.geshi.lang || 'Programming Language',                                       
                                            width: '125px',
                                             onChange: function( api ) {
                                                 var srch = this.getValue().toLowerCase();
                                                 srch = srch.escapeRegExpCkg(srch);
                                                   var regex = new RegExp('^' +srch); 
                                                    for(var i = 1; i< ckg_geshi_langopts.length; i++) { 
                                                            if(regex.test(ckg_geshi_langopts[i])) {
                                                                 srch=ckg_geshi_langopts[i];
                                                                 break;
                                                             }
                                                    }
                                                    if(srch)  geshi_dialog.getContentElement(  'tab-basic', 'ckg_geshi_lang' ).setValue(srch);                           
                                             }                                         
                                        },

                                        {
                                            type: 'text',
                                            id: 'file',
                                            label: editor.lang.geshi.file || 'File name',
                                            width: '175px',
                                        },                                        
                                        {
                                            type: 'radio',
                                            id: 'which',
                                            label: editor.lang.geshi.which,
                                            items: [ [ editor.lang.geshi.codeblock, 'block' ], [ editor.lang.geshi.snippet, 'snippet' ] ],
                                            'default': 'block',
                                            style: 'color: green',
                                              onClick: function() {    
                                                 radio = this.getValue();
                                            }
                                        },                    
                        ]          //hbox children
                    },            //hbox        
                    
				]  //elements
			},  //contents

		], //contents

       onShow : function()
       {
            var dialog = this;         
            geshi_dialog = dialog;
             selection = editor.getSelection();             
             var text = selection.getSelectedText();     
//var selectedElement = selection.getSelectedElement();
//selectedElement = new CKEDITOR.dom.element('p');
//selectedElement.setHtml();
//editor.insertElement(selectedElement);
/*
var selected = "<p>~~START_MSWORD~~</p>"; 
selected+=editor.getSelectedHtml(true)  ;
 editor.insertHtml(selected + "<p>~~END_MSWORD~~</p>");

  */          //dialog.getContentElement(  'tab-basic', 'geshi' ).setValue();  
           // dialog.getContentElement(  'tab-basic', 'geshi' ).setValue( selected);  
             String.prototype.escapeRegExpCkg = function(str) {
                   return str.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'); // $& means the whole matched string
             };                
         //   dialog.getContentElement(  'tab-basic', 'language' ).style='display:block'; 
          //  alert( 'Current value: ' + dialog.getValueOf( 'tab-basic', 'ckg_geshi_lang' ) );
       },
       
		
		onOk: function() {
			// The context of this function is the dialog object itself.
			// http://docs.ckeditor.com/#!/api/CKEDITOR.dialog
           var data_id = document.getElementById('ckgedit_mswin');
           var inner = data_id.innerHTML;    
           var  regex = new RegExp('<xml>([^]*)<\/xml>','gm'); 
            inner = inner.replace(regex, function(m,n) { 
                return "";
           });
          var  regex = new RegExp('<style>([^]*)<\/style>','gm'); 
              inner = inner.replace(regex, function(m,n) { 
               return "";
           });      
           
           inner = inner.replace(/style="[^>]+"/gm,"");          
           inner = inner.replace(/<span>/gm,"")
           inner = inner.replace(/<\/span>/gm,"")      
           inner =  "<p>~~START_MSWORD~~</p>" + inner + "<p>~~END_MSWORD~~</p>";
           editor.insertHtml(inner);       
		}
	};
});
