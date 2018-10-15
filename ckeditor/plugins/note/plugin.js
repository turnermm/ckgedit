CKEDITOR.plugins.add( 'note', {
    icons: 'note',
	lang: 'en,de',
    init: function( editor ) {
        //Plugin logic goes here.
		editor.addCommand( 'note', new CKEDITOR.dialogCommand( 'noteDialog' ) );
		
		editor.ui.addButton( 'Note', {
			label: editor.lang.note.title, 
			command: 'note',
			toolbar: 'insert',
			icon: this.path + 'icons/note.png', 
		});
		
		CKEDITOR.dialog.add( 'noteDialog', this.path + 'dialogs/note.js' );
    }
});