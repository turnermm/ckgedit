<?php
/**
 *
 * @license GPL 2 http://www.gnu.org/licenses/gpl-2.0.html
 * @author  Andreas Valder <valder@isf.rwth-aachen.de>
 */

// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();
class action_plugin_ckgedit_tagapi extends DokuWiki_Action_Plugin {
  private $tagplugin = null;
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
      if ($event->data !== 'tagapi_list') {
        return;
      }
      $event->stopPropagation();
      $event->preventDefault();

      if ($this->tagplugin = $this->loadHelper('tag')) {
        $tags = $this->tagplugin->tagOccurrences(array(), NULL, true);
        $a = print_r($tags,true);
       // file_put_contents(DOKU_INC . 'tags.txt', $a);
      } else {
        $tags = array();
      }

      // sort tags by name ($tags is in the form $tag => $count)
      ksort($tags);
      echo '{"tags":[';
      $firstelement = true;
      foreach (array_keys($tags) as $tag) {
        if ($firstelement) {
          $firstelement = false;
        } else {
          echo ',';
        }
        echo '{"name":"'.$this->tagToName($tag).'","id":"'.$tag.'"}';
      }
      echo']}';
    }

    private function tagToName($t) {
      $exists = false;
      $id = $t;
      resolve_pageID($this->tagplugin->namespace, $id, $exists);
      $name = p_get_first_heading($id, false);
      if (empty($name)) {
        $name = $t;
      } else {
        $name = $name;
      }
      return $name;
    }
}