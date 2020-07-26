<?php

if(!defined('DOKU_INC')) define('DOKU_INC',realpath(dirname(__FILE__).'/../../../').'/');
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'action.php');
require_once(DOKU_PLUGIN.'ckgedit/scripts/setsamesite.php');
class action_plugin_ckgedit_mediamanager extends DokuWiki_Action_Plugin {
    function __construct()
    {
        $this->setupLocale();
    }


    function register(Doku_Event_Handler $controller)
    {
        $controller->register_hook('MEDIAMANAGER_STARTED', 'AFTER', $this, 'mediaman_started');
        $controller->register_hook('MEDIA_UPLOAD_FINISH', 'BEFORE', $this, 'upload_finish');              
        $controller->register_hook('TPL_METAHEADER_OUTPUT', 'BEFORE', $this, 'handle_metafile');
    }

    function handle_metafile(Doku_Event $event) {
          $event->data['script'][] = 
            array( 
                'type'=>'text/javascript', 
                'charset'=>'utf-8', 
                '_data'=>'',
                 'src'=>DOKU_BASE.'lib/plugins/ckgedit/scripts/mediamgr.js'
            ) + ([ 'defer' => 'defer']);
    }
    
    function upload_finish(Doku_Event $event) {
        if(!preg_match("#^image/#",$event->data[3]) && $_COOKIE['ckgFbType'] == 'image') {
            if(!empty($event->data[3]) && strlen($event->data[3]) >30) {
                $fname = substr($event->data[3],0,29) . '. . .';                 
            }
            else $fname = $event->data[3];
            msg($this->getLang('mediamgr_imgonly') .  $fname);    
             setcookieSameSite('ckgFbType', 'image',time()-10);
            $event->preventDefault();
        }    
    }
    
    function mediaman_started(Doku_Event $event) {
        if ($_GET["onselect"] == "ckg_edit_mediaman_insert") {
            setcookieSameSite('ckgFbType', 'image');
        } else if ($_GET["onselect"] == "ckg_edit_mediaman_insertlink") {
            setcookieSameSite('ckgFbType', 'link');
        }
    }
}
