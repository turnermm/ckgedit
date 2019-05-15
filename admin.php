<?php


/**
 *   @author Myron Turner <turnermm02@shaw.ca>
 *   @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
*/

require_once(DOKU_INC . 'lib/plugins/ckgedit/scripts/css6.php');
class admin_plugin_ckgedit extends DokuWiki_Admin_Plugin {

	private $tpl_inc;
	private $template;	
	private $alt;
    function __construct() {      
	    global $conf;
        $this->template = $conf['template']; 	
		$this->tpl_inc = tpl_incdir();         
	}

    function handle() {
 
      if (!isset($_REQUEST['cmd'])) return;   // first time - nothing to do
 
      $this->output = 'invalid';
	
      if (!checkSecurityToken()) return;
      if (!is_array($_REQUEST['cmd'])) return; 
 
       switch (key($_REQUEST['cmd'])) {
	    case 'stylesheet' : {
			$this->alt = "";
			$this->output = 'style_sheet_msg';
			break;
		}
	    case 'alt_stylesheet' : {	
            $this->alt = $_REQUEST['templates'];		
			$this->output = 'alt_style_sheet_msg';
			break;
		}	
      }    

	
    }
 
    /**
     * output appropriate html
     */
    function html() {
	  ptln('<div id = "ckg_styl_sheet" style = "display:none">');	
      echo $this->locale_xhtml('style');
	  ptln('</div>');
      ptln('<button type = "button" id = "Infobut" onclick="jQuery(\'#ckg_styl_sheet\').toggle(800,ckg_admininfo(this));">');
	  
	  echo $this->getLang('stylesheet_oinfo');
	  ptln('</button>');
		  
      ptln('<form action="'.wl($ID).'" method="post">'); 
      // output hidden values to ensure dokuwiki will return back to this plugin
      ptln('  <input type="hidden" name="do"   value="admin" />');
      ptln('  <input type="hidden" name="page" value="'.$this->getPluginName().'" />');
      formSecurityToken();
      
      //Current style sheet
	  ptln('<p style = "line-height: 200%;">' . $this->getLang('default_stylesheet') . ': (' .$this->template . ')<br />');
	  ptln('<label for="ckg_save_ss">' .$this->getLang('checkbox').'</label>');
	  ptln('<input type="checkbox" name="ckg_save_ss">&nbsp;&nbsp;'); 
	  ptln('<input type="submit" name="cmd[stylesheet]"  value="'.$this->getLang('style_sheet').'" /></p>');	  
      
      // Other style sheet
	  $alt_val = isset($this->alt)?$this->alt: "" ;
	  ptln('<p style = "line-height: 200%;">' . $this->getLang('alt_stylesheet') .'<br />');
      ptln('<select name="templates" style = "line-height:100%">');
      echo $this->templates( $alt_val );
      ptln('</select>');
	  ptln('<input type="submit" name="cmd[alt_stylesheet]"  value="'.$this->getLang('style_sheet').'" />');   
      ptln('</form></p>');   

	  if($this->output && $this->output == 'style_sheet_msg') {	  
          $path = $this->tpl_inc;     
		  ptln(htmlspecialchars($this->getLang($this->output)). " " .$this->template);	  
		  $retv = css_ckg_out($path);
          $this->message($path, $retv);

      }
 	 else  if($this->output && $this->output == 'alt_style_sheet_msg') {		  
	    ptln(htmlspecialchars($this->getLang($this->output)). " " .$this->alt);				
		$path = str_replace('tpl/'.$this->template, 'tpl/'.$this->alt,$this->tpl_inc);
        $retv = css_ckg_out($path,$this->alt);
        $this->message($path, $retv);
	   }
	  
    }

   function message($path, $which) {
      $messages = array(
		  "Stylesheet saved to $path" . 'Styles/_style.css',
		  "Failed to save stylesheet to $path" . 'Styles/_style.css'		
         );          
     	  $color = $which == 0? '#333': 'blue';
		   ptln('<br /><span style = "color:'.$color. ';">'.htmlspecialchars($messages[$which]).'</span>');
	  
   }
   
   function templates($selected="") {
   $dir = dirname($this->tpl_inc);
   $files = scandir($dir);
   $dir .= '/';
   $list = "<option value=''  >Select</option>";
   foreach ($files AS $file) {
       if($file == '.' || $file == '..' || $file == $this->template) continue;
       $entry = $dir . $file;
       if(!is_writable($entry)) continue;
       if(is_dir ($entry ) ) {
             if($file == $selected) {
                 $list .= "<option value='$file'  selected>$file</option>";
             }
            else   $list .= "<option value='$file'  >$file</option>";
       }       
   }

  return $list;
   } 
}	