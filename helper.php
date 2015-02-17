<?php
/**
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Myron Turner <turnermm02@shaw.ca>
 */
 
// must be run within Dokuwiki
if (!defined('DOKU_INC')) die();

class helper_plugin_ckgedit extends DokuWiki_Plugin {
 

 
  function getMethods(){
    $result = array();
    $result[] = array(
      'name'   => 'registerOnLoad',
      'desc'   => 'register some javascript to the window.onload js event',
      'params' => array('js' => 'string'),
      'return' => array('html' => 'string'),
    );
    return $result;
  }

  /**
   * Convert string configuration value into an array
  */
  function get_conf_array($val) {
     $str = $this->getConf($val);
     $str = preg_replace('/\s+/',"",$str);
     return explode(',', $str);
  }
  
  function get_ckgedit_ImageAllowedExtensions() {
    $uploadImageTypes = ARRAY();
    foreach (getMimeTypes() as $ext=>$mtype) {
        if(preg_match("/image/", $mtype)) {
           $uploadImageTypes[] = $ext;
      }     
    }
     return '.(' . implode('|',$uploadImageTypes) .')$';
  }
  
  function is_outOfScope(&$which="") {
      if(isset($_REQUEST['target']) && $_REQUEST['target'] == 'plugin_data') return true; 
      return false;
  }
  
