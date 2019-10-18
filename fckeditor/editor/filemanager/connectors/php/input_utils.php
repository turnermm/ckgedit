<?php
/**  
 *  Connector to Dokuwiki Input class
 *  sanitizes $_REQUEST variables
 *  @author Myron Turner
 */
 
require_once('./Input.class.php');
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
function inutils_write_debug($what) {
if(is_array($what)) {
   $what = print_r($what,true);
}
$dwfckFHandle = fopen("iutls_dbg.txt", "a");
fwrite($dwfckFHandle, "$what\n");
fclose($dwfckFHandle);
}
?>