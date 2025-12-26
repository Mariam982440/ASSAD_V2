<?php
require_once 'User.php';

class Visiteur extends User {
    
    private $estActif;

    public function __construct($id, $nom, $email, $estActif) {
        parent::__construct($id, $nom, $email, 'visiteur');
        $this->estActif = $estActif;
    }

    public function isActif() {
        return $this->estActif == 1;
    }

    // methode pour l'admin
    public function desactiver() {
        $this->estActif = 0;
    }
}
?>