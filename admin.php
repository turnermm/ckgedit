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
        case 'hello' : $this->output = 'again'; break;
        case 'goodbye' : $this->output = 'goodbye'; break;
	    case 'stylesheet' : {
			//msg('stylesheet');
			$this->output = 'style_sheet_msg';
			break;
		}
      }    

	
    }
 
    /**
     * output appropriate html
     */
    function html() {
	 ptln('<p>'.htmlspecialchars($this->getLang($this->output)). " " .$this->template.'</p>');
 
      ptln('<form action="'.wl($ID).'" method="post">'); 
      // output hidden values to ensure dokuwiki will return back to this plugin
      ptln('  <input type="hidden" name="do"   value="admin" />');
      ptln('  <input type="hidden" name="page" value="'.$this->getPluginName().'" />');
      formSecurityToken();
 
      ptln('  <input type="submit" name="cmd[hello]"  value="'.$this->getLang('btn_hello').'" />');
      ptln('  <input type="submit" name="cmd[goodbye]"  value="'.$this->getLang('btn_goodbye').'" />');
	  ptln('  <input type="submit" name="cmd[stylesheet]"  value="'.$this->getLang('style_sheet').'" />');
      ptln('</form>');   
	  $path = $this->tpl_inc;
	  $messages = array(
		  "Stylesheet saved to $path" . 'Styles/_style.css',
		  "Failed to save stylesheet to $path" . 'Styles/_style.css'		  
		  );
	  if($this->output && $this->output == 'style_sheet_msg') {	  
		  ptln('<p>'.htmlspecialchars($this->getLang($this->output)). " " .$this->template.'</p>');	  
		  $retv = css_ckg_out($path);
		  $color = $retv == 0? '#333': 'blue';
		  ptln('<span style = "color:'.$color. ';">'.htmlspecialchars($messages[$retv]).'</span>');
      }
    }


}	