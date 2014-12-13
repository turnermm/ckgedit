<?php
/**
 *
 */
 
if(!defined('DOKU_INC')) die();
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'action.php');
 
class action_plugin_ckgedit_meta extends DokuWiki_Action_Plugin {
  var $session_id = false;    
  var $draft_file;
  var $user_rewrite = false;
  var $helper;
  var $dokuwiki_priority;
  
  function __construct() {
      $this->helper = plugin_load('helper', 'ckgedit');
      $this->dokuwiki_priority = $this->getConf('dw_priority');
  }
  /*
   * Register its handlers with the dokuwiki's event controller
   */
  function register(&$controller) {            

            if($this->helper->is_outOfScope()) return;
            $controller->register_hook( 'TPL_METAHEADER_OUTPUT', 'AFTER', $this, 'loadScript');    
            $controller->register_hook( 'HTML_EDITFORM_INJECTION', 'AFTER', $this, 'preprocess'); 
            $controller->register_hook( 'HTML_EDITFORM_OUTPUT', 'BEFORE', $this, 'insertFormElement');            
            $controller->register_hook('DOKUWIKI_STARTED', 'BEFORE', $this, 'file_type');         
            $controller->register_hook('TPL_CONTENT_DISPLAY', 'AFTER', $this, 'setupDWEdit');       
            $controller->register_hook('DOKUWIKI_STARTED', 'AFTER', $this, 'reset_user_rewrite_check');                 
            $controller->register_hook('DOKUWIKI_DONE', 'BEFORE', $this, 'restore_conf');   
                         
  }

 
 function  insertFormElement(&$event, $param) {	 
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


 function preprocess(&$event, $param) {	 
    $act = $event->data;
 
   if(is_string($act) && $act != 'edit') {  
        return;
   }
  global $INFO, $ckgedit_lang;
  $cname =  $INFO['draft'];   
  $discard = $this->getLang('discard_edits');  
  $dokuwiki_priority =$this->dokuwiki_priority;
  echo "<script type='text/javascript'>\n//<![CDATA[ \n";
  echo "var useDW_Editor =$dokuwiki_priority;";
  echo "\n //]]> </script>\n";
  echo <<<SCRIPT
    <script type="text/javascript">
    //<![CDATA[ 
    var ckgedit_dwedit_reject = false;
    function setDWEditCookie(which, e) { 
       var cname = "$cname";       
       var dom = document.getElementById('ckgedit_mode_type');          
       if(which == 1) {
           dwedit_draft_delete("$cname");
          
             if(useDW_Editor) {
                document.cookie = 'FCKG_USE=other;expires=';             
              }  
           else {
                document.cookie='FCKG_USE=other;expires=Thu,01-Jan-70 00:00:01 GMT;'
           }
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
            document.cookie = 'FCKG_USE=_false_;expires=';             
            dom.value = 'dwiki';        

            if(window.dwfckTextChanged  && !window.confirm("$discard")) {            
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
 
    if($this->getConf('no_symlinks')) {	
	   return;
	}
	
    global $INFO;
    global $conf;
	$userfiles = DOKU_PLUGIN . 'ckgedit/fckeditor/userfiles/';
    $save_dir = trim($conf['savedir']);  
    
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
        else $media_dir = '/lib/plugins/ckgedit/fckeditor/userfiles/image/';        
        setcookie('FCK_media',$media_dir, $expire, '/');           

     }
     else {
         $data_media = DOKU_INC.'data/media/';
     }
     
     if($this->getConf('winstyle')) return;    
     if(!is_readable($userfiles) && !is_writable($userfiles)){
              msg("ckgedit cannot access $userfiles. Please check the permissions.");
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
	   if(count($winlinks)) {
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
						  if($show_msg)  msg("unable to create $name link:  $path",-1);			  
				   }
				   else {
				     $successes[] = $name; 
				   }
			 }	   	   
		  }
      }
	  else {
	     if($show_msg)  {
			msg("Cannot create symlinks for filebrowser.  Cannot access:  $userfiles   ",-1);
		 }
	  }
	   
	 
	   
	  if($bad_create) {
	       if($show_msg)  {
			   msg("There was an error when trying to create symbolic links in $userfiles. "
					. "See ckgedit/auto_install.pdf  or  the <a href='http://www.mturner.org/ckgeditLite/doku.php?id=docs:auto_install'>ckgeditLite web site</a>" , 2);					
				}
      }
	  else {	        
	       if(count($successes)) {
				$links_created = implode(', ',$successes);
				msg('The following links were created in the userfiles directory: ' . $links_created,2);
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

           $_SESSION['dwfck_grps'] = $USERINFO['grps'];
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

          // $expire = time()+60*60*24*30;
           $expire = null;
           setcookie('FCK_NmSp_acl',$session_string, $expire, '/');           

           setcookie('FCK_SCAYT',$this->getConf('scayt'), $expire, '/');                
           setcookie('FCK_SCAYT_AUTO',$this->getConf('scayt_auto'), $expire, '/'); 
           $scayt_lang = $this->getConf('scayt_lang');
           if(isset($scayt_lang)) {
               list($scayt_lang_title,$scayt_lang_code) = explode('/',$scayt_lang);
               if($scayt_lang_code!="en_US") {
                  setcookie('FCK_SCAYT_LANG',$scayt_lang_code, $expire, '/'); 
               }
           }
           if ($this->getConf('winstyle')) {
              setcookie('FCKConnector','WIN', $expire, DOKU_BASE);                                
           }
           if ($this->dokuwiki_priority) {
               if(isset($_COOKIE['FCKG_USE']) && $_COOKIE['FCKG_USE'] == 'other') {                              
                   $expire = time() -60*60*24*30;
                   setcookie('FCKG_USE','_false_', $expire, '/');           
               }
               else {            
                  setcookie('FCKG_USE','_false_', $expire, '/');           
                }
           }
  }

  function file_type(&$event, $param) {	 
       global $ACT;
       global $ID; 
       global $JSINFO;
       $JSINFO['confirm_delete']= $this->getLang('confirm_delete');

	   $this->check_userfiles(); 
	   
       if(isset($_COOKIE['FCK_NmSp'])) $this->set_session(); 
       /* set cookie to pass namespace to FCKeditor's media dialog */
      // $expire = time()+60*60*24*30;
       $expire = null;
       setcookie ('FCK_NmSp',$ID, $expire, '/');     
      
          

      /* Remove TopLevel cookie */         
       if(isset($_COOKIE['TopLevel'])) {
            setcookie("TopLevel", $_REQUEST['TopLevel'], time()-3600, '/');
       }

     
       if(!isset($_REQUEST['id']) || isset($ACT['preview'])) return;
       if(isset($_REQUEST['do']) && isset($_REQUEST['do']['edit'])) {
              $_REQUEST['do'] = 'edit';
       }
  } 

function loadScript(&$event) {
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
 *    1. load script, if not loaded
 *    2. Re-label Cancel Button "Exit" when doing a preview  
 *    3. set up $REQUEST value to identify a preview when in DW Edit , used in 
 *       set_session to remove ckgedit and DW drafts if present after a DW preview  
*/
  function setupDWEdit(&$event) {
  global $ACT;

  $url = DOKU_URL . 'lib/plugins/ckgedit/scripts/script-cmpr.js';
  if(($ACT == 'login' || $this->session_id == false) && $this->getConf('preload_ckeditorjs')) {
     $url2 = DOKU_BASE.'lib/plugins/ckgedit/ckeditor/ckeditor.js';
  }
  else $url2 = "";
  echo <<<SCRIPT

    <script type="text/javascript">
    //<![CDATA[ 

    try {
    if(!window.HTMLParserInstalled || !HTMLParserInstalled){
         LoadScript("$url");        
    }
    }
    catch (ex) {  
         LoadScript("$url");        
    }             
    if("$url2") {
       LoadScriptDefer("$url2");        
    }
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
           echo ' var dwform = GetE("dw__editform"); dwform["do[draftdel]"].value = "Exit";';
           echo "\ncreateRequestValue()\n";
           echo  '</script>';
    }
  }


  }

	
  
function reset_user_rewrite_check() {

      global $ACT;
       global $conf;
	  
       if(isset($_COOKIE['FCKG_USE']) && $_COOKIE['FCKG_USE'] =='_false_' ) return;
       if($ACT == 'edit') {
          $this->user_rewrite = $conf['userewrite'];
	     $conf['userewrite']  = 0; 
       }
       
    }	  

      

function restore_conf() {
    global $conf;
    global $ACT;
    if($ACT == 'edit') { return; }
   
    if($this->user_rewrite !==false) {
         $conf['userewrite']   = $this->user_rewrite; 
    }
    
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



