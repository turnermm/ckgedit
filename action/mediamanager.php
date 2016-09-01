<?php

if(!defined('DOKU_INC')) define('DOKU_INC',realpath(dirname(__FILE__).'/../../../').'/');
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'action.php');

class action_plugin_ckgedit_mediamanager extends DokuWiki_Action_Plugin {
    function __construct()
    {
        $this->setupLocale();
    }


    function register(Doku_Event_Handler $controller)
    {
        $controller->register_hook('MEDIAMANAGER_STARTED', 'AFTER', $this, 'mediaman_started');
    }
    
    function mediaman_started($event) {
        echo '<script type="text/javascript">window.onload = function () {
        dw_mediamanager.insert = function (id) {
        var opts, alignleft, alignright, edid, s;

        // set syntax options
        dw_mediamanager.$popup.dialog(\'close\');

        opts = \'\';
        alignleft = \'\';
        alignright = \'\';

        if ({img: 1, swf: 1}[dw_mediamanager.ext] === 1) {

            if (dw_mediamanager.link === \'4\') {
                    opts = \'?linkonly\';
            } else {

                if (dw_mediamanager.link === "3" && dw_mediamanager.ext === \'img\') {
                    opts = \'?nolink\';
                } else if (dw_mediamanager.link === "2" && dw_mediamanager.ext === \'img\') {
                    opts = \'?direct\';
                }

                s = parseInt(dw_mediamanager.size, 10);

                if (s && s >= 1 && s < 4) {
                    opts += (opts.length)?\'&\':\'?\';
                    opts += dw_mediamanager.size + \'00\';
                    if (dw_mediamanager.ext === \'swf\') {
                        switch (s) {
                        case 1:
                            opts += \'x62\';
                            break;
                        case 2:
                            opts += \'x123\';
                            break;
                        case 3:
                            opts += \'x185\';
                            break;
                        }
                    }
                }
                if (dw_mediamanager.align !== \'1\') {
                    alignleft = dw_mediamanager.align === \'2\' ? \'\' : \' \';
                    alignright = dw_mediamanager.align === \'4\' ? \'\' : \' \';
                }
            }
        }
        edid = String.prototype.match.call(document.location, /&edid=([^&]+)/);
        //opener.insertTags(edid ? edid[1] : \'wiki__text\',\'{{\'+alignleft+id+opts+alignright+\'|\',\'}}\',\'\');

        var funcNum = (location.search.split(\'CKEditorFuncNum=\')[1]||\'\').split(\'&\')[0];
            var fileUrl = DOKU_BASE + \'/lib/exe/fetch.php/\' + alignleft + id;
            opener.CKEDITOR.tools.callFunction( funcNum, fileUrl);
        
        if(!dw_mediamanager.keepopen) {
            window.close();
        }
        opener.focus();           
        return false;
        
        
    };
    };</script>';
    }
}