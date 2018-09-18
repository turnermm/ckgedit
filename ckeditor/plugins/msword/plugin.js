/**
 * Copyright (c) 2014-2016, CKSource - Frederico Knabben. All rights reserved.
 * Licensed under the terms of the MIT License (see LICENSE.md).
 *
 * Basic sample plugin inserting current date and time into the CKEditor editing area.
 *
 * Created out of the CKEditor Plugin SDK:
 * http://docs.ckeditor.com/#!/guide/plugin_sdk_intro
 */

// Register the plugin within the editor.
CKEDITOR.plugins.add( 'msword', {

	// Register the icons. They must match command names.
	icons: 'msword',
    lang: 'en,de',
    	
	// The plugin initialization logic goes inside this method.
	init: function( editor ) {
        editor.addCommand( 'msword', new CKEDITOR.dialogCommand( 'mswordDialog' ) );

		// Create the toolbar button that executes the above command.
		editor.ui.addButton( 'Msword', {
		label:   editor.lang.msword.title,//'Insert Msword',
		command: 'msword',
		//toolbar: 'insert',   
            title: editor.lang.msword.title,    
            icon: this.path + 'icons/msword.png',           
		});
        CKEDITOR.dialog.add( 'mswordDialog', this.path + 'dialogs/msword.js' );
	}
});
