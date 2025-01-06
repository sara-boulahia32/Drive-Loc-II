<?php
session_start();
require_once('../database/db.php');
require_once('classes/recherche.php');

$db = dataBase::getInstance()->getConnection();
$critere = $_GET['critere'];
$vehicules = Recherche::rechercherVehicules($db, $critere);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Results</title>
</head>
<body>
    <h2>Search Results</h2>
    <ul>
        <?php foreach ($vehicules as $vehicule) { ?>
            <li><?php echo $vehicule->getModele(); ?> - <?php echo $vehicule->getPrix(); ?> - <?php echo $vehicule->getDisponibilite() ? 'Available' : 'Not Available'; ?></li>
        <?php } ?>
    </ul>
</body>
</html>
