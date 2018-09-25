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
CKEDITOR.plugins.add( 'geshi', {

	// Register the icons. They must match command names.
	icons: 'geshi',
    lang: 'en,de',
    	
	// The plugin initialization logic goes inside this method.
	init: function( editor ) {
        editor.addCommand( 'geshi', new CKEDITOR.dialogCommand( 'geshiDialog' ) );

		// Create the toolbar button that executes the above command.
		editor.ui.addButton( 'Geshi', {
			label:   editor.lang.geshi.title,//'Insert Geshi',
			command: 'geshi',
			toolbar: 'insert',        
            icon: this.path + 'icons/geshi.gif',           
		});
        CKEDITOR.dialog.add( 'geshiDialog', this.path + 'dialogs/geshi.js' );
	}
});
