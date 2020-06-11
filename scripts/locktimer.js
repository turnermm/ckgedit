 if(window.dw_locktimer) {
   var locktimer = dw_locktimer;
} 
 //alert('js');
 var ourLockTimerRefreshID;
 var ourLockTimerIsSet = true;
 var ourLockTimerWarningtimerID;
 var ourFCKEditorNode = null;
 var ourLockTimerIntervalID;
 var dwfckTextChanged = false;
var ourLockTimerINI = false;
   /**
    *    event handler
    *    handles some mousepresses and all keystrokes from CKEditor window
  */


 function handlekeypress (e) {      
   if(ourLockTimerIsSet) {
         lockTimerRefresh();        
   }
   window.dwfckTextChanged = true;
 }

 function unsetDokuWikiLockTimer() {
     
    if(window.locktimer && !ourLockTimerINI) {
        locktimer.old_reset = locktimer.reset;
        locktimer.old_warning = locktimer.warning;        
        ourLockTimerINI=true;
    }
    else {
        window.setTimeout("unsetDokuWikiLockTimer()", 600);

    }
  
  locktimer.reset = function(){
        locktimer.clear();  // alert(locktimer.timeout);
        window.clearTimeout(ourLockTimerWarningtimerID);
        ourLockTimerWarningtimerID =  window.setTimeout(function () { locktimer.warning(); }, locktimer.timeout);
   };

   locktimer.warning = function(){    
        window.clearTimeout(ourLockTimerWarningtimerID);

        if(ourLockTimerIsSet) {
            if(locktimer.msg.match(/$preview_button/i)) {
                locktimer.msg = locktimer.msg.replace(/$preview_button/i, "Back-up");      
             }
            alert(locktimer.msg);
        }
        else {
            alert("$locktimer_msg");
        }
     };
     

    locktimer.ourLockTimerReset = locktimer.reset;
    locktimer.our_lasttime = new Date();
    lockTimerRefresh();

 }

 function lockTimerRefresh(bak) {
        var now = new Date();
        if(!ourLockTimerINI)  unsetDokuWikiLockTimer();

        if((now.getTime() - locktimer.our_lasttime.getTime() > 45*1000) || bak){            
           var dwform = GetE('dw__editform');
            window.clearTimeout(ourLockTimerWarningtimerID);
            var params = 'call=lock&id='+locktimer.pageid;
            if(CKEDITOR.instances) {  
                dwform.elements.wikitext.value = CKEDITOR.instances.wiki__text.getData();
                params += '&prefix='+encodeURIComponent(dwform.elements.prefix.value);
                params += '&wikitext='+encodeURIComponent(dwform.elements.wikitext.value);
                params += '&suffix='+encodeURIComponent(dwform.elements.suffix.value);
                params += '&date='+encodeURIComponent(dwform.elements.date.value);
            }
            locktimer.our_lasttime = now;  
            jQuery.post(
                DOKU_BASE + 'lib/exe/ajax.php',
                params,
                function (data) {
                    data = data.replace(/auto/,"")  + ' by ckgedit';
                    locktimer.response = data; 
                    locktimer.refreshed(data);
                },
                'html'
            );
       }
        
 }
 function resetDokuWikiLockTimer(delete_checkbox) {

        var dom_checkbox = document.getElementById('ckgedit_timer');
        var dom_label = document.getElementById('ckgedit_timer_label');
        locktimer.clear();     
        if(ourLockTimerIsSet) {

             ourLockTimerIsSet = false;             
             locktimer.reset = locktimer.old_reset; 
             locktimer.refresh(); 
             return;
        }
      
     if(delete_checkbox) {
       dom_checkbox.style.display = 'none';
       dom_label.style.display = 'none';
     }

       ourLockTimerIsSet = true;
       locktimer.reset = locktimer.ourLockTimerReset;     
       lockTimerRefresh();
          
 }

function renewLock(bak) {
  if(ourLockTimerIsSet) {
         lockTimerRefresh(true);
   }
   else { 
    locktimer.refresh();
   }
   locktimer.reset();


    if(bak) {
        var id = "$ID"; 
        parse_wikitext('bakup');

        var dwform = GetE('dw__editform');
        if(dwform.elements.fck_wikitext.value == '__false__' ) return;
         GetE('saved_wiki_html').innerHTML = CKEDITOR.instances.wiki__text.getData(); // ourFCKEditorNode.innerHTML; 
        if(($editor_backup) == 0 ) {           
           return; 
        }
     
        var params = "rsave_id=" + encodeURIComponent("$meta_fn");       
        params += '&wikitext='+encodeURIComponent(dwform.elements.fck_wikitext.value);      
        params += '&call=refresh_save';
        jQuery.post(
           //     DOKU_BASE + 'lib/plugins/ckgedit/scripts/refresh_save.php',
               DOKU_BASE + 'lib/exe/ajax.php',
                params,
                function (data) {          
                    if(data == 'done') {
                        show_backup_msg("$meta_id");  
                    }
                    else {
                      alert("error saving: " + id);
                    }
                },
                'html'
            );
    }

} 
