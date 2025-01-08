<?php
require_once('../database/db.php');
require_once('../classes/article.php');

$db = dataBase::getInstance()->getConnection();

$columns = ['titre', 'contenu', 'image_path', 'video_path', 'statut', 'user_id', 'theme_id', 'date_creation', 'date_modification'];
$limit = isset($_POST['length']) ? $_POST['length'] : 10; // Default value if not set
$start = isset($_POST['start']) ? $_POST['start'] : 0; // Default value if not set
$order = isset($_POST['order'][0]['column']) ? $columns[$_POST['order'][0]['column']] : 'date_creation'; // Default column if not set
$dir = isset($_POST['order'][0]['dir']) ? $_POST['order'][0]['dir'] : 'desc'; // Default direction if not set
$draw = isset($_POST['draw']) ? intval($_POST['draw']) : 0;
$totalData = $db->query("SELECT COUNT(*) FROM Articles")->fetchColumn();
$totalFiltered = $totalData;

if (empty($_POST['search']['value'])) {
    $query = "SELECT * FROM Articles ORDER BY $order $dir LIMIT $start, $limit";
    $stmt = $db->prepare($query);
    $stmt->execute();
} else {
    $search = $_POST['search']['value'];
    $query = "SELECT * FROM Articles WHERE titre LIKE :search OR contenu LIKE :search ORDER BY $order $dir LIMIT $start, $limit";
    $stmt = $db->prepare($query);
    $stmt->bindValue(':search', "%$search%");
    $stmt->execute();
    $totalFiltered = $stmt->rowCount();
}

$data = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $nestedData = [];
    $nestedData['titre'] = $row['titre'];
    $nestedData['contenu'] = $row['contenu'];
    $nestedData['image_path'] = $row['image_path'];
    $nestedData['video_path'] = $row['video_path'];
    $nestedData['statut'] = $row['statut'];
    $nestedData['user_id'] = $row['user_id'];
    $nestedData['theme_id'] = $row['theme_id'];
    $nestedData['date_creation'] = $row['date_creation'];
    $nestedData['date_modification'] = $row['date_modification'];
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
