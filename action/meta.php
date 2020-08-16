<?php
/**
 *
 */
 
if(!defined('DOKU_INC')) die();
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
define('FCK_ACTION_SUBDIR',  DOKU_PLUGIN . 'ckgedit/action/');
require_once(DOKU_PLUGIN.'action.php');
require_once(DOKU_PLUGIN.'ckgedit/scripts/setsamesite.php');
 
class action_plugin_ckgedit_meta extends DokuWiki_Action_Plugin {
  var $session_id = false;    
  var $draft_file;
  var $user_rewrite = false;
  var $helper;
  var $dokuwiki_priority;
  var $profile_dwpriority;
  var $wiki_text;  
  var $dw_priority_group;
  var $dw_priority_metafn;
  var $captcha = false;
  var $geshi_dir;
  function __construct() {
  global $conf;
 
      $this->helper = plugin_load('helper', 'ckgedit');
      $this->dokuwiki_priority =  false;
      $this->dw_priority_group =  "NOT_SET";
      $this->dw_priority_metafn=metaFN(':ckgedit:dw_priority', '.ser');
      if(!file_exists($this->dw_priority_metafn)) {
          io_saveFile($this->dw_priority_metafn, serialize(array()));
      }
       
  }
  /*
   * Register its handlers with the dokuwiki's event controller
   */
  function register(Doku_Event_Handler $controller) {            

            if($this->helper->is_outOfScope()) return;
            $controller->register_hook( 'TPL_METAHEADER_OUTPUT', 'AFTER', $this, 'loadScript');    
            $controller->register_hook( 'HTML_EDITFORM_INJECTION', 'AFTER', $this, 'preprocess'); 
            $controller->register_hook( 'HTML_EDITFORM_OUTPUT', 'BEFORE', $this, 'insertFormElement');            
            $controller->register_hook('DOKUWIKI_STARTED', 'BEFORE', $this, 'file_type');         
            $controller->register_hook('TPL_CONTENT_DISPLAY', 'AFTER', $this, 'setupDWEdit');       
            $controller->register_hook('DOKUWIKI_STARTED', 'AFTER', $this, 'reset_user_rewrite_check');                 
            $controller->register_hook('DOKUWIKI_DONE', 'BEFORE', $this, 'restore_conf');   
            $controller->register_hook('AJAX_CALL_UNKNOWN', 'BEFORE', $this,'_ajax_call');                          
            //$controller->register_hook('HTML_UPDATEPROFILEFORM_OUTPUT', 'BEFORE', $this, 'handle_profile_form');            
            $controller->register_hook('ACTION_SHOW_REDIRECT', 'BEFORE', $this, 'handle_redirect');            
              }

    function handle_redirect(Doku_Event $event, $param) {
        global $INPUT;
        $ckg_redirect = $INPUT->str('ckgedit_redirect',"");
        if($ckg_redirect) $event->data['id'] = $ckg_redirect;
        //msg($ckg_redirect);
  }

