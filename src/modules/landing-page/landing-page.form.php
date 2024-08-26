<?php
include_once($_SERVER['DOCUMENT_ROOT'] . "/src/classes/httproutes.php");
class LandingPageForm extends HttpRoutes
{

    private $data = [];

    public function __construct($data)
    {
        // Get the passed data
        if (is_array($data) && count($data) > 0) {
            $this->data = $data;
            $this->current_route = $data['url'];
        }
    }

    public function invoke()
    {
        echo "You invoked a function!";
    }

    public function invoke2()
    {
        echo "You invoked the second function!";
    }
}
