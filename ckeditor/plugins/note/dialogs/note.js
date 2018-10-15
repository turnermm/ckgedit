CKEDITOR.dialog.add( 'noteDialog', function( editor ) {
    return {
        title: 'Note Properties',
        minWidth: 400,
        minHeight: 200,
        contents: [
			{
                id: 'tab-basic',
                label: 'Basic Note',
                elements: [
                    {
						type: 'radio',
						id: 'notetype',
						label: editor.lang.note.selectOption,
						items: [ [ '<img src="' + DOKU_BASE+ 'lib/plugins/ckgedit/ckeditor/plugins/note/icons/note_basic.png" alt="'+editor.lang.note.basic +'">', 'basic' ], [ '<img src="' + DOKU_BASE+ 'lib/plugins/ckgedit/ckeditor/plugins/note/icons/note_important.png" alt="'+editor.lang.note.important+'">', 'important' ] , [ '<img src="' + DOKU_BASE+ 'lib/plugins/ckgedit/ckeditor/plugins/note/icons/note_tip.png" alt="'+editor.lang.note    .tip+'">', 'tip' ] , [ '<img src="' + DOKU_BASE+ 'lib/plugins/ckgedit/ckeditor/plugins/note/icons/note_warning.png" alt="'+editor.lang.note.warning+'">', 'warning' ] ],
						style: 'color: black',
						'default': 'basic',
					},
					{
                        type: 'text',
                        id: 'note',
                        label: editor.lang.note.content,
              			'default': ''
                    }
                ]
            }
        ],
		// Invoked when the dialog is loaded.
		onShow: function() {
			// Get the selection from the editor.    
		    var text = editor.getSelection().getSelectedText();            
            if(text) {                          
                this.getContentElement( 'tab-basic', 'note').disable();
                this.setValueOf( 'tab-basic', 'note',text);
            }    
               else this.text = false;
		},       
        
        onOk: function() {
            var dialog = this;

          //    var note = editor.document.createElement( 'note' );  
          //  note.setAttribute( 'title', dialog.getValueOf( 'tab-basic', 'note' ) );
			
			//get the note type
			var noteTypeValue = dialog.getValueOf( 'tab-basic', 'notetype' );
			
			
			if (noteTypeValue == 'basic') {
				noteTypeValue = '<note>';
			} else {
				noteTypeValue = '<note ' + noteTypeValue + '>';
			}
			
			//get the note text
			var noteText = this.text ? this.text: dialog.getValueOf( 'tab-basic', 'note' );
            if(!noteText) {
                alert("Note cannot be left empty");
                return false;
            }
			//insert the note
			editor.insertText ( noteTypeValue + noteText + '</note>' )

        }
    };
});