  function handle_profile_form(Doku_Event $event, $param) {
         if(!$this->getConf('dw_priority')) { return;	}
          global $INFO;
            $client =   $_SERVER['REMOTE_USER']; //$INFO['client'];
            $ar = unserialize(file_get_contents($this->dw_priority_metafn));
            $which = $ar[$client];
            $dwed = ""; $cked = "";
            if($which == 'N') {
                $cked = "checked";                
            }
            else if($which ==  'Y') {
                $dwed = "checked";
            }

            $pos = $event->data->findElementByAttribute('type', 'reset');
            $_form = '</div></form><br /><form name="ckgeditform" action="#"><div class="no">';
            $_form.= '<fieldset ><legend>' . $this->getLang('uprofile_title') .'</legend>';
            
            $_form.= '<label><span><b>DW Editor</b></span> ';
            $_form .='<input type="radio" value = "Y" name="cked_selector" ' . $dwed .'></label>&nbsp;'; 
            $_form .='<label><span><b>CK Editor</b></span> ';
            $_form .='<input type="radio"  value = "N" name="cked_selector" ' . $cked . '></label>'; 
            
            $_form.= '<br /><label><span><b>User Name: </b></span> ';
            $_form.= '<input type="textbox" name="cked_client" disabled value="' .  $client .'"/></label>';
            $_form.= '<br /><br /><input type="button" value="Save" class="button" ' . "onclick='ckgedit_seteditor_priority(this.form.cked_selector.value,this.form.cked_client.value,this.form.cked_selector);' />&nbsp;";
            $_form.= '<input type="reset" value="Reset" class="button" />';
           $_form.= '</fieldset>';           
            $event->data->insertElement($pos+2, $_form);
  }
 
function _ajax_call(Doku_Event $event, $param) { 
     
     if ($event->data == 'cked_scaytchk') {  
          global $lang,$INPUT;
          $event->stopPropagation();
          $event->preventDefault();
		  $filename =  metaFN('fckl:scayt','.meta'); 
		  $msg =  $this->locale_xhtml('scayt');
		  if (!file_exists($filename)) {      
			  io_saveFile($filename,'1');  
              echo "$msg\n";			  
			  return;
		  }		   
           
           
           return;           
         }
       if ($event->data == 'cked_upload') {  
          global $lang;
           $event->stopPropagation();
          $event->preventDefault();
           global $INPUT;
           $id = urldecode($INPUT->str('ckedupl_id'));
           $id = str_replace('/', ':',$id);         
           $this->ajax_debug($id);
          $fn = mediaFN($id);
          $this->ajax_debug($fn);
          $delete = $INPUT->str('ckedupl_del');
           if(file_exists($fn)) {
              $size =  filesize($fn);               
              $this->ajax_debug("$fn:  $size");               
           }           
          else $this->ajax_debug("$fn not found");
          
          if($delete && $delete == 'D') {           
               $size = ""; $ft = ""; 
               $oldf  = $id;
              $size_tm =  $INPUT->str('delsize');         
               $this->ajax_debug('size_tm='.$size_tm);             
              if($size_tm != 'undefined' && isset($size_tm))   {                  
                  list($size,$ft) = explode(';',$size_tm);
                  $size=trim($size);
                  $ft=trim($ft);
                  $size =  '-' . $size;
              }
              else if(file_exists($fn)) {
                  if(!$size) {
                      $size = filesize($fn);               
                   $size =  '-' . $size;
                  }
                  if(!$ft) {                   
                   $ft=filemtime($fn) ;
              }
              }
              else {
                  $this->ajax_debug("$fn not found");
                  return;
              }
              if(isset($ft) && file_exists($fn)) {                
                $newf = mediaFN($id,$ft);
                $this->ajax_debug("newf:  $newf fn:  $fn");                                
                 if(file_exists($fn)){
                    $this->ajax_debug("old file: $oldf; $fn");               
               }
                 else  $this->ajax_debug("no old file: $fn");                 
                 
                 io_makeFileDir($newf);
                 if(copy($fn, $newf)) {
                    $this->ajax_debug("Copying $fn  to $newf");
                    chmod($newf, $conf['fmode']);
                   $this->ajax_debug("deleting: $fn");
                    if(!unlink($fn)) $this->ajax_debug("delete failed");
                }         
                 else $this->ajax_debug("copy failed");                
             }
              if(file_exists($fn)) {
                  if(!copy($fn, $newf)) { 
                     $this->ajax_debug ("(2nd try) could not copy $fn to $newf"); 
                     return; 
                     }
                  if(!unlink($fn))  { 
                     $this->ajax_debug ("could not delete $fn"); 
                     return; 
                  }
              }
              addMediaLogEntry($ft, $id, DOKU_CHANGE_TYPE_DELETE, $lang['deleted'],'', null, $size);            
          }
          else addMediaLogEntry(time(), $id, DOKU_CHANGE_TYPE_CREATE, $lang['created'],'', null, $size);
          echo 'done';
          return;
      }
      //cked_deletedsize
      if ($event->data == 'cked_deletedsize') {  
          $event->stopPropagation();
          $event->preventDefault();
           global $INPUT;
           $id = urldecode($INPUT->str('cked_delid'));
           $fn = mediaFN($id);
           if(file_exists($fn)) {
            $this->ajax_debug(filesize ($fn) . ';' .filemtime($fn) );
           }
           else echo ("$fn not found");
          return;
      }
      if ($event->data == 'use_heads') {  
         $event->stopPropagation();
          $event->preventDefault();
          global $INPUT;
          $page = $INPUT->str('dw_id');  
          $page = urldecode($page);
          $page = ltrim($page, ':');
         $t= trim(p_get_first_heading($page));
         echo $t;
         return;
     }
     if ($event->data == 'wrap_lang') {  // parse and return language file to ckeditor wrap plugin
         $event->stopPropagation();
          $event->preventDefault();
         global $INPUT;
         $which = $INPUT->str('lang');
         $path = DOKU_PLUGIN . 'wrap/lang/' . $which . '/lang.php';
         if(file_exists($path)) {   
                $data = file($path, FILE_IGNORE_NEW_LINES|FILE_SKIP_EMPTY_LINES );
                array_shift($data);
         }
		 else {
			 $data = array();
		 }		 
        $result = array();
        for($i=0; $i<count($data); $i++) {      
              list($name, $val) = explode('=',$data[$i]);
              $name = str_replace('$lang',"",$name);   
              $name = trim($name,' ][\'');
              if($name == 'picker') $name ='title';   
             $val = trim($val,' ;\'');              
              $result[$name] = $val;    
        }
         echo json_encode($result);
         return;
       }

     if ($event->data == 'cked_selector') {  //choose profile editor priority
         $event->stopPropagation();
         $event->preventDefault();
        global $INPUT, $USERINFO,$INFO;
        if(!isset($USERINFO)) return;

        $ar = unserialize(file_get_contents($this->dw_priority_metafn));
        $dwp = $INPUT->str('dw_val');
        $client = $INPUT->str('dwp_client');
         $ar[$client] = $dwp;
         $retv = file_put_contents($this->dw_priority_metafn,serialize($ar));  
         if($retv === false) {
             echo $this->dw_priority_metafn;            
         }
         else echo "done";
         return;
    }


   if ($event->data == 'geshi_sel') {     //get geshi file names , return as ;; separated string w/o php extensions
      $event->stopPropagation();
       $event->preventDefault();
  
       if( class_exists('GeSHi')) {         
            if(defined('GESHI_LANG_ROOT') )  $geshi_dir =GESHI_LANG_ROOT;
      }
     else {
         echo "ENotfound\n";
         return ;
     }  
    $gfiles = scandir ($geshi_dir);
    $selects = array();
    foreach($gfiles as $gfile){
        if(is_dir($gfile)) continue;
       $gfile =  preg_replace("/\.php\n?$/","",$gfile);
        $selects[] = $gfile;
    }
    $selects = implode ( ';;', $selects );
    echo $selects;
    return;
    }    
    
    if ($event->data !== 'refresh_save') {  // save ckgedit backups in native dw format
        return;
    }
       
    $event->stopPropagation();
    $event->preventDefault();
     global  $INPUT;
    
       
       $rsave_id = urldecode($INPUT->str('rsave_id'));
       $path = pathinfo($rsave_id);
       if($path['extension'] != 'ckgedit') {
             echo "failed";
             return;
        }  
      
       $this->wiki_text = urldecode($INPUT->str('wikitext'));
             
        if(!preg_match('/^\s+(\-|\*)/',$this->wiki_text)){     
              $this->wiki_text = trim($this->wiki_text);
        }
 
          /* preserve newlines in code blocks */
          $this->wiki_text = preg_replace_callback(
            '/(<code>|<file>)(.*?)(<\/code>|<\/file>)/ms',
            create_function(
                '$matches',         
                'return  str_replace("\n", "__code_NL__",$matches[0]);'
            ),
            $this->wiki_text
          );

        $this->wiki_text = preg_replace('/^\s*[\r\n]$/ms',"__n__", $this->wiki_text);
        $this->wiki_text = preg_replace('/\r/ms',"", $this->wiki_text);
        $this->wiki_text = preg_replace('/^\s+(?=\^|\|)/ms',"", $this->wiki_text);    
        $this->wiki_text = preg_replace('/__n__/',"\n", $this->wiki_text);
        $this->wiki_text = str_replace("__code_NL__","\n", $this->wiki_text);

 
       $this->wiki_text .= "\n";
         

        $pos = strpos($this->wiki_text, 'MULTI_PLUGIN_OPEN');
        if($pos !== false) {
           $this->wiki_text = preg_replace_callback(
            '|MULTI_PLUGIN_OPEN.*?MULTI_PLUGIN_CLOSE|ms',
            create_function(
                '$matches',         
                  'return  preg_replace("/\\\\\\\\/ms","\n",$matches[0]);'
            ),
            $this->wiki_text
          );

           $this->wiki_text = preg_replace_callback(
            '|MULTI_PLUGIN_OPEN.*?MULTI_PLUGIN_CLOSE|ms',
            create_function(
                '$matches',         
                  'return  preg_replace("/^\s+/ms","",$matches[0]);'
            ),
            $this->wiki_text
          );

        }

     $this->replace_entities();
     $this->wiki_text = preg_replace('/\<\?php/i', '&lt;?php',$this->wiki_text) ;
     $this->wiki_text = preg_replace('/\?>/i', '?&gt;',$this->wiki_text) ;
     file_put_contents($rsave_id, $this->wiki_text);
     echo 'done';

}

function replace_entities() {
    global $ents;
    $serialized = FCK_ACTION_SUBDIR . 'ent.ser';
    $ents = unserialize(file_get_contents($serialized));

       $this->wiki_text = preg_replace_callback(
            '|(&(\w+);)|',
            create_function(         
                '$matches',
                'global $ents; return $ents[$matches[2]];'
            ),
            $this->wiki_text
        );
    
}

