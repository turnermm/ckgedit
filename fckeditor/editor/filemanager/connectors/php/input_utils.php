<?php
/**  
 *  Connector to Dokuwiki Input class
 *  sanitizes $_REQUEST variables
 *  @author Myron Turner
 */
 
# i(!defined('DOKU_INC')) define('DOKU_INC',realpath(dirname(__FILE__).'/../../../../../../../../').'/');
require_once('Input.class.php');
global $INPUT; 
if(!isset($INPUT)) {
    $INPUT = new Input();  
}

function input_strval($which, $cmp="") {
global $INPUT;

   $val = $INPUT->str($which);
   if($cmp) return $cmp == $val;
   return $val;
}

?>