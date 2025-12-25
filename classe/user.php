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

}  

?>