<?php
require_once 'Database.php';

class Visite {
    private $id;
    private $titre;
    private $dateheure;
    private $prix;
    private $capacite;
    private $langue;
    private $duree;
    private $statut;
    private $id_utilisateur; 

    public function __construct($titre, $prix, $langue, $duree, $capacite, $dateheure, $statut, $id_utilisateur, $id = null) {
        $this->id = $id;
        $this->titre = $titre;
        $this->prix = $prix;
        $this->langue = $langue;
        $this->duree = $duree;
        $this->capacite = $capacite;
        $this->dateheure = $dateheure;
        $this->statut = $statut;
        $this->id_utilisateur = $id_utilisateur;
    }

    public function getId() { return $this->id; }
    public function getTitre() { return $this->titre; }
    public function getDateHeure() { return $this->dateheure; }
    public function getPrix() { return $this->prix; }
    public function getCapacite() { return $this->capacite; }
    public function getLangue() { return $this->langue; }
    public function getDuree() { return $this->duree; }
    public function getStatut() { return $this->statut; }

    public function setTitre($titre) { $this->titre = $titre; }
    public function setStatut($statut) { $this->statut = $statut; }


    public static function creerVisite($titre, $langue, $prix, $duree, $capacite, $dateheure,
        $statut, $id_utilisateur, $etapes_titres = [], $etapes_descs = [],$ordre = []) {
        
        $database = new Database();
        $db = $database->getConnection();

        $sql_tours = "INSERT INTO visite_guidee (titre, dateheure, langue, capacite_max, duree, prix, statut, id_utilisateur) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)"; 
        
        $stmt = $db->prepare($sql_tours);
        
        if ($stmt->execute([$titre, $dateheure, $langue, $capacite, $duree, $prix, $statut, $id_utilisateur])) {
            
            $id_insr = $db->lastInsertId();

            if (!empty($etapes_titres) && is_array($etapes_titres)) {
                
                $sql_etape = "INSERT INTO etapesvisite (titreetape, descriptionetape, ordreetape, id_visite) VALUES (?, ?, ?, ?)";
                $stmt_etape = $db->prepare($sql_etape);

                // on boucle sur chaque titre reçu
                for ($i = 0; $i < count($etapes_titres); $i++) {
                    
                    $desc = isset($etapes_descs[$i]) ? $etapes_descs[$i] : "";
                    
                    $stmt_etape->execute([
                        $etapes_titres[$i], 
                        $desc, 
                        $ordre[$i],   
                        $id_insr    
                    ]);
                }
            }

            return true; 
        } 
        else {
            return false; 
        }
    }
}
?>