 function  insertFormElement(Doku_Event $event, $param) {	 
   global $FCKG_show_preview;  

  $param = array();

   global $ID;
   $dwedit_ns = @$this->getConf('dwedit_ns');
   if(isset($dwedit_ns) && $dwedit_ns) {
       $ns_choices = explode(',',$dwedit_ns);
       foreach($ns_choices as $ns) {
         $ns = trim($ns);
         if(preg_match("/$ns/",$ID)) {
            echo "<style type = 'text/css'>#edbtn__preview,#edbtn__save, #edbtn__save { display: inline; } </style>";         
            break;
         }
       }
   }
   $act = $event->data;
   if(is_string($act) && $act != 'edit') {  
        return;
   }

  // restore preview button if standard DW editor is in place
  // $FCKG_show_preview is set in edit.php in the register() function
if($_REQUEST['fck_preview_mode'] != 'nil' && !isset($_COOKIE['FCKG_USE']) && !$FCKG_show_preview) {    
     echo '<style type="text/css">#edbtn__preview { display:none; }</style>';
 }
 elseif($FCKG_show_preview) {
      echo '<style type="text/css">#edbtn__preview { display: inline; } </style>';
 }
 else {
    echo '<style type="text/css">#edbtn__preview, .btn_show { position:absolute; visibility:hidden; }</style>';
 }
  
 global $ckgedit_lang;

  if($_REQUEST['fck_preview_mode']== 'preview'){
    return;
  }

 $param = array();
 $this->preprocess($event, $param);  // create the setDWEditCookie() js function
 $button = array
        (
            '_elem' => 'button',
            'type' => 'submit',
            '_action' => 'cancel',
            'value' => $this->getLang('btn_fck_edit'),
            'class' => 'button',
            'id' => 'edbtn__edit',            
            'title' => $this->getLang('btn_fck_edit')             
        );

     $pos = strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE');
     if($pos === false) {
                 $button['onclick'] = 'return setDWEditCookie(1, this);';
     }
     else {
                $button['onmousedown'] = 'return setDWEditCookie(1, this);';
     }

    $pos = $event->data->findElementByAttribute('type','submit');
       //inserts HTML data after that position.
    $event->data->insertElement(++$pos,$button);

   return;
 
  }


