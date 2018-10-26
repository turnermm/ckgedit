CKEDITOR.plugins.add("tags",
  {
    icons: 'tag',
    lang: [ 'en', 'de','fr'],
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
      var tags_position = 'top';
      editor.tags_pos = function() { return tags_position};
	  var existingTags;
	  editor.existing_tags = function() { return existingTags};
	  jQuery.ajax(
          DOKU_BASE + 'lib/exe/ajax.php',
          {
            data:
              {
                call: 'tagapi_list'
              },
            type: "POST",
          //  async: false,
            dataType: "json",
            success: function(data, textStatus, jqXHR)
              {
                existingTags = data.tags;
              // alert(existingTags);
              },
            error: function(jqXHR, textStatus, errorThrown )
              {
                alert(textStatus);
                alert(errorThrown);
              }
          }
        );
    }
  }
);