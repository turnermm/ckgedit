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
 * This is the File Manager Connector for PHP.
 */




require_once 'check_acl.php';


global $dwfck_conf;
global $_FolderClass;

function GetDwfckNs()
{
	echo $_SESSION['dwfck_ns'];	
}


 function has_permission($folder, $resourceType, $isFolder=true) {
   global $_FolderClass;
   global $Dwfck_conf_values;   
        $folder = str_replace('//','/',$folder);
       
        $sFolderPath = GetResourceTypeDirectory( $resourceType, 'GetFoldersAndFiles'); 
    
       $ns_tmp = str_replace('/',':',$folder);
       $ns_tmp=trim($ns_tmp,':');   
       
       if(preg_match('/%[a-zA-a0-9]/', $ns_tmp) && $Dwfck_conf_values['fnencode'] == 'safe') {
          $test = dwiki_decodeFN($ns_tmp);
       }
       else {
        
       $test = urldecode($ns_tmp);
       }
       
       if($isFolder) {
           $test .=  ':*' ;   
       }
       else {
           $test=preg_replace('/\.txt$/',"",$test);
       }

       $AUTH =  auth_aclcheck($test, $_SESSION['dwfck_client'] , $_SESSION['dwfck_grps'], 1);   

       $_FolderClass = $AUTH;    
       if(!$isFolder) return($AUTH > 0);       
       return ($AUTH >1);
 }

  
function GetFolders( $resourceType, $currentFolder )
{

   global $_FolderClass; 
   global $Config;
  
    $currentFolder=encode_dir($currentFolder);
   $isInternalLink = isset($_GET['DWFCK_Browser']) && $_GET['DWFCK_Browser'] == 'local'?  true : false;

	// Map the virtual path to the local server path.
	$sServerDir = ServerMapFolder( $resourceType, $currentFolder, 'GetFolders' ) ;

    if($Config['osWindows']) {
        $sServerDir = normalizeWIN($sServerDir); 
    }

	// Array that will hold the folders names.
	$aFolders	= array() ;

	$oCurrentFolder = @opendir( $sServerDir ) ;

	if ($oCurrentFolder !== false)
	{
		while ( $sFile = readdir( $oCurrentFolder ) )
		{
			if ( $sFile != '.' && $sFile != '..' && is_dir( $sServerDir . $sFile ) ) {
				

                if(has_permission(dwiki_encodeFN($currentFolder) .'/' . $sFile,  $resourceType) || has_open_access() ) {  
                        if($isInternalLink && $_FolderClass < 255) {
                            $class = 'r';                         
                       }              
                       else $class = ($_FolderClass < 8) ? 'r' : 'u';  
                       can_delete($class);
                       if($_FolderClass) {    
 			  	           $aFolders[] = '<Folder name="' . ConvertToXmlAttribute( $sFile ) .   
                            '" class="'. $class .'" />' ;
                       }

               }
			}
		}


		closedir( $oCurrentFolder ) ;
	}

	// Open the "Folders" node.
	echo "<Folders>" ;

	natcasesort( $aFolders ) ;
      
	foreach ( $aFolders as $sFolder )

		echo $sFolder ;


	// Close the "Folders" node.
	echo "</Folders>" ;

}

/**
    seeks to determine whether user has rights to create folder 
    if the folder does not exist when file browser is opened
    and the editor has not created it
    This situation occurs when the file browser opened from the
    root directory, where the file being written to is in a
    new subdirectory that has been created for the file:
           parent_dir:new_dir:new_file
   Dokuwiki creates new_dir in data/pages but not in data/media.
   Dokuwiki creates data/media/new_dir when the user opens
   the media manager. Similarly, this directory has to be created when
   FCKeditor's file browser is opened
   
*/
function has_open_access() {

    $open_access = false;
    if(isset($_REQUEST['TopLevel'])) {
    //   list($top_level,$auth) = explode(';;',$_REQUEST['TopLevel']);
     //  if($auth == 255 && $top_level =='/') $open_access = true;
    }
    $isadmin = isset($_SESSION['dwfck_conf']['isadmin']) ? $_SESSION['dwfck_conf']['isadmin'] : false;
    $acl = isset($_SESSION['dwfck_acl']) ? $_SESSION['dwfck_acl'] : 1;  
    $openbrowser = (isset($_SESSION['dwfck_openfb']) && $_SESSION['dwfck_openfb'] == 'y') ? true : false;
    if($open_access || $isadmin || $acl == 255 || ($openbrowser && $acl >= 8)) {
         return true;
    }

    return false;
}



