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

ob_start() ;
function getAccessNum () { 
  usleep(300);
  return microtime(true);

}
require('./config.php') ;
require('./util.php') ;
require('./io.php') ;
require('./basexml.php') ;
require('./commands.php') ;
require('./phpcompat.php') ;
require_once('./SafeFN.class.php');

if ( !$Config['Enabled'] )
	SendError( 1, 'FileBrowserError_Connector') ;


DoResponse() ;

function DoResponse()
{
	
	
    if (!isset($_GET)) {
        global $_GET;
    }
    

    
	if ( !isset( $_GET['Command'] ) || !isset( $_GET['Type'] ) || !isset( $_GET['CurrentFolder'] ) )
		return ;


		
	// Get the main request informaiton.
	$sCommand		= $_GET['Command'] ;
	$sResourceType	= $_GET['Type'] ;
	$sCurrentFolder	= GetCurrentFolder() ;

	// Check if it is an allowed command
	if ( ! IsAllowedCommand( $sCommand ) )
		SendError( 1, 'FileBrowserError_Command' . ';;' . $sCommand ) ;
	
	// Check if it is an allowed type.
	if ( !IsAllowedType( $sResourceType ) )
		SendError( 1, 'FileBrowserError_Type'  . ';;' . $sResourceType) ;
   
	
	// File Upload doesn't have to Return XML, so it must be intercepted before anything.
	if ( $sCommand == 'FileUpload' )
	{
		FileUpload( $sResourceType, $sCurrentFolder, $sCommand ) ;
		return ;
	}
	
	if ( $sCommand == 'GetDwfckNs' )
	{
		GetDwfckNs();
		return;		
	}

		

	CreateXmlHeader( $sCommand, $sResourceType, $sCurrentFolder ) ;


	
	// Execute the required command.
	switch ( $sCommand )
	{
		case 'GetFolders' :
			GetFolders( $sResourceType, $sCurrentFolder ) ;
			break ;
		case 'GetFoldersAndFiles' :
			GetFoldersAndFiles( $sResourceType, $sCurrentFolder ) ;
			break ;
		case 'CreateFolder' :
			CreateFolder( $sResourceType, $sCurrentFolder ) ;
			break ;
        case 'UnlinkFile' :
            UnlinkFile($sResourceType, $sCurrentFolder, $sCommand, $_GET['file']);
            break;

	}

	CreateXmlFooter() ;

	exit ;
}
?>
