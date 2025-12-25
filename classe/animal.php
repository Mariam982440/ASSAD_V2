<?php
require_once 'database.php'
class Visite {
    // attributs privés
    private $id;
    private $nom;
    private $espece;
    private $alimentation;
    private $image;
    private $paysorigine;
    private $desc_courte;


    // Constructeur pour créer l'objet
    public function __construct($nom, $prix, $langue, $duree, $capacite, $dateheure, $statut, $id_utilisateur ) {
        $this->id = $id;
        $this->titre = $titre;
        $this->prix = $prix;
        $this->langue = $langue;
        $this->duree = $duree;
        $this->capacite = $capacite;
        $this->dateheure = $dateheure;
        $this->statut = $statut;
        $this->id_utilisateur = $id_utilisateur;
        $database = new Database(); 
        $this->db = $database->getConnection()
    
    }

    // getters (pour lire)
    public function getId() { return $this->id; }
    public function getTitre() { return $this->titre; }
    public function getDateHeure() { return $this->dateheure; }
    public function getPrix() { return $this->prix; }
    public function getCapacite() { return $this->capacite; }
    public function getLangue() { return $this->langue; }
    public function getDuree() { return $this->duree; }
    public function getStatut() { return $this->statut; }

    // setters (pour modifier)
    public function setTitre($titre) { $this->titre = $titre; }
    public function setTitre($statut) { $this->statut = $statut; }


    public static function creeVisite($titre, $langue, $prix,$duree,$capacite,$dateheure,$satut,$id_utilisateur){

        $sql_tours = "INSERT INTO 
            visite_guidee (titre, dateheure, langue, capacite_max, duree, prix, statut, id_utilisateur) 
            VALUES 
            ('$titre', '$dateheure', '$langue', $capacite, $duree, $prix, '$statut', $id_utilisateur)"; 
        $stmt = $db->prapare($sql_tours) ;
        if ($stmt->execute())
    }
}
?>