function GetFoldersAndFiles( $resourceType, $currentFolder )
{
	if (!isset($_GET)) {
		global $_GET;
	}
     global $Config; 


   $isInternalLink = isset($_GET['DWFCK_Browser']) && $_GET['DWFCK_Browser'] == 'local'?  true : false;
   global $_FolderClass;
   global $Config;
   $currentFolder=encode_dir($currentFolder);

   $sess_id = session_id();
   if(!isset($sess_id) || $sess_id != $_COOKIE['FCK_NmSp_acl']) {
       session_id($_COOKIE['FCK_NmSp_acl']);
       session_start();    
   }    
    $acl_del = isset($_SESSION['dwfck_del']) ? $_SESSION['dwfck_del'] : 0;   
	// Map the virtual path to the local server path.
	$sServerDir = ServerMapFolder( $resourceType, $currentFolder, 'GetFoldersAndFiles' ) ;
    if($Config['osWindows']) {
        $sServerDir = normalizeWIN($sServerDir); 
    }

    mkdir_rek($sServerDir);
	// Arrays that will hold the folders and files names.
	$aFolders	= array() ;
	$aFiles		= array() ;

    $sFile = '__AAAAAAAA__.AAA';  
    $temp_folder = $currentFolder;
    $temp_folder = dwiki_encodeFN(trim($temp_folder,'/'));
    has_permission($temp_folder, $resourceType);
    if($isInternalLink && $_FolderClass < 16) {
         $sfclass = 'r';
    }
    else { 
         if($acl_del)  {
            $sfclass = $_FolderClass >= 16 ? 'u' : 'r'; 
         }
         else $sfclass = ($_FolderClass >= 8  || has_open_access()) ? 'u' : 'r'; 
         can_delete($sfclass);
    }
    if(!$_FolderClass) return;
    $aFolders[] = '<Folder name="' . ConvertToXmlAttribute( $sFile ) .   
                            '" class="'. $sfclass .'" />' ;
 
    $sErrorNumber=0;  

 
     $sFolderPath = GetResourceTypeDirectory( $resourceType, 'GetFoldersAndFiles');  

     $absolute_path = $Config['UserFilesAbsolutePath'];



  
	$oCurrentFolder = @opendir( $sServerDir ) ;

	if ($oCurrentFolder !== false)
	{
		while ( $sFile = readdir( $oCurrentFolder ) )
		{ 
          
			if ( $sFile != '.' && $sFile != '..' )
			{
				if ( is_dir( $sServerDir . $sFile ) ) {  
                    
                    if(has_permission(dwiki_encodeFN($currentFolder)  .$sFile,  $resourceType) || has_open_access()) {                  
                        if($isInternalLink && $_FolderClass < 255) {
                            $class = 'r';                         
                       }
                       else {
                              $class = ($_FolderClass < 8) ? 'r' : 'u';                        
                              can_delete($class);                              
                       }   
                       if($_FolderClass){               
				  	       $aFolders[] = '<Folder name="' . ConvertToXmlAttribute( $sFile ) .   
                              '" class="'. $class .'" />' ;
                       }
                        
                    }
                    
				}
				else
				{
					$iFileSize = @filesize( $sServerDir . $sFile ) ;

					if ( !$iFileSize ) {
						$iFileSize = 0 ;
					}
					if ( $iFileSize > 0 )
					{
						$iFileSize = round( $iFileSize / 1024 ) ;
						if ( $iFileSize < 1 )
							$iFileSize = 1 ;
					}
                    if($isInternalLink) {
                        if(!preg_match('/\.txt$/', $sFile)) continue;
                        if(has_permission(dwiki_encodeFN($currentFolder)  .$sFile,  $resourceType, false)) {                   
       				   	   $aFiles[] = '<File name="' . ConvertToXmlAttribute( $sFile ) . '" size="' . $iFileSize . '" />' ;
                        }
                    }
                    else { 
                       if($resourceType == 'Image') {
                            list($width, $height, $type, $attr) = getimagesize($sServerDir . $sFile);
                                if(isset($width) && isset($height)) {
                                  $iFileSize .= ";;$width;;$height"; 
                                }
                            
                            }


                          $aFiles[] = '<File name="' . ConvertToXmlAttribute( $sFile ) . '" size="' . $iFileSize . '" />' ;
                    }
                    
				}
			}
		}
		closedir( $oCurrentFolder ) ;
	}



	// Send the folders
	natcasesort( $aFolders ) ;
	echo '<Folders>' ;

	foreach ( $aFolders as $sFolder ) {
        
		echo $sFolder;
	}

	echo '</Folders>' ;

	// Send the files
	natcasesort( $aFiles ) ;
	echo '<Files>' ;

	foreach ( $aFiles as $sFiles )
		echo $sFiles ;
  
	echo '</Files>' ;



}

