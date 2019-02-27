<?php
if(!defined('DOKU_INC')) define('DOKU_INC',realpath(dirname(__FILE__).'/../../../').'/');
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
if(!defined('DOKU_MEDIA')) define('DOKU_MEDIA',DOKU_INC.'data/media/');
define ('BROKEN_IMAGE', DOKU_URL . 'lib/plugins/ckgedit/fckeditor/userfiles/blink.jpg?nolink&33x34');
require_once(DOKU_PLUGIN.'action.php');
define('FCK_ACTION_SUBDIR', realpath(dirname(__FILE__)) . '/');
/**
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 */

class action_plugin_ckgedit_save extends DokuWiki_Action_Plugin {
     var $helper = false;
    function register(Doku_Event_Handler $controller) {
  
        $controller->register_hook('DOKUWIKI_STARTED', 'BEFORE', $this, 'ckgedit_save_preprocess');
    }

    function ckgedit_save_preprocess(Doku_Event $event){
        global $ACT,$INPUT;
        $this->helper = $this->loadhelper('ckgedit');
        if (!isset($_REQUEST['ckgedit']) || ! is_array($ACT) || !(isset($ACT['save']) || isset($ACT['preview']))) return;
         if (isset($_REQUEST["fontdel"]) ) {
             msg($this->getLang("fontdel"),1);           
         }
         if (isset($_REQUEST["formatdel"]) ) {
             msg($this->getLang("formatdel"),1);           
         }         

         $img_size = $INPUT->int('broken_image');
         if($img_size) msg($this->getLang('broken_image') . $img_size/1000000 . 'M' ); 
      
       
        global $TEXT, $conf;
             
        if (!$TEXT) return;
        $preserve_enc = $this->getConf('preserve_enc');        
        $deaccent = $conf['deaccent'] == 0 ? false : true;
        $TEXT = $_REQUEST['fck_wikitext'];
        
        if(!preg_match('/^\s+(\-|\*)/',$TEXT)) {    
              $TEXT = trim($TEXT);
        }


  $TEXT = preg_replace_callback(
    '|\{\{data:(.*?);base64|ms',
      create_function(
        '$matches',
         'if(!preg_match("/image/",$matches[1])) {
          return "{{data:image/jpeg;base64";
         }
          return $matches[0];'
     ),$TEXT);
      
    if(strpos($TEXT,'data:image') !== false) {
        $TEXT = preg_replace_callback(
             '|\{\{(\s*)data:image\/(\w+;base64,\s*)(.*?)\?nolink&(\s*)\}\}|ms',
             create_function(
                '$matches',
                'list($ext,$base) = explode(";",$matches[2]);
                if($ext == "jpeg" || $ext == "tiff") $ext = "jpg";                    
                 if(function_exists("imagecreatefromstring") && !imagecreatefromstring (base64_decode($matches[3]))) {
                     msg("Clipboard paste: invalid $ext image format");
                     return "{{" . BROKEN_IMAGE .  "}}";
                 }                 
                  global $INFO,$conf;                 
                  $ns = getNS($INFO["id"]);                                    
                  $ns = trim($ns);
                  if(!empty($ns)) {                     
                      $ns = ":$ns:";
                       $dir = str_replace(":","/",$ns);                     
                  }
                  else {  // root namespace
                      $dir = "/";
                      $ns = ":";
                  }
                 $fn = md5($matches[3]) . ".$ext";
                 $path = $conf["mediadir"] . $dir .  $fn;   
                 @io_makeFileDir($path);
                 if(!file_exists($path)) {
                    @file_put_contents($path, base64_decode($matches[3]));
                      global $lang;
                     $id = $dir .  $fn;
                     $id = str_replace("/",":",$id);
                     addMediaLogEntry(time(), $id, DOKU_CHANGE_TYPE_CREATE, $lang["created"],"", null, strlen(base64_decode($matches[3])));
                 }
                 else {
                     msg("file for this image previousely saved",2);
                 }
                 $left = "{{";
                 $right = "}}";
                 if($matches[1]) $left .= $matches[1];
                 if($matches[4]) $right = $matches[4] . $right;
                 
                $retv = "$left" . $ns. $fn . "$right";              
                 return $retv;'
             ),
             $TEXT
             );
        }     
      $TEXT = str_replace('%%', "FCKGPERCENTESC",  $TEXT);
     
