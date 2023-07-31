<?php 

class Button {
    public $data;
    public function __construct($data) {
        $this->data = $data;

        if(file_exists(__DIR__.'/button.component.html')){
            include('button.component.html');
        }
    }
}


?>