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
  
  function has_plugin($plugin) {    
      $plugins_list = plugin_list();               
      return in_array($plugin, $plugins_list);
  }
  
     /** 
    * function dw_edit_displayed
    * @author  Myron Turner
    * determines whether or not to show  or hide the
    *  'DW Edit' button
   */

   function dw_edit_displayed() 
   { 
        global $INFO;

        $dw_edit_display = @$this->getConf('dw_edit_display');
        if(!isset($dw_edit_display))return "";  //version 0. 
        if($dw_edit_display != 'all') {
            $admin_exclusion = false;
            if($dw_edit_display == 'admin' && ($INFO['isadmin'] || $INFO['ismanager']) ) {    
                    $admin_exclusion = true;
            }
            if($dw_edit_display == 'none' || $admin_exclusion === false) {
              return ' style = "display:none"; ';
            }
           return "";
        }
        return "";
      
   }

  function registerOnLoad($js){
  global $ID;
  global $lang;
  global $skip_styling;
  global $JSINFO;

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

  if($useheading && $useheading != 'navigation') {
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
 $mfiles =   $this->getConf('mfiles');
 $extra_plugins = $this->getConf('extra_plugins');
  $ckg_gui = $this->getConf('gui');
  if(!isset($INFO['userinfo']) && !$open_upload) {
    $user_type = 'visitor';
  }
  else {
   $user_type = 'user';
  }
  $save_dir = DOKU_BASE . ltrim($conf['savedir'],'/.\/');
  $fbsz_increment = isset($_COOKIE['fbsz']) && $_COOKIE['fbsz'] ? $_COOKIE['fbsz'] : '0';
  $use_pastebase64 = (isset($_COOKIE['ckgEdPaste']) && $_COOKIE['ckgEdPaste'] == 'on' )  ? 'on' : 'off';
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
  $user_groups = str_replace('"','\"',implode(";;",$user_groups));

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

$ckg_brokenimg = $this->getLang('broken_image');
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

var ckgedit_onload = function() { $js };
window.onload =  ckgedit_onload;

  function getCurrentWikiNS() {
        var DWikiMediaManagerCommand_ns = '$media_tmp_ns';
        return DWikiMediaManagerCommand_ns;
  }
 
 var ourFCKEditorNode = null;

function revert_to_prev() {
  if(!(GetE('saved_wiki_html').innerHTML.length)) {
            if(!confirm(backup_empty)) {
                           return;
            }
  }
  CKEDITOR.instances.wiki__text.setData( GetE('saved_wiki_html').innerHTML);
   window.dwfckTextChanged = true;
}


function draft_delete() {

        var debug = false;
        var params = "draft_id=$cname";
        jQuery.ajax({
           url: DOKU_BASE + 'lib/plugins/ckgedit/scripts/draft_delete.php',
           data: params,    
           type: 'POST',
           dataType: 'html',         
           success: function(data){                 
               if(debug) {            
                  alert(data);
               }
              
    }
    });

    window.textChanged = false;
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
var skip_styling=parseInt("$skip_styling");
if(color_opts) {
  opts ='TextColor,BGColor,FontAssist';
}
else if(!skip_styling) {
     opts = 'FontAssist';
}
if(font_opts) {
  if(color_opts || !skip_styling) opts+=',';
  opts +='Font,FontSize';
}
if("$toolbar_opts") {
  if(opts) opts+=',';
  opts+="$toolbar_opts";
}

return opts;

}

function  extra_plugins(config) {  
    if("$use_pastebase64" == 'on')  config.addPaste();    
    return "$extra_plugins";
}

function ckgedit_language_chk(config) { 
    if("$scayt_auto" == 'on') {
        config.scayt_autoStartup = true;         
    }
    else config.scayt_autoStartup = false;
    if("$scayt_auto" == 'disable') {
        config.scayt__disable = true;
    }   
    config.scayt_sLang="$scayt_lang";  
   var lang = "$interface_lang"; 
   if(lang ==  'default') return; ;
   config.language = lang;
}

function getCKEditorGUI() {
    return "$ckg_gui";
}
var oDokuWiki_FCKEditorInstance;
function FCKeditor_OnComplete( editorInstance )
{

  oDokuWiki_FCKEditorInstance = editorInstance;
  editorInstance.on( 'key', handlekeypress, editorInstance );

  CKEDITOR.instances.wiki__text.on('change', function(event) {
        window.dwfckTextChanged = true;
        window.textChanged = true;
  });

  editorInstance.on("focus", function(e) {
          window.dwfckTextChanged = true;
    });
 
   var broken_image ='http://' +  location.host +  DOKU_BASE +  '/lib/plugins/ckgedit/fckeditor/userfiles/blink.jpg?nolink&33x34';
   editorInstance.on("paste", function(e) {      
   //   https://stackoverflow.com/questions/15900485/correct-way-to-convert-size-in-bytes-to-kb-mb-gb-in-javascript       
        var formatBytes = function(bytes,decimals) {
             if(bytes == 0) return '0 Bytes';
             var k = 1024,
             dm = decimals <= 0 ? 0 : decimals || 2,
             sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'],
             i = Math.floor(Math.log(bytes) / Math.log(k));
             return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
        }
         var len =  e.data.dataValue.length;
         var len = e.data.dataValue.length - 'data:image/png;base64,'.length;
         var size =   formatBytes(len,1);     
          var broken_msg = ckg_RawImgMsg();
          broken_msg += " " + size;
         if(e.data.dataValue.match(/data:image\/\w+;base64/) &&  len > 2500000) {
             alert(broken_msg);
             e.data.dataValue = '<img src ='+ broken_image + '/>';       
        }
    });

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
  oDokuWiki_FCKEditorInstance.mfiles = parseInt("$mfiles");
  oDokuWiki_FCKEditorInstance.fbsz_increment=parseInt("$fbsz_increment");

}


 window.DWikifnEncode = "$fnencode";

 //]]>
 
</script>
end_of_string;
  }
}
?>
