<?php
/**
../../../../conf/scheme.conf
*/

$SCHEMES = realpath(dirname(__FILE__).'/../../../../').'/conf/scheme.conf';
readfile($SCHEMES);
