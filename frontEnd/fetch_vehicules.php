<?php
require_once('../database/db.php');
require_once('../classes/vehicule.php');

$db = dataBase::getInstance()->getConnection();

$columns = ['image', 'modele', 'marque', 'prix', 'disponibilite', 'actions'];
$limit = isset($_POST['length']) ? $_POST['length'] : 10; // Default value if not set
$start = isset($_POST['start']) ? $_POST['start'] : 0; // Default value if not set
$order = isset($_POST['order'][0]['column']) ? $columns[$_POST['order'][0]['column']] : 'modele'; // Default column if not set
$dir = isset($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 'asc'; // Default direction if not set
$draw = isset($_POST['draw']) ? intval($_POST['draw']) : 0; // Default value if not set

$totalData = $db->query("SELECT COUNT(*) FROM vehicules")->fetchColumn();
$totalFiltered = $totalData;

if (empty($_POST['search']['value'])) {
    $query = "SELECT * FROM vehicules ORDER BY $order $dir LIMIT $start, $limit";
    $stmt = $db->prepare($query);
    $stmt->execute();
} else {
    $search = $_POST['search']['value'];
    $query = "SELECT * FROM vehicules WHERE modele LIKE :search OR marque LIKE :search OR description LIKE :search ORDER BY $order $dir LIMIT $start, $limit";
    $stmt = $db->prepare($query);
    $stmt->bindValue(':search', "%$search%");
    $stmt->execute();
    $totalFiltered = $stmt->rowCount();
}

$data = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $nestedData = [];
    $nestedData['image'] = $row['image_path'];
    $nestedData['modele'] = $row['modele'];
    $nestedData['marque'] = $row['marque'];
    $nestedData['prix'] = $row['prix'];
    $nestedData['disponibilite'] = $row['disponibilite'];
    $nestedData['id'] = $row['id'];
    $data[] = $nestedData;
}

// Debugging: Log the data being returned
error_log("Fetched Data: " . print_r($data, true));

$json_data = [
    "draw" => $draw,
    "recordsTotal" => intval($totalData),
    "recordsFiltered" => intval($totalFiltered),
    "data" => $data
];

echo json_encode($json_data);
?>
