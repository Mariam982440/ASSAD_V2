<?php
require_once 'User.php';

class Guide extends User {

    public function __construct($id, $nom, $email) {
        parent::__construct($id, $nom, $email, 'guide');
    }

    

    public function getMesVisites() {
        $stmt = $this->db->prepare("SELECT * FROM visite_guidee WHERE id_utilisateur = ?");
        $stmt->execute([$this->id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>