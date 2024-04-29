<?php 

class KofiCore {
    
    public string $page_title;

    public function __construct(){
        $this->SessionStart();
        $pageMaps = $this->PageMapping(["title"=> PAGE_TITLES]);
        $this->page_title = $pageMaps['PAGE_TITLE'];
    }

    public function SessionStart(){
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function PageMapping($data){

        if(array_key_exists("title", $data)){
            $request = $_SERVER['REQUEST_URI'];
            return [
                "PAGE_TITLE" => array_key_exists($request, $data['title']) ? $data['title'][$request] : "Document"
            ];
        }

        return [
            "PAGE_TITLE" => "Document"
        ];
    }
}
?>