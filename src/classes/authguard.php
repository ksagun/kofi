<?php 
    class AuthGuard {
        public bool $can_access;
        public string $redirect_url;

        public function __construct()
        {
            $this->can_access = true;
            $this->redirect_url = "";
        }
    
        public function canActivate(){
            return $this->can_access;
        }
    }

?>