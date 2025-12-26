<?php
require_once 'Database.php';

class Habitat {
    private $id;
    private $nom;
    private $typeClimat;
    private $description;
    private $zoneZoo;
    private $db;

    public function __construct($nom = null, $typeClimat = null, $description = null, $zoneZoo = null, $id = null) {
        $this->id = $id;
        $this->nom = $nom;
        $this->typeClimat = $typeClimat;
        $this->description = $description;
        $this->zoneZoo = $zoneZoo;
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getId() { return $this->id; }
    public function getNom() { return $this->nom; }
    public function getTypeClimat() { return $this->typeClimat; }
    public function getDescription() { return $this->description; }
    public function getZoneZoo() { return $this->zoneZoo; }

    public function setNom($nom) { $this->nom = $nom; }
    public function setTypeClimat($type) { $this->typeClimat = $type; }
    public function setDescription($desc) { $this->description = $desc; }
    public function setZoneZoo($zone) { $this->zoneZoo = $zone; }

    
    public function ajouter() {
        $sql = "INSERT INTO habitatt (nom_hab, typeclimat, description_hab, zonezoo) 
                VALUES (?, ?, ?, ?)";
        
        $stmt = $this->db->prepare($sql);
        
        if ($stmt->execute([$this->nom, $this->typeClimat, $this->description, $this->zoneZoo])) {
            $this->id = $this->db->lastInsertId();
            return true;
        }
        return false;
    }

    
    public function modifier() {
        if ($this->id === null) return false;

        $sql = "UPDATE habitatt SET nom_hab = ?, typeclimat = ?, description_hab = ?, zonezoo = ? 
                WHERE id_hab = ?";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $this->nom, 
            $this->typeClimat, 
            $this->description, 
            $this->zoneZoo, 
            $this->id
        ]);
    }

    
    public function supprimer() {
        if ($this->id === null) return false;

        $stmt = $this->db->prepare("DELETE FROM habitatt WHERE id_hab = ?");
        return $stmt->execute([$this->id]);
    }

    
    public static function getAll() {
        $database = new Database();
        $db = $database->getConnection();
        
        $stmt = $db->query("SELECT * FROM habitatt ORDER BY nom_hab ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public static function getById($id) {
        $database = new Database();
        $db = $database->getConnection();

        $stmt = $db->prepare("SELECT * FROM habitatt WHERE id_hab = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Habitat(
                $row['nom_hab'], 
                $row['typeclimat'], 
                $row['description_hab'], 
                $row['zonezoo'], 
                $row['id_hab']
            );
        }
        return null;
    }
}
?>

<?php
require_once 'Database.php';

