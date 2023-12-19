<?php
/**
 * DokuWiki StyleSheet creator
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Andreas Gohr <andi@splitbrain.org>
 */

if(!defined('DOKU_INC')) define('DOKU_INC',realpath(dirname(__FILE__).'/../../../../').'/');		
require_once(DOKU_INC.'inc/init.php'); 

// ---------------------- functions ------------------------------

/**
 * Output all needed Styles
 *
 * @author Andreas Gohr <andi@splitbrain.org>
 */
function css_ckg_out($path, $tpl = "")
{
    global $conf;
    global $lang;
    global $config_cascade;
	global $INPUT;
	$copy = $INPUT->str('ckg_save_ss',FALSE);
    chdir($path);

    $mediatypes = array('screen', 'all');
    $type = '';
   
    if(!$tpl) { 
        $tpl = $conf['template'];
		
		if($copy) {
		    $copy_path = DOKU_PLUGIN . 'ckgedit/ckeditor/css/_style.css';
			 msg($copy_path,1);
        }  
	}
  
    // load styl.ini
    $styleini = css_ckg_styleini($tpl);

    // if old 'default' userstyle setting exists, make it 'screen' userstyle for backwards compatibility
    if (isset($config_cascade['userstyle']['default'])) {
        $config_cascade['userstyle']['screen'] = $config_cascade['userstyle']['default'];
    }

    // Array of needed files and their web locations, the latter ones
    // are needed to fix relative paths in the stylesheets
    $files = array();
    foreach($mediatypes as $mediatype) {
        $files[$mediatype] = array();
        // load core styles
        $files[$mediatype][DOKU_INC.'lib/styles/'.$mediatype.'.css'] = DOKU_BASE.'lib/styles/';
       
        // load template styles
        if (isset($styleini['stylesheets'][$mediatype])) {
            $files[$mediatype] = array_merge($files[$mediatype], $styleini['stylesheets'][$mediatype]);
        }
        // load user styles
        if(!empty($config_cascade['userstyle'][$mediatype])) {
            foreach($config_cascade['userstyle'][$mediatype] as $userstyle) {
                $files[$mediatype][$userstyle] = DOKU_BASE;
            }
        }
    }

    $css="";

    // build the stylesheet
    foreach ($mediatypes as $mediatype) {

        // print the default classes for interwiki links and file downloads
        if ($mediatype == 'screen') {
            $css .= '@media screen {';
            css_ckg_interwiki($css);
            css_ckg_filetypes($css);
            $css .= '}';
        }

        $xcl =  'plugins|popup|fileuploader|toc|search|recent|diff|edit|form|admin|manager|media|modal';

        // load files
        $css_ckg_content = '';
        foreach($files[$mediatype] as $file => $location) {
           if(preg_match('#' .$xcl . '#',$file)  ) {			               
                   continue;               
		    }
            $display = str_replace(fullpath(DOKU_INC), '', fullpath($file));
            $css_ckg_content .= "\n/* XXXXXXXXX $display XXXXXXXXX */\n";
            $css_ckg_content .= css_ckg_loadfile($file, $location);
        }
        switch ($mediatype) {
            case 'screen':
                $css .=  NL.'@media screen { /* START screen styles */'.NL.$css_ckg_content.NL.'} /* /@media END screen styles */'.NL;
                break;
            case 'all':
            default:
                $css .= NL.'/* START rest styles */ '.NL.$css_ckg_content.NL.'/* END rest styles */'.NL;
                break;
        }
    }

    // apply style replacements
    $css = css_ckg_applystyle($css, $styleini['replacements']);
    // parse less
    $css = css_ckg_parseless($css);

    // embed small images right into the stylesheet
    if($conf['cssdatauri']){
        $base = preg_quote(DOKU_BASE,'#');
        $css = preg_replace_callback('#(url\([ \'"]*)('.$base.')(.*?(?:\.(png|gif)))#i','css_ckg_datauri',$css);
    }
    
   $css = preg_replace("/(\#?|\.?|div\.)dokuwiki\.?/", '', $css);
 
   $css = "@import 'additional.css';\n/* template: $tpl */\n@media screen {\n.$tpl{color:#ccc;}\n}\n" . $css;
   $css .=  '
   span.multi_p_open {
    display: block;
   }   
   body,html {
    background-color: #fff;
    background-image:none;
  }
  blockquote {
   padding-left: .5em;
   margin-left: 1.5em;
  }
' . "\n";

  if( io_saveFile($path . 'Styles/_style.css' ,$css)) {
	  if(isset($copy_path)) {		 ;
	     $retv = io_saveFile($copy_path,$css); 
		 if(!$retv) msg("failed: " . $copy_path);
	  }	  
	  return 0;
  }
  else {
	  return 1;
  }
}

