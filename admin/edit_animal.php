<?php
session_start();
require_once '../classe/User.php';
require_once '../classe/Animal.php';
require_once '../classe/Habitat.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') { header("Location: ../login.php"); exit(); }

if (!isset($_GET['id'])) { header("Location: ../animal.php"); exit(); }

$id_animal = intval($_GET['id']);
$animalObj = Animal::getById($id_animal); 

if (!$animalObj) die("Animal introuvable");

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $imageNom = $animalObj->getImage(); 
    
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageNom = time() . "_" . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/" . $imageNom);
    }

    $animalObj->setNom($_POST['nom']);
    $animalObj->setEspece($_POST['espece']);
    $animalObj->setAlimentation($_POST['alimentation']);
    $animalObj->setPaysorigine($_POST['pays']);
    $animalObj->setDesc_courte($_POST['description']);
    $animalObj->setImage($imageNom);
    
    if ($animalObj->modifier()) {
        $message = "<div class='text-green-600 font-bold mb-4'>Modifications enregistrées !</div>";
        $animalObj = Animal::getById($id_animal);
    } else {
        $message = "<div class='text-red-600 font-bold mb-4'>Erreur lors de la modification.</div>";
    }
}

$listeHabitats = Habitat::getAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Animal</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 py-10">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold mb-6">Modifier : <?= $animalObj->getNom() ?></h2>
        <?= $message ?>
        
        <form method="POST" enctype="multipart/form-data" class="space-y-4">
            <input type="text" name="nom" value="<?= $animalObj->getNom() ?>" class="w-full border p-2 rounded" placeholder="Nom">
            <input type="text" name="espece" value="<?= $animalObj->getEspece() ?>" class="w-full border p-2 rounded" placeholder="Espèce">
            <input type="text" name="alimentation" value="<?= $animalObj->getAlimentation() ?>" class="w-full border p-2 rounded" placeholder="Alimentation">
            <input type="text" name="pays" value="<?= $animalObj->getPaysorigine() ?>" class="w-full border p-2 rounded" placeholder="Pays">
            
            <select name="habitat" class="w-full border p-2 rounded">
                <?php foreach($listeHabitats as $h): ?>
                    <option value="<?= $h['id_hab'] ?>"><?= $h['nom_hab'] ?></option>
                <?php endforeach; ?>
            </select>

            <div class="flex items-center gap-4">
                <img src="../uploads/<?= $animalObj->getImage() ?>" class="w-16 h-16 object-cover rounded">
                <input type="file" name="image" class="border p-2 rounded w-full">
            </div>

            <textarea name="description" rows="3" class="w-full border p-2 rounded"><?= $animalObj->getDesc_courte() ?></textarea>

            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded">Mettre à jour</button>
            <a href="../animal.php" class="text-gray-500 ml-4">Retour</a>
        </form>
    </div>
</body>
</html>