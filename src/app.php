<?php
// Initiialize app src
include_once("classes/router.php");
include_once("classes/authguard.php");
require_once("autoload.php");
class App {

    public function init(){
        $router = new Router([
            "/" => [
                "module" => new LandingPageModule, 
                "guard" => new AuthGuard,
                "form" => [
                    ["url" => "/submit", "method" => "POST"]
                ],
            ],
            "error" => ["module" => new NotFoundPageModule]
        ]);
    }
}



?>