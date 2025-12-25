<?php
require_once 'User.php';

class Visiteur extends User {

    public function __construct($id, $nom, $email) {
        parent::__construct($id, $nom, $email, 'visiteur');
    }

    public function reserverVisite($idVisite, $nbPersonnes) {
        
        $sql = "INSERT INTO reservations (nbpersonnes, id_visite, id_utilisateur) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$nbPersonnes, $idVisite, $this->id]);
    }
}
?>