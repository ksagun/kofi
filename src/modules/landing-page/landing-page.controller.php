<?php 

class LandingPageController {
    public string $template_name = "landing-page.view.html";
    public string $style = "landing-page/landing-page.style.css";
    public string $js = "landing-page/landing-page.controller.js";

     
    
    public function clearSetSession($key){
        unset($_SESSION[$key]);
    }
}
?>