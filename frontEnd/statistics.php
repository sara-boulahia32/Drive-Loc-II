<?php
session_start();
require_once('../database/db.php');
require_once('../classes/admin.php');
require_once('../classes/statistiques.php');

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: login.php");
    exit();
}

$db = dataBase::getInstance()->getConnection();
$admin = new Admin('', '', '', '', 'admin');
$statistiques = Statistiques::getStatistiques($db);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Statistics</title>
</head>
<body>
    <h2>Statistics</h2>
    <table border="1">
        <tr>
            <th>Total Clients</th>
            <th>Total Reservations</th>
            <th>Approved Reservations</th>
            <th>Pending Reservations</th>
            <th>Refused Reservations</th>
        </tr>
        <tr>
            <td><?php echo $statistiques->total_clients; ?></td>
            <td><?php echo $statistiques->total_reservations; ?></td>
            <td><?php echo $statistiques->reservations_approuvees; ?></td>
            <td><?php echo $statistiques->reservations_en_attente; ?></td>
            <td><?php echo $statistiques->reservations_refusees; ?></td>
        </tr>
    </table>
</body>
</html>
