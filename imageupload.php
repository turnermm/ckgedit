<?php
/**
 * DokuWiki AJAX call handler for ckgedit uploadimage plugin
 *
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Andreas Gohr <andi@splitbrain.org>
 * @author     community
 */

if(!defined('DOKU_INC')) define('DOKU_INC', dirname(__FILE__) . '/../../../');
require_once(DOKU_INC . 'inc/init.php');

//close session
session_write_close();

// default header, ajax call may overwrite it later
header('Content-Type: text/html; charset=utf-8');


global $INPUT;
$INPUT->post->set('mediaid',"");
$INPUT->post->set('ow',false);


$_FILES['qqfile']=$_FILES['upload'];  // really needed!!!
$filename=$_FILES['upload']['name'] ;

ob_start();
new \dokuwiki\Ajax("mediaupload");
$call_ret = json_decode(ob_get_clean());

$ret = array("uploaded"=>0, "fileName" => $filename,"url" => "lib/exe/fetch.php?media=".$NS.":".$filename);

if ($call_ret->success)
{
 $ret["uploaded"]=1;
}else
{
 $ret["error"]["message"] = "Error uploading the file \"".$filename."\" to namespace \"".$NS."\"";
}

echo json_encode($ret);


