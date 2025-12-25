<?php
require_once 'User.php';

class Guide extends User {

    public function __construct($id, $nom, $email) {
        parent::__construct($id, $nom, $email, 'guide');
    }

    public function creerVisite($titre, $date, $langue, $prix, $duree, $capacite) {
        $sql = "INSERT INTO visite_guidee (titre, dateheure, langue, prix, duree, capacite_max, id_utilisateur, statut) 
                VALUES (?, ?, ?, ?, ?, ?, ?, 'plannifie')";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$titre, $date, $langue, $prix, $duree, $capacite, $this->id]);
    }

    public function getMesVisites() {
        $stmt = $this->db->prepare("SELECT * FROM visite_guidee WHERE id_utilisateur = ?");
        $stmt->execute([$this->id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>