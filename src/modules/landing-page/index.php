<?php
    include_once('landing-page.controller.php');
    include_once('landing-page.form.php');
    
    class LandingPageModule extends LandingPageController {

        public function init(){
            include_once('components/components.php');
            $components = new Components();
            $components->initComponents();
            
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