function CreateFolder( $resourceType, $currentFolder )
{
    global $_FolderClass;
    global $Config;
	if (!isset($_GET)) {
		global $_GET;
	}
	$sErrorNumber	= '0' ;
	$sErrorMsg		= '' ;
    if(!has_permission($currentFolder, $resourceType) || $_FolderClass < 8 ) {    
         if(!has_open_access()) {    
            $sErrorNumber = 103;     
      	    echo '<Error number="' . $sErrorNumber . '" />' ;
            return;
         }
    }


	if ( isset( $_GET['NewFolderName'] ) )
	{
       $sess_id = session_id();
       if(!isset($sess_id) || $sess_id != $_COOKIE['FCK_NmSp_acl']) {
           session_id($_COOKIE['FCK_NmSp_acl']);
           session_start();    
       }

        global $Dwfck_conf_values;
        global $dwfck_conf;
        $dwfck_conf = $_SESSION['dwfck_conf'];
        if(empty($dwfck_conf)) {
            $dwfck_conf['deaccent'] = isset($Dwfck_conf_values['deaccent'])? $Dwfck_conf_values['deaccent'] : 1;
            $dwfck_conf['useslash'] = isset($Dwfck_conf_values['useslash']) ? $Dwfck_conf_values['useslash'] : 0;
            $dwfck_conf['sepchar'] = isset($Dwfck_conf_values['sepchar']) ? $Dwfck_conf_values['sepchar'] : '_';
        }

		$sNewFolderName = $_GET['NewFolderName'] ;
        $sNewFolderName = str_replace(' ', $dwfck_conf['sepchar'], $sNewFolderName);
        $sNewFolderName=Dwfck_sanitize( $sNewFolderName ) ;

		if ( strpos( $sNewFolderName, '..' ) !== FALSE )
			$sErrorNumber = '102' ;		// Invalid folder name.
		else
		{
			// Map the virtual path to the local server path of the current folder.
			$sServerDir = ServerMapFolder( $resourceType, $currentFolder, 'CreateFolder' ) ;

           if($Dwfck_conf_values['fnencode'] == 'url' || ($Config['osWindows'] && !isset($Dwfck_conf_values['fnencode']))) {
                  $sServerDir=encode_dir($sServerDir);
           }
            if($Config['osWindows']) {
                $sServerDir = normalizeWIN($sServerDir); 
            }

			if ( is_writable( $sServerDir ) )
			{
				$sServerDir .= $sNewFolderName ;

				$sErrorMsg = CreateServerFolder( $sServerDir ) ;

				switch ( $sErrorMsg )
				{
					case '' :
						$sErrorNumber = '0' ;
						break ;
					case 'Invalid argument' :
					case 'No such file or directory' :
						$sErrorNumber = '102' ;		// Path too long.
						break ;
					default :
						$sErrorNumber = '110' ;
						break ;
				}
			}
			else
				$sErrorNumber = '103' ;
		}
	}
	else
		$sErrorNumber = '102' ;

	// Create the "Error" node.
	echo '<Error number="' . $sErrorNumber . '" />' ;
}

function Dwfck_sanitize($sFileName, $media=false) {    
  global $Dwfck_conf_values;
          
        if($Dwfck_conf_values['fnencode'] == 'safe') {
            if(!$media) {     
              return dwiki_encodeFN($sFileName); 
            }
           return cleanID($sFileName,false,$media);
        }
        $sFileName = cleanID(dwiki_decodeFN($sFileName),false,$media);
        return dwiki_encodeFN($sFileName); 
}


