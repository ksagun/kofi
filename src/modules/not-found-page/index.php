<?php 
    include_once("not-found-page.controller.php");
    
    class NotFoundPageModule extends NotFoundController {
        public function init(){
            include($this->template_name);
            define("CONTROLLER_JS", $this->js);
            define("CONTROLLER_STYLE", $this->style);
        }
    }
?>