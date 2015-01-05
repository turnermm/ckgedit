<?php
/*
 * FCKeditor - The text editor for Internet - http://www.fckeditor.net
 * Copyright (C) 2003-2009 Frederico Caldeira Knabben
 *
 * == BEGIN LICENSE ==
 *
 * Licensed under the terms of any of the following licenses at your
 * choice:
 *
 *  - GNU General Public License Version 2 or later (the "GPL")
 *    http://www.gnu.org/licenses/gpl.html
 *
 *  - GNU Lesser General Public License Version 2.1 or later (the "LGPL")
 *    http://www.gnu.org/licenses/lgpl.html
 *
 *  - Mozilla Public License Version 1.1 or later (the "MPL")
 *    http://www.mozilla.org/MPL/MPL-1.1.html
 *
 * == END LICENSE ==
 *
 * Configuration file for the File Manager Connector for PHP.
 */

require_once 'check_acl.php';
if(!defined('DOKU_INC')) define('DOKU_INC',realpath(dirname(__FILE__).'/../../../../../../../../').'/');


global $Config ;
global $AUTH; 
global $dwfck_client;
global $topLevelFolder;
global $sep;
global $useNixStyle;
global $Dwfck_conf_values;
$Dwfck_conf_values = doku_config_values();

$DWFCK_con_dbg = false;  
// SECURITY: You must explicitly enable this "connector". (Set it to "true").
// WARNING: don't just set "$Config['Enabled'] = true ;", you must be sure that only
//		authenticated users can access this file or use some kind of session checking.
$Config['Enabled'] = true ;

  if(isset($_REQUEST ) && isset($_REQUEST['DWFCK_Client'])) {
     $dwfck_client = $_REQUEST['DWFCK_Client'];
     if(!$dwfck_client) $AUTH_INI = 255;
  }
  else $AUTH_INI = 255;


$Config['osDarwin'] = DWFCK_is_OS('DARWIN') ? true : false;

  
/** 
  For filebrowser installation documents relating to this file, see the following:
  http://www.mturner.org/fckgLite/doku.php?id=file_browser_install
  http://www.mturner.org/fckgLite/doku.php?id=docs:auto_install
  http://www.mturner.org/fckgLite/doku.php?id=media#security_and_the_media_directory

*/



$isWindows = DWFCK_isWinOS();
$Config['osWindows'] = $isWindows;
$useWinStyle = false;
$useNixStyle = false;
$sep = $isWindows ? '\\' : '/';
$dwfck_local = false;
$useNixStyle=false;
if(isset($Dwfck_conf_values['plugin']['ckgedit']['nix_style'])) {
   $useNixStyle = $Dwfck_conf_values['plugin']['ckgedit']['nix_style']; 
}
if(isset($_REQUEST['DWFCK_Browser']) && $_REQUEST['DWFCK_Browser'] == 'local') {
     $useWinStyle = true;
     $dwfck_local = true;
	 $useNixStyle = false;    
}

$Config['isWinStyle'] = $useWinStyle;

