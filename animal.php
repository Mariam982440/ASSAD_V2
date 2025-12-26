<?php
session_start();

require_once 'classe/User.php';
require_once 'classe/Habitat.php'; 
require_once 'classe/Animal.php';  



if (!isset($_SESSION['user_id'])) {
    header("location: login.php");
    exit();
}

$nom = $_SESSION['user_nom']; 
$role = $_SESSION['user_role']; 

$listeHabitats = Habitat::getAll(); 
$listePays = Animal::getPays();

$filtre_habitat = $_GET['filtre_hab'] ?? null;
$filtre_pays    = $_GET['filtre_pays'] ?? null;
$recherche_nom  = $_GET['nom_rech'] ?? null;

$animaux = Animal::rechercher($filtre_habitat, $filtre_pays, $recherche_nom);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos Animaux - ASSAD Zoo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .card-img { transition: transform 0.3s ease; }
        .card:hover .card-img { transform: scale(1.05); }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <!-- NAVBAR -->
    <nav class="bg-green-800 text-white shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="text-xl font-bold flex items-center gap-2">
                <i class="fas fa-paw text-yellow-400"></i> ASSAD ZOO
            </div>
            
            <div class="hidden md:flex space-x-6 items-center">
                <span class="text-yellow-300 font-bold border-r pr-4 mr-2">Bonjour, <?= htmlspecialchars($nom) ?></span>
                
                <a href="asaad.php" class="hover:text-yellow-200 font-bold">Accueil</a>
                
                <?php if($role == 'guide'): ?>
                    <a href="guide/guide_tours.php" class="hover:text-yellow-200">Gérer Visites</a>
                <?php endif; ?>

                <?php if($role == 'admin'): ?>
                    <a href="admin/admin_panel.php" class="hover:text-yellow-200">Admin Panel</a>
                <?php endif; ?>
                
                <?php if($role == 'visiteur'):?>
                    <a href="visitor/visitor_tours.php" class="hover:text-yellow-200">Réserver</a>
                    <a href="visitor/visitor_dashboard.php" class="hover:text-yellow-200">Mes réservations</a>
                <?php endif; ?>

                <a href="logout.php" class="bg-gray-900 px-3 py-1 rounded hover:bg-black text-sm ml-4">Déconnexion</a>
            </div>
        </div>
    </nav>

    <!-- HEADER -->
    <header class="bg-white shadow-sm py-10">
        <div class="container mx-auto px-6 flex justify-between items-end">
            <div>
                <h1 class="text-3xl font-bold text-green-900 mb-2">La Faune Africaine</h1>
                <p class="text-gray-600">Découvrez les espèces protégées et leurs habitats naturels.</p>
            </div>
            
            <?php if($role == 'admin'): ?>
                <div class="flex gap-2">
                    <a href="admin/add_animal.php" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 shadow">
                        <i class="fas fa-plus-circle"></i> Animal
                    </a>
                    <a href="admin/add_habitat.php" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 shadow">
                        <i class="fas fa-map"></i> Habitat
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </header>

    <div class="container mx-auto px-6 py-8">

        <!-- BARRE DE FILTRES -->
        <div class="bg-white p-4 rounded-lg shadow mb-8 border border-gray-200">
            <form method="GET" action="" class="flex flex-col md:flex-row gap-4 items-center">
                
                <!-- Recherche par nom -->
                <div class="relative w-full md:w-1/3">
                    <input name="nom_rech" value="<?= htmlspecialchars($recherche_nom) ?>" type="text" placeholder="Rechercher (ex: Lion)..." class="w-full pl-10 pr-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>

                <!-- Filtre Habitat (Boucle foreach sur tableau d'objets ou array) -->
                <select name="filtre_hab" class="w-full md:w-1/4 border p-2 rounded-lg bg-white">
                    <option value="">Tous les habitats</option>
                    <?php foreach($listeHabitats as $hab): ?>
                        <!-- J'utilise l'ID pour la value, c'est plus fiable que le nom -->
                        <option value="<?= $hab['id_hab'] ?>" <?= ($filtre_habitat == $hab['id_hab']) ? 'selected' : '' ?>>
                            <?= $hab['nom_hab'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <!-- Filtre Pays -->
                <select name="filtre_pays" class="w-full md:w-1/4 border p-2 rounded-lg bg-white">
                    <option value="">Tous les pays</option>
                    <?php foreach($listePays as $pay): ?>
                        <option value="<?= $pay['paysorigine'] ?>" <?= ($filtre_pays == $pay['paysorigine']) ? 'selected' : '' ?>>
                            <?= $pay['paysorigine'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <button type="submit" class="w-full md:w-auto bg-green-700 text-white px-6 py-2 rounded-lg hover:bg-green-800 font-bold transition">
                    Filtrer
                </button>
                <a href="asaad.php" class="text-sm text-gray-500 hover:text-red-500">Reset</a>
            </form>
        </div>

        <!-- GRILLE DES ANIMAUX -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <?php if(count($animaux) == 0): ?>
                <p class="col-span-3 text-center text-gray-500 py-10">Aucun animal ne correspond à votre recherche.</p>
            <?php endif; ?>

            <!-- Boucle foreach au lieu de while -->
            <?php foreach($animaux as $row): ?>
                <div class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-200 card group">
                    
                    <div class="relative h-48 overflow-hidden">
                        <?php $imgSrc = !empty($row['image']) ? "uploads/".$row['image'] : "https://via.placeholder.com/300?text=No+Image"; ?>
                        <img src="<?= $imgSrc ?>" alt="<?= htmlspecialchars($row['nom_al']) ?>" class="w-full h-full object-cover card-img">
                    </div>
                    
                    <div class="p-4">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-xl font-bold text-gray-800"><?= htmlspecialchars($row['nom_al']) ?></h3>
                            <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded font-bold">
                                <?= htmlspecialchars($row['nom_hab'] ?? 'Inconnu') ?>
                            </span>
                        </div>
                        
                        <p class="text-sm text-gray-500 mb-2 italic">
                            <i class="fas fa-globe-africa"></i> <?= htmlspecialchars($row['paysorigine']) ?>
                        </p>

                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                            <?= htmlspecialchars(substr($row['descriptioncourte'], 0, 100)) ?>...
                        </p>
                        
                        <!-- Actions ADMIN -->
                        <?php if($role == 'admin'): ?>
                            <div class="flex gap-2 border-t pt-3 mt-auto">
                                <a href="admin/edit_animal.php?id=<?= $row['id_al'] ?>" class="flex-1 bg-blue-50 text-blue-600 py-2 rounded text-center text-sm font-bold hover:bg-blue-100">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="admin/delete_animal.php?id=<?= $row['id_al'] ?>" onclick="return confirm('Supprimer cet animal ?')" 
                                    class="flex-1 bg-red-50 text-red-600 py-2 rounded text-center text-sm font-bold hover:bg-red-100">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        <?php else: ?>
                            <!-- Bouton Voir pour les autres -->
                            <button class="w-full bg-gray-100 text-gray-700 py-2 rounded text-sm hover:bg-gray-200">Voir détails</button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>

    </div>

    <footer class="bg-gray-900 text-white py-6 mt-12 text-center">
        <p class="text-sm">ASSAD Zoo © 2025 - CAN Maroc</p>
    </footer>

</body>
</html>