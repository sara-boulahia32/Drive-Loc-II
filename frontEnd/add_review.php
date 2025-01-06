<?php
session_start();
require_once('../database/db.php');
require_once('../classes/avis.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reservation_id = $_POST['reservation_id'];
    $user_id = $_SESSION['user_id'];
    $vehicule_id = $_POST['vehicule_id'];
    $note = $_POST['note'];
    $commentaire = $_POST['commentaire'];

    $db = dataBase::getInstance()->getConnection();
    $avis = new Avis($reservation_id, $user_id, $vehicule_id, $note, $commentaire);
    $avis->save($db);

    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Review</title>
</head>
<body>
    <h2>Add Review</h2>
    <form method="post" action="add_review.php">
        <label for="reservation_id">Reservation ID:</label>
        <input type="text" id="reservation_id" name="reservation_id" required><br>
        <label for="vehicule_id">Vehicule ID:</label>
        <input type="text" id="vehicule_id" name="vehicule_id" required><br>
        <label for="note">Note (1-5):</label>
        <input type="number" id="note" name="note" min="1" max="5" required><br>
        <label for="commentaire">Commentaire:</label>
        <textarea id="commentaire" name="commentaire" required></textarea><br>
        <button type="submit">Add Review</button>
    </form>
</body>
</html>