        if($deaccent || $preserve_enc) {
              $TEXT = preg_replace_callback('/^(.*?)(\[\[.*?\]\])*(.*?)$/ms', 
                   create_function(
                         '$matches',         
                         '$matches[1] = preg_replace("/%([A-F0-9]{1,3})/i", "URLENC_PERCENT$1", $matches[1]);
                         $matches[2] = preg_replace("/%([A-F0-9]{1,3})/i", "URLENC_PERCENT$1", $matches[2]);
                          $matches[3] = preg_replace("/%([A-F0-9]{1,3})/i", "URLENC_PERCENT$1", $matches[3]);
                          return $matches[1].$matches[2].$matches[3];'            
                    ),
                    $TEXT
                 );
        }
        
        $TEXT = rawurldecode($TEXT);
        $TEXT = preg_replace('/NOWIKI_%_NOWIKI_%_/', '%%',$TEXT);
        $TEXT = preg_replace('/URLENC_PERCENT/', '%',$TEXT); 
        $TEXT = preg_replace('/NOWIKI_(.)_/', '$1',$TEXT);
        
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
        $TEXT = preg_replace('/oIWIKIo|cIWIKIc/ms',"", $TEXT);
        $TEXT = preg_replace('/\r/ms',"", $TEXT);
        $TEXT = preg_replace('/^\s+(?=\^|\|)/ms',"", $TEXT);    
        $TEXT = preg_replace('/__n__/',"\n", $TEXT);
        $TEXT = str_replace("__code_NL__","\n", $TEXT);
        $TEXT = str_replace("FCKGPERCENTESC", '%%',  $TEXT);
        if($this->getConf('complex_tables')) {
            $TEXT = str_replace('~~COMPLEX_TABLES~~','',$TEXT);
        }
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
          $TEXT = str_replace("~~MULTI_PLUGIN_OPEN~~","~~MULTI_PLUGIN_OPEN~~\n",$TEXT);
         }

       if(strpos($TEXT,'L_PARgr') !== false) {        
            $TEXT = preg_replace_callback(
                 '|\(\((.*?)\)\)|ms',
                 create_function(
                     '$matches',
                       'return  "((" . trim($matches[1]) . "))"; '
                 ),
                 $TEXT
             );         
            $TEXT = str_replace('L_PARgr', '(',$TEXT);
            $TEXT = str_replace('R_PARgr', ')',$TEXT);
       } 
       
        $this->replace_entities();
 /*Remove urls from linkonly images inserted after second and additional saves, resulting in multiple urls  corrupting  HTML output */
        $TEXT = preg_replace("/\{\{http:\/\/.*?fetch.php\?media=(.*?linkonly.*?)\}\}/",'{{' . "$1" .'}}',$TEXT);
        $TEXT = str_replace('< nowiki >', '%%<nowiki>%%',$TEXT);

 
          $TEXT = preg_replace_callback(
           '#\[\[(.*?)\]\]#ms',
               function($matches){ 
                    if($this->helper->has_plugin('button') && strpos($matches[0], '[[{') === 0) {    
                        return $matches[0];
                    }
                    if(preg_match('/(doku|this)\s*>/',$matches[0])) return $matches[0]; // exclude dokuwiki's wiki links
                    global $ID, $conf;      
                    $qs = "";
                    if(preg_match("/\[\[http/",$matches[0])) return $matches[0];  //not an internal link
                      if(preg_match("#\[\[.*?\|\{\{.*?\}\}\]\]#", $matches[0],$matches_1)) {  // media file
                        if(!$this->getConf('rel_links')) { 
                            return $matches[0];
                        }
                      $link = explode('?',$matches[1]); 
                      list($link_id,$linktext) = explode('|', $link[0]); 
                      $current_id = $this->abs2rel($link_id,$ID); 
                      return preg_replace("#$link_id#",$current_id, $matches[0]);                      
                   }                
                
                   $link = explode('?',$matches[1]);
                   if($link[1]) {                       
                       $link_id = $link[0];
                       list($qs,$linktext) = explode('|', $link[1]);     
                   }
                   else list($link_id,$linktext) = explode('|', $link[0]);     
                   if($this->getConf('rel_links')) 
                      $current_id = $this->abs2rel($link_id,$ID); 
                    else  $current_id = $link_id;
                    if($qs) $current_id .= "?$qs";
                    
                   //as in _getLinkTitle in xhtml.php
                   if(useHeading('content')) {
                      $tmp_linktext = p_get_first_heading($link_id);
                      if(trim($linktext) == trim($tmp_linktext)) {
                          $linktext = "";
                      }
                   }  
                   $tmp_ar = explode(':',$link_id);
                   $tmp_id = array_pop($tmp_ar);
                   if(trim($linktext,'.: ' ) == trim($tmp_id,'.: ')) $linktext = "";
                              
                   $current_id = $current_id.'|'.$linktext;
                   return '[[' . $current_id .']]';
               },
           $TEXT
         );      
         
        if($this->getConf('rel_links')) {    
          $TEXT = preg_replace_callback(
           '#\{\{(\s*)(.*?)(\s*)\}\}#ms',
           function($matches) {              
                global $ID;
               $link = explode('?',$matches[2]);
               list($link_id,$linktext) = explode('|', $link[0]);          
               $rel = $this->abs2rel($link_id,$ID);
               if(!empty($link[1])) $rel .= '?' . $link[1];
               if(!empty($linktext)) $rel = $rel.'|'.$linktext;
               return '{{' .$matches[1] . $rel . $matches[3]  .'}}';
           },
           $TEXT
         );               
        }

