<?php

class Security {
    
    public function encrypt_decrypt($action, $string) {
        $output = false;
    
        $encrypt_method = "AES-256-CBC";
        $secret_key = $this->getEnv()['YOUR_APP_SECRET']; //Change this to your ENV VARIABLE
        $secret_iv = $this->getEnv()['YOU_APP_SECOND_SECRET']; //Change this to your ENV VARIABLE
    
       
        $key = hash('sha256', $secret_key);
        
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
    
        if ( $action == 'encrypt') {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if( $action == 'decrypt') {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }
    
        return $output;
    }

    public function cleanRequestPayload($body){
        $encode = json_encode($body);
        $decode = json_decode($encode, true);
       
        foreach($decode as &$key){
            if(!is_bool($key)){
                $key = htmlspecialchars(trim($key), HTML_SPECIALCHARS);
            }
        }

        $json = json_encode($decode);
        return json_decode($json);
    }

    public function cleanQueryParams($params){
        foreach($params as &$key){
            if(!is_bool($key)){
                $key = htmlspecialchars(trim($key), HTML_SPECIALCHARS);
            }
        }

        return $params;
    }

    private function getEnv(){
        $env = parse_ini_file('.env');
        $ENVCONF = array_merge($_ENV, is_array($env) ? $env : []);
        return $ENVCONF;
    }
}

?>