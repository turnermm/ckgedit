<?php
/**
 * Renderer for XHTML output
 *
 * @author Pierre Spring <pierre.spring@liip.ch>
 * @author Myron Turner <turnermm02@shaw.ca>
 */
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();

// we inherit from the XHTML renderer instead directly of the base renderer
require_once DOKU_INC.'inc/parser/xhtml.php';

/**
 * The Renderer
 */
class renderer_plugin_ckgedit extends Doku_Renderer_xhtml 
{

    var $ver_anteater;
    var $dwiki_version;

/**
 * Establish version in constructor 
 * @author Myron Turner <turnermm02@shaw.ca>
 */
    
    function renderer_plugin_ckgedit() {
      global $conf;
      $this->ver_anteater = mktime(0,0,0,11,7,2010); 
      $this->dwiki_version=mktime(0,0,0,01,01,2008);

      if(isset($conf['fnencode'])) {
          $this->ver_anteater = mktime(0,0,0,11,7,2010); 
          $this->dwiki_version=mktime(0,0,0,11,7,2010); 
      }
      else if(function_exists('getVersionData')) {
          $verdata= getVersionData();
          if(isset($verdata) && preg_match('/(\d+)-(\d+)-(\d+)/',$verdata['date'],$ver_date)) {
              if($ver_date[1] >= 2005 && ($ver_date[3] > 0 && $ver_date[3] < 31) && ($ver_date[2] > 0 && $ver_date[2] <= 12)) { 
                                              // month        day               year
              $this->dwiki_version=@mktime(0,  0,  0, $ver_date[2],$ver_date[3], $ver_date[1]); 
              if(!$this->dwiki_version) $this->dwiki_version = mktime(0,0,0,01,01,2008);         
              $this->ver_anteater = mktime(0,0,0,11,7,2010); 
          }
        }
      }
    }


    /**
     * the format we produce
     */
    function getFormat()
    {
        // this should be 'ckgedit' usally, but we inherit from the xhtml renderer
        // and produce XHTML as well, so we can gain magically compatibility
        // by saying we're the 'xhtml' renderer here.
        return 'xhtml';
    }




    /*
     * The standard xhtml renderer adds anchors we do not need.
     */
    function header($text, $level, $pos) {
        // write the header
        $this->doc .= DOKU_LF.'<h'.$level.'>';
        $this->doc .= $this->_xmlEntities($text);
        $this->doc .= "</h$level>".DOKU_LF;
    }

    /*
     * The FCKEditor prefers <b> over <strong>
     */
    function strong_open()
    {   

        $this->doc .= '<b>';
    }
    function strong_close()
    {
        $this->doc .= '</b>';
    }

    /*
     * The FCKEditor prefers <strike> over <del>
     */
    function deleted_open()
    {
        $this->doc .= '<strike>';
    }
    function deleted_close()
    {
        $this->doc .= '</strike>';
    }
    
    /**
     * isolate table from bottom and top editor window margins
     * @author Myron Turner <turnermm02@shaw.ca>
     */
    function table_close()
    {
        global $conf;  
        $this->doc .= "</table>\n<span class='np_break'>&nbsp;</span>\n";
        if($this->dwiki_version >= $this->ver_anteater) {
           $this->doc .= "</div>";
        }
    } 
   
    function table_open($maxcols = null, $numrows = null, $pos = null){
        $this->doc .= "\n<span class='np_break'>&nbsp;</span>\n";
        parent::table_open($maxcols = null, $numrows = null, $pos = null);
    }
    /* 
     * Dokuwiki displays __underlines__ as follows
     *     <em class="u">underlines</em>
     * in the fck editor this conflicts with 
     * the //italic// style that is displayed as
     *     <em>italic</em>
     * which makes the rathe obvious
     */
    function underline_open()
    {
        $this->doc .= '<u>';
    }
    function underline_close()
    {
        $this->doc .= '</u>';
    }

    function listcontent_open()
    {
    }

    function listcontent_close()
    {
    }
}
