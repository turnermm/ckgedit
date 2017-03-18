<?php
/**
 lib/plugins/ckgedit/fckeditor/dwsmileys.php
*/

$SMILEYS = realpath(dirname(__FILE__).'/../../../../').'/conf/smileys.conf';
if(!file_exists($SMILEYS)) $SMILEYS ='/etc/dokuwiki/smileys.conf';
$LOCAL = preg_replace("/\.conf$/", '.local.conf', $SMILEYS) ;
if(file_exists($LOCAL)) readfile($LOCAL);
readfile($SMILEYS);