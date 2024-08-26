<?php
// Initiialize app src
include_once("classes/router.php");
include_once("classes/authguard.php");
include_once("classes/config.php");
include_once("classes/core.php");
require_once("autoload.php");

class App extends KofiCore
{
    private $router;

    public function __construct()
    {
        $this->router = new Router([
            "/" => [
                "module" => new LandingPageModule,
                "guard" => new AuthGuard,
                "form" => [
                    ["url" => "/submit", "method" => "GET", "invoke" => "invoke"],
                    ["url" => "/submit2", "method" => "POST", "invoke" => "invoke2:rest"]
                ],
                "title" => "Landing Page | kofi"
            ],
            "error" => ["module" => new NotFoundPageModule]
        ]);
        $this->InitPageMappings();
    }

    public function init()
    {
        $this->router->start();
    }
}
