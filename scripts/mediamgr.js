      
      if (opener != null && opener.CKEDITOR !== undefined) {
            window.onload = function () {
                var _action = '?ns=&edid=wiki__text&onselect=ckg_edit_mediaman_insert&ckg_media=img&CKEditor=wiki__text&CKEditorFuncNum=1&langCode=en';
                
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

  	   
                jQuery("form[action]").each(function(index, val){
                var url = jQuery(this).attr('action'); 
                url = url + _action;              
                jQuery(this).attr('action',url); 
		     });
		        
				  
                jQuery(document).ajaxComplete(function() {
                    ckg_nonimage_overlay();
                    jQuery("form[action]").each(function(index, val){
                        var url = jQuery(this).attr('action'); 
                        url = url + _action;              
                        jQuery(this).attr('action',url); 
                        });            
                });
            };
            
           jQuery( ".odd, .even" ).each( function( index, element ){
                if(!this.title.match(/\.(jpg|jpeg|png|tiff?|gif)$/)){
                    jQuery( this ).html(LANG.plugins.ckgedit.mediamgr_notice+": <b>" + this.title  +"</b>");
                }
            });
        
        }

        function ckg_nonimage_overlay() {
            if ((location.search.split("ckg_media=")[1]||"").split("&")[0] !== "img") {
                return;
            }
        }    