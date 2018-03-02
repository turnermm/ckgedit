/*
 *
 * Plugin name: headerbuttons
 *
 */
(function() {
CKEDITOR.plugins.add( 'headerbuttons', {
	lang: 'en,de', 
    icons: 'SH,HH,LH,P',
    hidpi: true,
    init: function( editor ) {
        editor.addCommand( 'same_header', {
            exec: function( editor ) {
                var lastH = getLastHeader(editor);

                var style = new CKEDITOR.style( { element: lastH } );
                editor.applyStyle(style);
            }
        });
        editor.addCommand( 'lower_header', {
            exec: function( editor ) {
                var lastH = getLastHeader(editor),
                    lowerH;

                if (lastH == 'h6') {
                    lowerH = 'h6';
                } else {
                    var lower = Number(lastH.substring(1,2)) + 1;
                    lowerH = 'h' + lower;
                }

                var style = new CKEDITOR.style( { element: lowerH } );
                editor.applyStyle(style);
            }
        });
        editor.addCommand( 'higher_header', {
            exec: function( editor ) {
                var lastH = getLastHeader(editor),
                    higherH;

                if (lastH == 'h1') {
                    higherH = 'h1';
                } else {
                    var higher = Number(lastH.substring(1,2)) - 1;
                    higherH = 'h' + higher;
                }

                var style = new CKEDITOR.style( { element: higherH } );
                editor.applyStyle(style);
            }
        });
        editor.addCommand( 'none_header', {
            exec: function( editor ) {
                var style = new CKEDITOR.style( { element: 'p' } );
                editor.applyStyle(style);
            }
        });

        editor.ui.addButton('same_header', {
            label: editor.lang.headerbuttons.same,
            command: 'same_header',
            toolbar: 'header_buttons',
            icon: 'SH'
        });
        editor.ui.addButton('lower_header', {
            label: editor.lang.headerbuttons.lower,
            command: 'lower_header',
            toolbar: 'header_buttons',
            icon: 'LH'
        });
        editor.ui.addButton('higher_header', {
            label: editor.lang.headerbuttons.higher,
            command: 'higher_header',
            toolbar: 'header_buttons',
            icon: 'HH'
        });
        editor.ui.addButton('none_header', {
            label: editor.lang.headerbuttons.remove,
            command: 'none_header',
            toolbar: 'header_buttons',
            icon: 'P'
        });
    }
});
})();

function getLastHeader( editor ) {
    //list of header types
    var headers = ['h1','h2','h3','h4','h5','h6'];

    // First we need to find where our cursor is
    var selection = editor.getSelection();
    var range = selection.getRanges()[0];

    //get previous node
    var prevNode = range.getPreviousNode();
    //go through each previous node
    while (prevNode) {
        var nodeType;
        if (typeof prevNode.getName === 'undefined') {
            nodeType = prevNode.$.parentNode.localName;
        } else {
            nodeType = prevNode.getName();
            if (headers.indexOf(nodeType) != -1) {
                return nodeType;
            }
        }

        prevNode = prevNode.getPreviousSourceNode();
    }

    //return h1 by default
    return 'h1';
}
