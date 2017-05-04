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
        return window.location.pathname;
  }
    var downloadable_header = function(type,fname) {   
    var id = 'start';  
    var file = fname ? fname: 'temp.' + type;
    
    return  '<dl class="file">' 
    +'<dt><a href="' + getHref() + '?do=export_code&id=' + id+ '&codeblock=0" title="Download Snippet" class="mediafile mf_' + type +'">' +file +'</a></dt> <dd><pre class="file ' + type+ '">';
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
             if(which == 'block') {
                 retval = '<pre class="code java">' + text + '</pre>';
             }
             else retval = downloadable_header(dialog.getValueOf( 'tab-basic', 'language' ),dialog.getValueOf( 'tab-basic', 'file' ) ) + text + downloadable_footer();
             editor.insertHtml(retval);

		}
	};
});
