<?php
define('FCK_ACTION_SUBDIR', realpath(dirname(__FILE__)) . '/../action/');

     global $wiki_text;
    // file_put_contents('save_ref.txt', print_r($_REQUEST,true));

       $wiki_text = urldecode($_REQUEST['wikitext']);
             
        if(!preg_match('/^\s+(\-|\*)/',$wiki_text)){     
              $wiki_text = trim($wiki_text);
        }
 
          /* preserve newlines in code blocks */
          $wiki_text = preg_replace_callback(
            '/(<code>|<file>)(.*?)(<\/code>|<\/file>)/ms',
            create_function(
                '$matches',         
                'return  str_replace("\n", "__code_NL__",$matches[0]);'
            ),
            $wiki_text
          );

        $wiki_text = preg_replace('/^\s*[\r\n]$/ms',"__n__", $wiki_text);
        $wiki_text = preg_replace('/\r/ms',"", $wiki_text);
        $wiki_text = preg_replace('/^\s+(?=\^|\|)/ms',"", $wiki_text);    
        $wiki_text = preg_replace('/__n__/',"\n", $wiki_text);
        $wiki_text = str_replace("__code_NL__","\n", $wiki_text);

 
       $wiki_text .= "\n";
         

        $pos = strpos($wiki_text, 'MULTI_PLUGIN_OPEN');
        if($pos !== false) {
           $wiki_text = preg_replace_callback(
            '|MULTI_PLUGIN_OPEN.*?MULTI_PLUGIN_CLOSE|ms',
            create_function(
                '$matches',         
                  'return  preg_replace("/\\\\\\\\/ms","\n",$matches[0]);'
            ),
            $wiki_text
          );

           $wiki_text = preg_replace_callback(
            '|MULTI_PLUGIN_OPEN.*?MULTI_PLUGIN_CLOSE|ms',
            create_function(
                '$matches',         
                  'return  preg_replace("/^\s+/ms","",$matches[0]);'
            ),
            $wiki_text
          );

        }

     replace_entities();

     file_put_contents($_REQUEST['rsave_id'], $wiki_text);
     echo 'done';


exit;

function replace_entities() {
global $wiki_text;
global $ents;
    $serialized = FCK_ACTION_SUBDIR . 'ent.ser';
    $ents = unserialize(file_get_contents($serialized));

       $wiki_text = preg_replace_callback(
            '|(&(\w+);)|',
            create_function(         
                '$matches',
                'global $ents; return $ents[$matches[2]];'
            ),
            $wiki_text
        );
    
}
?>
	
