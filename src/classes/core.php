<?php

class KofiCore
{
    public string $page_title;

    public function InitPageMappings()
    {
        $this->SessionStart();
        $pageMaps = $this->PageMapping(["title" => PAGE_TITLES]);
        $this->page_title = array_key_exists('title', Routes::$selected_route) ? Routes::$selected_route['title'] : 'Document';
    }

    public function SessionStart()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function PageMapping($data)
    {

        if (array_key_exists("title", $data)) {
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