if(!isset($Config['UserFilesAbsolutePath']) || !isset($Config['UserFilesPath'])) {
   if(isset($_COOKIE['FCKConnector']) && $_COOKIE['FCKConnector'] == 'WIN') {
      $useWinStyle = true;  
   }
   
   if($isWindows || $useWinStyle) {
    setupBasePathsWin();
    if($dwfck_local) {
     $savedir = $Dwfck_conf_values['savedir'];
     if(trim($savedir,'./') != 'data') {
        $Config['UserFilesPath'] = $savedir .'/pages/';
        $Config['UserFilesAbsolutePath'] = $Config['UserFilesPath'];
     }
     else $Config['UserFilesPath'] = str_replace('/media', '/pages', $Config['UserFilesPath']);     
     //$Config['UserFilesPath'] = str_replace('/media', '/pages', $Config['UserFilesPath']);
     if($isWindows) {
          if($Dwfck_conf_values['ckg_savedir']) {     
             $Config['UserFilesAbsolutePath'] = $Dwfck_conf_values['ckg_savedir'] . '/pages/';
         }   
         else $Config['UserFilesAbsolutePath'] = str_replace('\\media', '\\pages', $Config['UserFilesAbsolutePath']);
     }
     else {
         if($Dwfck_conf_values['ckg_savedir']) {     
             $Config['UserFilesAbsolutePath'] = $Dwfck_conf_values['ckg_savedir'] . '/pages/';
         }     
         else $Config['UserFilesAbsolutePath'] = str_replace('/media', '/pages/', $Config['UserFilesAbsolutePath']);
         $Config['UserFilesAbsolutePath'] = rtrim($Config['UserFilesAbsolutePath'],'/') . '/';
     }  
    }
    if($DWFCK_con_dbg && $isWindows) {
          DWFCK_cfg_dbg('win_paths.txt');
       }
       else {
          if($DWFCK_con_dbg) DWFCK_cfg_dbg('nix_local_paths-' . getAccessNum () .  '.txt');   
       }
   }
   else {
     setupBasePathsNix();
     if($DWFCK_con_dbg) DWFCK_cfg_dbg('nix_paths-' . getAccessNum () .  '.txt');   
   }
}
else {  //if both UserFilesPath and UserFilesAbsolutePath are set
   if($isWindows || $useWinStyle) {  
    if($dwfck_local) {
     $Config['UserFilesPath'] = str_replace('/media', '/pages', $Config['UserFilesPath']);
     if($isWindows) {
         $Config['UserFilesAbsolutePath'] = str_replace('\\media', '\\pages', $Config['UserFilesAbsolutePath']);
     }
     else {
        $Config['UserFilesAbsolutePath'] = str_replace('/media', '/pages', $Config['UserFilesAbsolutePath']);
     }
    }
    if($DWFCK_con_dbg) DWFCK_cfg_dbg('win_paths.txt');
   }
}

setUpMediaPaths();

// Due to security issues with Apache modules, it is recommended to leave the
// following setting enabled.
$Config['ForceSingleExtension'] = true ;

// Perform additional checks for image files.
// If set to true, validate image size (using getimagesize).
$Config['SecureImageUploads'] = true;

// What the user can do with this connector.
$Config['ConfigAllowedCommands'] = array('QuickUpload', 'FileUpload', 'GetFolders', 'GetFoldersAndFiles', 'CreateFolder', 'GetDwfckNs', 'UnlinkFile') ;

// Allowed Resource Types.
$Config['ConfigAllowedTypes'] = array('File', 'Image', 'Flash', 'Media') ;

// For security, HTML is allowed in the first Kb of data for files having the
// following extensions only.
$Config['HtmlExtensions'] = array("html", "htm", "xml", "xsd", "txt", "js") ;

// After file is uploaded, sometimes it is required to change its permissions
// so that it was possible to access it at the later time.
// If possible, it is recommended to set more restrictive permissions, like 0755.
// Set to 0 to disable this feature.
// Note: not needed on Windows-based servers.
if(isset($Dwfck_conf_values)) {
    $Config['ChmodOnUpload'] =  $Dwfck_conf_values['fmode'] ;
    $Config['ChmodOnFolderCreate'] = $Dwfck_conf_values['dmode']  ;
}
else {
   $Config['ChmodOnUpload'] =  0755 ;
   $Config['ChmodOnFolderCreate'] = 0755 ;
}

// See comments above.
// Used when creating folders that does not exist.

  

function setupBasePathsNix() {
  global $Config;
    $dir = dirname(__FILE__) ;
    $dir = preg_replace('/editor\/filemanager\/connectors\/.*/', 'userfiles/',$dir);
    $Config['UserFilesAbsolutePath'] = $dir;
    $document_root = $_SERVER['DOCUMENT_ROOT'];
    $relative_dir = str_replace($document_root, "", $dir);
    $Config['UserFilesPath'] = $relative_dir;
}