function normalizeWIN($path) {
  if(!$path) return "";
  global $winChars,  $winSearch;
  if(!isset($winSearch)) {
      $winChars = array('/',':','(',')','{','}','{','}',' ', '\\', 
     ']','[', '$',  '+',  '@',  '!',  '#',  '%',  '*', '?');
      $winSearch = array_map('rawurlencode', $winChars);
  }
  
   $path = str_replace($winSearch,$winChars,$path);
   $path = str_replace('/','\\',$path);
  // $path = preg_replace('#\\\\{2,}#','\\',$path);
   $path = str_replace('.\\','\\',$path);
  
   return str_replace('+',' ', $path);
 

}

function UnlinkFile($resourceType, $currentFolder, $sCommand, $filename ) {
global $Config;
  global $Dwfck_conf_values;
  $move = false;

    $sServerDir = ServerMapFolder( $resourceType, $currentFolder, 'GetFoldersAndFiles' ) ;
    
    if(preg_match('/^(.*?)\/(.*?)$/',$filename,$matches)) {
      $move = true;
      $sMoveDir = $sServerDir;
      $sMoveDir .= dwiki_encodeFN($matches[1]);

      $sMoveDir = rtrim($sMoveDir, '/');
      $filename = $matches[2];        
      mkdir_rek($sMoveDir); 

  
      if(preg_match('/secure$/', $sMoveDir)){  
          if(!file_exists($sMoveDir . '/' . '.htaccess')) {
            copy( 'htaccess' , $sMoveDir . '/' . '.htaccess') ;  
          }
      }
      $moveFile = $sMoveDir . '/' . dwiki_encodeFN($filename ); 

    }
    else {
        if($Dwfck_conf_values['fnencode'] == 'url' || ($Config['osWindows'] && !isset($Dwfck_conf_values['fnencode']))) {
              $sServerDir=encode_dir($sServerDir);
        }
    }

    $unlinkFile =    $sServerDir . dwiki_encodeFN($filename );

    if($Config['osWindows']) {
       $unlinkFile = normalizeWIN($unlinkFile);
    }

    if($move) {
      if($Config['osWindows']) {
         $moveFile = normalizeWIN($moveFile);
       }
          
       if(rename($unlinkFile, $moveFile)) {
         return GetFoldersAndFiles( $resourceType, $currentFolder );
       }
       else {
         $sErrorNumber = '205';
         echo '<Error number="' . $sErrorNumber . '" />' ;
         return;
       }
    }

    if(file_exists($unlinkFile) && unlink($unlinkFile)) {
          return GetFoldersAndFiles( $resourceType, $currentFolder );
    }
    else {
        $sErrorNumber = '204';
        echo '<Error number="' . $sErrorNumber . '" />' ;
    }

}

function encode_dir($path) {
   
   if(preg_match('/%25/',$path)) {
     $path =  urldecode($path);
     while(preg_match('/%25/',$path)) {
       $path =  urldecode($path);
     }
   
     return $path;

   }

   if(preg_match('/%[A-F]\d/i',$path) || preg_match('/%\d[A-F]/i',$path)) {          
     return $path;
   }


   $dirs = explode('/',$path);

   $new_path = "";
   foreach($dirs as $dir) {
     $new_path .= dwiki_encodeFN($dir). '/';
   }

    $new_path = rtrim($new_path,'/');
    $new_path .= '/';

    return $new_path;
}

