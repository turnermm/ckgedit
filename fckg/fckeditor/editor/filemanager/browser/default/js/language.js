var fck_Lang;

function setupLanguage(file) {

return;
 if(opener && opener.FCK.Language) {
    fck_Lang=opener.FCKLang;
    opener.FCK.Language.TranslatePage(document);
    return;  
 }
 /*
 if (parent && parent.opener.FCK.Language) {
    fck_Lang=parent.opener.FCKLang;
    parent.opener.FCK.Language.TranslatePage(document);
    return;  

 }
 
*/

}

function translateItem(js_code, default_str) {
/*
  if(fck_Lang[js_code] && fck_Lang[js_code] != "") {
        return fck_Lang[js_code];
  }
  */
  return default_str;

}


/* translate errors for error case 1 which implements variable error messages */
function translateErrorAny(err_str) {
return err_str;
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
 

