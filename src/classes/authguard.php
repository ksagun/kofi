<?php 
    class AuthGuard {
        public bool $can_access;
        public function __construct()
        {
            $this->can_access = true;
        }
    
        public function canActivate(){
            return $this->can_access;
        }
    }

?>