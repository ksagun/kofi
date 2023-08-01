<?php
    include_once('landing-page.controller.php');
    include_once('landing-page.form.php');
    
    // Call components php file to autoload components
    include_once('components/components.php');

    class LandingPageModule extends LandingPageController {

        public function init(){
            include($this->template_name);
            define("CONTROLLER_JS", $this->js);
            define("CONTROLLER_STYLE", $this->style);
        }

        public function initForm(){
            $form = new LandingPageForm([]);
            return $form;
        }
    }
?>