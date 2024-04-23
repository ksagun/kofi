<?php

include_once("routes.php");

class Router extends Routes
{
    private static $current_url;
    
    public function __construct($routes)
    {
        $request = $_SERVER['REQUEST_URI'];
        self::$current_url = trim($request);
        self::set_current_route(self::$current_url);
      
        $params = $this->paramsMap($routes, self::$current_url);
        $formPathMatch = $this->formPathMatchFull($routes, self::$current_url);

        $notFound = false;

        if(count($params) > 0 && $formPathMatch['hasform'] == 0){
            if(array_key_exists($params["url"], $routes)){
                $url = $params["url"];
                $pathParams = $params["data"];
                $module = $routes[$url]["module"];
                $guard = array_key_exists("guard", $routes[$url]) ? $routes[$url]["guard"] : false;
                
                if(is_object($module)){
                    self::set_route_params($pathParams);
                    if(is_object($guard)){  
                        if($guard->canActivate() == true){
                            $module->init();
                        } else {
                            if($guard->redirect_url != ""){
                                header("Location: ".$guard->redirect_url);
                            } else {
                                echo "<p class='text-center'>You are not authorized to access this page.</p>";
                                header("HTTP/1.1 401 Unauthorized");
                                exit;
                            }
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

            if(!array_key_exists("invoke",$method)) return exit("Please add invoke array key and add the function to be invoked.");

            if($method["method"] == 'POST' && $_SERVER['REQUEST_METHOD'] == 'POST') $module->initForm()->post($method["url"],$method["invoke"]);
            else if($method["method"] == 'GET' && $_SERVER['REQUEST_METHOD'] == 'GET') $module->initForm()->get($method["url"],$method["invoke"]);
            else if($method["method"] == 'PUT' && $_SERVER['REQUEST_METHOD'] == 'PUT') $module->initForm()->put($method["url"],$method["invoke"]);
            else if($method["method"] == 'PATCH' && $_SERVER['REQUEST_METHOD'] == 'PATCH') $module->initForm()->patch($method["url"],$method["invoke"]);
        } else{
            $notFound = true;   
        }

        if($notFound == 1){
            if(array_key_exists("error", $routes)){
                $module = $routes["error"]["module"];
                if(is_object($module)){
                    $module->init(); 
                } else {
                    throw new Exception("Error route module must be object.");
                }
            } else {
                echo "Page not found";
            }
        }
    }

    private function formPathMatchFull($route, $url){
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

    private function paramsMap($routes, $currenturl){
        $routeKeys = array_keys($routes);
        $matched = [];

        $matchedPathIndex = array_search($currenturl, $routeKeys);


        if($matchedPathIndex !== false){
            $result = $this->pathMatch($routeKeys[$matchedPathIndex], $currenturl);
            if ($result !== false) {
                $matched = ["url" => $routeKeys[$matchedPathIndex], "data" => $result];
            }
        } else {
            for($i = 0; $i < count($routeKeys); $i++){
                $result = $this->pathMatch($routeKeys[$i], $currenturl);
                if ($result !== false) {
                    $matched = ["url" => $routeKeys[$i], "data" => $result];
                    break;
                }
            }
        }

        return $matched;
    }

    private function pathMatch($pattern, $url){
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