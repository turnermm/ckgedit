<?php
/**
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author  
 */

// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();
include_once (DOKU_INC . 'inc/confutils.php');
class action_plugin_ckgedit_iwiki extends DokuWiki_Action_Plugin {
  private $interlinks = null;
    /**
     * Registers a callback function for a given event
     *
     * @param Doku_Event_Handler $controller DokuWiki's event controller object
     * @return void
     */
    public function register(Doku_Event_Handler $controller) {

       $controller->register_hook('AJAX_CALL_UNKNOWN', 'BEFORE', $this, 'handle_ajax_call_unknown');
   
    }

    /**
     * @param Doku_Event $event  event object by reference
     * @param mixed      $param  [the parameters passed as fifth argument to register_hook() when this
     *                           handler was registered]
     * @return void
     */

    public function handle_ajax_call_unknown(Doku_Event &$event, $param) {
     
      if ($event->data !== 'iwiki_list') {
        return;
      }
   
      $event->stopPropagation();
      $event->preventDefault();
      $a = getInterwiki();
      ksort($a);
      echo json_encode($a);       
    }

}