  function registerOnLoad($js){
  global $ID;
  global $lang;
  
  $preview_button = $lang['btn_preview'];

  $ckgedit_conf_direction = $this->getConf('direction');
   if($ckgedit_conf_direction == "dokuwiki") {
       $ckgedit_lang_direction = $lang['direction'];
   }    
  else {
      $ckgedit_lang_direction = $ckgedit_conf_direction;
  }   
  $ImageUploadAllowedExtensions = $this->get_ckgedit_ImageAllowedExtensions() ;
  $media_tmp_ns = preg_match('/:/',$ID) ? preg_replace('/:\w+$/',"",$ID,1) : "";    
  $locktimer_msg = "Your lock for editing this page is about to expire in a minute.\\n"                  
                . "You can reset the timer by clicking the Back-up button.";

    $meta_fn = metaFN($ID,'.ckgedit');
    $meta_id = 'meta/' . str_replace(':','/',$ID) . '.ckgedit';

  global $INFO; 
  global $conf;
  global $USERINFO;
  $_OS = strtolower(PHP_OS);
  $cname = getCacheName($INFO['client'].$ID,'.draft');
  $useheading = $conf['useheading'];
  if($useheading && $useheading != 'content' && $useheading != '0') {
       $useheading = 'y';
  }
  else $useheading = 'n';
  //msg('uh='.$useheading);
  $open_upload = $this->getConf('open_upload');
  $editor_backup = $this->getConf('editor_bak');
  $create_folder = $this->getConf('create_folder');
  $interface_lang = $this->getConf('other_lang');
  $scayt_lang = $this->getConf('scayt_lang');
  list($name,$scayt_lang) = explode('/', $scayt_lang);
  
  $scayt_auto = $this->getConf('scayt_auto');
 $color_opts = $this->getConf('color_options');
 $font_opts = $this->getConf('font_options');
  $toolbar_opts = $this->getConf('alt_toolbar');
  if(!isset($INFO['userinfo']) && !$open_upload) {
    $user_type = 'visitor';
  }
  else {
   $user_type = 'user';
  }
  $save_dir = DOKU_URL . ltrim($conf['savedir'],'/.\/');

  // if no ACL is used always return upload rights
  if($conf['useacl']) {
     $client = $_SERVER['REMOTE_USER']; 
  }
  else $client = "";
  $user_name = $USERINFO['name'];
  $user_email = $USERINFO['mail'];
  
  $fnencode = isset($conf['fnencode']) ? $conf['fnencode'] : 'url';  
  $user_groups = $USERINFO['grps'];
  if(!$user_groups) $user_groups = array();
  if (@in_array("guest", $user_groups)) {
     $create_folder = 'n';
	 $user_type = 'visitor';
  }
  $user_groups = implode(";;",$user_groups);

  if($INFO['isadmin'] || $INFO['ismanager']) {    
     $client = "";
  }
 
  $ver_anteater = mktime(0,0,0,11,7,2010); 
  $dwiki_version=mktime(0,0,0,01,01,2008);

  if(isset($conf['fnencode'])) {
      $ver_anteater = mktime(0,0,0,11,7,2010); 
      $dwiki_version=mktime(0,0,0,11,7,2010); 
  }
  else if(function_exists('getVersionData')) {
      $verdata= getVersionData();
      if(isset($verdata) && preg_match('/(\d+)-(\d+)-(\d+)/',$verdata['date'],$ver_date)) {
          if($ver_date[1] >= 2005 && ($ver_date[3] > 0 && $ver_date[3] < 31) && ($ver_date[2] > 0 && $ver_date[2] <= 12)) { 
                                          // month        day               year
          $dwiki_version=@mktime(0,  0,  0, $ver_date[2],$ver_date[3], $ver_date[1]); 
          if(!$dwiki_version) $dwiki_version = mktime(0,0,0,01,01,2008);         
          $ver_anteater = mktime(0,0,0,11,7,2010); 
      }
    }
  }


 $default_fb = $this->getConf('default_fb');
 if($default_fb == 'none') {
     $client = "";
 }

 $doku_base = DOKU_BASE; 

    return <<<end_of_string


<script type='text/javascript'>
 //<![CDATA[

if(window.dw_locktimer) {
   var locktimer = dw_locktimer;
} 
var FCKRecovery = "";
var oldonload = window.onload;
var ourLockTimerINI = false;
var oldBeforeunload;

  var ckgedit_onload = function() { $js };
  
      jQuery(window).bind('load',{},ckgedit_onload);
  
 function ckgeditEditorTextChanged() {
   window.textChanged = false;   
   oldBeforeunload(); 
   if(window.dwfckTextChanged) {        
      return LANG.notsavedyet;
   }  
 }

  function getCurrentWikiNS() {
        var DWikiMediaManagerCommand_ns = '$media_tmp_ns';
        return DWikiMediaManagerCommand_ns;
  }
 
 var ourLockTimerRefreshID;
 var ourLockTimerIsSet = true;
 var ourLockTimerWarningtimerID;
 var ourFCKEditorNode = null;
 var ourLockTimerIntervalID;
 var dwfckTextChanged = false;

   /**
    *    event handler
    *    handles both mousepresses and keystrokes from FCKeditor window
    *    assigned in fckeditor.html
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
                    data = data.replace(/auto/,"")  + ' by ckgeditLite';
                    locktimer.response = data; 
                    locktimer.refreshed(data);
                },
                'html'
            );
       }
        
 }


 /**
   Legacy function has no current use
 */
 function getRecoveredText() {
    return FCKRecovery;
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
       
        var params = "rsave_id=$meta_fn";
        params += '&wikitext='+encodeURIComponent(dwform.elements.fck_wikitext.value);      
        jQuery.post(
                DOKU_BASE + 'lib/plugins/ckgedit/scripts/refresh_save.php',
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


function revert_to_prev() {
  if(!(GetE('saved_wiki_html').innerHTML.length)) {
            if(!confirm(backup_empty)) {
                           return;
            }
  }
  CKEDITOR.instances.wiki__text.setData( GetE('saved_wiki_html').innerHTML);
   
}


function draft_delete() {

        var debug = false;
        var params = "draft_id=$cname";
        jQuery.ajax({
           url: DOKU_BASE + 'lib/plugins/ckgedit/scripts/draft_delete.php',
           async: false,
           data: params,    
           type: 'POST',
           dataType: 'html',         
           success: function(data){                 
               if(debug) {            
                  alert(data);
               }
              
    }
    });

}

function disableDokuWikiLockTimer() {
  resetDokuWikiLockTimer(false);
  if(ourLockTimerIntervalID) {
     window.clearInterval(ourLockTimerIntervalID);
  }
  if(ourLockTimerIsSet) { 
    ourLockTimerIntervalID = window.setInterval(function () { locktimer.refresh(); }, 30000);   
  }
}

function dwfckKeypressInstallHandler() {
  if(window.addEventListener){    
      oDokuWiki_FCKEditorInstance.EditorDocument.addEventListener('keyup', handlekeypress , false) ;
  }
  else {   
     oDokuWiki_FCKEditorInstance.EditorDocument.attachEvent('onkeyup', handlekeypress ) ;
  }
}

var DWFCK_EditorWinObj;
function FCKEditorWindowObj(w) { 
  DWFCK_EditorWinObj = w;
}

function ckgedit_isRTL() { 
var direction = "$ckgedit_lang_direction";

return direction == 'rtl';
  
}

function remove_styling() {
//'TextColor,BGColor, FontAssist,Font,FontSize';
var opts = "";
var color_opts = parseInt( "$color_opts");
var font_opts =  parseInt("$font_opts");
if(color_opts) {
  opts ='TextColor,BGColor, FontAssist';
}
if(font_opts) {
  if(color_opts) opts+=',';
  opts +='Font,FontSize';
}
if("$toolbar_opts") {
  if(opts) opts+=',';
  opts+="$toolbar_opts";
}

return opts;

}


function ckgedit_language_chk(config) { 
    if("$scayt_auto" == 'on') {
        config.scayt_autoStartup = true;      
    }
    else config.scayt_autoStartup = false;
    config.scayt_sLang="$scayt_lang";  
   var lang = "$interface_lang"; 
   if(lang ==  'default') return; ;
   config.language = lang;
}

var oDokuWiki_FCKEditorInstance;
function FCKeditor_OnComplete( editorInstance )
{

  oDokuWiki_FCKEditorInstance = editorInstance;
  editorInstance.on( 'key', handlekeypress, editorInstance );
  oDokuWiki_FCKEditorInstance.dwiki_user = "$user_type";   
  oDokuWiki_FCKEditorInstance.dwiki_client = "$client";    
  oDokuWiki_FCKEditorInstance.dwiki_usergroups = "$user_groups";  
  oDokuWiki_FCKEditorInstance.dwiki_doku_base = "$doku_base";  
  oDokuWiki_FCKEditorInstance.dwiki_create_folder = "$create_folder"; 
  oDokuWiki_FCKEditorInstance.dwiki_fnencode = "$fnencode"; 
  oDokuWiki_FCKEditorInstance.dwiki_version = $dwiki_version; 
  oDokuWiki_FCKEditorInstance.dwiki_anteater = $ver_anteater; 
  oDokuWiki_FCKEditorInstance.isLocalDwikiBrowser = false;
  oDokuWiki_FCKEditorInstance.isUrlExtern = false; 
  oDokuWiki_FCKEditorInstance.isDwikiMediaFile = false; 
  oDokuWiki_FCKEditorInstance.imageUploadAllowedExtensions="$ImageUploadAllowedExtensions";
  oDokuWiki_FCKEditorInstance.fckgUserName = "$user_name";
  oDokuWiki_FCKEditorInstance.fckgUserMail="$user_email"; 
  oDokuWiki_FCKEditorInstance.useheading = "$useheading"; 
  
 
  var index = navigator.userAgent.indexOf('Safari'); 
  if(index == -1  || (navigator.userAgent.indexOf('Chrome'))) {
    oldBeforeunload = window.onbeforeunload;
    window.onbeforeunload = ckgeditEditorTextChanged;
  }
 
  
}

   
 var DWikifnEncode = "$fnencode";

/* Make sure that show buttons in top and/or bottom clear the fckl file */  
 function get_showButtons() {	
	var inputs = document.getElementsByTagName('input');
    
     for(var i=0; i<inputs.length; i++) {	    
        if(inputs[i].type && inputs[i].type.match(/submit/i)) {		           		    
			if(inputs[i].value.match(/Show/i) || (inputs[i].form &&  inputs[i].form.className.match(/btn_show/) ) )
    			inputs[i].onmouseup = draft_delete;
        }
     }
  }

 /* make sure the entire page has been loaded */
 setTimeout("get_showButtons()", 3000);
 //]]>
 
</script>
end_of_string;
  }
}
?>
