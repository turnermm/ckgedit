CKEDITOR.dialog.add( 'sapnotelinkDialog', function( editor ) {
return {
        title: editor.lang.sapnotelink.title,
        minWidth: 400,
        minHeight: 200,
        contents: [
            {
                id: 'tab-basic',
                label: editor.lang.sapnotelink.title,
                elements: [
                    {
                        type: 'text',
                        id: 'sapnotelink',
                        label: editor.lang.sapnotelink.content,
						validate: CKEDITOR.dialog.validate.number( editor.lang.sapnotelink.number )
                    }
                ]
            }
        ],
        onOk: function() {
            var dialog = this;
            var notenumber = this.text ? this.text : dialog.getValueOf('tab-basic', 'sapnotelink');
            if (!notenumber) {
                alert( editor.lang.sapnotelink.empty );
                return false
            }
            editor.insertText('sap#' + notenumber);
        }
    };
});