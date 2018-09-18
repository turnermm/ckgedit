/**
 * Copyright (c) 2014-2016, CKSource - Frederico Knabben. All rights reserved.
 * Licensed under the terms of the MIT License (see LICENSE.md).
 *
 * The abbr plugin dialog window definition.
 *
 * Created out of the CKEditor Plugin SDK:
 * http://docs.ckeditor.com/#!/guide/plugin_sdk_sample_1
 */

// Our dialog definition.
CKEDITOR.dialog.add( 'mswordDialog', function( editor ) {
    var ed_lang = editor.lang.msword;
    /*top right  bottom left*/
//    var olstyle ='list-style: decimal-leading-zero; font-size: 1.1em; margin: 0 0 0 .25em';
    var olstyle ='font-size: 1.1em;';
	return { 
		// Basic properties of the dialog window: title, minimum size.
		title: 'MS Word',
		minWidth: 600,
		minHeight: 350,

		// Dialog window content definition.
		contents: [
			{
				// Definition of the Basic Settings dialog tab (page).
				id: 'tab-basic',
				label: 'Text',

				// The tab content.
				elements: [
					{					
						type: 'html',
                        html: '<div contenteditable="true" id="ckgedit_mswin" style="border: 2px solid #ddd; padding:3px; width:600px; height:350px; overflow:auto; cursor:auto;"> </div>',
                        minWidth: 350,
		                minHeight: 350,                         
					},
                    {
                        type: 'hbox',
                       height: [ '18px;'],
                       children: [
                        {
                          type: 'html',
                          html: editor.lang.msword.info,                          
                        }
                  
                        ]          //hbox children
                    },            //hbox        
                    
				],  //elements
    
			},  //contents
            {
				id: 'Info',
				label: editor.lang.msword.instructionsLabel,
                
              	elements: [
					{				
						type: 'html',                      
                        html:  "<div style='padding:40px;'><ol><li style='" +olstyle + "><span style='font-size:11pt'>"+ ed_lang.instructions +'</span></li><li style="' +olstyle + '"><span style="font-size:11pt"> ' + ed_lang.instructions_2
                        +'</li><ul style="list-style-position: inside;"><li style="margin: 0 0 0 4px"><span style="font-size:11pt;">'+ed_lang.instructions_3 + '</span></li><li style="margin: 0 0 0 4px"><span style="font-size:11pt">'+ed_lang.instructions_4
                         + '</span></ul><li style="' +olstyle + '"><span style="font-size:11pt;overflow-wrap">'
                        + ed_lang.instructions_5 + '</span></li></ol></div>',

                  
					},
               ]                    
            } 
		], //contents

       onShow : function()
       {
            var dialog = this;         
            geshi_dialog = dialog;
            selection = editor.getSelection();                     
            var selected=editor.getSelectedHtml(true)  ;
            if(selected) {
                 var data_id = document.getElementById('ckgedit_mswin');
                 data_id.innerHTML = selected;    
            }   
                jQuery( "#ckgedit_mswin" ).keydown(function(ev) {                   
                      if (ev.which == 13 ) {                         
                            ev.stopPropagation();
                     }                      
              });
       },
       
		
		onOk: function() {
			// The context of this function is the dialog object itself.
			// http://docs.ckeditor.com/#!/api/CKEDITOR.dialog
           var data_id = document.getElementById('ckgedit_mswin');
           var inner = data_id.innerHTML;    
            inner = inner.replace(/&lt/gm,'<'); 
            inner = inner.replace(/&gt/mg,'>');
          //if(confirm("exit now")  {
             //jQuery('.cke_dialog_ui_button_cancel').children().click();
         // }
           var  regex = new RegExp('<xml>([^]*)<\/xml>','gm'); 
            inner = inner.replace(regex, function(m,n) { 
                return "";
           });
           
        
          var  regex = new RegExp('<style>([^]*)<\/style>','gm'); 
              inner = inner.replace(regex, function(m,n) { 
               return "";
           });    

//      alert("START\n" +inner +"\nSTOP");
            
            inner = inner.replace(/&lt/gm,'<'); 
            inner = inner.replace(/&gt/mg,'>');
            inner = inner.replace(/<table\s+class=.*?>/mg, "<table>");
            inner = inner.replace(/<table.*?>/mg, "<table>");
            inner = inner.replace(/<tr.*?>/mg, "<tr>");         
            inner = inner.replace(/<td.*?>/mg, "<td>");  
           inner = inner.replace(/style="([^>]+)"/gm,function(m,i){
                matches = i.match(/level(\d)/);
                if(matches) {                  
                   return  'L_'+matches[1];                   } 
                 return m;
            });
            
           inner = inner.replace(/style="[^>]+"/gm,"");  
           inner = inner.replace(/<h(\d).*?><span.*?>/gm,"<h$1>");   
            inner = inner.replace(/(<span\s*>)+/gm,"");
            inner = inner.replace(/(<\/span>)+/gm,"");
            inner = inner.replace(/<tbody>([^]+)<\/tbody>/,function(m){          
                m = m.replace(/<\/p>/mg,"");
                return m.replace(/<p.*?>/mg,"");             
            });     
     //       alert(inner);
             inner = inner.replace(/<p class="MsoListParagraphCxSpFirst"\s+L_\d>([\s\S]+)<p class="MsoListParagraphCxSpLast"\s+L_\d>.*?\n(.*?)\/p>/gm, function(m,w){     
                        var n = m;
                        n = n.replace(/&nbsp;/gm,"");
                        n = n.replace(/>[1-5a-f]./gm,'>');
                         var ar = n.split(/\n/);  
                        var str = "";
                        
                          for(j=0;j<ar.length;j++) {                                                                                   
                                  if(ar[j].match(/SpFirst/)) {
                                     ar[j] = ar[j].replace(/<p.*?>/,""); 
                                      ar[j] = ar[j].replace(/<\/p>/,""); 
                                  
                                           ar[j] = ar[j].replace(/<p.*?>(\d*|·)/,"");
                                           str += "<ol><li>" +ar[j] + '</li>';
                                  } 
                                  else if (ar[j].match(/SpMiddle/)) {                               
                                      ar[j] = ar[j].replace(/<p.*?>/,"");
                                     ar[j] = ar[j].replace(/<p.*?>/,""); 
                                      ar[j] = ar[j].replace(/<\/p>/,"");                                        
                                  } 
                                  else if (ar[j].match(/SpLast/)) {    
                                       ar[j] = ar[j].replace(/<p.*?>/,""); 
                                      ar[j] = ar[j].replace(/<\/p>/,""); 
                                       ar[j] = ar[j].replace(/^\s+/,"");           
                                  }
                                  else {                                           
                                         ar[j] = ar[j].replace(/<\/p>/,""); 
                                         ar[j] = ar[j].replace(/^\s+/,""); 
                                          ar[j] = ar[j].replace(/\s+$/,""); 
                                           str+='<li>';
                                           str+=ar[j] + '</li>';                                         
                                  }
                          }                            
                         str = str.replace(/<li>·*<\/li>/gm,"");                        
                         str+="</ol>";
                         return str;
        } );
          editor.insertHtml(inner);   
           data_id.innerHTML  ="";
		}
	};
});