function FileUpload( $resourceType, $currentFolder, $sCommand )
{
    global $dwfck_conf;
    
	if (!isset($_FILES)) {
		global $_FILES;
	}
	$sErrorNumber = '0' ;
	$sFileName = '' ;
     
    $sess_id = session_id();
    if(!isset($sess_id) || $sess_id != $_COOKIE['FCK_NmSp_acl']) {
       session_id($_COOKIE['FCK_NmSp_acl']);
       session_start();    
   }

    global $Dwfck_conf_values;
    $dwfck_conf = $_SESSION['dwfck_conf'];
    if(empty($dwfck_conf)) {
        $dwfck_conf['deaccent'] = isset($Dwfck_conf_values['deaccent'])? $Dwfck_conf_values['deaccent'] : 1;
        $dwfck_conf['useslash'] = isset($Dwfck_conf_values['useslash']) ? $Dwfck_conf_values['useslash'] : 0;
        $dwfck_conf['sepchar'] = isset($Dwfck_conf_values['sepchar']) ? $Dwfck_conf_values['sepchar'] : '_';
    }
    
    $auth = 0;
    if(isset($_REQUEST['TopLevel'])) {
       list($top_level,$auth) = explode(';;',$_REQUEST['TopLevel']);
    }



  $safe = false;
  global $Dwfck_conf_values;
  if($Dwfck_conf_values['fnencode'] == 'safe') {
      if(preg_match('/%[a-z]+[0-9]/',$currentFolder) || preg_match('/%[0-9][a-z]/',$currentFolderp)) {
          $safe = true;
      }
  }
  $ns_tmp = dwiki_decodeFN(trim($currentFolder, '/'));
 
  $ns_tmp = str_replace('/', ':', $ns_tmp);  
  $test = $ns_tmp . ':*' ;   

  if(!$safe) {
    $test = urldecode($test);
    
    while(preg_match('/%25/',$test)){
          $test =  urldecode($test);
    }
    $test = urldecode($test);
  }
  
   $isadmin = isset($_SESSION['dwfck_conf']['isadmin']) ? $_SESSION['dwfck_conf']['isadmin'] : false; 
   if(!$isadmin) {
       $AUTH = auth_aclcheck($test, $_SESSION['dwfck_client'] , $_SESSION['dwfck_grps'],1);   
   
        if($AUTH < 8) {         
            $msg="";
        	$sFileUrl = CombinePaths( GetResourceTypePath( $resourceType, $sCommand ) , $currentFolder ) ;
    	    $sFileUrl = CombinePaths( $sFileUrl, $_FILES['NewFile']['name']);       
            SendUploadResults( '203', $sFileUrl, $_FILES['NewFile']['name'],  $msg ) ;
            return;

         }
   }
    if(!$safe) {
        $currentFolder = encode_dir($currentFolder);
    }
	if ( isset( $_FILES['NewFile'] ) && !is_null( $_FILES['NewFile']['tmp_name'] ) )
	{
		global $Config ;

        $upload_err = $_FILES['NewFile']['error'];
        if($upload_err ) {
            send_ckg_UploadError($upload_err,$sFileUrl, $_FILES['NewFile']['name']);           
            exit;
        }
		$oFile = $_FILES['NewFile'] ;


		// Map the virtual path to the local server path.
		$sServerDir = ServerMapFolder( $resourceType, $currentFolder, $sCommand ) ; 

		// Get the uploaded file name.
		$sFileName = dwiki_encodeFN($oFile['name']) ;
        $sOriginalFileName = dwiki_encodeFN($sFileName);

		// Get the extension.
		$sExtension = substr( $sFileName, ( strrpos($sFileName, '.') + 1 ) ) ;
		$sExtension = strtolower( $sExtension ) ;
        $image_file = false;
		
        if(in_array($sExtension,$Config['AllowedExtensions']['Image'])) {
            $image_file=true;    
        }
 
		if ( isset( $Config['SecureImageUploads'] ) )
		{
			if ( ( $isImageValid = IsImageValid( $oFile['tmp_name'], $sExtension ) ) === false )
			{
				$sErrorNumber = '202' ;
			}
		}

		if ( isset( $Config['HtmlExtensions'] ) )
		{
			if ( !IsHtmlExtension( $sExtension, $Config['HtmlExtensions'] ) &&
				( $detectHtml = DetectHtml( $oFile['tmp_name'] ) ) === true )
			{
				$sErrorNumber = '202' ;
			}
		}
        
        $sFileName = Dwfck_sanitize($sFileName, $image_file);

		// Check if it is an allowed extension.
		if ( !$sErrorNumber && IsAllowedExt( $sExtension, $resourceType ) )
		{
			$iCounter = 0 ;

			while ( true )
			{                
                
                //$sFileName = strtolower($sFileName);
                
                if(!is_dir($sServerDir))
                {
                	if ( isset( $Config['ChmodOnFolderCreate'] ) && !$Config['ChmodOnFolderCreate'] )
					{
						mkdir_rek($sServerDir,$permissions);
					}
					else
					{
						$permissions = 0777 ;
						if ( isset( $Config['ChmodOnFolderCreate'] ) )
						{
							$permissions = $Config['ChmodOnFolderCreate'] ;
						}
						// To create the folder with 0777 permissions, we need to set umask to zero.
						$oldumask = umask(0) ;
						mkdir_rek($sServerDir,$permissions);
						umask( $oldumask ) ;
					}
                	
                }
               
				$sFilePath = $sServerDir . $sFileName ;


				if ( is_file( $sFilePath ) )
				{
					$iCounter++ ;
       			    $sFileName = RemoveExtension($sOriginalFileName) . '_' . $iCounter  . ".$sExtension" ;
                    $sFileName = Dwfck_sanitize($sFileName, $image_file);

					$sErrorNumber = '201' ;
				}
				else
				{
					move_uploaded_file( $oFile['tmp_name'], $sFilePath ) ;

					if ( is_file( $sFilePath ) )
					{
						if ( isset( $Config['ChmodOnUpload'] ) && !$Config['ChmodOnUpload'] )
						{
							break ;
						}

						$permissions = 0777;

						if ( isset( $Config['ChmodOnUpload'] ) && $Config['ChmodOnUpload'] )
						{
							$permissions = $Config['ChmodOnUpload'] ;
						}

						$oldumask = umask(0) ;
						chmod( $sFilePath, $permissions ) ;
						umask( $oldumask ) ;
					}

					break ;
				}
			}

			if ( file_exists( $sFilePath ) )
			{
				//previous checks failed, try once again
				if ( isset( $isImageValid ) && $isImageValid === -1 && IsImageValid( $sFilePath, $sExtension ) === false )
				{
					@unlink( $sFilePath ) ;
					$sErrorNumber = '202' ;
				}
				else if ( isset( $detectHtml ) && $detectHtml === -1 && DetectHtml( $sFilePath ) === true )
				{
					@unlink( $sFilePath ) ;
					$sErrorNumber = '202' ;
				}
			}
		}
		else
			$sErrorNumber = '202' ;
	}
	else
		$sErrorNumber = '202' ;


	$sFileUrl = CombinePaths( GetResourceTypePath( $resourceType, $sCommand ) , $currentFolder ) ;
	$sFileUrl = CombinePaths( $sFileUrl, $sFileName ) ;

	SendUploadResults( $sErrorNumber, $sFileUrl, $sFileName ) ;

	exit ;
}

