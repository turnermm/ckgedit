<?php

global $dwfck_sessions_ini;


$dwfck_sessions_ini = false;
function dwfck_open($save_path, $session_name)
{
  global $dwfck_sessions_ini;
  global $sess_save_path;
  $dwfck_sessions_ini = true;
  $sess_save_path = $save_path;  
  return(true);
}

function dwfck_close()
{
  return(true);
}

function dwfck_read($id)
{
 
  global $sess_save_path;

  $sess_file = "$sess_save_path/sess_$id";
  file_put_contents('session_read.txt', $sess_file);
  return (string) @file_get_contents($sess_file);
}

function dwfck_write($id, $sess_data)
{
  
  global $sess_save_path;
  
  $sess_file = "$sess_save_path/sess_$id";
  file_put_contents('session_write.txt', $sess_file);
  if ($fp = @fopen($sess_file, "w")) {
    $return = fwrite($fp, $sess_data);
    fclose($fp);
    return $return;
  } else {
    return(false);
  }

}

function dwfck_destroy($id)
{

  global $sess_save_path;

  $sess_file = "$sess_save_path/sess_$id";
  return(@unlink($sess_file));
}

function dwfck_gc($maxlifetime)
{
  global $sess_save_path;

  foreach (glob("$sess_save_path/sess_*") as $filename) {
    if (filemtime($filename) + $maxlifetime < time()) {
      @unlink($filename);
    }
  }
  return true;
}

function dwfck_unserialize() {
     
     list($dw,$str) = explode('|',$sstr,2);     
     $inf = unserialize($str);
     $ar = print_r($inf, true);
     file_put_contents('DW_session', "$ar  $sstr");
}

function dwfck_session_start() {  
  global $dwfck_sessions_ini;
  if(isset($_REQUEST['FCK_NmSp_acl'])) {
   if(!$dwfck_sessions_ini) {
      session_set_save_handler("dwfck_open", "dwfck_close", "dwfck_read", "dwfck_write", "dwfck_destroy", "dwfck_gc");
   }
     session_id($_REQUEST['FCK_NmSp_acl']);
  }
  session_start(); 
}
?>

