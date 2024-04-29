<?php  
  class Components {
      public function initComponents(){
         $files = glob(__DIR__.'/*', GLOB_ONLYDIR);

         foreach($files as $component){
            $seperate = str_replace(['/', '\\'], ',', $component);
            $name = explode(",",$seperate);
            include($component."/".$name[count($name) - 1].".component.php");
            
            // $name = explode("/",$component);
            // include($component."/".$name[1].".component.php");
         }
      }
  }
?>