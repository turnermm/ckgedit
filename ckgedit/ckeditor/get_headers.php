<?php
// define("DOKU_INC", realpath(dirname(__FILE__).'/../../../../../../../'). '/');
define("DOKU_INC", realpath(dirname(__FILE__).'/../../../../') . '/');

define ("DOKU_PLUGIN", DOKU_INC . 'lib/plugins/');
define("PAGES", DOKU_INC . 'data/pages/');
define("FCKEDITOR", DOKU_PLUGIN . 'ckgedit/fckeditor/editor/');
define('CONNECTOR', FCKEDITOR . 'filemanager/connectors/php/');
require_once(CONNECTOR . 'check_acl.php');
global $dwfck_conf;

if(isset($_REQUEST['dw_id']) && $_REQUEST['dw_id']) {
  $page = ltrim($_REQUEST['dw_id'], ':');
}
else $page = 'ebook';
$page = str_replace(':', '/',$page);
$path = PAGES . $page . '.txt';

$dwfck_conf = doku_config_values();  // needed for cleanID
$resp = "";
$headers = array();
$lines = file($path);

foreach ($lines as $line) {
   if (preg_match('/^=+([^=]+)=+\s*$/',$line,$matches)) {                            
          $suffix_anchor = "";
          $suffix_header = "";
          if(isset($headers[$matches[1]])) {
              $headers[$matches[1]]++;
              $suffix_anchor = $headers[$matches[1]]; 
              $suffix_header = " [$suffix_anchor]";
          }
          else {
            $headers[$matches[1]]=0;
          }
           
          $resp .=  trim($matches[1]) . $suffix_header . ";;" ;  
          $resp .= cleanID($matches[1]). $suffix_anchor . "@@" ;  
   }

}

$resp = rtrim($resp,'@');
echo  rawurlencode($resp);
//file_put_contents('ajax-resp.txt', "dw_id=" . $_REQUEST['dw_id'] . "\npage=$page\npath=$path\n$resp\n" );

echo "\n";
function doku_config_values() {
  $dwphp = DOKU_INC . 'conf/dokuwiki.php';
  $localphp = DOKU_INC . 'conf/local.php';
  if(file_exists($dwphp))
  {
    include($dwphp);
    if(file_exists($localphp))
    {
      include($localphp);
    }
    return $conf;
  }

  return false;
}
?>

