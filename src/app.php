<?php
// Initiialize app src
include_once("router.php");
require_once("autoload.php");
class App {

    /* 
     =======================================================================================================
        THIS FILE IS WHERE YOU CALL AND SET YOUR ROUTES
        module - The main module of your page
        form - Add form optionally per module, you can set url that can be called from your form submition
        guard - You can add authorization or authentication in guard and this will block the access of the page depending on your condition
        error - Add custom error page to use for page not found or unauthorized pages
        In this file you will only modify the router code and nothing else


        Example below:
     =======================================================================================================

     "/menu" => ["module" => new MenuPageModule, "form" => [["url" => "/menu/orders", "method" => "POST"]]],
     "/orders" => [
                      "module" => new OrdersPageModule, 
                      "form" => [
                          ["url" => "/order/remove", "method" => "POST"],
                          ["url" => "/orders/checkout", "method" => "POST"]
                   ]
            ],
     */

    public function init(){
        $router = new Router([
            "/" => ["module" => new LandingPageModule, "guard" => new AuthGuard] //[module, guard, form]
        ]);
    }
}


class AuthGuard {
    public bool $can_access;
    public function __construct()
    {
        $this->can_access = true;
    }

    public function canActivate(){
        return $this->can_access;
    }
}
?>