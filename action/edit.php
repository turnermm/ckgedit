<?php
if(!defined('DOKU_INC')) define('DOKU_INC',realpath(dirname(__FILE__).'/../../../').'/');
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'action.php');
use dokuwiki\Extension\Event;

/**
 * @license    GNU GPLv2 version 2 or later (http://www.gnu.org/licenses/gpl.html)
 * 
 * class       plugin_ckgedit_edit 
 * @author     Myron Turner <turnermm02@shaw.ca>
 */

class action_plugin_ckgedit_edit extends DokuWiki_Action_Plugin {
    
    var $fck_location = "ckeditor";
    var $helper = false;
    var $ckgedit_bak_file = "";
    var $debug = false;
    var $test = false;
    var $page_from_template;
    var $draft_found = false;
    var $draft_text;
    var $draft_started;
    var $captcha;
    /**
     * Constructor
     */
    function __construct()
    {
        $this->setupLocale();
        $this->helper = plugin_load('helper', 'ckgedit');
        if(!plugin_isdisabled('captcha')) {
            $this->captcha = plugin_load('helper', 'captcha');
        }
        else  $this->captcha  = false;

    }


    function register(Doku_Event_Handler $controller)
    {
       $version = explode('.', phpversion());
       define('PHP_VERSION_NUM', $version[0] * 10+ $version[1]);
        
         if($this->helper->is_outOfScope()) return;
 
        global $FCKG_show_preview;
        $FCKG_show_preview = true;

        if(isset($_REQUEST['mode']) && $_REQUEST['mode'] == 'dwiki') {
          $FCKG_show_preview = true;
          return;
        }
        elseif(isset($_COOKIE['FCKG_USE'])) {
             preg_match('/_\w+_/',  $_COOKIE['FCKG_USE'], $matches);
             if($matches[0] == '_false_') {
                  $FCKG_show_preview = true;     
                   return;
             }
        }
        $Fck_NmSp = "!!NONSET!!"; 
        if(isset($_COOKIE['FCK_NmSp'])) {
          $Fck_NmSp = $_COOKIE['FCK_NmSp'];
        }
        $dwedit_ns = @$this->getConf('dwedit_ns');
        if(isset($dwedit_ns) && $dwedit_ns) {
            $ns_choices = explode(',',$dwedit_ns);
            foreach($ns_choices as $ns) {
              $ns = trim($ns);
              if(preg_match("/$ns/",$_REQUEST['id']) || preg_match("/$ns/",$Fck_NmSp)) {
                      $FCKG_show_preview = true;     
                       return;
             }
            }
        }
        $controller->register_hook('COMMON_PAGE_FROMTEMPLATE', 'AFTER', $this, 'pagefromtemplate', array());
        $controller->register_hook('COMMON_PAGETPL_LOAD', 'AFTER', $this, 'pagefromtemplate', array());

        $controller->register_hook('TPL_ACT_RENDER', 'BEFORE', $this, 'ckgedit_edit');
        $controller->register_hook('TPL_METAHEADER_OUTPUT', 'BEFORE', $this, 'ckgedit_edit_meta');
    }

   /**
    * function pagefromtemplate
    * Capture template text output by Template Event handler instead of pageTemplate()
	* @author  Myron Turner <turnermm02@shaw.ca>     
    *               
    */
    function pagefromtemplate(Doku_Event $event) {
      if($event->data['tpl']) { 
         $this->page_from_template = $event->data['tpl']; 
      }
    }

    /**
     * ckgedit_edit_meta 
     *
     * load fck js
     * @author Pierre Spring <pierre.spring@liip.ch>
    * @author Myron Turner <turnermm03@shaw.ca>     
     * @param mixed $event 
     * @access public
     * @return void
     */
    function ckgedit_edit_meta(Doku_Event $event)
    {
        global $ACT;
        // we only change the edit behaviour
        if ($ACT != 'edit'){
            return;
        }
        global $ID;
        global $REV;
        global $INFO;
        global $conf;
            $event->data['script'][] = 
                array( 
                    'type'=>'text/javascript', 
                    'charset'=>'utf-8', 
                    '_data'=>'',             
                     'src'=>DOKU_BASE.'lib/plugins/ckgedit/' .$this->fck_location. '/ckeditor.js'
                )+([ 'defer' => 'defer']);               
              
      if(isset($conf['fnencode']) && $conf['fnencode'] == 'safe') {
            $event->data['script'][] = 
                array( 
                    'type'=>'text/javascript', 
                    'charset'=>'utf-8', 
                    '_data'=>'',             
                     'src'=>'lib/plugins/ckgedit/scripts/safeFN_cmpr.js'
                ) + ([ 'defer' => 'defer']);
      } 
      $ua = strtolower ($_SERVER['HTTP_USER_AGENT']);
      if(strpos($ua, 'msie') !== false) {
          echo "\n" . '<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />' ."\n";     
      }
            
        if($this->test) {
         $nval = substr(md5(time()), -20);
         $parse_url = DOKU_URL . 'lib/plugins/ckgedit/scripts/parse_wiki.js.unc';
        }
        else $parse_url = DOKU_BASE . 'lib/plugins/ckgedit/scripts/parse_wiki-cmpr.js';
        $event->data['script'][] = 
            array( 
                'type'=>'text/javascript', 
                'charset'=>'utf-8', 
                '_data'=>'',             
                 'src'=> $parse_url
            ) + ([ 'defer' => 'defer']);
         
        return;
    }

    /**
     * function    ckgedit_edit
     * @author     Pierre Spring <pierre.spring@liip.ch>
     * edit screen using fck
     *
     * @param & $event
     * @access public
     * @return void
     */
    function ckgedit_edit(Doku_Event $event)
    {
  
        global $INFO;

        // we only change the edit behaviour
        if ($event->data != 'edit') {
            return;
        }
        // load xml and acl
        if (!$this->_preprocess()){
            return;
        }
        // print out the edit screen
        $this->_print();
        // prevent Dokuwiki normal processing of $ACT (it would clean the variable and destroy our 'index' value.
        $event->preventDefault();
        // index command belongs to us, there is no need to hold up Dokuwiki letting other plugins see if its for them
        $event->stopPropagation();
    }
    
