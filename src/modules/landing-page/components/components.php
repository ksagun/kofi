<?php  
  class Components {
      public function initComponents(){
         $files = glob(__DIR__.'/*', GLOB_ONLYDIR);

         foreach($files as $component){
            $name = explode("/",$component);
            include($component."/".$name[1].".component.php");
         }
      }
  }
?>