<?php
session_start();
require_once '../classe/Habitat.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') { 
    header("Location: ../login.php"); 
    exit(); 
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    Habitat::supprimer($id);
}

header("Location: ../asaad.php");
exit();
?>