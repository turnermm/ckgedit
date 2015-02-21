<?php
if(!defined('DOKU_INC')) define('DOKU_INC',realpath(dirname(__FILE__).'/../../../').'/');
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'action.php');


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
    /**
     * Constructor
     */
    function action_plugin_ckgedit_edit()
    {
        $this->setupLocale();
        $this->helper = plugin_load('helper', 'ckgedit');
    }


    function register(&$controller)
    {
       $version = explode('.', phpversion());
       define('PHP_VERSION_NUM', $version[0] * 10+ $version[1]);
        
        if(PHP_VERSION_NUM < 53)  {
           msg("ckgedit requires PHP 5.3 or later.  For a work-around, please see the  <a href='https://www.dokuwiki.org/plugin:ckgedit?&#important'>plugin page</a>", -1);
           return ;
        }
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
    function pagefromtemplate(&$event) {
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
    function ckgedit_edit_meta(&$event)
    {
        global $ACT;
        // we only change the edit behaviour
        if ($ACT != 'edit'){
            return;
        }
        global $ID;
        global $REV;
        global $INFO;

        $event->data['script'][] = 
            array( 
                'type'=>'text/javascript', 
                'charset'=>'utf-8', 
                '_data'=>'',
                 'src'=>DOKU_BASE.'lib/plugins/ckgedit/' .$this->fck_location. '/ckeditor.js'
            );

      $ua = strtolower ($_SERVER['HTTP_USER_AGENT']);
      if(strpos($ua, 'msie') !== false) {
          echo "\n" . '<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />' ."\n";     
      }
            
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
    function ckgedit_edit(&$event)
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
    function _preprocess()
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

     $text = preg_replace_callback(
    '/(~~NOCACHE~~|~~NOTOC~~|\{\{rss>http:\/\/.*?\}\})/ms',
     create_function(
               '$matches',
               '$matches[0] = str_replace("{{rss>http://", "{ { rss>Feed:",  $matches[0]);
               $matches[0] = str_replace("~", "~ ",  $matches[0]);
               return $matches[0];'
               ),$text);
    if($this->getConf('smiley_hack')) {
        $new_addr = $_SERVER['SERVER_NAME'] . DOKU_BASE;
        $text=preg_replace("#(?<=http://)(.*?)(?=lib/plugins/ckgedit/ckeditor/plugins/smiley/images)#s", $new_addr,$text);        
     }

    $text = preg_replace_callback('/\[\[\w+>.*?\]\]/ms',
    create_function(
        '$matches',
        'return str_replace("/", "__IWIKI_FSLASH__" ,$matches[0]);'
    ), $text);
    
      global $useComplexTables;
      if($this->getConf('complex_tables') || strrpos($text, '~~COMPLEX_TABLES~~') !== false) {     
          $useComplexTables=true;
      }
      else {
         $useComplexTables=false;
      }
      
      if(strpos($text, '%%') !== false) {  

        $text = preg_replace_callback(
            "/<(nowiki|code|file)>(.*?)<\/(nowiki|code|file)/ms",
            function ($matches) {
                $matches[0] = str_replace('%%', 'DBLPERCENT',$matches[0]);
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


           $text = preg_replace_callback(
            '/(<nowiki>)(.*?)(<\/nowiki>)/ms',          
            create_function(
                '$matches',         
                 '$needles =  array("[","]", "/",  ".", "*", "_","\'","<",">","%", "{", "}", "\\\");
                  $replacements = array("&#91;","&#93;","&#47;", "&#46;", "&#42;", "&#95;", "&#39;", "&#60;","&#62;","&#37;", "&#123;","&#125;", "&#92;"); 
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
                  return "<" . $matches[1] . $matches[2] . $matches[3] . $matches[4] . $matches[5];'            
            ),
            $text
          );

         /* \n_ckgedit_NPBBR_\n: the final \n prevents this from iterfering with next in line markups
            -- in particular tables which require a new line and margin left 
           this may leave an empty paragraph in the xhtml, which is removed below 
         */
          $text = preg_replace('/<\/(code|file)>(\s*)(?=[^\w])(\s*)/m',"</$1>\n_ckgedit_NPBBR_\n$2",$text );

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
      
         $text = preg_replace('/<(?!code|file|del|sup|sub|\/\/|\s|\/del|\/code|\/file|\/sup|\/sub)/ms',"&lt;",$text);
   
         $text = str_replace('%%&lt;', '&#37;&#37;&#60;', $text);              
       }  
       
	   if($this->getConf('duplicate_notes')) {
			$text = preg_replace_callback('/\(\(/ms',
				  create_function(
				   '$matches',
				   'static $count = 0;
				   $count++;
				   $ins = "FNoteINSert" . $count;
				   return "(($ins";'
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
       $this->xhtml = $this->_render_xhtml($text);

       $this->xhtml = str_replace("__IWIKI_FSLASH__", "&frasl;", $this->xhtml);
	   if($this->getConf('duplicate_notes')) {
			$this->xhtml = preg_replace("/FNoteINSert\d+/ms", "",$this->xhtml);
	   }
	  
       $this->xhtml = str_replace("__GESHI_QUOT__", '&#34;', $this->xhtml);        
       $this->xhtml = str_replace("__GESHI_OPEN__", "&#60; ", $this->xhtml); 
       $this->xhtml = str_replace('CHEVRONescC', '>>',$this->xhtml);
       $this->xhtml = str_replace('CHEVRONescO', '<<',$this->xhtml);
       $this->xhtml = preg_replace('/_QUOT_/ms','>',$this->xhtml);  // dw quotes     

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
       
       $cname = getCacheName($INFO['client'].$ID,'.draft.fckl');
       if(file_exists($cname)) {
          $cdata =  unserialize(io_readFile($cname,false));
          $cdata['text'] = urldecode($cdata['text']);
          preg_match_all("/<\/(.*?)\>/", $cdata['text'],$matches);
          /* exclude drafts saved from preview mode */
          if (!in_array('code', $matches[1]) && !in_array('file', $matches[1]) && !in_array('nowiki', $matches[1])) {
              $this->draft_text = $cdata['text'];
              $this->draft_found = true;
              msg($this->getLang('draft_msg')) ;
          }
          unlink($cname);
       }    
        return true;
    }

   /** 
    * function dw_edit_displayed
    * @author  Myron Turner
    * determines whether or not to show  or hide the
    *  'DW Edit' button
   */

   function dw_edit_displayed() 
   { 
        global $INFO;

        $dw_edit_display = @$this->getConf('dw_edit_display');
        if(!isset($dw_edit_display))return "";  //version 0. 
        if($dw_edit_display != 'all') {
            $admin_exclusion = false;
            if($dw_edit_display == 'admin' && ($INFO['isadmin'] || $INFO['ismanager']) ) {    
                    $admin_exclusion = true;
            }
            if($dw_edit_display == 'none' || $admin_exclusion === false) {
              return ' style = "display:none"; ';
            }
           return "";
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
$doku_url=  rtrim(DOKU_URL,'/');        
$ckeditor_replace =<<<CKEDITOR_REPLACE

		   ckgeditCKInstance = CKEDITOR.replace('wiki__text',
		       { 
                  toolbar: '$toolbar' ,    
                  filebrowserImageBrowseUrl :  '$doku_url/lib/plugins/ckgedit/fckeditor/editor/filemanager/browser/default/browser.html?Type=Image&Connector=$doku_url/lib/plugins/ckgedit/fckeditor/editor/filemanager/connectors/php/connector.php',
                  filebrowserBrowseUrl: '$doku_url/lib/plugins/ckgedit/fckeditor/editor/filemanager/browser/default/browser.html?Type=File&Connector=$doku_url/lib/plugins/ckgedit/fckeditor/editor/filemanager/connectors/php/connector.php',                                
               }
		   );
           FCKeditor_OnComplete(ckgeditCKInstance);
           
               
CKEDITOR_REPLACE;

		 echo  $this->helper->registerOnLoad($ckeditor_replace);

         global $skip_styling;
            
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
      <?php
      if(function_exists('formSecurityToken')) {
           formSecurityToken();  
      }
      ?>
    </div>

    <textarea name="wikitext" id="wiki__text" <?php echo $ro?> cols="80" rows="10" class="edit" tabindex="1"><?php echo "\n".$this->xhtml?></textarea>
    
<?php 

$temp=array();
trigger_event('HTML_EDITFORM_INJECTION', $temp);

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


$DW_EDIT_hide = $this->dw_edit_displayed(); 

$is_ckgeditChrome = false;
 if(stripos($_SERVER['HTTP_USER_AGENT'],'Chrome') !== false) {
      $is_ckgeditChrome =true;
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
<?php
global $INFO;

  $disabled = 'Disabled';
  $inline = $this->test ? 'inline' : 'none';
  $chrome_dwedit_link =  '<a href="doku.php?id=' . $INFO['id']. '&do=show" ' . 'onclick="draft_delete();setDWEditCookie(2);"class="action edit" rel="nofollow" title="DW Edit"><span>DW Edit</span></a>';
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


     <label class="nowrap" for="complex_tables" >     
        <input type="checkbox" name="complex_tables" value="complex_tables"  id = "complex_tables" 
                     /><span id='complex_tables_label'> <?php echo $this->getLang('complex_tables');?> (<a href="https://www.dokuwiki.org/plugin:fckglite#table_handling" target='_blank'><?php echo $this->getLang('whats_this')?></a>)</span></label> 

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
    <?php } ?>  

<?php
   
   
   $pos = strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE');
   if($pos === false) {
     echo "var isIE = false;";
   }
   else {
     echo "var isIE = true;";
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
   $url = DOKU_URL . 'lib/plugins/ckgedit/scripts/script-cmpr.js';    
  echo "var script_url = '$url';";
  if($this->test) {
     $parse_url = DOKU_URL . 'lib/plugins/ckgedit/scripts/parse_wiki.js.unc';
  }
  else $parse_url = DOKU_URL . 'lib/plugins/ckgedit/scripts/parse_wiki-cmpr.js';
  
  echo "var parse_url = '$parse_url';";
//  $safe_url = DOKU_URL . 'lib/plugins/ckgedit/scripts/safeFN_cmpr.js';       
?>

LoadScript(parse_url);
try {
  if(!window.HTMLParserInstalled){
    LoadScript(script_url);   
  }
}
catch (ex) {  
   LoadScript(script_url); 
}


if(window.DWikifnEncode && window.DWikifnEncode == 'safe') {
   LoadScript(DOKU_BASE + 'lib/plugins/ckgedit/scripts/safeFN_cmpr.js' );
}


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
        $text = preg_replace_callback('/(\[\[\w+>)(.*?)([\]\|])/ms',
             create_function(
               '$matches',              
               '  //if(preg_match("/^\w+$/",$matches[2])) return $matches[0];
                return $matches[1] . "oIWIKIo" . $matches[2] ."cIWIKIc" . $matches[3] ;' 
          ), $text); 

       global $Smilies;
       $smiley_as_text = @$this->getConf('smiley_as_text');
       if($smiley_as_text) {

           $Smilies = array('8-)'=>'aSMILEY_1', '8-O'=>'aSMILEY_2',  ':-('=>'aSMILEY_3',  ':-)'=>'aSMILEY_4',
             '=)' => 'aSMILEY_5',  ':-/' => 'aSMILEY_6', ':-\\' => 'aSMILEY_7', ':-?' => 'aSMILEY_8',
             ':-D'=>'aSMILEY_9',  ':-P'=>'bSMILEY_10',  ':-O'=>'bSMILEY_11',  ':-X'=>'bSMILEY_12',
             ':-|'=>'bSMILEY_13',  ';-)'=>'bSMILEY_14',  '^_^'=>'bSMILEY_15',  ':?:'=>'bSMILEY_16', 
             ':!:'=>'bSMILEY_17',  'LOL'=>'bSMILEY_18',  'FIXME'=>'bSMILEY_19',  'DELETEME'=>'bSMILEY_20');

          $s_values = array_values($Smilies);
          $s_values_regex = implode('|', $s_values);
            $s_keys = array_keys($Smilies);
            $s_keys = array_map  ( create_function(
               '$k',     
               'return "(" . preg_quote($k,"/") . ")";'
           ) ,
            $s_keys );



           $s_keys_regex = implode('|', $s_keys);
             global $haveDokuSmilies;
             $haveDokuSmilies = false;
             $text = preg_replace_callback(
                '/(' . $s_keys_regex . ')/ms', 
                 create_function(
                '$matches',
                'global $Smilies;   
                 global $haveDokuSmilies;
                 $haveDokuSmilies = true;
                 return $Smilies[$matches[1]];'
                 ), $text
             );

       }

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

       
          $text = preg_replace_callback('/(<code>|<file>)([^<]+)(<\/code>|<\/file>)/ms',
             create_function(
               '$matches',             
               '$matches[2] = str_replace("&lt;font","ckgeditFONTOpen",$matches[2]);
               $matches[2] = str_replace("font&gt;","ckgeditFONTClose",$matches[2]);
                return $matches[1] .$matches[2] . $matches[3]; '
          ), $text); 
    
    
            $instructions = p_get_instructions("=== header ==="); // loads DOKU_PLUGINS array --M.T. Dec 22 2009
            global $multi_block;
            if(preg_match('/(?=MULTI_PLUGIN_OPEN)(.*?)(?<=MULTI_PLUGIN_CLOSE)/ms', $text, $matches)) {             
             $multi_block = $matches[1];
           }
        
        $instructions = p_get_instructions($text);
        if(is_null($instructions)) return '';
              

        $Renderer->notoc();
        $Renderer->smileys = getSmileys();
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
        trigger_event('RENDERER_CONTENT_POSTPROCESS',$data);
        $xhtml = $Renderer->doc;
        if(!$skip_styling) { 
        $xhtml = preg_replace_callback(
            '|&amp;lt;font\s+(.*?)/([\w ,\-]+);;([\(\)),\w,\s\#]+);;([\(\)),\w,\s\#]+)&gt;(.*?)&amp;lt;/font&gt;|ms',
             function($matches) {
               return '<span style = "color:' . $matches[3] .'">' .
               '<span style = "font-size:' . $matches[1] .'">' .
               '<span style = "font-family:' . $matches[2] .'">' .
               '<span style = "background-color:' . $matches[4] .'">' .
                $matches[5] . '</span></span></span></span>';
             }, $xhtml
        );
        }
         if(strpos($xhtml,'oIWIKIo') !== false) {
            $xhtml = preg_replace_callback(
                '/(.)oIWIKIo(.*?)cIWIKIc/ms',
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
           $multi_block = str_replace(array('oIWIKIo','cIWIKIc'),"",$multi_block);  /*  remove wikilink macros */
           $xhtml = preg_replace('/MULTI_PLUGIN_OPEN.*?MULTI_PLUGIN_CLOSE/ms', $multi_block, $xhtml);
           $xhtml = preg_replace_callback(
            '|MULTI_PLUGIN_OPEN.*?MULTI_PLUGIN_CLOSE|ms',
            create_function(
                '$matches',                          
                  '$matches[0] = str_replace("//<//", "< ",$matches[0]);
                  return preg_replace("/\n/ms","<br />",$matches[0]);'            
            ),
            $xhtml
          );
           
           $xhtml = preg_replace('/~\s*~\s*MULTI_PLUGIN_OPEN~\s*~/', "~~MULTI_PLUGIN_OPEN~~\n\n<span class='multi_p_open'>\n\n</span>", $xhtml);
           $xhtml = preg_replace('/~\s*~\s*MULTI_PLUGIN_CLOSE~\s*~/', "<span class='multi_p_close'>\n\n</span>\n\n~~MULTI_PLUGIN_CLOSE~~\n", $xhtml);
           

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
       if($smiley_as_text) {
           if($haveDokuSmilies) {
                 $s_values = array_values($Smilies);
                 $s_values_regex = (implode('|', $s_values));

                 $xhtml = preg_replace_callback(
                     '/(' . $s_values_regex . ')/ms', 
                     create_function(
                     '$matches',
                    'global $Smilies;     
                     return array_search($matches[1],$Smilies); '
                     ), $xhtml
                 );
            }
          }

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

  function write_debug($what) {
     return;
     $handle = fopen("ckgedit_php.txt", "a");
     if(is_array($what)) $what = print_r($what,true);
     fwrite($handle,"$what\n");
     fclose($handle);
  }

} //end of action class

?>
