<?php
define("DOKU_INC", realpath(dirname(__FILE__).'/../../../../') . '/');
require_once DOKU_INC . 'inc/init.php';
require_once DOKU_INC . 'inc/template.php';
if(isset($_REQUEST['dw_id']) && $_REQUEST['dw_id']) {
  $page = urldecode($_REQUEST['dw_id']);
  $page = ltrim($page, ':');
}
else {
echo $_REQUEST['dw_id'] . "\n";
exit;
}
$t= trim(tpl_pagetitle($page,1));
echo "$t\n";

