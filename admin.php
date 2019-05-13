<?php


/**
 *   @author Myron Turner <turnermm02@shaw.ca>
 *   @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
*/

require_once(DOKU_INC . 'lib/plugins/ckgedit/scripts/css6.php');
class admin_plugin_ckgedit extends DokuWiki_Admin_Plugin {

	private $tpl_inc;
	private $template;	
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
      // msg(print_r($_REQUEST,1));
       switch (key($_REQUEST['cmd'])) {
	    case 'stylesheet' : {
			$this->output = 'style_sheet_msg';
			break;
		}
	    case 'alt_stylesheet' : {	
			$this->alt = $_REQUEST['alt_stylesheet'];			
			$this->output = 'alt_style_sheet_msg';
			break;
		}	
      }    

	
    }
 
    /**
     * output appropriate html
     */
    function html() {
      ptln('<form action="'.wl($ID).'" method="post">'); 
      // output hidden values to ensure dokuwiki will return back to this plugin
      ptln('  <input type="hidden" name="do"   value="admin" />');
      ptln('  <input type="hidden" name="page" value="'.$this->getPluginName().'" />');
      formSecurityToken();
	  ptln('<p style = "line-height: 200%;">Create a style sheet for the current template: (' .$this->template . ')<br />');
	  ptln('<input type="submit" name="cmd[stylesheet]"  value="'.$this->getLang('style_sheet').'" /></p>');	  
	  $alt_val = isset($this->alt)?$this->alt: "" ;
	  ptln('<p style = "line-height: 200%;">' . $this->getLang('alt_stylesheet') .'<br />');
      ptln('<input type = "text" name = "alt_stylesheet" value ="'.$alt_val.'">&nbsp;&nbsp;');
	  ptln('<input type="submit" name="cmd[alt_stylesheet]"  value="'.$this->getLang('style_sheet').'" /></p>');
 
      ptln('</form>');   
	  $path = $this->tpl_inc;
	  $messages = array(
		  "Stylesheet saved to $path" . 'Styles/_style.css',
		  "Failed to save stylesheet to $path" . 'Styles/_style.css'		  
		  );
	  ptln('<p>');	  
	  if($this->output && $this->output == 'style_sheet_msg') {	  
		  ptln(htmlspecialchars($this->getLang($this->output)). " " .$this->template);	  
		  $retv = css_ckg_out($path);
		  $color = $retv == 0? '#333': 'blue';
		  ptln('<br /><span style = "color:'.$color. ';">'.htmlspecialchars($messages[$retv]).'</span>');
      }
	   if($this->output && $this->output == 'alt_style_sheet_msg') {		  
	     ptln(htmlspecialchars($this->getLang($this->output)). " " .$this->alt);
		$tmpl = str_replace('tpl/'.$this->template, 'tpl/'.$this->alt,$this->tpl_inc);
	    echo  "<br />" .  $tmpl;
	   }
	  
	  ptln('</p>');
    }


}	