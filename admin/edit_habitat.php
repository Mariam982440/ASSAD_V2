<?php
session_start();
require_once '../classe/Habitat.php'; 


if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') { 
    header("Location: ../login.php"); 
    exit(); 
}

if (!isset($_GET['id'])) {
    header("Location: ../animal.php");
    exit();
}

$id = intval($_GET['id']);


$habitat = Habitat::getById($id);

if (!$habitat) {
    die("Habitat introuvable.");
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $habitat->setNom($_POST['nom']);
    $habitat->setTypeClimat($_POST['climat']);
    $habitat->setZoneZoo($_POST['zone']);
    $habitat->setDescription($_POST['description']);

    if ($habitat->modifier()) {
        $message = "<div class='text-green-600 font-bold mb-4'>Habitat modifié avec succès !</div>";
    } else {
        $message = "<div class='text-red-600 font-bold mb-4'>Erreur lors de la modification.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Habitat</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 py-10">
    <div class="max-w-lg mx-auto bg-white p-8 rounded shadow">
        <h2 class="text-xl font-bold mb-4">Modifier Habitat</h2>
        <?= $message ?>
        
        <form method="POST" class="space-y-4">
            
            <!-- NOM -->
            <div>
                <label class="block font-bold">Nom</label>
                <input type="text" name="nom" value="<?= htmlspecialchars($habitat->getNom()) ?>" class="w-full border p-2 rounded">
            </div>

            <div>
                <label class="block font-bold">Climat</label>
                <input type="text" name="climat" value="<?= htmlspecialchars($habitat->getTypeClimat()) ?>" class="w-full border p-2 rounded">
            </div>

            <div>
                <label class="block font-bold">Zone</label>
                <select name="zone" class="w-full border p-2 rounded">
                    <!-- on compare avec le getter pour sélectionner la bonne option -->
                    <option value="Zone A" <?= $habitat->getZoneZoo() == 'Zone A' ? 'selected' : '' ?>>Zone A</option>
                    <option value="Zone B" <?= $habitat->getZoneZoo() == 'Zone B' ? 'selected' : '' ?>>Zone B</option>
                    <option value="Zone C" <?= $habitat->getZoneZoo() == 'Zone C' ? 'selected' : '' ?>>Zone C</option>
                    <option value="Zone D" <?= $habitat->getZoneZoo() == 'Zone D' ? 'selected' : '' ?>>Zone D</option>
                </select>
            </div>

            
            <div>
                <label class="block font-bold">Description</label>
                <textarea name="description" class="w-full border p-2 rounded"><?= htmlspecialchars($habitat->getDescription()) ?></textarea>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Sauvegarder</button>
                <a href="../animal.php" class="bg-gray-300 text-black px-4 py-2 rounded">Retour</a>
            </div>
        </form>
    </div>
</body>
</html>