/**
 * Uses phpless to parse LESS in our CSS
 *
 * most of this function is error handling to show a nice useful error when
 * LESS compilation fails
 *
 * @param $css
 * @return string
 */
function css_ckg_parseless($css) {
    $less = new lessc();
    $less->importDir[] = DOKU_INC;

    try {
        return $less->compile($css);
    } catch(Exception $e) {
            // get exception message
        $msg = str_replace(array("\n", "\r", "'"), array(), $e->getMessage());

        // try to use line number to find affected file
        if(preg_match('/line: (\d+)$/', $msg, $m)){
            $msg = substr($msg, 0, -1* strlen($m[0])); //remove useless linenumber
            $lno = $m[1];

            // walk upwards to last include
            $lines = explode("\n", $css);
            for($i=$lno-1; $i>=0; $i--){
                if(preg_match('/\/(\* XXXXXXXXX )(.*?)( XXXXXXXXX \*)\//', $lines[$i], $m)){
                    // we found it, add info to message
                    $msg .= ' in '.$m[2].' at line '.($lno-$i);
                    break;
                }
            }
        }

        // something went wrong
        $error = 'A fatal error occured during compilation of the CSS files. '.
            'If you recently installed a new plugin or template it '.
            'might be broken and you should try disabling it again. ['.$msg.']';

         msg($error);

        exit;
    }
}

/**
 * Does placeholder replacements in the style according to
 * the ones defined in a templates style.ini file
 *
 * This also adds the ini defined placeholders as less variables
 * (sans the surrounding __ and with a ini_ prefix)
 *
 * @author Andreas Gohr <andi@splitbrain.org>
 */
function css_ckg_applystyle($css, $replacements) {
    // we convert ini replacements to LESS variable names
    // and build a list of variable: value; pairs
    $less = '';
    foreach((array) $replacements as $key => $value) {
        $lkey = trim($key, '_');
        $lkey = '@ini_'.$lkey;
        $less .= "$lkey: $value;\n";

        $replacements[$key] = $lkey;
    }

    // we now replace all old ini replacements with LESS variables
    $css = strtr($css, $replacements);

    // now prepend the list of LESS variables as the very first thing
    $css = $less.$css;
    return $css;
}

/**
 * Load style ini contents
 *
 * Loads and merges style.ini files from template and config and prepares
 * the stylesheet modes
 *
 * @author Andreas Gohr <andi@splitbrain.org>
 * @param string $tpl the used template
 * @return array with keys 'stylesheets' and 'replacements'
 */
function css_ckg_styleini($tpl) {
    $stylesheets = array(); // mode, file => base
    $replacements = array(); // placeholder => value

    // load template's style.ini
    $incbase = tpl_incdir($tpl);
    $webbase = tpl_basedir($tpl);
    $ini = $incbase.'style.ini';
$data = []; // Define a variável <link>$data</link> como um array vazio
    if(file_exists($ini)){
        $data = parse_ini_file($ini, true);

        // stylesheets
        if(is_array($data['stylesheets'])) foreach($data['stylesheets'] as $file => $mode){
            $stylesheets[$mode][$incbase.$file] = $webbase;
        }

        // replacements
        if(is_array($data['replacements'])){
            $replacements = array_merge($replacements, css_ckg_fixreplacementurls($data['replacements'],$webbase));
        }
    }

    // load configs's style.ini
    $webbase = DOKU_BASE;
    $ini = DOKU_CONF."tpl/$tpl/style.ini";
    $incbase = dirname($ini).'/';
    if(file_exists($ini)){
        $data = parse_ini_file($ini, true);

        // stylesheets
        if(isset($data['stylesheets']) && is_array($data['stylesheets'])) foreach($data['stylesheets'] as $file => $mode){
            $stylesheets[$mode][$incbase.$file] = $webbase;
        }

        // replacements
        if(isset($data['replacements']) && is_array($data['replacements'])){
            $replacements = array_merge($replacements, css_ckg_fixreplacementurls($data['replacements'],$webbase));
        }
    }

    return array(
        'stylesheets' => $stylesheets,
        'replacements' => $replacements
    );
}

/**
 * Amend paths used in replacement relative urls, refer FS#2879
 *
 * @author Chris Smith <chris@jalakai.co.uk>
 */
function css_ckg_fixreplacementurls($replacements, $location) {
    foreach($replacements as $key => $value) {
        $replacements[$key] = preg_replace('#(url\([ \'"]*)(?!/|data:|http://|https://| |\'|")#','\\1'.$location,$value);
    }
    return $replacements;
}

