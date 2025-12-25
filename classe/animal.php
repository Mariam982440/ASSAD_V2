<?php
require_once 'database.php';
class Animal {

    private $id;
    private $nom;
    private $espece;
    private $alimentation;
    private $image;
    private $paysorigine;
    private $desc_courte;


    public function __construct($nom, $espece, $alimentation, $image, $paysorigine, $desc_courte) {
        $this->id = $id;
        $this->nom = $nom;
        $this->espece = $espece;
        $this->alimentation = $alimentation;
        $this->image = $image;
        $this->paysorigine = $paysorigine;
        $this->desc_courte = $desc_courte;
        $database = new Database(); 
        $this->db = $database->getConnection();
    
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
    


    public static function creeVisite($titre, $langue, $prix,$duree,$capacite,$dateheure,$satut,$id_utilisateur){

        $database = new Database(); 
        $this->db = $database->getConnection();
        
        $imageName = "";
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $imageName = time() . "_" . $_FILES['image']['name']; 
            move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/" . $imageName);
        }

        $sql = "INSERT INTO animal (nom_al, espece, paysorigine, descriptioncourte, id_habitat, image) 
                VALUES ('$nom', '$espece', '$pays', '$desc', '$habitat', '$imageName')";

        if (mysqli_query($conn, $sql)) {
            header("Location: ../animal.php"); 
            exit();
        } else {
            $message = "Erreur SQL : " . mysqli_error($conn);
        }
       
    }
}
?>