   /**
    * function _preprocess
	* @author  Myron Turner <turnermm02@shaw.ca>
    */
    function _preprocess($draft_text = "")
    {
        global $ID;
        global $REV;
        global $DATE;
        global $RANGE;
        global $PRE;
        global $SUF;
        global $INFO;
        global $SUM;
        global $lang;
        global $conf;
        global $ckgedit_lang; 
        //set summary default
        if(!$SUM){
            if($REV){
                $SUM = $lang['restored'];
            }elseif(!$INFO['exists']){
                $SUM = $lang['created'];
            }
        }
            if(!$draft_text) {
            if($INFO['exists']){
                if($RANGE){
                    list($PRE,$text,$SUF) = rawWikiSlices($RANGE,$ID,$REV);
                }else{
                    $text = rawWiki($ID,$REV);
                }
            }else{
                //try to load a pagetemplate
                 $text = pageTemplate($ID);
                //Check for text from template event handler
                 if(!$text && $this->page_from_template) $text = $this->page_from_template;
            }
            }
            else $text = $draft_text;
         
     $text = str_replace('&notags',  '&amp;amp;notags',$text);
     $text = preg_replace_callback(
    '/(~~NOCACHE~~|~~NOTOC~~|\{\{rss>http(s?):\/\/.*?\}\})/ms',
     create_function(
               '$matches',
               '$matches[0] = preg_replace("#{{rss>http(s?):\/\/#", "{ { rss>$1Feed:",  $matches[0]);
               $matches[0] = str_replace("~", "~ ",  $matches[0]);
               return $matches[0];'
               ),$text);
			   
    if($this->getConf('smiley_hack')) {
        $new_addr = $_SERVER['SERVER_NAME'] . DOKU_BASE;
        $text=preg_replace("#(?<=http://)(.*?)(?=lib/plugins/ckgedit/ckeditor/plugins/smiley/images)#s", $new_addr,$text);        
     }
 /*interwiki frasl refactoring*/

/*
    $text = preg_replace_callback('/\[\[\w+>.*?\]\]/ms',
    create_function(
        '$matches',
        'return str_replace("/", "__IWIKI_FSLASH__" ,$matches[0]);'
    ), $text);
    */
    
      global $useComplexTables;
      if($this->getConf('complex_tables') || strrpos($text, '~~COMPLEX_TABLES~~') !== false) {     
          $useComplexTables=true;
      }
      else {
         $useComplexTables=false;
      }
      
      if(strpos($text, '%%') !== false || strpos($text, '\\\\') !== false || strpos($text, '|') !== false ) {  
      $text = preg_replace('/%%\s*<nowiki>\s*%%/ms', 'PERCNWPERC',$text);
      $text = preg_replace('/%%\s*<(code|file)>\s*%%/ms', 'PERC' . "$1" . 'PERC',$text);
        $text = preg_replace_callback(
            "/<(nowiki|code|file)>(.*?)<\/(nowiki|code|file)/ms",
            function ($matches) {
                $matches[0] = str_replace('%%', 'DBLPERCENT',$matches[0]);
                $matches[0] =  str_replace('\\ ', 'DBLBACKSPLASH',$matches[0]);
                 $matches[0] =  str_replace('|', 'NWPIPECHARACTER',$matches[0]);                
                return $matches[0];
            },
           $text
        );

        $text = preg_replace_callback(
            "/(?<!nowiki>)%%(.*?)%%/ms",
            function($matches) {
            return '<nowiki>' . $matches[1] . '</nowiki>';
            },
            $text
        );

        $text =  str_replace('DBLPERCENT','%%',$text);    
      }
       
       $pos = strpos($text, '<');

       if($pos !== false) {

/* skipentity support */
        $text = preg_replace_callback(
            '/``(.*?)``/ms',
            function($matches) {          
                $needles =  array('[',']', '/',  '.', '*', '_','\'','<','>','%', '{', '}', '\\' , '(' );                          
                $replacements = array('&#91;','&#93;','&#47;', '&#46;', '&#42;', '&#95;', '&#39;', '&#60;','&#62;','&#37;', '&#123;','&#125;', '&#92;','&#40;');                       
                $matches[1] = str_replace($needles, $replacements, $matches[1]); 
               return '&grave;&grave;' .$matches[1] .'&grave;&grave;' ;
            },
            $text
        );
      

           $text = preg_replace_callback(
            '/(<nowiki>)(.*?)(<\/nowiki>)/ms',          
            create_function(
                '$matches',         
                 '$needles =  array("[","]", "/",  ".", "*", "_","\'","<",">","%", "{", "}", "\\\","(");
                  $replacements = array("&#91;","&#93;","&#47;", "&#46;", "&#42;", "&#95;", "&#39;", "&#60;","&#62;","&#37;", "&#123;","&#125;", "&#92;","&#40;"); 
                  $matches[2] = str_replace($needles, $replacements, $matches[2]);
                  return  $matches[1] . $matches[2] . $matches[3];'            
            ),
            $text
          );               

           $text = preg_replace_callback(
            '/<(code|file)(.*?)(>)(.*?)(<\/\1>)/ms',
            create_function(
                '$matches',         
                 ' //file_put_contents("geshi.txt", print_r($matches,true));
                 if(preg_match("/(^\s*geshi:\s*(\w+)(\s+\w+\.\w+)*\s*)$/m",$matches[0],$gmatch)){
                      $gmatch[0] = preg_replace("/\s*geshi:\s+/","",$gmatch[0]);                    
                      $matches[1] .= " " . trim($gmatch[0]);                       
                      //file_put_contents("gmatch.txt", print_r($gmatch,true));
                      $c=1;
                      $matches[4] = str_replace($gmatch[1],"",$matches[4],$c);
                  }
                 if(preg_match("/\w+/",$matches[2])) {
                   $matches[4] = str_replace("CHEVRONescC", ">>",$matches[4]);
                   $matches[4] = str_replace("CHEVRONescO", "<<",$matches[4]);
                   $matches[4] = preg_replace("/<(?!\s)/ms", "__GESHI_OPEN__", $matches[4]); 
                  }
                  else {
                  if( preg_match("/MULTI/",$matches[0])) {
                     $open = "< ";
                     $close = " >";
                  }
                  else {  
                     $open = "&lt;";
                     $close = "&gt;";
                  }
                  $matches[4] = preg_replace("/<(?!\s)/ms", $open, $matches[4]); 
                  $matches[4] = preg_replace("/(?<!\s)>/ms", $close, $matches[4]);                    
                  }
                  $matches[4] = str_replace("\"", "__GESHI_QUOT__", $matches[4]);     
                  $matches[4] = preg_replace("/\\\\\\(\n|\s)/ms","CODE_BLOCK_EOL_MASK$1",$matches[4]);
                  return "<" . $matches[1] . $matches[2] . $matches[3] . $matches[4] . $matches[5];'            
            ),
            $text
          );

          $text = preg_replace_callback(
             '/~~START_HTML_BLOCK~~.*?CLOSE_HTML_BLOCK/ms',
                 create_function(
                '$matches',
                '$matches[0] = str_replace("_ckgedit_NPBBR_","",$matches[0]);
                 return $matches[0];'
        ),$text);    
      
          $text = preg_replace_callback(
            '/(\|\s*)(<code>|<file>)(.*?)(<\/code>|<\/file>)\n_ckgedit_NPBBR_(?=.*?\|)/ms',
            create_function(
                '$matches',         
                 '$matches[2] = preg_replace("/<code>/ms", "TPRE_CODE", $matches[2]); 
                  $matches[2] = preg_replace("/<file>/ms", "TPRE_FILE", $matches[2]);    
                  $matches[4] = "TPRE_CLOSE";                    
                  $matches[3] = preg_replace("/^\n+/", "TC_NL",$matches[3]);  
                  $matches[3] = preg_replace("/\n/ms", "TC_NL",$matches[3]);                                   
                  return $matches[1] . $matches[2] .  trim($matches[3]) .   $matches[4];'            
            ),
            $text
          );
         $text = preg_replace('/TPRE_CLOSE\s+/ms',"TPRE_CLOSE",$text); 
         $text = preg_replace('/<(?!code|file|nowiki|del|sup|sub|\/\/|\s|\/del|\/code|\/nowiki|\/file|\/sup|\/sub)/ms',"&lt;",$text);
         $text = str_replace(array('<nowiki>','</nowiki>'),array('NWIKISTART<nowiki>','NWIKICLOSE</nowiki>'),$text);
         $text = str_replace('%%&lt;', '&#37;&#37;&#60;', $text);              
       }  
       
	   if($this->getConf('duplicate_notes')) {
			$text = preg_replace_callback('/\(\((.*?)\)\)/ms',
				  create_function(
				   '$matches',
				   'static $count = 0;
				   $count++;
				   $ins = "FNoteINSert" . $count;
                   $needles =  array("[","]", "/",  ".", "*", "_","\'","<",">","%", "{", "}", "\\\","(");
                   $replacements = array("&#91;","&#93;","&#47;", "&#46;", "&#42;", "&#95;", "&#39;", "&#60;","&#62;","&#37;", "&#123;","&#125;", "&#92;","&#40;"); 
                   $matches[1] = str_replace($needles, $replacements, $matches[1]);                    
              	   return "(($ins" . $matches[1] . "))" ;'
				 ), $text
			);			 
		}
       $text = preg_replace('/^\>/ms',"_QUOT_",$text);  // dw quotes
       $text = str_replace('>>','CHEVRONescC',$text);
       $text = str_replace('<<','CHEVRONescO',$text);
       $text = preg_replace('/(={3,}.*?)(\{\{.*?\}\})(.*?={3,})/',"$1$3\n$2",$text);
       $email_regex = '/\/\/\<\/\/(.*?@.*?)>/';
       $text = preg_replace($email_regex,"<$1>",$text);

       $text = preg_replace('/{{(.*)\.swf(\s*)}}/ms',"__SWF__$1.swf$2__FWS__",$text);
       $text = preg_replace('/PERCNWPERC/ms', '%%&lt; nowiki &gt;%%',$text);
       //$text = preg_replace('/%%\s*<(code|file)>\s*%%/ms', 'PERC' . "$1" . 'PERC',$text);
       $text = preg_replace('/PERCcodePERC/ms','%%&lt;code&gt;%%', $text);
       $text = preg_replace('/PERCfilePERC/ms','%%&lt;file&gt;%%', $text);
       $divalign = false;
       if($this->helper->has_plugin('divalign2')
		   ||$this->helper->has_plugin('divalign2_center')) {
           $divalign = true;
           $text = preg_replace_callback('/\n([;#]{3})/',
                                
                              function ($matches) {  
                               return "divalNLine" . str_replace('#','CGEHASH',$matches[1]);
                              },   $text
            );
       }
      $text = preg_replace_callback( 
               '|(<code\s+\w+)(\s+\[enable_line_numbers.*?\])\s*>(.*?<\/code>)|ms',
            function($matches) {
                $retstr = $matches[1] . ">\n/*" .   $matches[2] . "*/\n" . $matches[3];               
               return $retstr;              
            }, $text
        );

       $this->xhtml = $this->_render_xhtml($text);

 /*interwiki frasl refactoring*/  
  //   $this->xhtml = str_replace("__IWIKI_FSLASH__", "&frasl;", $this->xhtml);
	   if($this->getConf('duplicate_notes')) {
			$this->xhtml = preg_replace("/FNoteINSert\d+/ms", "",$this->xhtml);
	   }
      if($divalign) {
            $this->xhtml = str_replace("CGEHASH", "#", $this->xhtml);           
      }   
       $this->xhtml = str_replace("__GESHI_QUOT__", '&#34;', $this->xhtml);        
       $this->xhtml = str_replace("__GESHI_OPEN__", "&#60; ", $this->xhtml); 
       $this->xhtml = str_replace('CHEVRONescC', '>>',$this->xhtml);
       $this->xhtml = str_replace('CHEVRONescO', '<<',$this->xhtml);
       $this->xhtml = preg_replace('/_QUOT_/ms','>',$this->xhtml);  // dw quotes     
       $this->xhtml = preg_replace_callback(
         "/^(>+)(.*?)$/ms",
         function($matches) {
             $matches[2] = str_ireplace('<br/>',"",$matches[2]);
                return $matches[1] . $matches[2] . "<br />";
         },
        $this->xhtml
       );
      
       if($pos !== false) {
       $this->xhtml = preg_replace_callback(
                '/(TPRE_CODE|TPRE_FILE)(.*?)(TPRE_CLOSE)/ms',
                create_function(
                   '$matches', 
                   '$matches[1] = preg_replace("/TPRE_CODE/","<pre class=\'code\'>\n", $matches[1]);  
                    $matches[1] = preg_replace("/TPRE_FILE/","<pre class=\'file\'>\n", $matches[1]);  
                    $matches[2] = preg_replace("/TC_NL/ms", "\n", $matches[2]);  
                    $matches[3] = "</pre>";                    
                    return $matches[1] . $matches[2] . $matches[3];'            
                ),
                $this->xhtml
              ); 
			  
       }
        $this->xhtml = preg_replace_callback(
    '/~~START_HTML_BLOCK~~[\n\s]*(.*?)CLOSE_HTML_BLOCK/ms',
        create_function(
            '$matches',
            '$matches[1] = str_replace("&amp;","&",$matches[1]);
         $matches[1] =  html_entity_decode($matches[1],ENT_QUOTES, "UTF-8");
             $matches[1] = preg_replace("/<\/?code.*?>/", "",$matches[1]);
         $matches[1] = preg_replace("/^\s*<\/p>/","",$matches[1]);
         $tmp = explode("\n", $matches[1]);
         for($n=0; $n<7; $n++) {
               if( (preg_match("/(<p>\s*)*(&nbsp;|\s+)<\/p>/",$tmp[$n])) || (preg_match("/^\s+$/",$tmp[$n]))) {
                unset($tmp[$n]);
             }
          }
         return "~~START_HTML_BLOCK~~" . implode("\n",$tmp) . "CLOSE_HTML_BLOCK"; '
        ),$this->xhtml);
        
        $this->xhtml = preg_replace_callback(
            '/(<pre)(.*?)(>)(.*?)(<\/pre>)/ms',
            create_function(
                '$matches',                          
                  '$matches[4] = preg_replace("/(\||\^)[ ]+(\||\^)/ms","$1 &nbsp; $2" , $matches[4]);                    
                  return  $matches[1] . $matches[2] . $matches[3] . $matches[4] . $matches[5];'            
            ),
            $this->xhtml
          );
      
          $this->xhtml = preg_replace_callback(
            '/~~MULTI_PLUGIN_OPEN~~(.*?)~~MULTI_PLUGIN_CLOSE~~/ms',
            create_function(
                '$matches',                          
                'return str_replace("&lt;", "< ",$matches[0]);'
            ),
            $this->xhtml
          );
		  //insures breaks are retained for single spacing
      $this->xhtml = preg_replace('/<p>\s*<br\/>\s*<\/p>/ms', '<br/>', $this->xhtml);
	   
      if($this->draft_started) return $this->xhtml;
       $cname = getCacheName($INFO['client'].$ID,'.draft.fckl');
     
       $this->draft_started = false;
        if(file_exists($cname)  && !$this->draft_started) {
    
           $this->draft_started = true;
         
          $cdata =  unserialize(io_readFile($cname,false));
          $prefix =  isset($cdata['prefix']) ? urldecode($cdata['prefix']) : "" ;
          if($prefix) $prefix = $this-> _preprocess($prefix);
          $text = urldecode($cdata['text']);
          $suffix = isset($cdata['suffix']) ? urldecode($cdata['suffix']) : "" ;
          
          if($suffix) $suffix = $this-> _preprocess($suffix);
       
          preg_match_all("/<\/(.*?)\>/", $cdata['text'],$matches);
          /* exclude drafts saved from preview mode */
          if (!in_array('code', $matches[1]) && !in_array('file', $matches[1]) && !in_array('nowiki', $matches[1])) {
             //$this->draft_text = $cdata['text'];
             $this->draft_text = $prefix . $text . $suffix;
              $this->draft_found = true;
              msg($this->getLang('draft_msg')) ;
          }
          unlink($cname);
       }    
       if($draft_started) return $this->xhtml;
        return true;
    }


   /**
      Check for for alternate style sheet
    */
    function alt_style_sheet() {
       $stylesheet = DOKU_PLUGIN . 'ckgedit/ckeditor/css/_style.css';
       if(file_exists($stylesheet)) {
           global $conf;
           $tpl_name = $conf['template'];          
           if($fh = fopen($stylesheet,"r")) { 
               $line_num = 0;
               while (!feof($fh) &&  $line_num < 4) {
                    $line = fgets($fh,1024);            //msg($line);      
                    if(strpos($line,$tpl_name)!==false) {
                         return DOKU_BASE . '/lib/plugins/ckgedit/ckeditor/css/_style.css' ;
                        break;
                     }   
                    $line_num ++;                     
               }                    
           }
       }
      return "";       
    }
    
    
   /**
    * function _print
    * @author  Myron Turner
    */ 
    function _print()
    {
        global $INFO;
        global $lang;
        global $ckgedit_lang;
        global $ID;
        global $REV;
        global $DATE;
        global $PRE;
        global $SUF;
        global $SUM;
        $wr = $INFO['writable'];
        if($wr){
           if ($REV) print p_locale_xhtml('editrev');          
           $ro=false;
        }else{
            // check pseudo action 'source'
            if(!actionOK('source')){
                msg('Command disabled: source',-1);
                return false;
            }
            print p_locale_xhtml('read');
            $ro='readonly="readonly"';
        }

        if(!$DATE) $DATE = $INFO['lastmod'];
        $guest_toolbar = $this->getConf('guest_toolbar');
        $guest_media  = $this->getConf('guest_media');
        if(!isset($INFO['userinfo']) && !$guest_toolbar) {  
            $toolbar = "DokuwikiNoGuest";  
        }
       else if(!isset($INFO['userinfo']) && !$guest_media) {            
	        $toolbar = "DokuwikiGuest";
	   }
        else $toolbar = 'Dokuwiki';
       
$height = isset($_COOKIE['ckgEdht']) && $_COOKIE['ckgEdht'] ? $_COOKIE['ckgEdht']: 250;
if(!is_numeric($height)) $height = 250;
$fbsz_increment = isset($_COOKIE['fbsz']) && $_COOKIE['fbsz'] ? $_COOKIE['fbsz'] : false;
$fbrowser_width = 1070;
$fbrowser_height = 660;
if($fbsz_increment) {
    $fbrowser_width  = $fbrowser_width + ($fbrowser_width*($fbsz_increment/100));
    $fbrowser_height  =$fbrowser_height + ($fbrowser_height*($fbsz_increment/100));
}

$doku_base=  rtrim(DOKU_BASE,'/');        
$ns = getNS($_COOKIE['FCK_NmSp']);

//get user file browser if allowed
if ($this->getConf('allow_ckg_filebrowser') == 'all') {
    $fb = $this->getUserFb();
} else {
    //use only allowed file browser
    $fb = $this->getConf('allow_ckg_filebrowser');
}

//setup options
if ($fb == 'dokuwiki') {
    $fbOptions = "filebrowserImageBrowseUrl: \"$doku_base/lib/exe/mediamanager.php?ns=$ns&edid=wiki__text&onselect=ckg_edit_mediaman_insert&ckg_media=img\",
    filebrowserBrowseUrl: \"$doku_base/lib/exe/mediamanager.php?ns=$ns&edid=wiki__text&onselect=ckg_edit_mediaman_insertlink&ckg_media=link\"";
} else {
    $fbOptions = "filebrowserImageBrowseUrl :  \"$doku_base/lib/plugins/ckgedit/fckeditor/editor/filemanager/browser/default/browser.html?Type=Image&Connector=$doku_base/lib/plugins/ckgedit/fckeditor/editor/filemanager/connectors/php/connector.php\",
    filebrowserBrowseUrl: \"$doku_base/lib/plugins/ckgedit/fckeditor/editor/filemanager/browser/default/browser.html?Type=File&Connector=$doku_base/lib/plugins/ckgedit/fckeditor/editor/filemanager/connectors/php/connector.php\"";
}
if($this->getConf('style_sheet')) {
$contents_css = $this->alt_style_sheet();
}
//msg($contents_css);
$ckeditor_replace =<<<CKEDITOR_REPLACE

		   ckgeditCKInstance = CKEDITOR.replace('wiki__text',
		       { 
                  toolbar: '$toolbar' ,    
                  height: $height,
                   filebrowserWindowWidth: $fbrowser_width,
                   filebrowserWindowHeight:  $fbrowser_height,
                  $fbOptions,
                    on : {  'instanceReady' : function( evt ) {
                         evt.editor.document.on( 'mousedown', function()
                   {
                              var browser_level = (window.top != window.self) ? window.self : window.top; browser_level.handlekeypress(evt);
                             //  parent. handlekeypress(evt);
                         } );
                       }
                     },
                     on : {  'instanceReady' : function( evt ) {
                         evt.editor.document.on( 'focus', function()
                      {
                               var browser_level = (window.top != window.self) ? window.self : window.top; browser_level.handlekeypress(evt);
                              // parent. handlekeypress(evt);
                         } );
                      }
                   },  

               } 
		   );
           FCKeditor_OnComplete(ckgeditCKInstance);
           if("$contents_css") {
            CKEDITOR.config.contentsCss = "$contents_css";
         } 
               
CKEDITOR_REPLACE;

		 echo  $this->helper->registerOnLoad($ckeditor_replace);

         global $skip_styling;
            
?>
<?php
            global $INPUT;
            if($this->page_from_template) {
             $ckg_template = 'tpl';   
            }
            else $ckg_template ="";

             if($INPUT->has('hid')) {            
               $hid = $INPUT->str('hid');
           }
           else {
               $hid = "";
           }
         /* accommodates include plugin's redirect to original page after editing included page */  
       $ckgedit_redirect =  $INPUT->str('redirect_id', "");      

 ?>
   <form id="dw__editform" method="post" action="<?php echo script()?>"  accept-charset="<?php echo $lang['encoding']?>">
    <div class="no">
      <input type="hidden" name="id"   value="<?php echo $ID?>" />
      <input type="hidden" name="rev"  value="<?php echo $REV?>" />
      <input type="hidden" name="date" value="<?php echo $DATE?>" />
      <input type="hidden" name="prefix" value="<?php echo formText($PRE)?>" />
      <input type="hidden" name="suffix" value="<?php echo formText($SUF)?>" />
      <input type="hidden" id="ckgedit_mode_type"  name="mode" value="" />
      <input type="hidden" id="fck_preview_mode"  name="fck_preview_mode" value="nil" />
      <input type="hidden" id="fck_wikitext"    name="fck_wikitext" value="__false__" />     
       <input type="hidden" id="styling"  name="styling" value="styles" />
      <?php if(!empty($ckgedit_redirect)):?>
     <input type="hidden" id="ckgedit_redirect"  name="ckgedit_redirect" value="<?php echo $ckgedit_redirect ?>" />
      <?php endif ?>           
	  <?php if(!empty($hid)):?>
       <input type="hidden" id="hid"  name="hid" value="<?php echo $hid; ?>" />       
	  <?php endif ?>      
      <input type="hidden" id="template"  name="template" value="<?php echo $ckg_template?>" />
      <?php
      if(function_exists('formSecurityToken')) {
           formSecurityToken();  
      }
      ?>
    </div>
<?php
/*
$this->xhtml=<<<ERRTXT
[<a class="wikilink1 curid" data-curid="true" href="/dokuwiki/doku.php?id=*:*" title="*:*">go to top</a> | <a class="wikilink1" href="/dokuwiki/doku.php?id=*:start#system_configuration" title="*:start">back to Index</a> | <a class="wikilink1" href="/dokuwiki/doku.php?id=*:start" title="*:start">Wiki start page</a> ]
ERRTXT;*/
?>

    <textarea name="wikitext" id="wiki__text" <?php echo $ro?> cols="80" rows="10" class="edit" tabindex="1"><?php echo "\n".$this->xhtml?></textarea>

<?php 

$temp=array();

if(class_exists('dokuwiki\Extension\Event')) {
    Event::createAndTrigger('HTML_EDITFORM_INJECTION', $temp);
}
else {
 trigger_event('HTML_EDITFORM_INJECTION', $temp);
}
$DW_EDIT_disabled = '';
$guest_perm = auth_quickaclcheck($_REQUEST['id']);
$guest_group = false;
$guest_user = false;

if(isset($INFO['userinfo'])&& isset($INFO['userinfo']['grps'])) {
   $user_groups = $INFO['userinfo']['grps'];
   if(is_array($user_groups) && $user_groups) {  
      foreach($user_groups as $group) { 
        if (strcasecmp('guest', $group) == 0) {
          $guest_group = true;
          break;
        }
     }
   }
  if($INFO['client'] == 'guest') $guest_user = true; 
}

if(($guest_user || $guest_group) && $guest_perm <= 2) $DW_EDIT_disabled = 'disabled';
global $USERINFO;
$DW_EDIT_hide = $this->helper->dw_edit_displayed(); 
$is_ckgeditChrome = false;
 if(stripos($_SERVER['HTTP_USER_AGENT'],'Chrome') !== false) {
      preg_match("/Chrome\/(\d+)/", $_SERVER['HTTP_USER_AGENT'],$cmatch);
      if((int)$cmatch[1] <26)  $is_ckgeditChrome =true;    
} 

?>

    <div id="wiki__editbar">
      <div id="size__ctl" style="display: none"></div>
      <?php if($wr){?>
         <div class="editButtons">
            <input type="checkbox" name="ckgedit" value="ckgedit" checked="checked" style="display: none"/>
             <input class="button" type="button" id = "save_button"
                   name="do[save]"
                   value="<?php echo $lang['btn_save']?>" 
                   title="<?php echo $lang['btn_save']?> "   
                   <?php echo $DW_EDIT_disabled; ?>                   
                  /> 

            <input class="button" id="ebtn__delete" type="submit" 
                   <?php echo $DW_EDIT_disabled; ?>
                   name="do[delete]" value="<?php echo $lang['btn_delete']?>"
                   title="<?php echo $this->getLang('title_dw_delete') ?>"
                   style = "font-size: 100%;"
            />

            
             <?php if(!$is_ckgeditChrome): ?> 
             <input class="button"  id = "ebtn__dwedit"
                 <?php echo $DW_EDIT_disabled; ?>                 
                 <?php echo $DW_EDIT_hide; ?>
                 style = "font-size: 100%;"            
                 type="submit" 
                 name="do[save]" 
                 value="<?php echo $this->getLang('btn_dw_edit')?>"  
                 title="<?php echo $this->getLang('title_dw_edit')?>"
                  />
             <?php endif; ?>

             <?php if($this->getConf('allow_ckg_filebrowser') == 'all'): ?>
            <input class="button" id="ebtn__fbswitch"
                   style="font-size: 100%;"
                   type="submit"
                   name="do[save]"
                   value="<?php echo $this->get_switch_fb_value() ?>"
                   title="<?php echo $this->get_switch_fb_title() ?>"
                   />
             <?php endif; ?>
<?php
global $INFO;

  $disabled = 'Disabled';
  $inline = $this->test ? 'inline' : 'none';
  $chrome_dwedit_link =  '<a href="'.wl($INFO['id'],array('do'=>'show')).'" ' . 'onclick="draft_delete();setDWEditCookie(2);"class="action edit" rel="nofollow" title="DW Edit"><span>DW Edit</span></a>';
  $backup_btn =$this->getLang('dw_btn_backup') ? $this->getLang('dw_btn_backup') : $this->getLang('dw_btn_refresh');
  $backup_title = $this->getLang('title_dw_backup') ? $this->getLang('title_dw_backup') : $this->getLang('title_dw_refresh');   
  $using_scayt = ($this->getConf('scayt')) == 'on';
  
?>
            <input class="button" type="submit" 
                 name="do[draftdel]" 
                 id = "ebut_cancel"
                 value="<?php echo $lang['btn_cancel']?>"                  
                 style = "font-size: 100%;"
                 title = "<?php echo $this->getLang('title_dw_cancel')?>"
             />

           <!-- aspell button removed, not supported -->

            <input class="button" type="button" value = "Test"
                   title="Test"  
                   style = 'display:<?php echo $inline ?>;'
                   onmousedown="parse_wikitext('test');"
                  /> 

 <?php if($this->draft_found) { ?>
             <input class="button"       
                 style = "background-color: yellow"
                 id="ckgedit_draft_btn" 
                 type="button" value="<?php echo $this->getLang('btn_draft') ?>"  
                 title="<?php echo $this->getLang('title_draft') ?>"
                  />
 <?php } else { ?>

  
             <input class="button" type="button" 
                   id = "backup_button"
                   value="<?php echo $backup_btn ?>"
                   title="<?php echo $backup_title ?>"  
                   
                  />
 
             <input class="button" type="button"
                   id = "revert_to_prev_btn"
                   value="<?php echo $this->getLang('dw_btn_revert')?>"  
                   title="<?php echo $this->getLang('title_dw_revert')?>"  
                   
                  />
     <?php if(!$skip_styling) : ?>              
              <input class="button" type="submit"
                   name ="do[edit]" 
                   id = "no_styling_btn"                   
                   style = "font-size: 100%;"                   
                   value="<?php echo $this->getLang('dw_btn_styling')?>"  
                   title="<?php echo $this->getLang('title_styling')?>"  
                  />
    <?php endif ?>                  
             &nbsp;&nbsp;&nbsp;

<?php                  
if($is_ckgeditChrome) echo $chrome_dwedit_link;
?>
 <br />

 <?php }  ?>

 <?php if($this->debug) { ?>
         <input class="button" type="button" value = "Debug"
                   title="Debug"                     
                   onclick="HTMLParser_debug();"
                  /> 

            <br />
 <?php } ?>

   <div id = "backup_msg" class="backup_msg" style=" display:none;">
     <table><tr><td class = "backup_msg_td">
      <div id="backup_msg_area" class="backup_msg_area"></div>
     <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     <td align="right">
      <a href="javascript:hide_backup_msg();void(0);" class="backup_msg_close">[ close ]</a>&nbsp;&nbsp;&nbsp;
     </table>
     
 </div>
<?php

if(!isset($_COOKIE['ckgEdPaste'])) {
    $paste_value = 'on';
}
else {
    $paste_value = (isset($_COOKIE['ckgEdPaste']) && $_COOKIE['ckgEdPaste'] == 'off' )  ? 'on' : 'off';
}
?>

     <label class="nowrap" for="complex_tables" id="complex_tables_label">     
        <input type="checkbox" name="complex_tables" value="complex_tables"  id = "complex_tables" 
                     /><span id='complex_tables_label_text'> <?php echo $this->getLang('complex_tables');?></span></label> 
      &nbsp;&nbsp;<label class="nowrap" for="editor_height"><?php echo $this->getLang('editor_height');?></label> 
        <input type="text" size= "4" name="editor_height" title = "<?php echo $this->getLang('editor_height_title'); ?>" value="<?php echo $height?>"  id = "editor_height"  onchange="setEdHeight(this.value);" />  px    
    &nbsp;&nbsp;<label class="nowrap" for="ckg_img_paste" title ="<?php echo $this->getLang('ckg_img_paste_title'); ?>"> <?php echo $this->getLang('ckg_img_paste') . " ". $this->getLang($paste_value) ?></label> 
        &nbsp;<input type="checkbox" name="ckg_img_paste" title = "<?php echo $this->getLang('ckg_img_paste_title'); ?>"  
            id = "ckg_img_paste"  value = "<?php echo $paste_value?>" onchange="ckgd_setImgPaste(this.value);" />
        
      <input style="display:none;" class="button" id="edbtn__save" type="submit" name="do[save]" 
                      value="<?php echo $lang['btn_save']?>" 
                      onmouseup="draft_delete();"
                      <?php echo $DW_EDIT_disabled; ?>
                      title="<?php echo $lang['btn_save']?> "  />

            <!-- Not used by ckgedit but required to prevent null error when DW adds events -->
            <input type="button" id='edbtn__preview' style="display: none"/>


 <div id='saved_wiki_html' style = 'display:none;' ></div>
 <div id='ckgedit_draft_html' style = 'display:none;' >
 <?php echo $this->draft_text; ?>
 </div>

         </div>
      <?php } ?>

        <?php if($wr){ ?>
            <div class="summary">
                <label for="edit__summary" class="nowrap"><?php echo $lang['summary']?>:</label>
                <input type="text" class="edit" name="summary" id="edit__summary" size="50" value="<?php echo formText($SUM)?>" tabindex="2" />
                <label class="nowrap" for="minoredit"><input type="checkbox" id="minoredit" name="minor" value="1" tabindex="3" /> <span><?php echo $this->getLang('minor_changes') ?></span></label>
            </div>
        <?php }?>
        <?php if($this->captcha && $this->captcha->isEnabled()) echo $this->captcha->getHTML(); ?>
    </div>
   </form>

        <!-- draft messages from DW -->
        <div id="draft__status"></div>
  <script type="text/javascript">
//<![CDATA[
        <?php  echo 'var backup_empty = "' . $this->getLang('backup_empty') .'";'; ?>
        /* aspell_window removed, not supported */
        if(window.unsetDokuWikiLockTimer) window.unsetDokuWikiLockTimer();  

   
  function getComplexTables() {   
     return  document.getElementById('complex_tables').checked;
  }

    <?php  global $useComplexTables;  if($useComplexTables) { ?>               
        document.getElementById('complex_tables').click();            
    <?php } ?>  
    <?php  if($this->getConf('complex_tables')) { ?>
         document.getElementById('complex_tables').disabled = true;
         document.getElementById('complex_tables_label').style = "display:none";
         document.getElementById('complex_tables_label_text').style = "display:none";
    <?php } ?>  

<?php
   
   
   if(preg_match("/MISIE|Trident/",$_SERVER['HTTP_USER_AGENT'])) {
      echo "var isIE = true;";
   }
   else {
     echo "var isIE = false;";
   }

   echo "var doku_base = '" . DOKU_BASE ."'"; 
     
?>  
          
   var ckgedit_draft_btn = "<?php echo $this->getLang('btn_exit_draft') ?>";
   var ckgedit_draft_btn_title = "<?php echo $this->getLang('title_exit_draft')?>";
   function ckgedit_get_draft() {
      var dom = GetE('ckgedit_draft_html');
      var draft = dom.innerHTML;
      var dw_text =  CKEDITOR.instances.wiki__text.getData();     	 
 
      CKEDITOR.instances.wiki__text.setData(draft);      
      dom.innerHTML = dw_text;
      var btn = GetE('ckgedit_draft_btn');
      var tmp = btn.value;  
      btn.value = ckgedit_draft_btn;
      ckgedit_draft_btn = tmp;
      tmp = ckgedit_draft_btn_title;
      btn.title = ckgedit_draft_btn_title;
      ckgedit_draft_btn_title = tmp;
   }


   function safe_convert(value) {            

     if(oDokuWiki_FCKEditorInstance.dwiki_fnencode && oDokuWiki_FCKEditorInstance.dwiki_fnencode == 'safe') {
      <?php
       global $updateVersion;
       if(!isset($updateVersion)) $updateVersion = 0;
       echo "updateVersion=$updateVersion;";
       $list = plugin_list('action');       
       $safe_converted = false;
       if(in_array( 'safefnrecode' , $list)) {
          $safe_converted = true;          
       }
       
     ?>

 		if(value.match(/%25/ && value.match(/%25[a-z0-9]/))) {
                          value = value.replace(/%25/g,"%");
                          <?php                         
                          if($updateVersion > 30 || $safe_converted) {
                            echo 'value = value.replace(/%5D/g,"]");';
                          }
                          ?>

                          value =  dwikiUTF8_decodeFN(value,'safe');
                       }
        }
        return value; 

     }
	 
RegExp.escape = function(str)
{
    var specials = new RegExp("[.*+?|()\\[\\]{}\\\\]", "g"); // .*+?|()[]{}\
    return str.replace(specials, "\\$&");
}
var ckgedit_xcl_fonts =parseInt  ("<?php echo $this->getConf('font_options') ;?>");
var ckgedit_xcl_colors =parseInt("<?php echo $this->getConf('color_options') ;?>");
var ckgedit_xcl_styles = (ckgedit_xcl_fonts + ckgedit_xcl_colors ==2) ? true : false;
var HTMLParser_DEBUG = "";
var ckgedit_hasCaptcha = "<?php echo $this->captcha?1:0?>";

<?php if($this->debug) { ?>
   function HTMLParser_debug() {        
       HTMLParser_DEBUG = "";
       parse_wikitext("");
/*
      for(var i in oDokuWiki_FCKEditorInstance) {     
         HTMLParser_DEBUG += i + ' = ' + oDokuWiki_FCKEditorInstance[i] + "\n";;
       }
*/

       var w = window.open();       
       w.document.write('<pre>' + HTMLParser_DEBUG + '</pre>');
       w.document.close();
  }
<?php } ?>

<?php  
       global $conf;

       if(isset($conf['animal'])) {
         echo "var config_animal='" . $conf['animal'] . "';";
       }
   ?>

 //]]>

  </script>


  
<?php
    }

    /**
     * Renders a list of instruction to minimal xhtml
     *@author Myron Turner <turnermm02@shaw.ca>
     */
    function _render_xhtml($text){
        $mode = 'ckgedit';

        global $skip_styling;
        $skip_styling =  $this->getConf('nofont_styling');
        if(!$skip_styling && $_POST['styling'] == 'no_styles') {
            $skip_styling = true;
        }  

        if(strpos($text,'~~NO_STYLING~~') !== false) {
            $skip_styling = true;
        }
 //    $text = preg_replace("/\\\\(\n|\s)/ms","CODE_BLOCK_EOL_MASK$1",$text);
     $text = preg_replace_callback('/\[\[(.*?>)(.*?)\]\]/ms',
              function ($matches) {    
                 if(strpos($matches[0],"\n") !== false) return $matches[0];
                 if(preg_match("#<(\w+)>.*?<\/\\1>#",$matches[0])) return $matches[0];  
                 list($name,$link_text) = explode('|',$matches[2]);
                 $retv = '[[' . $matches[1] . "oIWIKIo" . $name ."cIWIKIc";
                 if(!empty($link_text)) {
                     $retv .= "|$link_text";
                 }
                 return $retv . ']]';
              },                 
           $text);

        // try default renderer first:
        $file = DOKU_INC."inc/parser/$mode.php";

        if(@file_exists($file)){
	
            require_once $file;
            $rclass = "Doku_Renderer_$mode";

            if ( !class_exists($rclass) ) {
                trigger_error("Unable to resolve render class $rclass",E_USER_WARNING);
                msg("Renderer for $mode not valid",-1);
                return null;
            }
            $Renderer = new $rclass();
        }
        else{
            // Maybe a plugin is available?
            $Renderer = plugin_load('renderer',$mode);	    
            if(is_null($Renderer)){
                msg("No renderer for $mode found",-1);
                return null;
            }
        }
// aimed at wrap plugin which allows multiple newlines in a cell
$text = preg_replace_callback(
    '#(\|.*?)\|.?[\n\r]#ms',
        function ($matches) {
            $matches[0] = preg_replace("#\\\\\\\\\s*[\r\n]#ms", "  \\\\\\\\  ",$matches[0]);
            return ($matches[0]);
        },
    $text);    
        
        // prevents utf8 conversions of quotation marks
         $text = str_replace('"',"_ckgedit_QUOT_",$text);        

         $text = preg_replace_callback('/(<code.*?>)([^<]+)(<\/code>)/ms',
             create_function(
               '$matches',              
               '$quot =  str_replace("_ckgedit_QUOT_",\'"\',$matches[2]); 
                $quot = str_replace("\\\\ ","_ckgedit_NL",$quot); 
                $quot .= "_ckgedit_NL";                
                return $matches[1] . $quot . $matches[3];' 
          ), $text); 

         $text = preg_replace_callback('/(<file.*?>)([^<]+)(<\/file>)/ms',
             create_function(
               '$matches',              
               '$quot =  str_replace("_ckgedit_QUOT_",\'"\',$matches[2]); 
                $quot = str_replace("\\\\ ","_ckgedit_NL",$quot); 
                $quot .= "_ckgedit_NL";                
                return $matches[1] . $quot . $matches[3];' 
          ), $text); 

          $text = preg_replace_callback('/\|([\s\S]+)\|/ms',  // prevents  extra backslash  from hanging on a new line
            function ($matches) {
                if(!strpos($matches[1], "_ckgedit_NL")) return $matches[0];                    
                $matches[1]  =  str_replace("\\_ckgedit_NL","_ckgedit_NL",$matches[1]);                 

                return '|' . $matches[1] . '|';
                return $matches[0];
            },
           $text
        );          
       
          $text = preg_replace_callback('/(<code>|<file>)([^<]+)(<\/code>|<\/file>)/ms',
             create_function(
               '$matches',             
               '$matches[2] = str_replace("&lt;font","ckgeditFONTOpen",$matches[2]);
               $matches[2] = str_replace("font&gt;","ckgeditFONTClose",$matches[2]);
                return $matches[1] .$matches[2] . $matches[3]; '
          ), $text); 
           $text = str_replace('CODE_BLOCK_EOL_MASK','\\', $text);
         ///  msg($text);
            $instructions = p_get_instructions("=== header ==="); // loads DOKU_PLUGINS array --M.T. Dec 22 2009
        
        $instructions = p_get_instructions($text);
        if(is_null($instructions)) return '';
              
        $Renderer->notoc();
        if(!$this->getConf('smiley_as_text')) {
        $Renderer->smileys = getSmileys();
        }
        $Renderer->entities = getEntities();
        $Renderer->acronyms = array();
        $Renderer->interwiki = getInterwiki();
       
        // Loop through the instructions
        /*
           By-passing plugin processing was sugested and first implemented
           by Matti Lattu<matti.lattu@iki.fi>
           It is a significant contribution to the functionality of ckgEdit
        */
        foreach ( $instructions as $instruction ) {
             if ($instruction[0] == 'plugin') {              
                $Renderer->doc .= $instruction[1][3];
          } else {
               // Execute the callback against the Renderer
               call_user_func_array(array(&$Renderer, $instruction[0]),$instruction[1]);              
            }
        }

        //set info array
        $info = $Renderer->info;

        // Post process and return the output
        $data = array($mode,& $Renderer->doc);
        if(class_exists('dokuwiki\Extension\Event')) {
           Event::createAndTrigger('RENDERER_CONTENT_POSTPROCESS', $data);
        }
        else {
        trigger_event('RENDERER_CONTENT_POSTPROCESS',$data);
        }
       
        $xhtml = $Renderer->doc;
	    $xhtml = str_replace(
		    array('NWIKISTART','NWIKICLOSE'),
		    array('&amp;lt;nowiki>','&amp;lt;/nowiki>'),$xhtml);
		
        if(!$skip_styling) {  // create font styles from font plugin markup for html display
        $xhtml = preg_replace_callback(
            '|&amp;lt;font\s+(.*?)/([\w ,\-]+);;([\(\)),\w,\s\#]+);;([\(\)),\w,\s\#]+)&gt;(.*?)&amp;lt;/font&gt;|ms',
             function($matches) {
               $count = 0; $str='';
              if($matches[3] && $matches[3] != 'inherit') { $str .= '<span style = "color:' . $matches[3] .'">'; $count++;} 
              if($matches[1] && $matches[1] != 'inherit') { $str .= '<span style = "font-size:' . $matches[1] .'">'; $count++; } 
              if($matches[2] && $matches[2] != 'inherit') { $str .= '<span style = "font-family:' . $matches[2] .'">'; $count++; } 
              if($matches[4] && $matches[4] != 'inherit') { $str .= '<span style = "background-color:' . $matches[4] .'">'; $count++; }  
              $str .= $matches[5];              
              for($i =0; $i<$count; $i++) {
                  $str .= '</span>';
              }
               return $str;            
             }, $xhtml
        );
        }
        
    /**   
     * Alternative to  the one liner at 1179:  $xhtml = str_replace(array('oiwikio','ciwikic'),array('oIWIKIo','cIWIKIc'),$xhtml);   
     *  if it turns out that there are users using  'oiwikio','ciwikic' 
     $xhtml = preg_replace_callback(
        '|class=\"interwiki.*?href=\".*?:oiwikiotowerciwikic\".*?title=\".*?oiwikiotowerciwikic\"|ms',
        function($matches) {
           $matches[0] = str_replace(array('oiwikio','ciwikic'),array('oIWIKIo','cIWIKIc'),$matches[0]);
          return $matches[0];
       },$xhtml
       );  
     */
     if(stripos($xhtml,'oIWIKIo') !== false) {
        $xhtml = str_replace(array('oiwikio','ciwikic'),array('oIWIKIo','cIWIKIc'),$xhtml);
            $xhtml = preg_replace_callback(
                '/<?(.*?)oIWIKIo(.*?)cIWIKIc/ms',
                 create_function(
                   '$matches',              
                   ' if(preg_match("/^\w+$/",$matches[2]) && $matches[1] == "/")  return "/". $matches[2];
                     return $matches[0];'               
              ),        
              $xhtml              
            );  
            $xhtml = preg_replace_callback(
                '/>oIWIKIo(.*?)cIWIKIc(?=<\/a>)/ms',
                 create_function(
                   '$matches',              
                   ' return ">". $matches[1] ;'               
              ),        
              $xhtml              
            );              
            
           }
           
        $pos = strpos($xhtml, 'MULTI_PLUGIN_OPEN');
        if($pos !== false) {
           $xhtml = preg_replace_callback(
            '|MULTI_PLUGIN_OPEN.*?MULTI_PLUGIN_CLOSE|ms',
            create_function(
                '$matches',                          
                  '$matches[0] = str_replace("//<//", "< ",$matches[0]);
                  $matches[0] = str_replace(array("oIWIKIo","cIWIKIc"),"",$matches[0]);
                  return preg_replace("/\n/ms","<br />",$matches[0]);'            
            ),
            $xhtml
          );
           
           $xhtml = preg_replace('/~\s*~\s*MULTI_PLUGIN_OPEN~\s*~/', "\n\n~~MULTI_PLUGIN_OPEN~~<span class='multi_p_open'>\n\n</span>\n\n", $xhtml);
           $xhtml = preg_replace('/~\s*~\s*MULTI_PLUGIN_CLOSE~\s*~/', "<span class='multi_p_close'>\n\n<br /></span>\n\n~~MULTI_PLUGIN_CLOSE~~\n\n", $xhtml);

        }  


         // remove empty paragraph: see _ckgedit_NPBBR_ comment above
        $xhtml = preg_replace('/<p>\s+_ckgedit_NPBBR_\s+<\/p>/ms',"\n",$xhtml);
        $xhtml = str_replace('_ckgedit_NPBBR_', "<span class='np_break'>&nbsp;</span>", $xhtml);
        $xhtml = str_replace('_ckgedit_QUOT_', '&quot;', $xhtml);
        $xhtml = str_replace('_ckgedit_NL', "\n", $xhtml);
        $xhtml = str_replace('</pre>', "\n\n</pre><p>&nbsp;</p>", $xhtml);
        // inserts p before an initial codeblock to enable text entry above block
        $xhtml = preg_replace('/^<pre/',"<p>&nbsp;</p><pre",$xhtml);  
        //remove empty markup remaining after removing marked-up acronyms in lists
        $xhtml = preg_replace('/<(em|b|u|i)>\s+<\/(em|b|u|i)>/ms',"",$xhtml);
        $xhtml = preg_replace("/col\d+\s+(\w+align)/ms", "$1",$xhtml);  //remove col number for cell prpoerties dialog
        $xhtml = str_replace('ckgeditFONTOpen', '&amp;lt;font',$xhtml);  // protect font markup in code blocks
        $xhtml = str_replace('ckgeditFONTClose', 'font&amp;gt;',$xhtml);
        $xhtml = str_replace('DBLBACKSPLASH', '\\ ',$xhtml);
        $xhtml = str_replace('NWPIPECHARACTER', '|',$xhtml);            
        $xhtml = str_replace('&amp;lt;blockquote&gt;','<blockquote>',$xhtml);
        $xhtml = str_replace('&amp;lt;/blockquote&gt;','</blockquote>',$xhtml); 
       
       $xhtml= preg_replace_callback(
            '/(<p>\s*)?<blockquote>(.*?)<\/blockquote>(\s*<\/p>)?/ms',  
            function($matches) {
                $matches[0] = preg_replace("/(<p>)?\s*(<blockquote>)\s*(<\/p>)?/m","<p></p>$2",$matches[0]);
                $matches[0] = preg_replace("/(<p>)?\s*(<\/blockquote>)\s*(<\/p>)?/m","$2<p></p>",$matches[0]);
             //   $matches[0] = str_replace('<blockquote>',  '<blockquote class ="blockquote-plugin">', $matches[0]);  
               return $matches[0];
            },    $xhtml
        );
        
      $ua = strtolower ($_SERVER['HTTP_USER_AGENT']); 
	  if(strpos($ua,'chrome') !== false) {
       $xhtml = preg_replace_callback(
             '/(?<=<a )(href=\".*?\")(\s+\w+=\".*?\")(.*?)(?=>)/sm',
			 create_function(
			 '$matches',
			 '$ret_str = " " . trim($matches[3]) . " " . trim($matches[2])  . " " . trim($matches[1]) ;
			  return $ret_str;'
			 ),
			 $xhtml
			 );
		}	 
       
        return $xhtml;
    }

  function write_debug($what,$line="") {
     return;
     $handle = fopen("ckgedit_php.txt", "a");
    // if(is_array($what)) $what = print_r($what,true);
     if($line) $what = "line $line\n" . $what;
     fwrite($handle,"$what\n");
     fclose($handle);
  }

    function get_switch_fb_value() {
        if ($this->getUserFb() == 'dokuwiki') {
            $fbText = $this->getLang('btn_val_ckg_fb');
        } else {
            $fbText = $this->getLang('btn_val_dw_fb');
        }
        return $fbText;
    }

    function get_switch_fb_title() {
        if ($this->getUserFb() == 'dokuwiki') {
            $fbText = $this->getLang('btn_title_ckg_fb');
        } else {
            $fbText = $this->getLang('btn_title_dw_fb');
        }
        return $fbText;
    }

    function getUserFb() {
        //get user file browser
        if (!isset($_COOKIE['ckgFbOpt'])) {
            $_COOKIE['ckgFbOpt'] = $this->getConf('default_ckg_filebrowser');
        }
        return $_COOKIE['ckgFbOpt'];
    }

} //end of action class

?>