/**
 * Prints classes for interwikilinks
 *
 * Interwiki links have two classes: 'interwiki' and 'iw_$name>' where
 * $name is the identifier given in the config. All Interwiki links get
 * an default style with a default icon. If a special icon is available
 * for an interwiki URL it is set in it's own class. Both classes can be
 * overwritten in the template or userstyles.
 *
 * @author Andreas Gohr <andi@splitbrain.org>
 */
function css_ckg_interwiki(&$css){

    // default style
    $css .= 'a.interwiki {';
    $css .= ' background: transparent url('.DOKU_BASE.'lib/images/interwiki.png) 0px 1px no-repeat;';
    $css .= ' padding: 1px 0px 1px 16px;';
    $css .= '}';

    // additional styles when icon available
    $iwlinks = getInterwiki();
    foreach(array_keys($iwlinks) as $iw){
        $class = preg_replace('/[^_\-a-z0-9]+/i','_',$iw);
        if(@file_exists(DOKU_INC.'lib/images/interwiki/'.$iw.'.png')){
            $css .= "a.iw_$class {";
            $css .= '  background-image: url('.DOKU_BASE.'lib/images/interwiki/'.$iw.'.png)';
            $css .= '}';
        }elseif(@file_exists(DOKU_INC.'lib/images/interwiki/'.$iw.'.gif')){
            $css .= "a.iw_$class {";
            $css .= '  background-image: url('.DOKU_BASE.'lib/images/interwiki/'.$iw.'.gif)';
            $css .= '}';
        }
    }
}

/**
 * Prints classes for file download links
 *
 * @author Andreas Gohr <andi@splitbrain.org>
 */
function css_ckg_filetypes(&$css){

    // default style
    $css .= '.mediafile {';
    $css .= ' background: transparent url('.DOKU_BASE.'lib/images/fileicons/file.png) 0px 1px no-repeat;';
    $css .= ' padding-left: 18px;';
    $css .= ' padding-bottom: 1px;';
    $css .= '}';

    // additional styles when icon available
    // scan directory for all icons
    $exts = array();
    if($dh = opendir(DOKU_INC.'lib/images/fileicons')){
        while(false !== ($file = readdir($dh))){
            if(preg_match('/([_\-a-z0-9]+(?:\.[_\-a-z0-9]+)*?)\.(png|gif)/i',$file,$match)){
                $ext = strtolower($match[1]);
                $type = '.'.strtolower($match[2]);
                if($ext!='file' && (!isset($exts[$ext]) || $type=='.png')){
                    $exts[$ext] = $type;
                }
            }
        }
        closedir($dh);
    }
    foreach($exts as $ext=>$type){
        $class = preg_replace('/[^_\-a-z0-9]+/','_',$ext);
        $css .= ".mf_$class {";
        $css .= '  background-image: url('.DOKU_BASE.'lib/images/fileicons/'.$ext.$type.')';
        $css .= '}';
    }
}

/**
 * Loads a given file and fixes relative URLs with the
 * given location prefix
 */
function css_ckg_loadfile($file,$location=''){
    $css_ckg_file = new DokuCssFile($file);
    return $css_ckg_file->load($location);
}

/**
 *  Helper class to abstract loading of css/less files
 *
 *  @author Chris Smith <chris@jalakai.co.uk>
 */
class DokuCssFile {

    protected $filepath;             // file system path to the CSS/Less file
    protected $location;             // base url location of the CSS/Less file
    private   $relative_path = null;

    public function __construct($file) {
        $this->filepath = $file;
    }

    /**
     * Load the contents of the css/less file and adjust any relative paths/urls (relative to this file) to be
     * relative to the dokuwiki root: the web root (DOKU_BASE) for most files; the file system root (DOKU_INC)
     * for less files.
     *
     * @param   string   $location   base url for this file
     * @return  string               the CSS/Less contents of the file
     */
    public function load($location='') {
        if (!file_exists($this->filepath)) return '';

        $css = io_readFile($this->filepath);
        if (!$location) return $css;

        $this->location = $location;

        $css = preg_replace_callback('#(url\( *)([\'"]?)(.*?)(\2)( *\))#',array($this,'replacements'),$css);
        $css = preg_replace_callback('#(@import\s+)([\'"])(.*?)(\2)#',array($this,'replacements'),$css);

        return $css;
    }

    /**
     * Get the relative file system path of this file, relative to dokuwiki's root folder, DOKU_INC
     *
     * @return string   relative file system path
     */
    private function getRelativePath(){

        if (is_null($this->relative_path)) {
            $basedir = array(DOKU_INC);
            
            $basedir = array_map('preg_quote_cb', $basedir);
            $regex = '/^('.join('|',$basedir).')/';
            $this->relative_path = preg_replace($regex, '', dirname($this->filepath));
        }

        return $this->relative_path;
    }

