<?php
define("DOKU_INC", realpath(dirname(__FILE__).'/../../../../') . '/');
define ("DOKU_PLUGIN", DOKU_INC . 'lib/plugins/');
define("PAGES", DOKU_INC . 'data/pages/');
define("FCKEDITOR", DOKU_PLUGIN . 'ckgedit/fckeditor/editor/');
define('CONNECTOR', FCKEDITOR . 'filemanager/connectors/php/');
require_once(CONNECTOR . 'check_acl.php');
if(file_exists(DOKU_INC.'inc/Input.class.php')) {
require_once(DOKU_INC.'inc/Input.class.php');
}
else {  
 require_once(DOKU_PLUGIN . 'ckgedit/fckeditor/editor/filemanager/connectors/php/Input.class.php');
}
require_once(CONNECTOR . 'SafeFN.class.php');
global $dwfck_conf;
global $Dwfck_conf_values;
$INPUT = new Input();
$page = $INPUT->str('dw_id');
$page =  ltrim($page, ':');

$dwfck_conf = doku_config_values();  // needed for cleanID
$Dwfck_conf_values = $dwfck_conf;
$page = str_replace(':', '/',$page);
$page = dwiki_encodeFN($page);

if(!empty($Dwfck_conf_values['ckg_savedir'])) {
  if (stristr(PHP_OS, 'WIN')) {
      $path = realpath(DOKU_INC . $Dwfck_conf_values['ckg_savedir']);
      $path  .= '/pages/' . $page . '.txt';
  }  
  else $path = $Dwfck_conf_values['ckg_savedir'] . '/pages/' . $page . '.txt';
}
else $path = PAGES . $page . '.txt';

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
  $conf['ckg_savedir']= false;
  if(file_exists($dwphp))
  {
    include($dwphp);
    if(file_exists($localphp))
    {
      include($localphp);
    }
    $sv = preg_replace("#^\.+/#","",$conf['savedir']);
    if($sv != 'data') {
     $conf['ckg_savedir']= $conf['savedir'];
   }
    return $conf;
  }

  return false;
}
?>

