/**
 * Basic sample plugin inserting current date and time into CKEditor editing area.
 */

// Register the plugin with the editor.
// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.plugins.html
CKEDITOR.plugins.add( 'truetype',
{
	// The plugin initialization logic goes inside this method.
	// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.pluginDefinition.html#init
	init: function( editor )
	{
     //    var lang = editor.lang.signature;   
    //     if(!lang) lang = CKEDITOR.lang['default']['signature'];
             
		// Define an editor command that inserts a timestamp. 
		// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.editor.html#addCommand
		editor.addCommand( 'truetype',
			{

				// Define a function that will be fired when the command is executed.
				// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.commandDefinition.html#exec
				exec : function( editor )
				{    
                  

                          var selection = editor.getSelection();                     
                           var text = selection.getSelectedText();

					// Insert the timestamp into the document.
					// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.editor.html#insertHtml				
                	editor.insertHtml('<code>' + text + '</code>');
				}
			});
		// Create a toolbar button that executes the plugin command. 
		// http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.ui.html#addButton
		editor.ui.addButton( 'TrueType',
		{
			// Toolbar button tooltip.
			label: 'TrueType',
			// Reference to the plugin command name.
			command: 'truetype',
			// Button's icon file path.
			icon: this.path + 'images/truetype.png'
		} );
	}
} );