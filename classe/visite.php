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


    public function enregistrer($etapes_titres = [], $etapes_descs = [], $etapes_ordres = []) {
        
        $database = new Database();
        $db = $database->getConnection();

        $sql_tours = "INSERT INTO visite_guidee (titre, dateheure, langue, capacite_max, duree, prix, statut, id_utilisateur) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)"; 
        
        $stmt = $db->prepare($sql_tours);
        
        if ($stmt->execute([
            $this->titre,       
            $this->dateheure,
            $this->langue,
            $this->capacite,
            $this->duree,
            $this->prix,
            $this->statut,
            $this->id_utilisateur
        ])) {
            
            $this->id = $db->lastInsertId(); 

            if (!empty($etapes_titres) && is_array($etapes_titres)) {
                
                require_once 'Etape.php'; 

                for ($i = 0; $i < count($etapes_titres); $i++) {
                    
                    $desc = isset($etapes_descs[$i]) ? $etapes_descs[$i] : "";
                    $ordre = isset($etapes_ordres[$i]) ? $etapes_ordres[$i] : ($i + 1);

                    $nouvelleEtape = new Etape($etapes_titres[$i], $desc, $ordre, $this->id);
                    
                    $nouvelleEtape->enregistrer($db);
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