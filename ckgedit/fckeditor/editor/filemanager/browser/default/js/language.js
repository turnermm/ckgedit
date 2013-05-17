var fck_Lang;

function setupLanguage() {

     if(opener && opener.oDokuWiki_FCKEditorInstance.Lang) {
        if(opener.oDokuWiki_FCKEditorInstance.Lang['fbrowser'])
            fck_Lang=opener.oDokuWiki_FCKEditorInstance.Lang['fbrowser'];               
            return;  
 }

     if (parent && parent.opener.oDokuWiki_FCKEditorInstance.Lang) {
        fck_Lang=parent.opener.oDokuWiki_FCKEditorInstance.Lang['fbrowser'];          
        ckgTranslatePage(document);
        return;  
 }
 
}

function translateItem(js_code, default_str) {

  if(!fck_Lang) return default_str;
  if(fck_Lang[js_code] && fck_Lang[js_code] != "") {
        return fck_Lang[js_code];
  }
  
  return default_str;

}


/* translate errors for error case 1 which implements variable error messages */
function translateErrorAny(err_str) {
 if(!fck_Lang) return err_str;
 if(!err_str.match(/^FileBrowserError_/)) {
     return err_str;    
 }

 if(err_str.match(/;;/)) {
    var elems = err_str.split(/;;/);
    if(fck_Lang[elems[0]]) {
       return fck_Lang[elems[0]] + ' ' + elems[1];   
    }
    return err_str
 }
 
  if(err_str.match(/^FileBrowserError_\w+$/)) {
      return fck_Lang[err_str];
  }
   
  return err_str;  
}
 
function ckgTranslatePage(d) {

   var spans = d.getElementsByTagName('span');
    
   for(i=0; i<spans.length; i++) {
      if(spans[i].getAttribute("fckLang")) {
         var val = spans[i].getAttribute("fckLang");
         var translation = translateItem(val,  "");
         if(translation) {
            spans[i].innerHTML = translation;
         }
      }
   }

   var input = d.getElementsByTagName('input');
    for(i=0; i<input.length; i++) {
      if(input[i].getAttribute("fckLang")) {
         var val = input[i].getAttribute("fckLang");        
         var translation = translateItem(val,  "");
         if(translation) {
            input[i].value = translation;
         }
      }
   }
 
}