function setupBasePathsWin() {
  global $Config;
  global $isWindows;
  global $useNixStyle;
 
    $data_media = $isWindows ? 'data\\media\\' : 'data/media/';
    if($useNixStyle) {
    $regex = $isWindows ? '\editor\filemanager\connectors' : 'lib/plugins/ckgedit/fckeditor/editor/filemanager/connectors'; 
	$data_media = '\\userfiles\\';
    }  
    else {
       $regex = $isWindows ? 'lib\plugins\ckgedit\fckeditor\editor\filemanager\connectors' : 'lib/plugins/ckgedit/fckeditor/editor/filemanager/connectors'; 
     }
    $dir = dirname(__FILE__) ;   
       
    $regex = preg_quote($regex, '/');
    
    $dir = preg_replace('/'. $regex .'.*/', $data_media, $dir);

    $Config['UserFilesAbsolutePath'] = $dir;
     
    $base_url = getBaseURL_fck();
    if($useNixStyle) {
       $Config['UserFilesPath'] =  $base_url . 'lib/plugins/ckgedit/fckeditor/userfiles/';
     }  
    else $Config['UserFilesPath'] =  $base_url . 'data/media/';

}

/**
*   find hierarchically highest level parent namespace which allows acl CREATE  
*/
function get_start_dir() {
global $Config ;
global $AUTH; 
global $AUTH_INI;
global $sep;
global $dwfck_client;
 if(!$dwfck_client || $AUTH_INI == 255) return "";
  
  if(isset($_REQUEST['DWFCK_usergrps'])) {
      $usergrps = get_conf_array($_REQUEST['DWFCK_usergrps']);
  }
  else $usergrps = array();

   $elems = explode(':', $_COOKIE['FCK_NmSp']);  
   array_pop($elems);
   $ns = "";
   $prev_auth = -1;
   while(count($elems) > 0) {       
      $ns_tmp = implode(':',$elems);
      $test = $ns_tmp . ':*';          
      $AUTH = auth_aclcheck($test,$dwfck_client,$usergrps);           
      if($AUTH < 4) {  
          if(!$ns) {
             $ns = $ns_tmp;             
             break;
          }
           $AUTH = $prev_auth;
           break; 
      }
      $prev_auth = $AUTH; 
      $ns = $ns_tmp;
      array_pop($elems);        

   }

      
    if($ns) {      
       if(strpos($ns, ':')) {   
          return str_replace(':', '/', $ns);
       }
      $AUTH = auth_aclcheck(':*', $dwfck_client,$usergrps);     
        
      if($AUTH >= 8)  return "";
      return $ns;
    }
    $AUTH = auth_aclcheck(':*', $dwfck_client,$usergrps);      
    return "";
 
}

