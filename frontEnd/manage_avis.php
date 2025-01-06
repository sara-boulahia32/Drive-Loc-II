<?php
session_start();
require_once('../database/db.php');
require_once('../classes/admin.php');
require_once('../classes/avis.php');

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: login.php");
    exit();
}

$db = dataBase::getInstance()->getConnection();
$admin = new Admin('', '', '', '', 'admin');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];
    $avis_id = $_POST['avis_id'];

    if ($action == 'hide') {
        Avis::softDelete($db, $avis_id);
    } elseif ($action == 'delete') {
        $query = "DELETE FROM avis WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $avis_id);
        $stmt->execute();
    }

    header("Location: manage_avis.php");
    exit();
}

$avisList = Avis::getAllAvis($db);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Avis</title>
</head>
<body>
    <h2>Manage Avis</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Reservation ID</th>
            <th>User ID</th>
            <th>Vehicule ID</th>
            <th>Note</th>
            <th>Commentaire</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($avisList as $avis) { ?>
        <tr>
            <td><?php echo $avis->getId(); ?></td>
            <td><?php echo $avis->getReservationId(); ?></td>
            <td><?php echo $avis->getUserId(); ?></td>
            <td><?php echo $avis->getVehiculeId(); ?></td>
            <td><?php echo $avis->getNote(); ?></td>
            <td><?php echo $avis->getCommentaire(); ?></td>
            <td>
                <form method="post" action="manage_avis.php">
                    <input type="hidden" name="avis_id" value="<?php echo $avis->getId(); ?>">
                    <button type="submit" name="action" value="hide">Hide</button>
                    <button type="submit" name="action" value="delete">Delete</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
