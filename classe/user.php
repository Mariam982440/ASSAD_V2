<?php
require_once 'Database.php';

class User {
    
    protected $id;
    protected $nom;
    protected $email;
    protected $role;
    protected $db;

    public function __construct($id, $nom, $email, $role) {
        $this->id = $id;
        $this->nom = $nom;
        $this->email = $email;
        $this->role = $role;
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // getters communs à tout le monde
    public function getId() { return $this->id; }
    public function getNom() { return $this->nom; }
    public function getRole() { return $this->role; }
    public function getEmail() { return $this->email; }

    
    public static function inscrire($nom, $email, $password, $role) {
        
        $database = new Database();
        $db = $database->getConnection();

        $check = $db->prepare("SELECT id_usr FROM utilisateur WHERE email_usr = ?");
        $check->execute([$email]);

        if ($check->rowCount() > 0) {
            return "Cet email est déjà utilisé.";
        }

        // pour l'approbation guide = 0 autres = 1
        // le role admin est interdit
        if ($role == 'admin') {
            return "Action interdite."; 
        }
           
        $est_approuve = ($role == 'guide') ? 0 : 1;
            
        // hashage du mot de passe
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO utilisateur (nom_usr, email_usr, role_usr, motdepasse_hash, est_approuve) 
                VALUES (?, ?, ?, ?, ?)";
            
        $stmt = $db->prepare($sql);
            
        if ($stmt->execute([$nom, $email, $role, $hash, $est_approuve])) {
            return true; 
        } else {
            return "Erreur technique lors de l'enregistrement.";
        }
    }
}

?>