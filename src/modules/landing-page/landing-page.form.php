<?php 

class LandingPageForm {

    private $data;

    public function __construct($data)
    {
        // Get the passed data
        if(is_array($data) && count($data) > 0){
            $this->data = $data;
        }
    }

    public function get(){
        echo "GET data sent!";
    }

    public function post(){
        echo "POST data sent!";
    }

    public function put(){
        echo "PUT data sent!";
    }

    public function patch(){
        echo "PATCH data sent!";
    }

    public function delete(){
        echo "DELETE data sent!";
    }
}
?>