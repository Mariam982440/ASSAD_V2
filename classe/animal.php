
<?php
require_once 'Database.php';

class Animal {
    private $id;
    private $nom;
    private $espece;
    private $alimentation;
    private $image;
    private $paysorigine;
    private $desc_courte;
    private $id_habitat; 

    public function __construct($nom, $espece, $alimentation, $image, $paysorigine, $desc_courte, $id_habitat, $id = null) {
        $this->id = $id;
        $this->nom = $nom;
        $this->espece = $espece;
        $this->alimentation = $alimentation;
        $this->image = $image;
        $this->paysorigine = $paysorigine;
        $this->desc_courte = $desc_courte;
        $this->id_habitat = $id_habitat; 
    }

    public function getId() { return $this->id; }
    public function getNom() { return $this->nom; }
    public function getEspece() { return $this->espece; }
    public function getAlimentation() { return $this->alimentation; }
    public function getImage() { return $this->image; }
    public function getPaysorigine() { return $this->paysorigine; }
    public function getDesc_courte() { return $this->desc_courte; }
   

    public function setNom($nom) { $this->nom = $nom; }
    public function setEspece($espece) { $this->espece = $espece;}
    public function setAlimentation($alimentation) { $this->alimentation = $alimentation; }
    public function setImage($image) { $this->image = $image; }
    public function setPaysorigine($paysorigine) { $this->paysorigine = $paysorigine; }
    public function setDesc_courte($desc_courte) { $this->desc_courte = $desc_courte; }

    public function ajouterAnimal() {
        $database = new Database();
        $db = $database->getConnection();

        $sql = "INSERT INTO animal (nom_al, espece, alimentation, image, paysorigine, descriptioncourte, id_habitat) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $db->prepare($sql);

        return $stmt->execute([
            $this->nom,
            $this->espece,
            $this->alimentation,
            $this->image,
            $this->paysorigine,
            $this->desc_courte,
            $this->id_habitat
        ]);
    }

    public static function getListanimaux() {
        $database = new Database();
        $db = $database->getConnection();
        $sql = "SELECT a.*, h.nom_hab 
                FROM animal a 
                LEFT JOIN habitatt h ON a.id_habitat = h.id_hab";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getPays() {
        $database = new Database();
        $db = $database->getConnection();
        
        $sql = "SELECT DISTINCT paysorigine FROM animal WHERE paysorigine IS NOT NULL AND paysorigine != '' ORDER BY paysorigine ASC";
        $stmt = $db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public static function rechercher($id_habitat = null, $pays = null, $recherche_nom = null) {
        $database = new Database();
        $db = $database->getConnection();

        
        $sql = "SELECT a.*, h.nom_hab 
                FROM animal a 
                LEFT JOIN habitatt h ON a.id_habitat = h.id_hab 
                WHERE 1=1"; 

        $params = [];

        // filtre Habitat
        if (!empty($id_habitat)) {
            $sql .= " AND a.id_habitat = ?";
            $params[] = $id_habitat;
        }

        // filtre Pays
        if (!empty($pays)) {
            $sql .= " AND a.paysorigine = ?";
            $params[] = $pays;
        }

        // filtre recherche nom 
        if (!empty($recherche_nom)) {
            $sql .= " AND a.nom_al LIKE ?";
            $params[] = "%" . $recherche_nom . "%";
        }

        $sql .= " ORDER BY a.id_al DESC";

        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>