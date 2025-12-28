<?php
session_start();
require_once '../classe/User.php';
require_once '../classe/Animal.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') { header("Location: ../login.php"); exit(); }

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    Animal::supprimer($id);
}

header("Location: ../animal.php"); 
exit();
?>