    /**
     * preg_replace callback to adjust relative urls from relative to this file to relative
     * to the appropriate dokuwiki root location as described in the code
     *
     * @param  array    see http://php.net/preg_replace_callback
     * @return string   see http://php.net/preg_replace_callback
     */
    public function replacements($match) {

        // not a relative url? - no adjustment required
        if (preg_match('#^(/|data:|https?://)#',$match[3])) {
            return $match[0];
        }
        // a less file import? - requires a file system location
        else if (substr($match[3],-5) == '.less') {
            if ($match[3][0] != '/') {
                $match[3] = $this->getRelativePath() . '/' . $match[3];
            }
        }
        // everything else requires a url adjustment
        else {
            $match[3] = $this->location . $match[3];
        }

        return join('',array_slice($match,1));
    }
}

/**
 * Convert local image URLs to data URLs if the filesize is small
 *
 * Callback for preg_replace_callback
 */
function css_ckg_datauri($match){
    global $conf;

    $pre   = unslash($match[1]);
    $base  = unslash($match[2]);
    $url   = unslash($match[3]);
    $ext   = unslash($match[4]);

    $local = DOKU_INC.$url;
    $size  = @filesize($local);
    if($size && $size < $conf['cssdatauri']){
        $data = base64_encode(file_get_contents($local));
    }
    if($data){
        $url = 'data:image/'.$ext.';base64,'.$data;
    }else{
        $url = $base.$url;
    }
    return $pre.$url;
}



/**
 * Very simple CSS optimizer
 *
 * @author Andreas Gohr <andi@splitbrain.org>
 */
function css_ckg_compress($css){
    //strip comments through a callback
    $css = preg_replace_callback('#(/\*)(.*?)(\*/)#s','css_ckg_comment_cb',$css);

    //strip (incorrect but common) one line comments
    $css = preg_replace('/(?<!:)\/\/.*$/m','',$css);

    // strip whitespaces
    $css = preg_replace('![\r\n\t ]+!',' ',$css);
    $css = preg_replace('/ ?([;,{}\/]) ?/','\\1',$css);
    $css = preg_replace('/ ?: /',':',$css);

    // number compression
    $css = preg_replace('/([: ])0+(\.\d+?)0*((?:pt|pc|in|mm|cm|em|ex|px)\b|%)(?=[^\{]*[;\}])/', '$1$2$3', $css); // "0.1em" to ".1em", "1.10em" to "1.1em"
    $css = preg_replace('/([: ])\.(0)+((?:pt|pc|in|mm|cm|em|ex|px)\b|%)(?=[^\{]*[;\}])/', '$1$2', $css); // ".0em" to "0"
    $css = preg_replace('/([: ]0)0*(\.0*)?((?:pt|pc|in|mm|cm|em|ex|px)(?=[^\{]*[;\}])\b|%)/', '$1', $css); // "0.0em" to "0"
    $css = preg_replace('/([: ]\d+)(\.0*)((?:pt|pc|in|mm|cm|em|ex|px)(?=[^\{]*[;\}])\b|%)/', '$1$3', $css); // "1.0em" to "1em"
    $css = preg_replace('/([: ])0+(\d+|\d*\.\d+)((?:pt|pc|in|mm|cm|em|ex|px)(?=[^\{]*[;\}])\b|%)/', '$1$2$3', $css); // "001em" to "1em"

    // shorten attributes (1em 1em 1em 1em -> 1em)
    $css = preg_replace('/(?<![\w\-])((?:margin|padding|border|border-(?:width|radius)):)([\w\.]+)( \2)+(?=[;\}]| !)/', '$1$2', $css); // "1em 1em 1em 1em" to "1em"
    $css = preg_replace('/(?<![\w\-])((?:margin|padding|border|border-(?:width)):)([\w\.]+) ([\w\.]+) \2 \3(?=[;\}]| !)/', '$1$2 $3', $css); // "1em 2em 1em 2em" to "1em 2em"

    // shorten colors
    $css = preg_replace("/#([0-9a-fA-F]{1})\\1([0-9a-fA-F]{1})\\2([0-9a-fA-F]{1})\\3(?=[^\{]*[;\}])/", "#\\1\\2\\3", $css);

    return $css;
}

/**
 * Callback for css_ckg_compress()
 *
 * Keeps short comments (< 5 chars) to maintain typical browser hacks
 *
 * @author Andreas Gohr <andi@splitbrain.org>
 */
function css_ckg_comment_cb($matches){
    if(strlen($matches[2]) > 4) return '';
    return $matches[0];
}