function setUpMediaPaths() {

  global $Config;
  global $isWindows;
  global $useWinStyle; 
  global $AUTH;
  global $dwfck_client;
  global $useNixStyle;
  
  if($useNixStyle) {  
	$useWinStyle=false;
	$isWindows = false;
  }
  $ALLOWED_MIMES = DOKU_INC . 'conf/mime.conf';
  if(!file_exists($ALLOWED_MIMES)) {
      $ALLOWED_MIMES = DOKU_CONF . '/mime.conf';
      $MIMES_LOCAL = DOKU_CONF . '/mime.local.conf';
  }
  $out=@file($ALLOWED_MIMES,FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
  
  if(file_exists(DOKU_INC . 'conf/mime.local.conf'))
  {
  	$out_local = @file(DOKU_INC . 'conf/mime.local.conf',FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);  	
  	$out = array_merge($out,$out_local);
  }
  elseif(isset($MIMES_LOCAL) && file_exists($MIMES_LOCAL)) {
   	$out_local = @file($MIMES_LOCAL,FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);  	   
  	$out = array_merge($out,$out_local);
  }
  $extensions = array();
  $image_extensions = array();
  foreach($out as $line) {
      if(strpos($line,'#') ===  false) {
         list($ext,$mtype)  = preg_split('/\s+/', $line); 
         $extensions[] = $ext;
		 if(strpos($mtype,'image')!==false) {
		     $image_extensions[] = $ext;
		 }
     }
  }

  
   
    // if !$dwfck_client then the file browser is not restricted to the client's permissions 
   if(!$dwfck_client) {
      $unrestricted_browser = true;
   }
   else $unrestricted_browser = false;

  if(isset($_REQUEST['DWFCK_usergrps'])) {
      $usergrps = get_conf_array($_REQUEST['DWFCK_usergrps']);
  }
  else $usergrps = array();


   $Config['AllowedExtensions']['File']	= array('7z', 'aiff', 'asf', 'avi', 'bmp', 'csv',
      'doc', 'docx','fla', 'flv', 'gif', 'gz', 'gzip', 'jpeg', 'jpg',
      'mid', 'mov', 'mp3', 'mp4', 'mpc', 'mpeg', 'mpg', 'ods', 'odt', 
      'pdf', 'png', 'ppt', 'psd', 'pxd', 'qt', 'ram', 'rar', 'rm', 'rmi', 'rmvb',
      'rtf', 'sdc', 'sitd', 'swf', 'sxc', 'sxw', 'tar', 'tgz', 'tif',
      'tiff', 'txt', 'vsd', 'wav', 'wma', 'wmv', 'xls', 'xml', 'zip') ;
    
    if(count($extensions) ) {
       $Config['AllowedExtensions']['File']	 = array_merge($Config['AllowedExtensions']['File'],$extensions);	
}
    $Config['DeniedExtensions']['File']		= array() ;
    $Config['AllowedExtensions']['Image']	= array_merge(array('bmp','gif','jpeg','jpg','png'),$image_extensions) ;
    $Config['DeniedExtensions']['Image']	= array() ;
    $Config['AllowedExtensions']['Flash']	= array('swf','flv') ;
    $Config['DeniedExtensions']['Flash']	= array() ;
    $Config['AllowedExtensions']['Media']	= array_merge(array('aiff', 'asf', 'avi', 'bmp', 'fla', 'flv', 'gif', 'jpeg', 'jpg', 'mid', 'mov', 'mp3', 'mp4', 'mpc', 'mpeg', 'mpg', 
	                              'png', 'qt', 'ram', 'rm', 'rmi', 'rmvb', 'swf', 'tif', 'tiff', 'wav', 'wma', 'wmv') ,$image_extensions);
    $Config['DeniedExtensions']['Media']	= array() ;
  
    $DWFCK_MediaTypes = array('File','Image', 'Flash','Media'); 
    $DWFCK_use_acl = true;
    if($unrestricted_browser) $DWFCK_use_acl = false;
    $current__Folder = ""; 
    if($DWFCK_use_acl && isset($_COOKIE['FCK_NmSp'])) {      
        if(strpos($_COOKIE['FCK_NmSp'], ':')) {         
          $current__Folder=get_start_dir();           
        }
   } 
    
    $sess_id = session_id();
    if(!isset($sess_id) || $sess_id != $_COOKIE['FCK_NmSp_acl']) {
        session_id($_COOKIE['FCK_NmSp_acl']);
        session_start();      
    }
   //file_put_contents('session.txt',print_r($_SESSION,true));
   if($_SESSION['dwfck_openfb'] == 'y') {
          $current__Folder = "";
   }
  
   $topLevelFolder=$current__Folder ? $current__Folder : '/';
   if($current__Folder) $current__Folder .= '/';        
   if($unrestricted_browser) $AUTH = 255;   
   setcookie("TopLevel", "$topLevelFolder;;$AUTH", time()+3600, '/'); 
   foreach($DWFCK_MediaTypes as $type) {   

        $abs_type_dir = strtolower($type) . '/';
        if($isWindows || $useWinStyle) {
          $abs_type_dir = "";
        }
        else {
           $abs_type_dir = strtolower($type) . '/';
        }
        $Config['FileTypesPath'][$type]		= $Config['UserFilesPath'] . $abs_type_dir; // $dir_type; 
        $Config['FileTypesAbsolutePath'][$type] = $Config['UserFilesAbsolutePath'] . $abs_type_dir; // $abs_type_dir ;
        $Config['QuickUploadPath'][$type]		= $Config['UserFilesPath'] . $abs_type_dir; // $dir_type ;
        $Config['QuickUploadAbsolutePath'][$type]= $Config['UserFilesAbsolutePath'] . $abs_type_dir;
        
        $Config['FileTypesPath'][$type]		= $Config['UserFilesPath'] . $abs_type_dir; //$dir_type; 
        $Config['FileTypesAbsolutePath'][$type] = $Config['UserFilesAbsolutePath'] . $abs_type_dir ;
        
        
    }

}

function getBaseURL_fck(){
 
  if(substr($_SERVER['SCRIPT_NAME'],-4) == '.php'){
    $dir = dirname($_SERVER['SCRIPT_NAME']);
  }elseif(substr($_SERVER['PHP_SELF'],-4) == '.php'){
    $dir = dirname($_SERVER['PHP_SELF']);
  }elseif($_SERVER['DOCUMENT_ROOT'] && $_SERVER['SCRIPT_FILENAME']){
    $dir = preg_replace ('/^'.preg_quote($_SERVER['DOCUMENT_ROOT'],'/').'/','',
                         $_SERVER['SCRIPT_FILENAME']);
    $dir = dirname('/'.$dir);
  }else{
    $dir = '.'; //probably wrong
  }

  $dir = str_replace('\\','/',$dir);             // bugfix for weird WIN behaviour
  $dir = preg_replace('#//+#','/',"/$dir/");     // ensure leading and trailing slashes

  //handle script in lib/exe dir
  $dir = preg_replace('!lib/exe/$!','',$dir);

  //handle script in lib/plugins dir
  $dir = preg_replace('!lib/plugins/.*$!','',$dir);

  //finish here for relative URLs
  return $dir;
}

function DWFCK_isWinOS() {
  global $Config;  
  if(isset($_SERVER['WINDIR']) && $_SERVER['WINDIR']) {
      return true;
  }
  elseif(stristr(PHP_OS, 'WIN') && !DWFCK_is_OS('DARWIN')) {
     return true;
  }
  
  return false;
}


function DWFCK_is_OS($os) {
  $os = strtolower($os);
  $_OS = strtolower(PHP_OS);

  if($os == $_OS || stristr(PHP_OS, $os) || stristr($os,PHP_OS) ) {
        return true;
  }
  return false;
}

function doku_config_values() {  
  $dwphp = DOKU_INC . 'conf/dokuwiki.php';
  if(!file_exists($dwphp)) {
     $dwphp = DOKU_CONF . 'dokuwiki.php';
     $localphp = DOKU_CONF . 'local.php';
  }
  else $localphp = DOKU_INC . 'conf/local.php';
  
  if(file_exists($dwphp))
  {
  	include($dwphp);
    if(file_exists($localphp))
    {
      include($localphp);
    }
   if(trim($conf['savedir'],'/.\/') != 'data') {
     $conf['ckg_savedir']= $conf['savedir'];
   }
 
    return $conf;
  }

  return false;
}

function DWFCK_cfg_dbg($fname) {
   global $Config;
   global $Dwfck_conf_values;
   $request = print_r($_REQUEST,true);
   $request .= "\n" .  print_r($Dwfck_conf_values,true);
   file_put_contents($fname, $Config['UserFilesAbsolutePath'] . "\r\n" . $Config['UserFilesPath'] . "\r\n" .$request ."\r\n");
}

function config_write_debug($what) {
return;
if(is_array($what)) {
   $what = print_r($what,true);
}
$dwfckFHandle = fopen("fbrowser_dbg.txt", "a");
fwrite($dwfckFHandle, "$what\n");
fclose($dwfckFHandle);
}
?>
