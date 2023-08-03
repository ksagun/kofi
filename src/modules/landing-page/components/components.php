<?php  
   /*$files = glob(__DIR__.'/*', GLOB_ONLYDIR);

   foreach($files as $component){
      $name = explode("/",$component);
      include($component."/".$name[1].".component.php");
   }*/

  spl_autoload_register(function ($class_name) {
      include $class_name.'/'.$class_name . '.component.php';
  });

?>
