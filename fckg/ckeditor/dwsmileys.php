<?php
/**
 lib/plugins/fckg/fckeditor/dwsmileys.php
*/

$SMILEYS = realpath(dirname(__FILE__).'/../../../../').'/conf/smileys.conf';
if(!file_exists($SMILEYS)) $SMILEYS ='/etc/dokuwiki/smileys.conf';
readfile($SMILEYS);
