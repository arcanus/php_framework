<?php
  include 'core/autoload.php';

  if(config\globalConfig::getEnv() == 'dev')
  {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Vista por defecto</title>
  </head>
  <body>

  

  </body>
</html>
