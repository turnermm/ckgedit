CKEDITOR.plugins.add( 'wrap', {   
	lang: 'en,de',
    init: function( editor ) {
        //Plugin logic goes here.
		editor.addCommand( 'wrap', new CKEDITOR.dialogCommand( 'wrapDialolg' ) );	
		editor.ui.addButton( 'Wrap', {
			label: editor.config.wrap_lang.title, 
			command: 'wrap',
			toolbar: 'insert',
			icon: this.path + 'icons/wrap.png', 
		});
		
		CKEDITOR.dialog.add( 'wrapDialolg', this.path + 'dialogs/wrap.js' );
    }
});