<?php

if(!defined('DOKU_INC')) define('DOKU_INC',realpath(dirname(__FILE__).'/../../../../../../../../').'/');
define ('CKG_META_DIR',DOKU_INC .'data/meta');

function ckg_get_title($page,$dir) {
   
  $id = preg_replace('/.txt/','.meta',$page) ; 
 
      $meta_file = CKG_META_DIR . $dir . $id;
      if(file_exists($meta_file) && is_readable ($meta_file)){
           $inf_str = file_get_contents($meta_file);
           $inf = @unserialize($inf_str);
           if(isset($inf['current']['title']) && !empty($inf['current']['title'])) {
               return ($inf['current']['title']);
           }      
      }  
      return "";      
 }

