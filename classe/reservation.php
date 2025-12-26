<?php
require_once 'Database.php';

class Reservation {
    private $id;
    private $nbPersonnes;
    private $dateReservation;
    private $idVisite;
    private $idUtilisateur;
    private $db;

    public function __construct($nbPersonnes, $idVisite, $idUtilisateur, $id = null, $dateReservation = null) {
        $this->nbPersonnes = $nbPersonnes;
        $this->idVisite = $idVisite;
        $this->idUtilisateur = $idUtilisateur;
        $this->id = $id;
        $this->dateReservation = $dateReservation;

        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getId() { return $this->id; }
    public function getNbPersonnes() { return $this->nbPersonnes; }
    public function getDateReservation() { return $this->dateReservation; }
    public function getIdVisite() { return $this->idVisite; }
    public function getIdUtilisateur() { return $this->idUtilisateur; }

    public function ajouter() {
        
        if (!$this->verifierDisponibilite()) {
            return "Complet : Il ne reste pas assez de places.";
        }
        $sql = "INSERT INTO reservations (nbpersonnes, id_visite, id_utilisateur) 
                VALUES (?, ?, ?)";
        
        $stmt = $this->db->prepare($sql);

        if ($stmt->execute([
            $this->nbPersonnes,
            $this->idVisite,
            $this->idUtilisateur
        ])) {
            $this->id = $this->db->lastInsertId();
            return true; 
        } else {
            return "Erreur technique lors de l'enregistrement.";
        }
    }

    private function verifierDisponibilite() {
        $sqlInfo = "SELECT capacite_max FROM visite_guidee WHERE id = ?";
        $stmtInfo = $this->db->prepare($sqlInfo);
        $stmtInfo->execute([$this->idVisite]);
        $visite = $stmtInfo->fetch(PDO::FETCH_ASSOC);

        if (!$visite) return false; 

        $sqlCount = "SELECT SUM(nbpersonnes) as total FROM reservations WHERE id_visite = ?";
        $stmtCount = $this->db->prepare($sqlCount);
        $stmtCount->execute([$this->idVisite]);
        $result = $stmtCount->fetch(PDO::FETCH_ASSOC);

        $placesPrises = $result['total'] ? $result['total'] : 0;
        $placesRestantes = $visite['capacite_max'] - $placesPrises;

        if ($this->nbPersonnes <= $placesRestantes) {
            return true;
        } else {
            return false;
        }
    }

    public static function getMesReservations($id_user) {
        $database = new Database();
        $db = $database->getConnection();

        $sql = "SELECT r.*, v.titre, v.dateheure, v.prix 
                FROM reservations r
                JOIN visite_guidee v ON r.id_visite = v.id
                WHERE r.id_utilisateur = ?
                ORDER BY r.datereservation DESC";
        
        $stmt = $db->prepare($sql);
        $stmt->execute([$id_user]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>