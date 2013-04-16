CKEDITOR.plugins.add("footnote",{init:function(a){a.addCommand("footnoteDialog",new CKEDITOR.dialogCommand("footnoteDialog"));if(!oDokuWiki_FCKEditorInstance.oinsertHtmlCodeObj){oDokuWiki_FCKEditorInstance.oinsertHtmlCodeObj=new Object();oDokuWiki_FCKEditorInstance.oinsertHtmlCodeObj.notes=new Array();oDokuWiki_FCKEditorInstance.oinsertHtmlCodeObj.count=0}a.ui.addButton("Footnotes",{label:"Insert a footnote",command:"footnoteDialog",icon:this.path+"images/footnote.png"});CKEDITOR.dialog.add("footnoteDialog",function(c){var b=['<div style="padding: 18px;font-size:125%;line-height:125%;">','<ul style="list-style-type:disc;"><li>To create a footnote enter the footnote text into the editing box and click OK</li>',"<li>To edit a footnote enter the footnote id into the id box and click the Load button. <br /> The footnote will ","appear in the editing box, where you can then edit it.<br /> When you are finished editing, click OK to save.</li>","<li> A footnote id has this form: <b>fckgL_&lt;n&gt;</b>, where n is the number of the note.</li></ul></div>"];return{title:"Footnote Dialog",minWidth:400,minHeight:200,fontSize:"14pt",onShow:function(){},contents:[{id:"general",label:"Settings",elements:[{type:"html",html:"This dialog window lets you create and edit footnotes."},{type:"textarea",id:"contents",label:"Footnote Text (required)",validate:CKEDITOR.dialog.validate.notEmpty("The footnote text field cannot be empty."),commit:function(d){d.contents=this.getValue()},},{type:"hbox",id:"revisions",widths:["15%","30%","2%","53%"],children:[{type:"html",html:"Footnote Id: ",},{type:"text",id:"noteId",maxLength:"9",commit:function(d){d.noteId=this.getValue()},onChange:function(d){},},{type:"html",html:"&nbsp;&nbsp;",},{type:"button",label:"Load Note In Editor",id:"id3",onClick:function(){var f=this.getDialog();var g=f.getContentElement("general","noteId").getInputElement().$.id;var d=document.getElementById(g).value;if(d){if(oDokuWiki_FCKEditorInstance.oinsertHtmlCodeObj.notes[d]){var g=f.getContentElement("general","contents").getInputElement().$.id;var e=document.getElementById(g);e.value=oDokuWiki_FCKEditorInstance.oinsertHtmlCodeObj.notes[d]}}},}]},]},{id:"info",label:"Info",elements:[{type:"html",html:b.join(""),},]},],onOk:function(){var g=this,h={},f=c.document.createElement("sup");this.commitContent(h);if(h.noteId){oDokuWiki_FCKEditorInstance.oinsertHtmlCodeObj.notes[h.noteId]=h.contents;return}f.setAttribute("class","dwfcknote ");var e=++oDokuWiki_FCKEditorInstance.oinsertHtmlCodeObj.count;var d="fckgL"+e;f.setAttribute("class","dwfcknote "+d);oDokuWiki_FCKEditorInstance.oinsertHtmlCodeObj.notes[d]=h.contents;f.setHtml(d);c.insertElement(f)}}})}});