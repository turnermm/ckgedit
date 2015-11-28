<?php
define('DOKU_INC', realpath(dirname(__FILE__)) . '/../../../../');
require_once(DOKU_INC.'inc/init.php');
require_once(DOKU_INC.'inc/io.php');

//$cname = $_REQUEST['draft_id'];
$cname = $INPUT->str('draft_id');
$cname = urldecode($cname);
if(!preg_match("#/data/cache/\w/[a-f0-9]{32}\.draft$#i", $cname)) return;
if(file_exists($cname)) {
   if(unlink($cname)){
     echo  "$cname unlinked";   
     exit;
   }
   else {
     echo "unlink failed";   
   }
      
}

echo "$cname done";

