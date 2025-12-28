<?php
session_start();
require_once '../classe/User.php';
require_once '../classe/Habitat.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $habitat = new Habitat(
        $_POST['nom'],
        $_POST['climat'],
        $_POST['description'],
        $_POST['zone']
    );

    if ($habitat->ajouter()) {
        $message = "<div class='bg-blue-100 text-blue-700 p-4 rounded mb-4'>Habitat créé avec succès !</div>";
    } else {
        $message = "<div class='bg-red-100 text-red-700 p-4 rounded mb-4'>Erreur lors de la création.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Habitat</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 py-10">

    <div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-lg">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Ajouter un Habitat</h2>
            <a href="../animal.php" class="text-blue-600 hover:underline">Retour</a>
        </div>

        <?= $message ?>

        <form method="POST" class="space-y-4">
            
            <div>
                <label class="block text-gray-700 font-bold mb-1">Nom de l'habitat</label>
                <input type="text" name="nom" required placeholder="Ex: Savane Africaine" class="w-full border p-2 rounded">
            </div>

            <div>
                <label class="block text-gray-700 font-bold mb-1">Type de Climat</label>
                <input type="text" name="climat" required placeholder="Ex: Chaud et Sec" class="w-full border p-2 rounded">
            </div>

            <div>
                <label class="block text-gray-700 font-bold mb-1">Zone du Zoo</label>
                <select name="zone" class="w-full border p-2 rounded bg-white">
                    <option value="Zone A">Zone A (Nord)</option>
                    <option value="Zone B">Zone B (Sud)</option>
                    <option value="Zone C">Zone C (Est)</option>
                    <option value="Zone D">Zone D (Ouest)</option>
                </select>
            </div>

            <div>
                <label class="block text-gray-700 font-bold mb-1">Description</label>
                <textarea name="description" rows="3" class="w-full border p-2 rounded"></textarea>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 rounded hover:bg-blue-700 transition">
                Créer l'Habitat
            </button>
        </form>
    </div>

</body>
</html>