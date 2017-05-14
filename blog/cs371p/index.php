<?php
  $root = '/home/www/' . $_SERVER['env_vhost'];
  $functions = $root . '/functions.php';

  include_once ($functions);

  $curPath = $root . '/blog/cs371p/';

  $a = getFiles ($curPath);

  foreach ($a as $key => $value) {
    if (!strpos($value, "w"))
      echo "NOPE";
    else
      echo "<a href='$value'>$key - $value</a> <br />";
  }
?>