function mkdir_rek($dir, $mode = 0777)
{
 global $Config; 
    if($Config['osWindows']) $dir=normalizeWIN($dir);  
	if (!is_dir($dir))	{        
		mkdir_rek(dirname($dir), $mode);
		mkdir($dir, $mode);

	}
}

function send_ckg_UploadError($err,$sFileUrl, $file) {
    switch($err) {
        
        case UPLOAD_ERR_INI_SIZE:
            $msg = "The uploaded file exceeds the upload_max_filesize directive in php.ini.";
            break;
            
        case UPLOAD_ERR_FORM_SIZE:
        $msg = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.";
        break;
        
        case UPLOAD_ERR_PARTIAL:
            $msg = "The uploaded file was only partially uploaded.";
            break;
            
        case UPLOAD_ERR_NO_FILE:
            $msg = "No file was uploaded.";
            break;

       case 6:       //   UPLOAD_ERR_NO_TMP_DIR  Introduced in PHP 4.3.10 and PHP 5.0.3.
            $msg = "Missing a temporary folder.";
            break;
        
       case 7:  //UPLOAD_ERR_CANT_WRITE  Introduced in PHP 5.1.0.
            $msg="Failed to write file to disk.";
            break;
       
        case 8: //UPLOAD_ERR_EXTENSION   Introduced in PHP 5.2.0. 
            $msg="PHP does not provide a way to ascertain which extension caused the file upload to stop; examining the list of loaded extensions with phpinfo() may help.";
            break;
           
        default:
           $msg = "Undetermined  upload error";
           break;
    }     
      $upload_error = 300 + $err;
       SendUploadResults( $upload_error, $sFileUrl, $file,  $msg ) ;
      
}   

function can_delete(&$class) {
   global $_FolderClass;
   if($_FolderClass >=16) $class = 'd'; 
}

function cmd_write_debug($what) {
return;
if(is_array($what)) {
   $what = print_r($what,true);
}
$dwfckFHandle = fopen("fbrowser_dbg.txt", "a");
fwrite($dwfckFHandle, "$what\n");
fclose($dwfckFHandle);
}
?>
