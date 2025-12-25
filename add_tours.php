

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Espace Guide - Mes Visites</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50">

    <!-- NAVBAR GUIDE -->
    <nav class="bg-blue-900 text-white shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="font-bold text-xl flex items-center gap-2">
                <i class="fas fa-compass text-yellow-400"></i> ESPACE GUIDE
            </div>
            <div class="space-x-4 flex items-center">
                <span class="text-gray-300 text-sm mr-2">Bonjour, </span>
                <a href="../asaad.php" class="hover:text-yellow-200">Accueil</a>
                <a href="guide_tours.php" class="text-yellow-300 font-bold border-b-2 border-yellow-300">Mes Visites</a>
                <a href="guide_reservations.php" class="hover:text-yellow-200">Voir Réservations</a>
                <a href="../logout.php" class="bg-red-600 px-3 py-1 rounded hover:bg-red-700 text-sm">Déconnexion</a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-6 py-8">

        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Mes Visites Programmées</h2>
            <!-- bouton ajouter -->
            <a href="add_tours.php" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 shadow transition flex items-center gap-2">
                <i class="fas fa-plus-circle"></i> Ajouter une visite
            </a>
        </div>

        <!-- liste des visites -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">     
                <!-- carte visite -->
                

        </div>
    </div>
</body>
</html>