/* 11 Dec 2013 see comment below        
Remove discarded font syntax    
*/
        $TEXT = preg_replace_callback(
            '|_REMOVE_FONTS_START_(.*?)_REMOVE_FONTS_END_|ms',
            create_function(
                '$matches',
                '$matches[1] = preg_replace("/<font.*?>/ms","",$matches[1]);
                 return preg_replace("/<\/font>/ms","",$matches[1]);'
            ),
            $TEXT
        );

 /* 
6 April 2013
Removed newlines and spaces from beginnings and ends of text enclosed by font tags.  Too subtle for javascript. 
 */
        $TEXT = preg_replace_callback(
         '|(<font.*?>)(.*?)(?=</font>)|ms',
         create_function(
             '$matches',
               '$matches[2]=preg_replace("/^\s+/ms","",$matches[2]);
               $matches[2]=preg_replace("/\s+$/ms","",$matches[2]);              
               return $matches[1]. $matches[2];'
         ),
         $TEXT
       );
       $TEXT = preg_replace('/__QUOTE__/ms',">",$TEXT);
       $TEXT = preg_replace('/[\t\x20]+$/ms',"",$TEXT);
       $TEXT = preg_replace('/\n{4,}/ms',"\n\n",$TEXT);
       $TEXT = preg_replace('/\n{3,}/ms',"\n\n",$TEXT);
                  
      /*first pass for blockquotes*/                         
      $TEXT  = preg_replace_callback(
      "#^>+(.*?)\\\\\\\\#ms",
        function($matches) {      
            return str_replace('\\',"",$matches[0]);
        },
        $TEXT 
    );

      /* remove extra line-feeds following in-table code blocks
         make sure cell-ending pipe not mistaken for a following link divider      
      */ 
      $TEXT = preg_replace_callback(
       '#(/code|/file)\>.*?\n\|#ms',  
       function($matches) {         
                $matches[0] = preg_replace("/([\S\s\w\:])\\\\\\\\(\w)/ms","$1@#@$2",$matches[0]); //retain backslashes inside code blocks
                $matches[0] = preg_replace("/(\w+)\\\\\\\\(\w)/ms","$1@#@",$matches[0]);
                $matches[0] = preg_replace("/\\\\(\w+)/ms","@!@$1",$matches[0]);
                $matches[0] = preg_replace("/(\w+)\\\\/ms","@!@$1",$matches[0]);               
         $matches[0] =  str_replace("\\", "",$matches[0]);              
                $matches[0] =  str_replace("@!@",'\\',$matches[0]);
         return str_replace("@#@", "\\\\",$matches[0]);              
      },
      $TEXT     
      );
      /* reformat table cell after removing extra line-feeds, above */
    $TEXT = preg_replace_callback(  
         '#\|[\s\n]+(\<file.*?\>)(.*?)(\<\/file>\s*.*?)\n?\|#ms',   
         function($matches) {  
             $matches[3]  = preg_replace('/\n+/',"",$matches[3] );
             $matches[3]  = preg_replace('/\s+$/',"",$matches[3] ) . '|';     
             return '|' . $matches[1]  . $matches[2]  . str_replace("\\ ","",$matches[3]);
         },
         $TEXT     
    );      

        /*  Feb 23 2019
	remove spaces and line feeds between beginning of table cell and start of code block
	*/
      $TEXT = preg_replace_callback(
       '#\|(.*?)[\s\n]+\<(code|file)\>#ms',  
       function($matches) {  	      
	   return '|' . $matches[1] .'<'. $matches[2] .'>';         
       },$TEXT
       );
     /*remove line feeds following block */
    $TEXT = preg_replace_callback(
       '#\<\/(code|file)\>([\s\S]+)\|#ms',  
       function($matches) {  
          $ret =  '</' . $matches[1] . '>' . str_replace('\\',"",$matches[2]) . '|';  
          return $ret;  
       },$TEXT
       ); 
       
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
/* @auth Sergey Kotov */
//linkPath is the link in the page
//pagePath is absolute path of the page (ns1:ns2:....:page or :ns1:ns2:....:page)
function abs2rel($linkPath,$pagePath){
    if ($linkPath[0]==='.'){
        // It's already relative
        return $linkPath;
    }
    $aLink=explode(':',$linkPath);
    $nLink=count($aLink);
    if ($nLink<2){
        return $linkPath;
    }
    $aPage=explode(':',$pagePath);
    if(empty($aLink[0])) {
        // If linkPath is started by ':'
        // Make canonical absolute path ns1:ns2:.....:pageLink (strip leading :)
        array_shift($aLink);
        if (--$nLink<2) {
            return $linkPath;
        }
    }
    
    if(empty($aPage[0])) {
        // If pagePath is started by ':'
        // Make canonical absolute path ns1:ns2:.....:page (strip leading :)
        array_shift($aPage);
    }
    $nPage=count($aPage);
    $nslEqual=0; // count of equal namespaces from left to right
    // Minimal length of these two arrays, page name is not included
    $nMin=($nLink<$nPage ? $nLink : $nPage)-1 ;
    for ($i=0;$i<$nMin;++$i){
        if ($aLink[$i]===$aPage[$i]){
            ++$nslEqual;
        }
        else {
            break;
        }
    }
    if ($nslEqual==0){
        // Link and page from different root namespaces
        return $linkPath;
    }
    // Truncate equal lef namespaces
    $aPageDiff=array_slice($aPage,$nslEqual);
    $nPageDiff=count($aPageDiff);
    $aLinkDiff=array_slice($aLink,$nslEqual);
    
    // Now we have to go up to nPageDiff-1 levels
    $aResult=array();
    if ($nPageDiff>1){
        $aResult=array_fill(0,$nPageDiff-1,'..');
    }
     else if($nPageDiff == 1) {
        $aResult[] = '.';
    }
    $aResult=array_merge($aResult,$aLinkDiff);
    return implode(':', $aResult);
}


} //end of action class
?>