 function preprocess(Doku_Event $event, $param) {	 
    $act = $event->data;
 
   if(is_string($act) && $act != 'edit') {  
        return;
   }
  global $INFO, $ckgedit_lang;
    
  $discard = $this->getLang('discard_edits');   
  echo "<script type='text/javascript'>\n//<![CDATA[ \n";
  echo "var useDW_Editor =   $this->profile_dwpriority;"; 
  echo "\n //]]> </script>\n";
  echo <<<SCRIPT
    <script type="text/javascript">
    //<![CDATA[ 
    var ckgedit_dwedit_reject = false;
    var ckgedit_to_dwedit = false;
    function setDWEditCookie(which, e) { 
      
        var dom = document.getElementById('ckgedit_mode_type');                
          
         if(useDW_Editor) {
                document.cookie = 'FCKG_USE=other;expires=0;path=/;SameSite=Lax';             
              }  
             else {
                document.cookie='FCKG_USE=other;expires=Thu,01-Jan-70 00:00:01 GMT;path=/;SameSite=Lax'
           }
        if(which == 1) {             
           if(e && e.form) {
                    if(e.form['mode']) {
                       e.form['mode'].value = 'fck';
                    }
                    else {
                       e.form['mode'] = new Object;
                       e.form['mode'].value = 'fck';  
                    }
           }
           else dom.value = 'fck';  
           e.form.submit(); 
       }
        else {            
            document.cookie = 'FCKG_USE=_false_;expires=0;path=/;SameSite=Lax';             
            dom.value = 'dwiki';    
           if(JSINFO['chrome_version'] >= 56 && window.dwfckTextChanged) {
           }
            else if(window.dwfckTextChanged  && !window.confirm("$discard")) {            
               var dom = GetE('dwsave_select');                
               ckgedit_dwedit_reject=true;
               window.dwfckTextChanged = false;
        }
       }
        
    }
  
 
    //]]> 

    </script>
SCRIPT;

  }

function check_userfiles() {	  

    global $INFO;
    global $conf;
    
    $save_dir = trim($conf['savedir']);  
    $animal = isset($conf['animal']) ? $conf['animal'] : 'userfiles';
    
   $userfiles = DOKU_PLUGIN . "ckgedit/fckeditor/$animal/";
    if(isset($conf['animal']) && $conf['animal'] !== 'userfiles') {
        setcookieSameSite('FCK_animal',$animal, $expire, '/');     
		setcookieSameSite('FCK_animal_inc',$conf['animal_inc'], $expire, '/');     
        preg_match('#^(.*?' . $conf['animal'] . ')#', $save_dir,$matches);
        $save_dir=$matches[1] . '/data/pages';
        setcookieSameSite('FCK_farmlocal',$save_dir, $expire, '/');     
    
        return;
    }
// msg('BASE='. DOKU_BASE);
// msg(DOKU_URL);
// msg('REL='. DOKU_REL);
    if(!preg_match('#^\.\/data$#',$save_dir)) {
        $data_media = $conf['savedir']  . '/media/';
        
        $domain = trim(DOKU_BASE,'/');    
        
        $expire = null;        
  
        if(! empty($domain )) {
        list($prefix,$mdir) = explode(trim(DOKU_BASE, '/'),$userfiles);
           $mdir = ltrim($mdir, '/');
        $media_dir = DOKU_BASE . $mdir . 'image/';
        }
        else $media_dir = '/lib/plugins/ckgedit/fckeditor/'. $animal . '/image/';        
        setcookieSameSite('FCK_media',$media_dir, $expire, '/');           

     }
     else {
         $data_media = DOKU_INC.'data/media/';
     }
     
     if($this->getConf('winstyle'))  {    
         $htaccess = $data_media . '.htaccess';
          if(!file_exists($htaccess)) {               
               $security = $userfiles . '.htaccess.security';
               if(file_exists($security)) {                   
                   if(!copy($security, $htaccess)) {
                       msg($this->getLang("ws_cantcopy") . $htaccess);  
                   }
                   else msg($this->getLang("ws_copiedhtaccess"));    
               }
          } 
         return;    
     }
     if(!is_readable($userfiles) && !is_writable($userfiles)){
              msg($this->getLang("userfiles_perm" ) . ' ' . $userfiles) ;
		      return;
     }		   
	$version = io_readFile(DOKU_PLUGIN . 'ckgedit/version');
	if(!$version) return;
    $meta = metaFN('fckl:symchk','.meta'); 
	$symcheck = io_readFile($meta);	    
    if($symcheck) {
	   if(trim($version)== trim($symcheck)) {  //symlinks should already have been created	 
		  return;
	   }
    }
				
	if (function_exists('php_uname')) {
	   $sys = php_uname() ;
	   if( preg_match('/Windows/i',  $sys) ) {
		     preg_match('/build\s+(\d+)/',$sys, $matches);	  
		    if($matches[1]  < 6000) {  // we can make symlinks for vista (6000) or later 
			   return;
		   }		
		 
		   $winlinks =  array();
		   $userfiles = str_replace('/', '\\',$userfiles);		   
		   exec("dir " . $userfiles, $output);
		   foreach($output as $line) {
		      if(preg_match('/<SYMLINKD>\s+(.*?)\s+\[/i',$line,$matches)) {
			     $winlinks[] = $matches[1];
			  }
		   }
		}
		
    }  
	else if( preg_match('/WINNT/i',  PHP_OS) ) {    // if we can't get php_uname and a build and this is Windows, just return
         return;
    }
	
       $show_msg = false;
	   if($INFO['isadmin'] || $INFO['ismanager'] )    {  // only admins and mgrs get messages
	       $show_msg = true;		   
	   }
	   $link_names = array('flash',  'image',  'media', 'file', 'image');
	   if(is_array($winlinks) && count($winlinks)) {
	       $link_names = array_diff($link_names, $winlinks);
	   }
	   $links = array();
	   foreach ($link_names as $ln) {
	        $links[$ln] = $userfiles . $ln;
	   }

      $bad_create = false; 
	  $successes =  array();
	  if(@file_exists($userfiles)) {
		   foreach($links as $name => $path) {		
			  if(!is_link($path)) {		                      
                     if(file_exists($path) && is_file($path) ){
					       unlink($path);
                       }					 
                    if(file_exists($path) && is_dir($path) ){
					       rmdir($path);
                       }					 
					 if(!@symlink($data_media,$path) ) {
					     $bad_create = true;
						  if($show_msg)   msg($this->getLang("sym_not created_1") . " $name link:  $path",-1);		
				   }
				   else {
				     $successes[] = $name; 
				   }
			 }	   	   
		  }
      }
	  else {
	     if($show_msg)  {
	        msg($this->getLang("sym_not created_2") ." $userfiles",-1);
		 }
	  }
	   
	 
	   
	  if($bad_create) {
	       if($show_msg)  {
		       msg($this->getLang("sym_not created_3") . " $userfiles"); 
				}
      }
	  else {	        
	       if(count($successes)) {
				$links_created = implode(', ',$successes);
				 msg($this->getLang("syms_created") . " $links_created",2);   
			 }
	  }
	  			io_saveFile($meta,$version);
                chmod($meta, 0666);
}
            
  
  function set_session() {	
      global $USERINFO, $INFO; 
      global $conf; 
      global $ID;
      global $ACT;

      if($this->session_id) return;       

           $cname = getCacheName($INFO['client'].$ID,'.draft');  
           $fckl_draft = $cname . '.fckl';
           if((isset($ACT) && is_array($ACT)) || isset($_REQUEST['dwedit_preview'])) {
              if(isset($ACT['draftdel']) || isset($ACT['cancel']) || isset($_REQUEST['dwedit_preview'])) {
                 @unlink($fckl_draft);   
                 @unlink($cname); 
              }
           }

           if(file_exists($cname)) {
              if(file_exists($fckl_draft)) {
                    unlink($fckl_draft);
              }
              @rename($cname, $fckl_draft);
           }

          
           $session_string =  session_id(); 
           $this->session_id = $session_string;      
       

           $_SESSION['dwfck_id'] = $session_string; 
           $default_fb = $this->getConf('default_fb');

           if($default_fb == 'none') {
               $acl = 255; 
           }
           else {
              $acl = auth_quickaclcheck($ID); 
           }
           $_SESSION['dwfck_acl'] = $acl; 

           if($this->getConf('openfb') || $acl == 255) {
             $_SESSION['dwfck_openfb'] = 'y';
           }
           else { 
              $_SESSION['dwfck_openfb'] = 'n';
           }

           $_SESSION['dwfck_grps'] = isset($USERINFO['grps']) ? $USERINFO['grps'] : array();     
           $_SESSION['dwfck_client'] = $INFO['client'];   
           $_SESSION['dwfck_sepchar'] = $conf['sepchar'] ;   
           $_SESSION['dwfck_conf'] = array('sepchar'=> $conf['sepchar'],
                  'isadmin'=>($INFO['isadmin'] || $INFO['ismanager']), 
                  'deaccent'=>$conf['deaccent'], 'useslash'=>$conf['useslash']);
           $elems = explode(':', $ID);  
           array_pop($elems);
 
           $_SESSION['dwfck_ns'] = implode(':',$elems);        
           $_SESSION['dwfck_top'] = implode('/',$elems);           
           $_SESSION['dwfck_del'] = $this->getConf('acl_del');
           
            // temp fix for puzzling encoding=url bug in frmresourceslist.html,
           // where image loading is processed in GetFileRowHtml()

           if(preg_match('/ckgedit:fckeditor:userfiles:image/',$ID)) {
                      $_SESSION['dwfck_ns'] = "";        
                      $_SESSION['dwfck_top'] = "";      

            }

           $expire = time()+60*60*24*30;
          // $expire = null;
           setcookieSameSite('FCK_NmSp_acl',$session_string, $expire, '/');           

           setcookieSameSite('FCK_SCAYT',$this->getConf('scayt'), $expire, '/');                
           setcookieSameSite('FCK_SCAYT_AUTO',$this->getConf('scayt_auto'), $expire, '/'); 
           $scayt_lang = $this->getConf('scayt_lang');
           if(isset($scayt_lang)) {
               list($scayt_lang_title,$scayt_lang_code) = explode('/',$scayt_lang);
               if($scayt_lang_code!="en_US") {
                  setcookieSameSite('FCK_SCAYT_LANG',$scayt_lang_code, $expire, '/'); 
               }
           }
           if ($this->getConf('winstyle')) {
              setcookieSameSite('FCKConnector','WIN', $expire, DOKU_BASE);                                
           }
          
           if ($this->dokuwiki_priority && $this->in_dwpriority_group() ) {
               if(isset($_COOKIE['FCKG_USE']) && $_COOKIE['FCKG_USE'] == 'other') {           //if other go to ckeditor                   
                   $expire = time() -60*60*24*30;
                   setcookieSameSite('FCKG_USE','_false_', $expire, '/');           
               }
               else {            
                   setcookieSameSite('FCKG_USE','_false_', $expire, '/');                //turn off ckeditor      
                }
           }
  }

