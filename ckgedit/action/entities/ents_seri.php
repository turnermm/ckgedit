<?php

define('FCK_ACTION_SUBDIR', realpath(dirname(__FILE__)) . '/');

$entities = array();
serialize_ents('ents.data');
serialize_ents('fcked-ents.data');
serialize_ents('ents.merge.data');
$file = "";

if(isset($argv[1])) {
     $f = $argv[1];
     if ($f && file_exists($f)) $file = $f;
}
elseif(file_exists('add.ent')) {
  $file = 'add.ent';
 
}


if($file && file_exists($file)) {
   echo "adding entities from $file\n";
   serialize_ents($file);
}

$serialized = FCK_ACTION_SUBDIR . 'ent.ser';
file_put_contents($serialized,serialize($entities));
//$ents = unserialize(file_get_contents($serialized));
//print_r($ents);
exit;

function serialize_ents($file) {
global $entities;

    $entities_file = FCK_ACTION_SUBDIR . $file;
    if(!file_exists($entities_file)) return;
    $lines = file_get_contents($entities_file);
    $lines_array=preg_split('/^\n/ms',$lines);
  
    foreach ($lines_array as $line) {
        if(isset($line) && strlen($line)) { 
            list($icon, $numeric,$character) = @preg_split('/\s+/',$line);      
            if(!$icon || !$numeric || !$character) continue;
            $numeric = trim($numeric,'&#;'); 
            $character=trim($character,'&;');     
            $entities[$numeric] = $icon;
            $entities[$character] = $icon;  
        }


    }

     $entities[32] = ' ';
     $entities['nbsp'] = ' ';
}





?>
