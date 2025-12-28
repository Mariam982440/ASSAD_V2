<?php
session_start();
require_once '../classe/User.php';
require_once '../classe/Animal.php';
require_once '../classe/Habitat.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

$message = "";

$listeHabitats = Habitat::getAll(); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $imageNom = "";
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $imageNom = time() . "_" . uniqid() . "." . $ext; 
        move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/" . $imageNom);
    }

    $animal = new Animal(
        $_POST['nom'],
        $_POST['espece'],
        $_POST['alimentation'],
        $imageNom,
        $_POST['pays'],
        $_POST['description'],
        $_POST['habitat'] // l'id envoyé par le <select>
    );

    if ($animal->ajouterAnimal()) {
        $message = "<div class='bg-green-100 text-green-700 p-4 rounded mb-4'>Animal ajouté avec succès !</div>";
    } else {
        $message = "<div class='bg-red-100 text-red-700 p-4 rounded mb-4'>Erreur lors de l'ajout.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Animal</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 py-10">

    <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-lg">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Ajouter un nouvel Animal</h2>
            <a href="../animal.php" class="text-blue-600 hover:underline">Retour au catalogue</a>
        </div>

        <?= $message ?>

        <form method="POST" enctype="multipart/form-data" class="space-y-4">
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-bold mb-1">Nom</label>
                    <input type="text" name="nom" required class="w-full border p-2 rounded">
                </div>
                <div>
                    <label class="block text-gray-700 font-bold mb-1">Espèce</label>
                    <input type="text" name="espece" required class="w-full border p-2 rounded">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-bold mb-1">Alimentation</label>
                    <input type="text" name="alimentation" placeholder="Ex: Carnivore" class="w-full border p-2 rounded">
                </div>
                <div>
                    <label class="block text-gray-700 font-bold mb-1">Pays d'origine</label>
                    <input type="text" name="pays" required class="w-full border p-2 rounded">
                </div>
            </div>

            <div>
                <label class="block text-gray-700 font-bold mb-1">Habitat</label>
                <select name="habitat" required class="w-full border p-2 rounded bg-white">
                    <option value="">Sélectionner un habitat...</option>
                    <?php foreach($listeHabitats as $h): ?>
                        <option value="<?= $h['id_hab'] ?>"><?= $h['nom_hab'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="block text-gray-700 font-bold mb-1">Photo</label>
                <input type="file" name="image" required class="w-full border p-2 rounded bg-gray-50">
            </div>

            <div>
                <label class="block text-gray-700 font-bold mb-1">Description courte</label>
                <textarea name="description" rows="3" class="w-full border p-2 rounded"></textarea>
            </div>

            <button type="submit" class="w-full bg-green-600 text-white font-bold py-3 rounded hover:bg-green-700 transition">
                Enregistrer l'Animal
            </button>
        </form>
    </div>

</body>
</html>