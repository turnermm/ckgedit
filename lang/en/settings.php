<?php

$lang['groups'] = "Group allowed to disable lock timer (deprecated)";
$lang['fck_preview'] = "FCK Preview Group";
$lang['guest_toolbar'] = "Display Toolbar to Guests";
$lang['guest_media'] = "Guest Can Link to Media Files";
$lang['open_upload'] = "Guest Can Upload";
$lang['default_fb'] = "Default file-browing access. With none, acl does not apply.";
$lang['openfb'] = "Open File Browsing. This gives user access to entire directory structure, whether or not the user has permissions. ACL still applies to uploads.";
$lang['dw_edit_display'] = 'Controls which users have access to the "DW Edit" button. Choices: "all" for all users; "admin" for admin and managers only; "none" for no one. Defaults to "all".';
$lang['smiley_as_text']  = 'Display smileys as text in CKeditor (will still display as image in browser)';
$lang['editor_bak'] = "Save backup to meta/&lt;namespace&gt;.ckgedit";
$lang['create_folder'] = "Enable folder creation button in file browser (y/n)";
$lang['dwedit_ns'] = "Comma separated list of namespaces and/or pages where ckgedit automatically switches " .
                     "over to the native DokuWiki Editor; accepts partial matches."; 
$lang['acl_del'] =  "Default (box not checked) allows users with upload permission to delete media files; if box is checked, then user needs delete permission to delete from the folder.";
$lang['auth_ci'] = "The user login id is case insensitive, that is you can login as both USER and user";
$lang['nix_style'] = "For Windows Servers (Vista and Later).  This setting makes it possible to access data\\media through ckgedit\\CKeditor\\userfiles, if links to media and file have been successfully created in userfiles";
$lang['no_symlinks']  = "Disable automatic creation of symbolic links in ckgedit/userfiles.";            
$lang['direction'] = 'Set Language direction in CKeditor:  <b>nocheck</b>: ckgedit will make no changes to the default direction setting; ' 
                       . ' <b>dokuwiki</b>:  the current Dokuwiki language direction;  <b>ltr</b>: Left-to-right ; <b>rtl</b>: Right-to-left.';
$lang['scayt_auto'] = 'Automatically enable the SCAYT spellchecker. Defaults to "on". To turn off SCAYT select "off"';
$lang['scayt_lang']="Set SCAYT default language.";
$lang['smiley_hack'] = "Reset URL for CKeditor's smilies when moving to new server. This is done on a page by page basis when page is loaded for editing and saved.  This option should normally be turned off.";
$lang['complex_tables'] ="Use the complex tables algorithm.  As opposed to the standard parsing of tables, this should give better results when mixing complex arrangements of rowspans and colspans. But slightly more processing time.";
$lang['duplicate_notes'] = "Set this to true if users create multiple footnotes with the same footnote texts; required to prevent notes from being corrupted.";
$lang['winstyle'] = 'Use direct path to media directory instead of fckeditor/userfiles. This function copies <br />fckeditor/userfiles/.htaccess.security to data/media/.htaccess; if not, this should be done manually';
$lang['other_lang'] = 'Your default language for the CKEditor is the language set for your browser.   You can, however, choose another language here; it is independent of the Dokuwiki interface language.';
$lang['dw_priority'] = "Make Dokuwiki editor the default editor: does not work in farms"; 
$lang['preload_ckeditorjs'] = "Preload the ckeditor's javascript to speed up subsequent loading of editor";
$lang['nofont_styling']  = 'Display font styles in editor as plugin markup. See the ckgedit plugin page at Dokuwiki.org for details.';
$lang['font_options']  = 'Remove font options.';
$lang['color_options']  = 'Remove Color options.';
$lang['alt_toolbar'] = 'Functions to remove from CKEditor toolbar.<br /><br /> Any other functions can be removed by including them as a comma separated list in the text box:<br /><br />' . 
         'Bold, Italic, Underline, Strike, Subscript, Superscript, RemoveFormat, Find, Replace, SelectAll, Scayt, '  .     
         'Image, Table, Tags, Link, Unlink, Format, Styles,TextColor, BGColor, NumberedList, BulletedList, ' .
         'Cut, Copy, Paste, PasteText, PasteFromWord, Undo, Redo, Source, Maximize, About.';
 
$lang['mfiles'] = 'Enable mfile support';
$lang['extra_plugins']  = "Comma separated list of additional Ckeditor plugins to be added to toolbar.  See ckgedit plugin's <a href='https://www.dokuwiki.org/plugin:ckgedit:configuration#extra_plugins'>config page</a>  for details";
$lang['dw_users'] = "Group name of users whose editor defaults to Dokuwiki editor when <b>dw_priority</b> is slected.  If  not defined, then all users get the native Dokuwiki editor when <b>dw_priority</b> is selected.";

