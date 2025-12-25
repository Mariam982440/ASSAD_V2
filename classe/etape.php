<?php
require_once 'database.php';

class Etape {
    private $titre;
    private $description;
    private $ordre;
    private $id_visite;

    public function __construct($titre, $description, $ordre, $id_visite) {
        $this->titre = $titre;
        $this->description = $description;
        $this->ordre = $ordre;
        $this->id_visite = $id_visite;
    }

    // on passe $db en paramètre pour réutiliser la connexion de la visite (performance)
    public function enregistrer($db) {
        $sql = "INSERT INTO etapesvisite (titreetape, descriptionetape, ordreetape, id_visite) 
                VALUES (?, ?, ?, ?)";
        
        $stmt = $db->prepare($sql);
        return $stmt->execute([
            $this->titre,
            $this->description,
            $this->ordre,
            $this->id_visite
        ]);
    }
}
?>