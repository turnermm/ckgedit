<?php

// Syntax: <align left|right|center|justify>
 
// must be run within Dokuwiki
if(!defined('DOKU_INC')) die();
 
if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'syntax.php');
 
/**
 * All DokuWiki plugins to extend the parser/rendering mechanism
 * need to inherit from this class
 */
class syntax_plugin_ckgedit_align extends DokuWiki_Syntax_Plugin {
 

 
    function getType(){ return 'formatting'; }
    function getAllowedTypes() { return array('formatting', 'substition', 'disabled'); }   
    function getSort(){ return 159; }
    function connectTo($mode) { $this->Lexer->addEntryPattern('<align\\s+[A-Za-z0-9]+>(?=.*?</align>)',$mode,'plugin_ckgedit_align'); }
    function postConnect() { $this->Lexer->addExitPattern('</align>','plugin_ckgedit_align'); }
 
 
    /**
     * Handle the match
     */
    function handle($match, $state, $pos, Doku_Handler $handler){


        switch ($state) {
          case DOKU_LEXER_ENTER :
                $align = substr($match, 7, -1);
                return array($state, $align);
 
          case DOKU_LEXER_UNMATCHED :  return array($state, $match);
          case DOKU_LEXER_EXIT :       return array($state, '');
        }
        return array();
    }
 
    /**
     * Create output
     */
    function render($mode, Doku_Renderer $renderer, $data) {
        if($mode == 'xhtml'){
            list($state, $match) = $data;

            switch ($state) {
              case DOKU_LEXER_ENTER :      
                $style = "text-align: $match";
                $renderer->doc .= "</p><p style='$style'>"; 
                break;
 
              case DOKU_LEXER_UNMATCHED :  $renderer->doc .= $renderer->_xmlEntities(str_replace("\n", "", $match)); break;
              case DOKU_LEXER_EXIT :       $renderer->doc .= "</p><p>"; break;
            }
            return true;
        }
        return false;
    }
 
 
}
?>
