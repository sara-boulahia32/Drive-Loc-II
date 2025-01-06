<?php
session_start();
require_once('../database/db.php');
require_once('../classes/vehicule.php');

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$db = dataBase::getInstance()->getConnection();
$vehicule_id = $_GET['id'];
$vehicule = Vehicule::getVehiculeById($db, $vehicule_id);

if (!$vehicule) {
    echo "Véhicule non trouvé.";
    exit();
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Véhicule</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="min-h-screen bg-black text-white p-8">

    <!-- Navigation --> 
    <nav class="bg-black shadow-lg"> 
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"> 
        <div class="flex justify-between h-16 items-center"> 
          <div class="flex items-center"> 
            <svg class="w-8 h-8 text-silver-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"> 
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /> 
            </svg> <span class="ml-2 text-xl font-bold text-white">Drive & Loc</span> 
          </div> 
          <div class="hidden md:flex items-center space-x-8"> 
            <a href="../index.html" class="text-white hover:text-silver-300 transition-colors">Accueil</a> 
            <a href="vehicule.php" class="text-white hover:text-silver-300 transition-colors">Véhicules</a> 
            <a href="mes_reservations.php" class="text-white hover:text-silver-300 transition-colors">Réservations</a> 
            <a href="#" class="text-white hover:text-silver-300 transition-colors">Contact</a> 
            <a href="logout.php" class="bg-transparent border-2 border-white text-white px-4 py-2 rounded-md hover:bg-white hover:text-black transition-all">Log out</a> 
          </div> 
        </div> 
      </div> 
    </nav> 
    <!-- Vehicle Details Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h2 class="text-3xl font-bold text-white mb-8">Détails du Véhicule</h2>
        <div class="bg-black rounded-lg shadow-md overflow-hidden">
            <div class="h-64 bg-silver-300">
                <img src="../uploads/<?php echo $vehicule->getImage(); ?>" alt="Car" class="w-full h-full object-cover">
            </div>
            <div class="p-6">
                <h3 class="text-2xl font-bold text-white mb-2"><?php echo $vehicule->getModele(); ?></h3>
                <p class="text-silver-300 mb-4">Marque : <?php echo $vehicule->getMarque(); ?></p>
                <p class="text-silver-300 mb-4">Catégorie : <?php echo $vehicule->getCategorieId(); ?></p>
                <p class="text-silver-300 mb-4">Description : <?php echo $vehicule->getDescription(); ?></p>
                <p class="text-silver">
                <p class="text-silver-300 mb-4">Prix : <?php echo $vehicule->getPrix(); ?>€/jour</p>
<p class="text-silver-300 mb-4">Disponibilité : <?php echo $vehicule->getDisponibilite() ? 'Disponible' : 'Indisponible'; ?></p>
<p class="text-silver-300 mb-4">Année de fabrication : <?php echo $vehicule->getAnneeFabrication(); ?></p>
<p class="text-silver-300 mb-4">Kilométrage : <?php echo $vehicule->getKilometrage(); ?> km</p>
<p class="text-silver-300 mb-4">Type de carburant : <?php echo $vehicule->getTypeCarburant(); ?></p>
<p class="text-silver-300 mb-4">Boîte de vitesse : <?php echo $vehicule->getBoiteVitesse(); ?></p>
<p class="text-silver-300 mb-4">Puissance moteur : <?php echo $vehicule->getPuissanceMoteur(); ?> CV</p>
<p class="text-silver-300 mb-4">Couleur : <?php echo $vehicule->getCouleur(); ?></p>
<p class="text-silver-300 mb-4">Équipements standards : <?php echo $vehicule->getEquipementsStandards(); ?></p>
<p class="text-silver-300 mb-4">Options supplémentaires : <?php echo $vehicule->getOptionsSupplementaires(); ?></p>
<p class="text-silver-300 mb-4">Dates disponibles : <?php echo $vehicule->getDatesDisponibles(); ?></p>
<p class="text-silver-300 mb-4">Lieu de prise en charge : <?php echo $vehicule->getLieuPriseEnCharge(); ?></p>
<p class="text-silver-300 mb-4">Lieu de retour : <?php echo $vehicule->getLieuRetour(); ?></p>
<a href="reserver.php?id=<?php echo $vehicule->getId(); ?>" class="bg-transparent border-2 border-white text-white px-4 py-2 rounded-md hover:bg-white hover:text-black transition-all">
    Réserver
</a>
</div>
</div>
</div>

</body>

</html>
