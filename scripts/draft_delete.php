<?php
define('DOKU_INC', realpath(dirname(__FILE__)) . '/../../../../');
require_once(DOKU_INC.'inc/init.php');
require_once(DOKU_INC.'inc/io.php');

$cname = $_REQUEST['draft_id'];
$cname = urldecode($cname);
if(!preg_match("#/data/cache/\w/[a-f0-9]{32}\.draft$#i", $cname)) return;
$ckgedit_cname = $cname . '.fckl';


if(file_exists($cname)) {
   @io_lock($cname);
   if(file_exists($ckgedit_cname)) {
      unlink($ckgedit_cname); 
   }
   unlink($cname); 

  exit;
}

echo "done";

