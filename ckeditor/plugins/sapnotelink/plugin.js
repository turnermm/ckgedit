CKEDITOR.plugins.add( 'sapnotelink', {
    icons: 'sapnotelink',
	lang: 'en,de',
    init: function( editor ) {
        editor.addCommand( 'sapnotelink', new CKEDITOR.dialogCommand( 'sapnotelinkDialog' ) );
        editor.ui.addButton( 'SAPnotelink', {
            label: editor.lang.sapnotelink.title,
            command: 'sapnotelink',
            toolbar: 'insert',
			icon: this.path + 'icons/sapnotelink.png' 
        });

        CKEDITOR.dialog.add( 'sapnotelinkDialog', this.path + 'dialogs/sapnotelink.js' );
    }
});
