<?php
require_once('../database/db.php');
require_once('../classes/theme.php');

$db = dataBase::getInstance()->getConnection();

$columns = ['nom', 'description', 'date_creation'];
$limit = isset($_POST['length']) ? $_POST['length'] : 10; // Default value if not set
$start = isset($_POST['start']) ? $_POST['start'] : 0; // Default value if not set
$order = isset($_POST['order'][0]['column']) ? $columns[$_POST['order'][0]['column']] : 'nom'; // Default column if not set
$dir = isset($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 'asc'; // Default direction if not set
$draw = isset($_POST['draw']) ? intval($_POST['draw']) : 0;
$totalData = $db->query("SELECT COUNT(*) FROM Themes")->fetchColumn();
$totalFiltered = $totalData;

if (empty($_POST['search']['value'])) {
    $query = "SELECT * FROM Themes ORDER BY $order $dir LIMIT $start, $limit";
    $stmt = $db->prepare($query);
    $stmt->execute();
} else {
    $search = $_POST['search']['value'];
    $query = "SELECT * FROM Themes WHERE nom LIKE :search OR description LIKE :search ORDER BY $order $dir LIMIT $start, $limit";
    $stmt = $db->prepare($query);
    $stmt->bindValue(':search', "%$search%");
    $stmt->execute();
    $totalFiltered = $stmt->rowCount();
}

$data = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $nestedData = [];
    $nestedData['nom'] = $row['nom'];
    $nestedData['description'] = $row['description'];
    $nestedData['date_creation'] = $row['date_creation'];
    $nestedData['id'] = $row['id'];
    $data[] = $nestedData;
}

$json_data = [
    "draw" => $draw,
    "recordsTotal" => intval($totalData),
    "recordsFiltered" => intval($totalFiltered),
    "data" => $data
];

echo json_encode($json_data);
?>
