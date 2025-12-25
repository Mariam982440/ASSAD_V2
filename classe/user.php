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

    public static function authentifier($email, $password) {

        $database = new Database();
        $db = $database->getConnection();

        $stmt = $db->prepare("SELECT * FROM utilisateur WHERE email_usr = ?");
        $stmt->execute([$email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && password_verify($password, $row['motdepasse_hash'])) {
            
            
            
            if ($row['role_usr'] === 'guide') {

                if ($row['est_approuve'] == 0) return "NonApprouve";

                return new Guide($row['id_usr'], $row['nom_usr'], $row['email_usr']);
            } 
            elseif ($row['role_usr'] === 'visiteur') {
                return new Visiteur($row['id_usr'], $row['nom_usr'], $row['email_usr']);
            }
            elseif ($row['role_usr'] === 'admin') {
                return new Admin($row['id_usr'], $row['nom_usr'], $row['email_usr']);
            }
        }
        return false;
    }
    public static function inscrire($nom, $email, $password, $role) {
        
        $database = new Database();
        $db = $database->getConnection();

        $check = $db->prepare("SELECT id_usr FROM utilisateur WHERE email_usr = ?");
        $check->execute([$email]);

        if ($check->rowCount() > 0) {
            return "Cet email est déjà utilisé.";
        }

        // le role admin est interdit
        if ($role == 'admin') {
            return "Action interdite."; 
        }

        // pour l'approbation guide = 0 autres = 1
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


