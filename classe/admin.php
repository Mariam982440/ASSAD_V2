<?php
require_once 'User.php';

class Admin extends User {
    
    public function __construct($id, $nom, $email) {
        parent::__construct($id, $nom, $email, 'admin');
        
    }

    

}
?>