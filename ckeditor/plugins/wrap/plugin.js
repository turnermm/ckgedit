CKEDITOR.plugins.add( 'wrap', {   
	lang: 'en,de,zh,zh-tw,tr,sk,ru,pt-br,no,nl,ko,ja,it,hu,hr,fr,fa,es,eo,de-informal,da,cs,bn,ar',
    init: function( editor ) {
        //Plugin logic goes here.
		editor.addCommand( 'wrap', new CKEDITOR.dialogCommand( 'wrapDialolg' ) );	
		editor.ui.addButton( 'Wrap', {
			label:  editor.lang.wrap.title || 'Wrap Plugin', 
			command: 'wrap',
			toolbar: 'insert',
			icon: this.path + 'icons/wrap.png', 
		});
		
		CKEDITOR.dialog.add( 'wrapDialolg', this.path + 'dialogs/wrap.js' );
    }
});