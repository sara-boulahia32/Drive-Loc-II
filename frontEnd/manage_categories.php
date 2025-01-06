<?php
session_start();
require_once('../database/db.php');
require_once('../classes/admin.php');
require_once('../classes/categorie.php');

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: login.php");
    exit();
}

$db = dataBase::getInstance()->getConnection();
$admin = new Admin('', '', '', '', 'admin');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];
    $categorie_id = $_POST['categorie_id'];

    if ($action == 'add') {
        $nom = $_POST['nom'];
        $description = $_POST['description'];
        $categorie = new Categorie($nom, $description);
        $admin->ajouterCategorie($db, $categorie);
    } elseif ($action == 'delete') {
        $admin->supprimerCategorie($db, $categorie_id);
    }

    header("Location: manage_categories.php");
    exit();
}

$categories = Categorie::getAllCategories($db);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Categories</title>
</head>
<body>
    <h2>Manage Categories</h2>
    <form method="post" action="manage_categories.php">
        <input type="hidden" name="action" value="add">
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" required><br>
        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea><br>
        <button type="submit">Add Category</button>
    </form>

    <h3>Existing Categories</h3>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($categories as $categorie) { ?>
        <tr>
            <td><?php echo $categorie->getId(); ?></td>
            <td><?php echo $categorie->getNom(); ?></td>
            <td><?php echo $categorie->getDescription(); ?></td>
            <td>
                <form method="post" action="manage_categories.php">
                    <input type="hidden" name="categorie_id" value="<?php echo $categorie->getId(); ?>">
                    <input type="hidden" name="action" value="delete">
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
