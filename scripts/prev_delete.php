<?php
define('DOKU_INC', realpath(dirname(__FILE__)) . '/../../../../');
require_once(DOKU_INC.'inc/init.php');
require_once(DOKU_INC.'inc/io.php');

$cname = $_REQUEST['draft_id'];
$cname = urldecode($cname);

if(file_exists($cname)) {
   if(unlink($cname)){
     echo  "$cname unlinked";   
     exit;
   }
   else {
     echo "unlink failed";   
   }
      
}

echo "done";

