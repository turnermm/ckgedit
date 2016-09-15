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
        $controller->register_hook('MEDIA_UPLOAD_FINISH', 'BEFORE', $this, 'upload_finish');              
    }

    function upload_finish($event) {
        if(!preg_match("#^image/#",$event->data[3]) && $_COOKIE['ckgFbType'] == 'image') {
            msg($this->getLang('mediamgr_imgonly')  .$event->data[3] );
           $event->preventDefault() ;
        }    
    }
    
    function mediaman_started($event) {
        if ($_GET["onselect"] == "ckg_edit_mediaman_insert") {
            setcookie('ckgFbType', 'image');
        } else if ($_GET["onselect"] == "ckg_edit_mediaman_insertlink") {
            setcookie('ckgFbType', 'link');
        }

        echo '<script type="text/javascript">
        if (opener != null && opener.CKEDITOR !== undefined) {
            window.onload = function () {
                jQuery( document ).ready(function() {
                    if ((location.search.split("ckg_media=")[1]||"").split("&")[0] == "link") {
                        jQuery(".select").on("click", function(event) {
                            var $link, id;

                            event.preventDefault();

                            $link = jQuery(this);
                            id = $link.attr("id").substr(2);

                            dw_mediamanager.insert(id);
                            return;
                        });
                    } else if ((location.search.split("ckg_media=")[1]||"").split("&")[0] == "img") {
                        jQuery("#media__linkbtn4").css("display", "none");
                        ckg_nonimage_overlay();
                    }
                });

                jQuery(document).ajaxComplete(function() {
                    ckg_nonimage_overlay();
                });
            };
        }

        function ckg_nonimage_overlay() {
            if ((location.search.split("ckg_media=")[1]||"").split("&")[0] !== "img") {
                return;
            }

            jQuery( ".odd, .even" ).each( function( index, element ){
                if(!this.title.match(/\.(jpg|jpeg|png|tiff?|gif)$/)){
                    jQuery( this ).html(LANG.plugins.ckgedit.mediamgr_notice+": <b>" + this.title  +"</b>");
                }
            });
        }
        </script>';
    }
}
