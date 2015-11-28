<?php
define("DOKU_INC", realpath(dirname(__FILE__).'/../../../../') . '/');
require_once DOKU_INC . 'inc/init.php';
require_once DOKU_INC . 'inc/template.php';

  global $INPUT;
  $page = $INPUT->str('dw_id');  
  $page = urldecode($page);
  $page = ltrim($page, ':');

$t= trim(tpl_pagetitle($page,1));
  echo htmlentities($t) . "\n";

