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
    var radio;
    var  getHref = function() {
       var data = window.location.pathname;
       var qs = window.location.search;
       var href, id;
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
  }
 
    var downloadable_header = function(type,fname) {   
    var id = 'start';  
    var file = fname ? fname: 'temp.' + type;
    var href_vals = getHref();   
    return  '<dl class="file">' 
    +'<dt><a href="' + href_vals.href + '?do=export_code&id=' + href_vals.id+ '&codeblock=0" title="Download Snippet" class="mediafile mf_' + type +'">' +file +'</a></dt> <dd><pre class="file ' + type+ '">';
 }
 var downloadable_footer = function() {   
    return "</pre> </dd></dl>";
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
						type: 'textarea',
                        rows:18,
                        cols:  80,
						id: 'geshi',
						label: editor.lang.geshi.code,
						// Validation checking whether the field is not empty.
						validate: CKEDITOR.dialog.validate.notEmpty(editor.lang.geshi.code_empty)
					},
                    {
                        type: 'hbox',
                        widths: [ '33%', '33%','33%'],
                        children: [

                                        {                                           
                                            type: 'text',
                                            id: 'language',
                                            label: editor.lang.geshi.lang || 'Programming Language',
                                            width: '175px',
                                            validate: CKEDITOR.dialog.validate.notEmpty(editor.lang.geshi.lang_empty)
                                        },
                                        {
                                            type: 'text',
                                            id: 'file',
                                            label: editor.lang.geshi.file || 'File name',
                                            width: '175px',
                                          //  validate: CKEDITOR.dialog.validate.notEmpty(editor.lang.geshi.lang_empty)
                                        },                                        
                                        {
                                            type: 'radio',
                                            id: 'which',
                                            label: editor.lang.geshi.which,
                                            items: [ [ editor.lang.geshi.codeblock, 'block' ], [ editor.lang.geshi.snippet, 'snippet' ] ],
                                            default: 'block',
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
             selection = editor.getSelection();             
             var text = selection.getSelectedText();                    
            dialog.getContentElement(  'tab-basic', 'geshi' ).setValue( text );   
       },
       
		// This method is invoked once a user clicks the OK button, confirming the dialog.
		onOk: function() {
			// The context of this function is the dialog object itself.
			// http://docs.ckeditor.com/#!/api/CKEDITOR.dialog
			var dialog = this, retval;      
	         var text = dialog.getValueOf( 'tab-basic', 'geshi' );
             var which = dialog.getValueOf( 'tab-basic', 'which' );
             var p_lang = dialog.getValueOf( 'tab-basic', 'language' );
             if(which == 'block') {
                 retval = '<pre class="code ' + p_lang + ' ">' + text + '</pre>';
             }
             else retval = downloadable_header(p_lang,dialog.getValueOf( 'tab-basic', 'file' ) ) + text + downloadable_footer();
             editor.insertHtml(retval);

		}
	};
});
