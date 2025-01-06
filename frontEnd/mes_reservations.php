<?php
session_start();
require_once('../database/db.php');
require_once('../classes/reservation.php');
require_once('../classes/vehicule.php');
require_once('../classes/avis.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$db = dataBase::getInstance()->getConnection();
$user_id = $_SESSION['user_id'];
$reservations = Reservation::getReservationsByUserId($db, $user_id);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reservation_id = $_POST['reservation_id'];
    $vehicule_id = $_POST['vehicule_id'];
    $note = $_POST['note'];
    $commentaire = $_POST['commentaire'];
    $avis = new Avis($reservation_id, $user_id, $vehicule_id, $note, $commentaire);
    $avis->save($db);
    echo "<script>alert('Avis ajouté avec succès !');</script>";
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Réservations</title>
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
                    </svg>
                    <span class="ml-2 text-xl font-bold text-white">Drive & Loc</span>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="index.php" class="text-white hover:text-silver-300 transition-colors">Accueil</a>
                    <a href="vehicules.php" class="text-white hover:text-silver-300 transition-colors">Véhicules</a>
                    <a href="reservations.php" class="text-white hover:text-silver-300 transition-colors">Réservations</a>
                    <a href="contact.php" class="text-white hover:text-silver-300 transition-colors">Contact</a>
                    <button class="bg-transparent border-2 border-white text-white px-4 py-2 rounded-md hover:bg-white hover:text-black transition-all">
                        Log out
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Reservations Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h2 class="text-3xl font-bold text-white mb-8">Mes Réservations</h2>
        <div class="bg-black rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
                <?php if (count($reservations) > 0) { ?>
                    <table class="min-w-full bg-black bg-opacity-40 rounded-lg">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 text-left">Véhicule</th>
                                <th class="py-2 px-4 text-left">Date de début</th>
                                <th class="py-2 px-4 text-left">Date de fin</th>
                                <th class="py-2 px-4 text-left">Statut</th>
                                <th class="py-2 px-4 text-left">Avis</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reservations as $reservation) { 
                                $vehicule = Vehicule::getVehiculeById($db, $reservation['vehicule_id']);
                            ?>
                            <tr>
                                <td class="py-2 px-4"><?php echo $vehicule->getModele(); ?></td>
                                <td class="py-2 px-4"><?php echo $reservation['date_debut']; ?></td>
                                <td class="py-2 px-4"><?php echo $reservation['date_fin']; ?></td>
                                <td class="py-2 px-4"><?php echo $reservation['statut']; ?></td>
                                <td class="py-2 px-4">
                                    <?php 
                                    // if ($reservation['statut'] == 'approuvée') { 
                                        ?>
                                    <form method="post" action="mes_reservations.php">
                                        <input type="hidden" name="reservation_id" value="<?php echo $reservation['id']; ?>">
                                        <input type="hidden" name="vehicule_id" value="<?php echo $reservation['vehicule_id']; ?>">
                                        <div class="flex items-center">
                                            <select name="note" class="bg-black text-white border border-white rounded-md mr-2">
                                                <option value="1">1/5</option>
                                                <option value="2">2/5</option>
                                                <option value="3">3/5</option>
                                                <option value="4">4/5</option>
                                                <option value="5">5/5</option>
                                            </select>
                                            <input type="text" name="commentaire" placeholder="Votre commentaire" class="bg-black text-white border border-white rounded-md p-2">
                                            <button type="submit" class="bg-transparent border-2 border-white text-white px-4 py-2 rounded-md hover:bg-white hover:text-black transition-all ml-2">
                                                Ajouter
                                            </button>
                                        </div>
                                    </form>
                                    <?php 
                                // } else { 
                                    ?>
                                    <p class="text-silver-300">Avis non disponible</p>
                                    <?php 
                                // }
                                 ?>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php } else { ?>
                    <p class="text-silver-300">Vous n'avez aucune réservation.</p>
                <?php } ?>
            </div>
        </div>
    </div>

</body>

</html>
