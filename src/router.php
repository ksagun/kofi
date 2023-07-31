<?php

class Router
{

    private static $current_url;

    public function __construct($routes)
    {
        $request = $_SERVER['REQUEST_URI'];
        self::$current_url = trim($request);
      
        $params = $this->paramsMap($routes, self::$current_url);
        $formPathMatch = $this->formPathMatchFull($routes, self::$current_url);

        $notFound = false;

        if(count($params) > 0 && $formPathMatch['hasform'] == 0){
            if(array_key_exists($params["url"], $routes)){
                $url = $params["url"];
                $module = $routes[$url]["module"];
                $guard = array_key_exists("guard", $routes[$url]) ? $routes[$url]["guard"] : false;
                
                if(is_object($module)){
                    if(is_object($guard)){  
                        if($guard->canActivate() == true){
                            $module->init();
                        } else {
                            echo "You are not authorized to access this page.";
                        }
                    } else {
                        $module->init();
                    }
                } else {
                    $notFound = true;
                }
            }
        } else if($formPathMatch["hasform"] == 1){
            $module = $routes[$formPathMatch["key"]]["module"];
            $method = $formPathMatch["matches"][0];
            if($method["method"] == 'POST') $module->initForm()->post();
            else if($method["method"] == 'GET') $module->initForm()->get();
            else if($method["method"] == 'PUT') $module->initForm()->put();
            else if($method["method"] == 'PATCH') $module->initForm()->patch();
        } else{
            $notFound = true;   
        }

        if($notFound == 1){
            if(array_key_exists("error", $routes)){
                $module = $routes["error"]["module"];
                if(is_object($module)){
                    $module->init();    
                } else {
                    echo "Page not found";
                }
            } else {
                echo "Page not found";
            }
        }
    }

    public function routeMatch($url){
        $url = ltrim($url, "/");
        $url_map = explode("/", $url);
        return $url_map;
    }

    public function formPathMatchFull($route, $url){
        $matches = [];
        $formParentKey = null;

        foreach($route as $key => $row){
            if(array_key_exists("form", $route[$key])){
              $form = $row["form"];

              $formParentKey = $key;
              foreach($form as $item){
                // echo "Current URL: ".$url."<br>";
                // echo "URL from routing: ".$item['url']."<br>";
                if($url == $item["url"] && $item["method"] == $_SERVER['REQUEST_METHOD']){
                    array_push($matches, $item);
                }
              }
            }

            if(count($matches) > 0 ) break;
        }

        if(count($matches) > 0){
            return ["hasform" => 1, "matches" => $matches, "key" => $formParentKey]; 
        } else {
            return ["hasform" => 0, "matches" => $matches, "key" => null]; 
        }
    }

    public function paramsMap($routes, $currenturl){
        $routeKeys = array_keys($routes);
        $matched = [];

        for($i = 0; $i < count($routeKeys); $i++){
            $result = $this->pathMatch($routeKeys[$i], $currenturl);
            if ($result !== false) {
                // echo "Matched values: " . implode(", ", $result)."<br>";
                $matched = ["url" => $routeKeys[$i], "data" => $result];
                break;
            } else {
                // echo "URL path does not match the expected pattern."."<br>";
            }
        }

        return $matched;
    }

    public function pathMatch($pattern, $url ){
        $pattern = str_replace('/', '\/', $pattern); // Escape forward slashes in the pattern
        $pattern = '~^' . $pattern . '$~'; // Add start and end anchors to the pattern
    
        // Extract placeholders from the pattern
        preg_match_all('~\{([^/}]+)\}~', $pattern, $matches);
        $placeholders = $matches[1];
    
        // Replace placeholders with capture groups in the pattern
        $captureGroups = [];
        foreach ($placeholders as $index => $placeholder) {
            $captureGroups[] = '([^/]+)';
            $pattern = str_replace('{' . $placeholder . '}', $captureGroups[$index], $pattern);
        }
    
        if (preg_match($pattern, $url, $matches)) {
            $values = array_slice($matches, 1);
            return array_combine($placeholders, $values);
        } else {
            return false;
        }
    }


}