<?php
$meta['groups'] = array('multichoice','_choices' => array('ANY'));
$meta['guest_toolbar'] = array('onoff');
$meta['guest_media'] = array('onoff');
$meta['open_upload'] = array('onoff');
#$meta['xcl_plugins'] = array('string');
$meta['default_fb'] = array('multichoice','_choices' => array('none','acl'));
$meta['openfb'] = array('onoff');
$meta['dw_edit_display'] = array('multichoice','_choices' => array('all','admin','none'));
$meta['smiley_as_text'] = array('onoff');
$meta['editor_bak'] = array('onoff');
$meta['create_folder'] = array('multichoice','_choices' => array('n','y'));
$meta['dwedit_ns'] = array('string');
$meta['acl_del'] = array('onoff');
$meta['auth_ci'] = array('onoff');
$meta['nix_style'] = array('onoff');
$meta['no_symlinks'] = array('onoff');
$meta['direction'] = array('multichoice','_choices' => array('nocheck','dokuwiki','ltr','rtl'));#
$meta['scayt_auto'] = array('multichoice','_choices' => array('on','off'));
$meta['scayt_lang'] = array('multichoice','_choices' => array('American English/en_US','Brazilian Portuguese/pt_BR','British English/en_GB','Canadian English/en_CA','Canadian French/fr_CA','Danish/da_DK','Dutch/nl_NL','Finnish/fi_FI','French/fr_FR','German/de_DE','Greek/el_GR','Italian/it_IT', 'Norwegian/nb_NO','Portuguese/pt_PT', 'Spanish/es_ES','Swedish/sv_SE'));
$meta['complex_tables'] = array('onoff');
$meta['duplicate_notes'] = array('onoff');
$meta['smiley_hack'] = array('onoff');
$meta['winstyle'] = array('onoff');
$meta['dw_priority'] = array('onoff');
$meta['other_lang'] = array('multichoice','_choices' => array('default','af','ar','bg','bn','bs','ca','cs','cy','da',
                                                             'de','el','en-au','en-ca','en-gb','en','eo','es','et','eu','fa','fi','fo','fr-ca','fr','gl','gu','he','hi','hr','hu',
                                                             'is','it','ja','ka','km','ko','ku','lt','lv','mk','mn','ms','nb','nl','no','pl','pt-br','pt','ro','ru','sk','sl','sr',
                                                             'sr-latn','sv','th','tr','ug','uk','vi','zh-cn','zh'));
$meta['preload_ckeditorjs']  = array('onoff'); 
$meta['color_options'] = array('onoff');
$meta['font_options'] = array('onoff');
$meta['nofont_styling'] = array('onoff');
$meta['alt_toolbar']  = array('multicheckbox','_choices' => array( 'HorizontalRule', 'Smiley','SpecialChar', 'Signature' ,'Footnotes',  'Font','FontSize', 'Source', 'Maximize','Underline','Strike', 'Subscript','Superscript', 'Indent','Outdent', 'Link','Unlink','FontAssist'));
