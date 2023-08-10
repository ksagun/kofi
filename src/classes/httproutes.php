<?php 

class HttpRoutes {
    protected $current_route;

    public function get($url, $invoke){
        if($url == $this->current_route){
            $parsed = $this->parseProtocol($invoke);
            $this->callInvokeFunc($parsed["invoke"], $parsed["protocol"]);
        }
    }

    public function post($url, $invoke){
        if($url == $this->current_route){
            $parsed = $this->parseProtocol($invoke);
            $this->callInvokeFunc($parsed["invoke"], $parsed["protocol"]);
        }
    }

    public function put($url, $invoke){
        if($url == $this->current_route){
            $parsed = $this->parseProtocol($invoke);
            $this->callInvokeFunc($parsed["invoke"], $parsed["protocol"]);
        }
    }

    public function patch($url, $invoke){
        if($url == $this->current_route){
            $parsed = $this->parseProtocol($invoke);
            $this->callInvokeFunc($parsed["invoke"], $parsed["protocol"]);
        }
    }

    public function delete($url, $invoke){
        if($url == $this->current_route){
            $parsed = $this->parseProtocol($invoke);
            $this->callInvokeFunc($parsed["invoke"], $parsed["protocol"]);
        }
    }

    protected function parseProtocol($invoke){
        $invoke = explode(":",$invoke);
        $protocol = "";

        if(count($invoke) == 2){
            $protocol = $invoke[1] == "rest" ? $invoke[1] : "form";
        } else {
            $protocol = "form";
        }

        return ["invoke" => $invoke[0], "protocol" =>$protocol];
    }

    private function callInvokeFunc($function_name, $protocol){
        echo $protocol;
        if(method_exists($this, $function_name)){
            if($protocol == "form"){
                call_user_func([$this, $function_name]);
            } else if($protocol == "rest"){
                ob_clean();
                call_user_func([$this, $function_name]);
                exit();
            }
        }
    }
}

?>