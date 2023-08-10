<?php 

class LandingPageForm {

    private $data = [];
    private $current_route;

    public function __construct($data)
    {
        // Get the passed data
        if(is_array($data) && count($data) > 0){
            $this->data = $data;
        }
    }

    public function get($url, $invoke){
        echo "GET data sent!";
        if($url == $this->current_route){
            if(method_exists($this, $invoke)){
                call_user_func([$this, $invoke], $this->data);
            }
        }
    }

    public function post($url, $invoke){
        echo "POST data sent!";
        if($url == $this->current_route){
            if(method_exists($this, $invoke)){
                call_user_func([$this, $invoke], $this->data);
            }
        }
    }

    public function put($url, $invoke){
        echo "PUT data sent!";
        if($url == $this->current_route){
            if(method_exists($this, $invoke)){
                call_user_func([$this, $invoke], $this->data);
            }
        }
    }

    public function patch($url, $invoke){
        echo "PATCH data sent!";
        if($url == $this->current_route){
            if(method_exists($this, $invoke)){
                call_user_func([$this, $invoke], $this->data);
            }
        }
    }

    public function delete($url, $invoke){
        echo "DELETE data sent!";
        if($url == $this->current_route){
            if(method_exists($this, $invoke)){
                call_user_func([$this, $invoke], $this->data);
            }
        }
    }

    public function invoke(){
        echo "You envoked a function!";
    }
}
?>