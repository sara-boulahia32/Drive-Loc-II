<?php
session_start();
require_once('../database/db.php');
require_once('../classes/admin.php');
require_once('../classes/reservation.php');

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: login.php");
    exit();
}

$db = dataBase::getInstance()->getConnection();
$admin = new Admin('', '', '', '', 'admin');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];
    $reservation_id = $_POST['reservation_id'];

    if ($action == 'approve') {
        $admin->approuverReservation($db, $reservation_id);
    } elseif ($action == 'refuse') {
        $admin->refuserReservation($db, $reservation_id);
    }

    header("Location: manage_reservations.php");
    exit();
}

$reservations = Reservation::getAllReservations($db);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Reservations</title>
</head>
<body>
    <h2>Manage Reservations</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>User ID</th>
            <th>Vehicule ID</th>
            <th>Date Début</th>
            <th>Date Fin</th>
            <th>Statut</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($reservations as $reservation) { ?>
        <tr>
            <td><?php echo $reservation->getId(); ?></td>
            <td><?php echo $reservation->getUserId(); ?></td>
            <td><?php echo $reservation->getVehiculeId(); ?></td>
            <td><?php echo $reservation->getDateDebut(); ?></td>
            <td><?php echo $reservation->getDateFin(); ?></td>
            <td><?php echo $reservation->getStatut(); ?></td>
            <td>
                <form method="post" action="manage_reservations.php">
                    <input type="hidden" name="reservation_id" value="<?php echo $reservation->getId(); ?>">
                    <button type="submit" name="action" value="approve">Approve</button>
                    <button type="submit" name="action" value="refuse">Refuse</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
