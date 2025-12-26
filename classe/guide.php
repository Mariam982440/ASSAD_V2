<?php
require_once 'User.php';

class Guide extends User {
    private $estApprouve;

    public function __construct($id, $nom, $email, $estApprouve) {
        parent::__construct($id, $nom, $email, 'guide');
        
        $this->estApprouve = $estApprouve;
    }

    public function isApprouve() {
        return $this->estApprouve == 1; 
    }

}
?>