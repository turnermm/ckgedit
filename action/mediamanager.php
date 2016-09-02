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
        //used by dokuwiki editor
        var opts, alignleft, alignright, edid, s;
        //used by CKEditor
        var link, align, width;

        // set syntax options
        dw_mediamanager.$popup.dialog(\'close\');

        opts = \'\';
        alignleft = \'\';
        alignright = \'\';

        if ({img: 1, swf: 1}[dw_mediamanager.ext] === 1) {

            if (dw_mediamanager.link === \'4\') {
                    opts = "?linkonly";
                    link = "linkonly";
            } else {

                if (dw_mediamanager.link === "3" && dw_mediamanager.ext === \'img\') {
                    opts = "?nolink";
                    link = "nolink";
                } else if (dw_mediamanager.link === "2" && dw_mediamanager.ext === \'img\') {
                    opts = "?direct";
                    link = "direct";
                } else {
                    link = "detail";
                }

                s = parseInt(dw_mediamanager.size, 10);
                width = s*200;
                if (s && s >= 1 && s < 4) {
                    opts += (opts.length)?\'&\':\'?\';
                    opts += dw_mediamanager.size + "00";
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
                switch (dw_mediamanager.align) {
                case "1":
                    align = "";
                    break;
                case "2":
                    align = "medialeft";
                    break;
                case "3":
                    align = "mediacenter";
                    break;
                case "4":
                    align = "mediaright";
                    break;
                default:
                    align = "baseline";
                    break;
                }
            }
        }
        edid = String.prototype.match.call(document.location, /&edid=([^&]+)/);

        var funcNum = (location.search.split(\'CKEditorFuncNum=\')[1]||\'\').split(\'&\')[0];
            var fileUrl = DOKU_BASE + \'/lib/exe/fetch.php/\' + alignleft + id;
            opener.CKEDITOR.tools.callFunction( funcNum, fileUrl, function() {
                var dialog = this.getDialog();
                if ( dialog.getName() == "image" ) {
                    if (align != null) {
                        dialog.getContentElement("info", "cmbAlign").setValue(align);
                    }
                    if (link != null) {
                        dialog.getContentElement("info", "cmbLinkType").setValue(link);
                    }
                    if (width != null) {
                        dialog.getContentElement("info", "txtWidth").setValue(width);
                        dialog.dontResetSize = true;
                    }
                }
            });
        
        if(!dw_mediamanager.keepopen) {
            window.close();
        }
        opener.focus();           
        return false;
        
        
    };
    };</script>';
    }
}
