<?php
function listDirectory ($dir) {
  if (is_dir($dir)){
    if ($dh = opendir($dir)){
      while (($file = readdir($dh)) !== false) {
        echo "filename:" . $file . "<br>";
      }
      closedir($dh);
    }
  }
}

function getFiles ($dir) {
  $arr = array();
  if (is_dir($dir)){
    if ($dh = opendir($dir)){
      while (($file = readdir($dh)) !== false) {
        if ($file !== '.' && $file !== '..')
          array_push($arr, $file);
      }
      closedir($dh);
    }
  }

  return $arr;
}


 // echo $_SERVER['DOCUMENT_ROOT'];
?>
