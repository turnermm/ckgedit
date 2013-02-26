<?php

$lang['groups'] = "Group allowed to disable lock timer (deprecated)";
$lang['middot'] = "Comma delimited list of groups using &amp;middot; for &amp;nbsp;";
$lang['big_files'] = "Check to safely edit oversized files";
$lang['big_file_sz'] = "Oversized File Size (bytes)";
$lang['big_file_tm'] = "Oversized File processing will time out after (seconds):";
$lang['fck_preview'] = "FCK Preview Group";
$lang['guest_toolbar'] = "Display Toolbar to Guests";
$lang['guest_media'] = "Guest Can Link to Media Files";
$lang['open_upload'] = "Guest Can Upload";
$list = plugin_list('syntax');
$list = implode  (", "  , $list);  
$lang['xcl_plugins'] ="Comma delimited list of Immutable Syntax plugins. " .
      "Their names should be exactly as appears in this list of Currently Installed Plugins: $list";
$lang['default_fb'] = "Default file-browing access. With none, acl does not apply.";
$lang['openfb'] = "Open File Browsing. This gives user access to entire directory structure, whether or not the user has permissions. ACL still applies to uploads.";
#$lang['csrf'] = "If you get a CSRF warning, check this box.";                     
$lang['dw_edit_display'] = 'Controls which users have access to the "DW Edit" button. Choices: "all" for all users; "admin" for admin and managers only; "none" for no one. Defaults to "all".';
$lang['smiley_as_text']  = 'Display smileys as text in FCKeditor (will still display as image in browser)';
$lang['editor_bak'] = "Save backup to meta/&lt;namespace&gt;.fckg";
$lang['create_folder'] = "Enable folder creation button in file browser (y/n)";
$lang['dwedit_ns'] = "Comma separated list of namespaces where FckgLite automatically switches " .
                     "over to the native DokuWiki Editor."; 
$lang['acl_del'] =  "Default (box not checked) allows users with upload permission to delete media files; if box is checked, then user needs delete permission to delete from the folder.";
$lang['auth_ci'] = "The user login id is case insensitive, that is you can login as both USER and user";
$lang['nix_style'] = "For Windows Servers (Vista and Later).  This setting makes it possible to access data\\media through fckg\\fckeditor\\userfiles, if links to media and file have been successfully created in userfiles";
$lang['no_symlinks']  = "Disable automatic creation of symbolic links in fckg/userfiles.";            
$lang['direction'] = 'Set Language direction in FCKeditor:  <b>nocheck</b>: fckgLite will make no changes to the default direction setting; ' 
                       . ' <b>dokuwiki</b>:  the current Dokuwiki language direction;  <b>ltr</b>: Left-to-right ; <b>rtl</b>: Right-to-left.';
$lang['scayt_auto'] = 'Automatically enable the SCAYT spellchecker. Defaults to "on". To turn off SCAYT select "off"';
$lang['scayt'] = 'Use the SCAYT spellchecker. This defaults to "on"; selecting "off" will switch to the spellerpages checker';  
$lang['scayt_lang']="Set SCAYT default language.";
$lang['smiley_hack'] = "Reset URL for FCKeditor's smilies when moving to new server. This is done on a page by page basis when page is loaded for editing and saved.  This option should normally be turned off.";

