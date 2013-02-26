<?php
if(!defined('DOKU_INC')) define('DOKU_INC',realpath(dirname(__FILE__).'/../../../').'/');
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'action.php');
define('FCK_ACTION_SUBDIR', realpath(dirname(__FILE__)) . '/');
/**
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 */

class action_plugin_fckg_save extends DokuWiki_Action_Plugin {
    /**
     * Constructor
     */
    function action_plugin_fckg_save(){
    }



    function register(&$controller) {
  
        $controller->register_hook('DOKUWIKI_STARTED', 'BEFORE', $this, 'fckg_save_preprocess');
    }

    function fckg_save_preprocess(&$event){
        global $ACT;
        if (!isset($_REQUEST['fckg']) || ! is_array($ACT) || !(isset($ACT['save']) || isset($ACT['preview']))) return;
     
        global $TEXT;
        if (!$TEXT) return;

        $TEXT = $_REQUEST['fck_wikitext'];
        
        if(!preg_match('/^\s+(\-|\*)/',$TEXT)) {    
              $TEXT = trim($TEXT);
        }


      $TEXT = str_replace('%%', "FCKGPERCENTESC",  $TEXT);
     
          $TEXT = preg_replace_callback('/^(.*?)(\[\[.*?\]\])*(.*?)$/ms', 
               create_function(
                     '$matches',         
                     '$matches[1] = preg_replace("/%([A-F]+)/i", "URLENC_PERCENT$1", $matches[1]);
                      $matches[3] = preg_replace("/%([A-F]+)/i", "URLENC_PERCENT$1", $matches[3]);
                      return $matches[1].$matches[2].$matches[3];'            
                ),
                $TEXT
             );
        

        $TEXT = rawurldecode($TEXT);
        $TEXT = preg_replace('/NOWIKI_(.)_/', '$1',$TEXT);
        $TEXT = preg_replace('/URLENC_PERCENT/', '%',$TEXT); 
          /* preserve newlines in code blocks */
          $TEXT = preg_replace_callback(
            '/(<code>|<file>)(.*?)(<\/code>|<\/file>)/ms',
            create_function(
                '$matches',         
                'return  str_replace("\n", "__code_NL__",$matches[0]);'
            ),
            $TEXT
          );

        $TEXT = preg_replace('/^\s*[\r\n]$/ms',"__n__", $TEXT);
        $TEXT = preg_replace('/\r/ms',"", $TEXT);
        $TEXT = preg_replace('/^\s+(?=\^|\|)/ms',"", $TEXT);    
        $TEXT = preg_replace('/__n__/',"\n", $TEXT);
        $TEXT = str_replace("__code_NL__","\n", $TEXT);
        $TEXT = str_replace("FCKGPERCENTESC", '%%',  $TEXT);
        $TEXT .= "\n";
        // Removes relics of markup characters left over after acronym markup has been removed
        //$TEXT = preg_replace('/([\*\/_]{2})\s+\\1\s*([A-Z]+)\s*\\1+/ms',"$2",$TEXT);
      
         $pos = strpos($TEXT, 'MULTI_PLUGIN_OPEN');
         if($pos !== false) {
            $TEXT = preg_replace_callback(
             '|MULTI_PLUGIN_OPEN.*?MULTI_PLUGIN_CLOSE|ms',
             create_function(
                 '$matches',
                   'return  preg_replace("/\\\\\\\\/ms","\n",$matches[0]);'
             ),
             $TEXT
           );

            $TEXT = preg_replace_callback(
             '|MULTI_PLUGIN_OPEN.*?MULTI_PLUGIN_CLOSE|ms',
             create_function(
                 '$matches',
                   'return  preg_replace("/^\s+/ms","",$matches[0]);'
             ),
             $TEXT
           );

         }
 
        $this->replace_entities();

     
         return;
    
    }

function replace_entities() {
global $TEXT;
global $ents;
    $serialized = FCK_ACTION_SUBDIR . 'ent.ser';
    $ents = unserialize(file_get_contents($serialized));

       $TEXT = preg_replace_callback(
            '|(&(\w+);)|',
            create_function(         
                '$matches',
                'global $ents; return $ents[$matches[2]];'
            ),
            $TEXT
        );
    
}


function write_debug($data) {
return;
  if (!$handle = fopen('save.txt', 'a')) {
    return;
    }

    // Write $somecontent to our opened file.
    fwrite($handle, "save.php: $data\n");
    fclose($handle);

}
} //end of action class
?>
