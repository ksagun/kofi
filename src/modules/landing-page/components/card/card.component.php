<?php 
 
 class Card {
    public $data;
    public function __construct($data) {
        $this->data = $data;

        if(file_exists(__DIR__.'/card.component.html')){
            include('button.component.html');
        }
    }
 }
?>