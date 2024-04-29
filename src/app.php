<?php
// Initiialize app src
include_once("classes/router.php");
include_once("classes/authguard.php");
include_once("classes/config.php");
include_once("classes/core.php");
require_once("autoload.php");

class App extends KofiCore{

    public function init(){
        $router = new Router([
            "/" => [
                "module" => new LandingPageModule, 
                "guard" => new AuthGuard,
                "form" => [
                    ["url" => "/submit", "method" => "GET", "invoke" => "invoke"],
                    ["url" => "/submit", "method" => "POST", "invoke" => "invoke2:rest"]
                ],
            ],
            "error" => ["module" => new NotFoundPageModule]
        ]);
    }
}



?>