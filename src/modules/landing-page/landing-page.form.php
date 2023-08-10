<?php 
    include_once($_SERVER['DOCUMENT_ROOT']."/src/classes/httproutes.php");
    class LandingPageForm extends HttpRoutes{

        private $data = [];

        public function __construct($data)
        {
            $this->current_route = $_SERVER['REQUEST_URI'];
            // Get the passed data
            if(is_array($data) && count($data) > 0){
                $this->data = $data;
            }
        }

        public function invoke(){
            echo "You invoked a function!";
        }

        public function invoke2(){
            echo "You invoked the second function!";
        }
}
?>