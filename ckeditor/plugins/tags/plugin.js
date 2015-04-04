CKEDITOR.plugins.add("tags",
  {
    icons: 'tag',
    lang: [ 'en', 'de'],
    init: function(editor) {
      CKEDITOR.dialog.add( 'tagsDialog', this.path + 'dialogs/tags.js' );
      editor.addCommand( 'editTags', new CKEDITOR.dialogCommand( 'tagsDialog') );
      editor.ui.addButton( 'Tags',
        {
          label: 'Tags',
          command: 'editTags',
          toolbar: 'insert',
          icon: this.path + 'images/icon.png'
        }
      );
    }
  }
);