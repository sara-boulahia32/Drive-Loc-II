<?php
session_start();
require_once('../database/db.php');
require_once('../classes/vehicule.php');
require_once('../classes/reservation.php');

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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $date_debut = $_POST['date_debut'];
    $date_fin = $_POST['date_fin'];
    $reservation = new Reservation($user_id, $vehicule_id, $date_debut, $date_fin, 'en attente');
    $reservation->ajouterReservation($db);
    echo "<script>alert('Réservation effectuée avec succès !');</script>";
    header("Location: vehicule.php");

    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réserver un Véhicule</title>
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

    <!-- Reservation Form Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h2 class="text-3xl font-bold text-white mb-8">Réserver un Véhicule</h2>
        <div class="bg-black rounded-lg shadow-md overflow-hidden">
            <div class="h-64 bg-silver-300">
                <img src="../uploads/<?php echo $vehicule->getImage(); ?>" alt="Car" class="w-full h-full object-cover">
            </div>
            <div class="p-6">
                <h3 class="text-2xl font-bold text-white mb-2"><?php echo $vehicule->getModele(); ?></h3>
                <p class="text-silver-300 mb-4">Prix : <?php echo $vehicule->getPrix(); ?>€/jour</p>
                <form method="post" action="reserver.php?id=<?php echo $vehicule->getId(); ?>"> 
                    <div class="mb-4">
                        <label for="date_debut" class="block text-silver-300 mb-2">Date de début :</label>
                        <input type="date" id="date_debut" name="date_debut" required class="w-full p-2 border rounded  text-black">
                    </div>
                    <div class="mb-4">
                        <label for="date_fin" class="block text-silver-300 mb-2">Date de fin :</label>
                        <input type="date" id="date_fin" name="date_fin" required class="w-full p-2 border rounded text-black">
                    </div>
                    
                    <button type="submit" class="bg-transparent border-2 border-white text-white px-4 py-2 rounded-md hover:bg-white hover:text-black transition-all"> Réserver </button>
                </form>
                
            </div>
        </div>
    </div>

</body>

</html>