  function file_type(Doku_Event $event, $param) {	 
       global $ACT;
       global $ID; 
       global $JSINFO;
       global  $INPUT;
       global $updateVersion;
       global $conf, $USERINFO;

       if(isset($USERINFO)) {
           $this->startup_msg();
       }
       if((float)$updateVersion >= 51){  //   HOGFATHER +
    //       $conf['plugin']['ckgedit']['allow_ckg_filebrowser'] = 'dokuwiki';
    //       $conf['plugin']['ckgedit']['default_ckg_filebrowser'] = 'dokuwiki';          
       } 
      
       $auth = auth_quickaclcheck($ID);  
       $JSINFO['confirm_delete']= $this->getLang('confirm_delete');
       $JSINFO['doku_base'] = DOKU_BASE ;
       $JSINFO['cg_rev'] = $INPUT->str('rev');
       $JSINFO['dw_version']  = (float)$updateVersion;
       if(preg_match("/Chrome\/(\d+)/", $_SERVER['HTTP_USER_AGENT'],$cmatch)) {
           $JSINFO['chrome_version']  = (float) $cmatch[1];
       }
       else $JSINFO['chrome_version'] = 0;
       $JSINFO['hide_captcha_error'] = $INPUT->str('ckged_captcha_err','none');
       $dbl_click_auth  =  $this->getConf('dw_edit_display');
       if($dbl_click_auth == 'none' || empty($_SERVER['REMOTE_USER'])) {
           $JSINFO['ckg_dbl_click']  = "";
       }
       else if($dbl_click_auth == 'all' ||$auth == 255 ) {
           $JSINFO['ckg_dbl_click']  = "1";
       }
       $onoff = $this->getConf('dblclk');
       if($onoff == 'off') $JSINFO['ckg_dbl_click'] = "";
       $JSINFO['ckg_canonical'] =$conf['canonical'];
        $JSINFO['doku_base'] = DOKU_BASE;
        $JSINFO['doku_url'] = DOKU_URL;
       if($this->helper->has_plugin('tag'))  $JSINFO['has_tags'] = "Tag";
       if($this->helper->has_plugin('wrap') && ! plugin_isdisabled('wrap'))  {       
           $JSINFO['has_wrap'] = "Wrap";
        $wrap_helper =  plugin_load('helper','wrap');
           if($wrap_helper ) {            
        $syntaxDiv = $wrap_helper->getConf('syntaxDiv');
        if(!empty($syntaxDiv)) {
            $JSINFO['wrapDiv'] = $syntaxDiv;
          } 
          else $JSINFO['wrapDiv'] = "";
     
        $syntaxSpan = $wrap_helper->getConf('syntaxSpan');
        if(!empty($syntaxSpan)) {
            $JSINFO['wrapSpan'] = $syntaxSpan; 
        }
        else $JSINFO['wrapSpan'] = "";
           }
       }
        if(!isset($_COOKIE['ckgEdPaste'])) {
            $JSINFO['ckgEdPaste'] = 'off';
        }
        else {
            $JSINFO['ckgEdPaste'] = $_COOKIE['ckgEdPaste'];
        }       
        $JSINFO[ 'rel_links'] = $this->getConf('rel_links');       
        $JSINFO['ckg_template'] = $conf['template'];
	   $this->check_userfiles(); 
	   $this->profile_dwpriority=($this->dokuwiki_priority && $this->in_dwpriority_group()) ? 1 :  0; 
       if(isset($_COOKIE['FCK_NmSp'])) $this->set_session(); 
       /* set cookie to pass namespace to FCKeditor's media dialog */
      // $expire = time()+60*60*24*30;
       $expire = null;
       setcookieSameSite('FCK_NmSp',$ID, $expire, '/');     
      
          

      /* Remove TopLevel cookie */         
       if(isset($_COOKIE['TopLevel'])) {
            setcookieSameSite("TopLevel", $_REQUEST['TopLevel'], time()-3600, '/');
       }

     
       if(!isset($_REQUEST['id']) || isset($ACT['preview'])) return;
       if(isset($_REQUEST['do']) && isset($_REQUEST['do']['edit'])) {
              $_REQUEST['do'] = 'edit';
       }
  } 

function loadScript(Doku_Event $event) {
     echo <<<SCRIPT

    <script type="text/javascript">
    //<![CDATA[ 
    function LoadScript( url )
    {
     document.write( '<scr' + 'ipt type="text/javascript" src="' + url + '"><\/scr' + 'ipt>' ) ;        

    }
   function LoadScriptDefer( url )
    {
     document.write( '<scr' + 'ipt type="text/javascript" src="' + url + '" defer><\/scr' + 'ipt>' ) ;        

    }
//]]> 

 </script>
 
SCRIPT;

}

/** 
 *  Handle features need for DW Edit: 
 *    1. Re-label Cancel Button "Exit" when doing a preview  
 *    2. set up $REQUEST value to identify a preview when in DW Edit , used in 
 *       set_session to remove ckgedit and DW drafts if present after a DW preview  
*/
  function setupDWEdit(Doku_Event $event) {
  global $ACT;

 // $url = DOKU_URL . 'lib/plugins/ckgedit/scripts/script-cmpr.js';
  echo <<<SCRIPT

    <script type="text/javascript">
    //<![CDATA[ 

    function createRequestValue() {
        try{
        var inputNode=document.createElement('input');
        inputNode.setAttribute('type','hidden');
        inputNode.setAttribute('value','yes');
        inputNode.setAttribute('name','dwedit_preview');
        inputNode.setAttribute('id','dwedit_preview');
        var dwform = GetE("dw__editform");
        dwform.appendChild(inputNode);
        }catch(e) { alert(e); }
    }
//]]> 
 </script>

SCRIPT;

  if(isset($_REQUEST['do']) && is_array($_REQUEST['do'])) {
    if(isset($_REQUEST['do']['preview'])) {
           echo '<script type="text/javascript">';
           echo ' var dwform = GetE("dw__editform"); if(dwform["do[draftdel]"]) {dwform["do[draftdel]"].value = "Exit";}';
           echo "\ncreateRequestValue()\n";
           echo  '</script>';
    }
  }


  }

	
  
function reset_user_rewrite_check() {

      global $ACT;
       global $conf;
	   global $JSINFO,$USERINFO;	  

       if(isset($_COOKIE['FCKG_USE']) && $_COOKIE['FCKG_USE'] =='_false_' ) return;
       if($ACT == 'edit') {
         $this->user_rewrite = $conf['userewrite'];
	     $conf['userewrite']  = 0; 
       }
      
       if($conf['htmlok'] || $this->getConf('htmlblock_ok')) { 
         $JSINFO['htmlok'] = 1;
    }	  
    else $JSINFO['htmlok'] = 0;
    }	  

function startup_msg() {  
   global $INFO;
    global $ACT;
   global $updateVersion;
   $show_msg = false;
   if($INFO['isadmin'] || $INFO['ismanager'] )    {  // only admins and mgrs get messages
	       $show_msg = true;		   
	}
   if(!$show_msg)  return;

  $filename =  metaFN('fckl:scayt','.meta'); 
  $msg =  $this->locale_xhtml('scayt');  
  if (!file_exists($filename)) {      
      io_saveFile($filename,'1'); 
      msg($msg,MSG_MANAGERS_ONLY);          
  }
  else {
        if($this->getConf('scayt_auto') != 'off') return;
        $this->startup_check_twice($filename, 'scayt');
  }
  if( (float)$updateVersion  < 51) {
      return;
  }
  
/*
  $filename =  metaFN('fckl:hogfather','.meta'); 
  $msg =  $this->locale_xhtml('hogfather');
  if (!file_exists($filename)) {      
      io_saveFile($filename,'1'); 
       msg($msg,MSG_MANAGERS_ONLY);      
  } */
  
}

function  startup_check_twice($filename, $which) {
    global $ACT;

    if($ACT != 'login') return;    
    $msg =  $this->locale_xhtml($which);
   if (file_exists($filename)) {      
           $reps = io_readFile($filename);
           if($reps <2) {
              $reminder =  $this->getLang('dblclk_reminder');
              msg("($reminder) " . $msg,2 );    
              io_saveFile($filename,$reps+1); 
              return;
           }
   }
}
/**
  checked for additional dw priority possibilities only if the dw priority option is set to true
*/
function in_dwpriority_group() {      
        global $USERINFO,$INFO;
        if(!isset($USERINFO)) return false; 
         if(empty($this->dw_priority_group)) return true;  // all users get dw_priority if no dw_priority group has been set in config
         $client =   $_SERVER['REMOTE_USER']; 
         $ar = unserialize(file_get_contents($this->dw_priority_metafn));  // check user profile settings
         $expire = time() -60*60*24*30;
         if(isset($ar[$client])) {
             if($ar[$client] =='Y') return true;    // Y = dw_priority selected    
             if($ar[$client] =='N') {   
                 setcookieSameSite('FCKG_USE','_false_', $expire, '/');    
                 return false;  // N = CKEditor selected
             }
         }
        $user_groups = $USERINFO['grps'];   
      
        if(in_array($this->dw_priority_group, $user_groups) || in_array("admin", $user_groups)) {          
           return true;
        }
        
         setcookieSameSite('FCKG_USE','_false_', $expire, '/');    
 
      return false;
}

function restore_conf() {
    global $conf;
    global $ACT;
    if($ACT == 'edit') { return; }
   
    if($this->user_rewrite !==false) {
         $conf['userewrite']   = $this->user_rewrite; 
    }
    
}
function ajax_debug($data) {
    return;
    echo "$data\n";
}
function write_debug($data) {
  return;
  if (!$handle = fopen(DOKU_INC .'meta.txt', 'a')) {
    return;
    }
  if(is_array($data)) {
     $data = print_r($data,true);
  }
    // Write $somecontent to our opened file.
    fwrite($handle, "$data\n");
    fclose($handle);

}

}



