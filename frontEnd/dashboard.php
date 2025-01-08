<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: login.php");
    exit();
}

require_once('../database/db.php');
require_once('../classes/admin.php');
require_once('../classes/vehicule.php');
require_once('../classes/categorie.php');
require_once('../classes/avis.php');
require_once('../classes/statistiques.php');
require_once('../classes/theme.php'); // Inclure la classe Theme

$db = dataBase::getInstance()->getConnection();
$admin = new Admin('', '', '', '', 'admin'); 
$statistiques = Statistiques::getStatistiques($db); 
$vehicules = Vehicule::getAllVehicules($db); 
$categories = Categorie::getAllCategories($db); 
$avisList = Avis::getAllAvis($db); 

if ($_SERVER["REQUEST_METHOD"] == "POST") { 
    $action = $_POST['action']; 
    if ($action == 'add_vehicule') { 
        $modele = $_POST['modele']; 
        $prix = $_POST['prix']; 
        $disponibilite = $_POST['disponibilite']; 
        $categorie_id = $_POST['categorie_id']; 
        $image_path = $_FILES['image']['name']; 
        move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/" . $image_path); 
        $vehicule = new Vehicule("", $modele, $marque, $categorie_id, $description, $prix, $disponibilite, $annee_fabrication, $kilometrage, $type_carburant, $boite_vitesse, $puissance_moteur, $couleur, $equipements_standards, $options_supplementaires, $dates_disponibles, $lieu_prise_en_charge, $lieu_retour, $image_path); 
        $admin->ajouterVehicule($db, $vehicule); 
    } elseif ($action == 'add_categorie') { 
        $nom = $_POST['nom']; 
        $description = $_POST['description']; 
        $categorie = new Categorie($nom, $description); 
        $admin->ajouterCategorie($db, $categorie); 
    } elseif ($action == 'add_theme') { 
        $nom = $_POST['nom']; 
        $description = $_POST['description']; 
        Theme::addTheme($db, $nom, $description); 
    } elseif ($action == 'delete_avis') { 
        $avis_id = $_POST['avis_id']; 
        Avis::softDelete($db, $avis_id); 
    } 
    header("Location: dashboard.php"); 
    exit(); 
}

$query = "
    SELECT 
        avis.id AS avis_id,
        reservations.id AS reservation_id,
        users.nom AS user_nom,
        users.prenom AS user_prenom,
        vehicules.modele AS vehicule_modele,
        avis.note,
        avis.commentaire
    FROM avis
    JOIN reservations ON avis.reservation_id = reservations.id
    JOIN users ON avis.user_id = users.id
    JOIN vehicules ON avis.vehicule_id = vehicules.id
    WHERE avis.deleted_at IS NULL
";
$stmt = $db->prepare($query);
$stmt->execute();
$avisList = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script type="text/javascript">
        function generateFields() {
            var numberOfVehicles = document.getElementById('numberOfVehicles').value;
            var container = document.getElementById('vehicleFieldsContainer');
            container.innerHTML = '';

            for (var i = 0; i < numberOfVehicles; i++) {
                var vehicleFields = `
                    <div class="mb-4 p-4 border border-silver-300 rounded-md">
                        <h3 class="text-xl font-bold text-white mb-4">Véhicule ${i + 1}</h3>
                        <label for="modele_${i}">Modele:</label>
                        <input type="text" id="modele_${i}" name="modele[]" required class="mb-4 p-2 border rounded text-black"><br>
                        <label for="marque_${i}">Marque:</label>
                        <input type="text" id="marque_${i}" name="marque[]" required class="mb-4 p-2 border rounded text-black"><br>
                        <label for="prix_${i}">Prix:</label>
                        <input type="number" id="prix_${i}" name="prix[]" required class="mb-4 p-2 border rounded text-black"><br>
                        <label for="disponibilite_${i}">Disponibilité:</label>
                        <input type="number" id="disponibilite_${i}" name="disponibilite[]" required class="mb-4 p-2 border rounded text-black"><br>
                        <label for="categorie_id_${i}">Catégorie ID:</label>
                        <input type="number" id="categorie_id_${i}" name="categorie_id[]" required class="mb-4 p-2 border rounded text-black"><br>
                        <label for="description_${i}">Description:</label>
                        <textarea id="description_${i}" name="description[]" rows="3" class="mb-4 p-2 border rounded text-black"></textarea><br>
                        <label for="image_${i}">Image:</label>
                        <input type="file" id="image_${i}" name="image[]" required class="mb-4 p-2 border rounded text-black"><br>
                    </div>
                `;
                container.innerHTML += vehicleFields;
            }
        }
    </script>

    
</head>
<body class="min-h-screen bg-black text-white p-8">

    <!-- Sidebar -->
    <div class="fixed left-0 top-0 h-full w-20 bg-zinc-900 flex flex-col items-center py-8 space-y-8">
        <div class="p-3 bg-white rounded-xl">
            <!-- Icon placeholder -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 11h14M5 11l7-7m0 0l7 7m-7-7v12" /></svg>
        </div>
        <div class="text-gray-500 hover:text-white cursor-pointer">
            <!-- Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18" /></svg>
        </div>
        <!-- Add more icons as needed -->
    </div>

    <!-- Main Content -->
    <div class="ml-24">

        <!-- Header -->
        <div class="flex justify-between items-center mb-12">
            <h1 class="text-3xl font-light">Dashboard Overview</h1>
            <div class="px-4 py-2 bg-zinc-900 rounded-lg">Today</div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <div class="bg-zinc-900 p-6 rounded-xl">
                <div class="flex justify-between items-start mb-4">
                    <div class="text-white h-6 w-6 bg-gray-800 rounded-full"></div> <!-- Placeholder for icon -->
                    <span class="text-green-500 text-sm">+12%</span>
                </div>
                <div class="text-3xl font-light mb-2"><?= $statistiques->total_clients; ?></div>
                <div class="text-gray-400 text-sm">Total Clients</div>
            </div>
            <div class="bg-zinc-900 p-6 rounded-xl">
                <div class="flex justify-between items-start mb-4">
                    <div class="text-white h-6 w-6 bg-gray-800 rounded-full">

                    <!-- Placeholder for icon -->

                    </div> 
                    <span class="text-green-500 text-sm">+5%</span>
                </div>
                <div class="text-3xl font-light mb-2"><?= $statistiques->total_reservations; ?></div>
                <div class="text-gray-400 text-sm">Total Reservations</div>
            </div>
            <div class="bg-zinc-900 p-6 rounded-xl">
                <div class="flex justify-between items-start mb-4">
                    <div class="text-white h-6 w-6 bg-gray-800 rounded-full">


                    </div> <!-- Placeholder for icon -->
                    <span class="text-green-500 text-sm">+18%</span>
                </div>
                <div class="text-3xl font-light mb-2"><?= $statistiques->reservations_approuvees; ?></div>
                <div class="text-gray-400 text-sm">Approved Reservations</div>
            </div>
            <div class="bg-zinc-900 p-6 rounded-xl">
                <div class="flex justify-between items-start mb-4">
                    <div class="text-white h-6 w-6 bg-gray-800 rounded-full">


                    </div> <!-- Placeholder for icon -->
                    <span class="text-green-500 text-sm">+22%</span>
                </div>
                <div class="text-3xl font-light mb-2"><?= $statistiques->reservations_en_attente; ?></div>
                <div class="text-gray-400 text-sm">Pending Reservations</div>
            </div>
        </div>

        <!-- Add Vehicle Button -->
        <div class="mb-12">
            <button class="bg-white text-black px-8 py-3 rounded-sm hover:bg-gray-200 transition-all" onclick="document.getElementById('addVehicleModal').classList.remove('hidden')">Add Vehicle</button>
            <button class="bg-white text-black px-8 py-3 rounded-sm hover:bg-gray-200 transition-all" onclick="document.getElementById('bulkInsertionModal').classList.remove('hidden')">Bulk Insertion</button>
        </div>
        

        <!-- Add Category Button -->
        <div class="mb-12">
            <button class="border border-white text-white px-8 py-3 rounded-sm hover:bg-white/10 transition-all" onclick="document.getElementById('addCategoryModal').classList.remove('hidden')">Add Category</button>
        </div>

       <!-- Add theme Button -->
       <div class="mb-12">
            <button class="border border-white text-white px-8 py-3 rounded-sm hover:bg-white/10 transition-all" onclick="document.getElementById('addThemeModal').classList.remove('hidden')">Add Theme</button>
        </div>


        <!-- Add Vehicle Modal -->
        <div id="addVehicleModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
            <div class="bg-black p-8 rounded-lg">
                <h2 class="text-2xl mb-4">Add Vehicle</h2>
                <form method="post" action="dashboard.php" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="add_vehicule">
                    <label for="modele">Modele:</label>
                    <input type="text" id="modele" name="modele" required class="mb-4 p-2 border rounded text-black"><br>
                    <label for="prix">Prix:</label>
                    <input type="number" id="prix" name="prix" required class="mb-4 p-2 border rounded text-black"><br>
                    <label for="disponibilite">Disponibilite:</label>
                    <input type="number" id="disponibilite" name="disponibilite" required class="mb-4 p-2 border rounded text-black"><br>
                    <label for="categorie_id">Categorie ID:</label>
                    <input type="number" id="categorie_id" name="categorie_id"  required class="mb-4 p-2 border rounded text-black"><br>
                    <label for="image">Image:</label>
                    <input type="file" id="image" name="image" required class="mb-4 p-2 border rounded  text-black"><br>     
                    <button type="submit" class="bg-white text-black px-8 py-3 rounded-sm hover:bg-gray-200 transition-all">Add Vehicle</button>
                    <button type="button" class="border border-white text-white px-8 py-3 rounded-sm hover:bg-white/10 transition-all" onclick="document.getElementById('addVehicleModal').classList.add('hidden')">Cancel</button>
                </form>
            </div>
        </div>

        <!-- Add Category Modal -->
        <div id="addCategoryModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
            <div class="bg-black p-8 rounded-lg">
                <h2 class="text-2xl mb-4">Add Category</h2>
                <form method="post" action="dashboard.php">
                    <input type="hidden" name="action" value="add_categorie">
                    <label for="nom">Nom:</label>
                    <input type="text" id="nom" name="nom" required class="mb-4 p-2 border rounded text-black"><br>
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" required class="mb-4 p-2 border rounded text-black"></textarea><br>
                    <button type="submit" class="bg-white text-black px-8 py-3 rounded-sm hover:bg-gray-200 transition-all">Add Category</button>
                    <button type="button" class="border border-white text-white px-8 py-3 rounded-sm hover:bg-white/10 transition-all" onclick="document.getElementById('addCategoryModal').classList.add('hidden')">Cancel</button>
                </form>
            </div>
        </div>
        <!-- Add Theme Modal -->
        <div id="addThemeModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
            <div class="bg-black p-8 rounded-lg">
                <h2 class="text-2xl mb-4 text-white">Add Theme</h2>
                <form method="post" action="dashboard.php">
                    <input type="hidden" name="action" value="add_theme">
                    <label for="nom" class="text-white">Nom:</label>
                    <input type="text" id="nom" name="nom" required class="mb-4 p-2 border rounded text-black w-full"><br>
                    <label for="description" class="text-white">Description:</label>
                    <textarea id="description" name="description" required class="mb-4 p-2 border rounded text-black w-full"></textarea><br>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-white text-black px-8 py-3 rounded-sm hover:bg-gray-200 transition-all">Add Theme</button>
                        <button type="button" class="border border-white text-white px-8 py-3 rounded-sm hover:bg-white/10 transition-all" onclick="document.getElementById('addThemeModal').classList.add('hidden')">Cancel</button>
                    </div>
                </form>
            </div>
        </div>


        <!-- Bulk Insertion Form -->
        <!-- <div id="" class="fixed inset-0 bg-black bg-opacity-50  flex items-center justify-center z-50"> -->
        <div class="bg-black p-8 rounded-lg">
        <h2 class="text-2xl mb-4">Add Vehicle</h2>
        <h2 class="text-3xl font-bold text-white mb-8">Insertion en Masse</h2>
        <form id="bulkInsertionForm" method="post" action="dashboard.php" enctype="multipart/form-data">
            <div class="mb-4">
                <label for="numberOfVehicles" class="block text-white mb-2">Nombre de véhicules</label>
                <select id="numberOfVehicles" name="numberOfVehicles" class="w-full p-2 bg-black text-white border border-silver-300 rounded-md" onchange="generateFields()">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
            <div id="vehicleFieldsContainer"></div>
            <button type="submit" class="bg-transparent border-2 border-white text-white px-4 py-2 rounded-md hover:bg-white hover:text-black transition-all">Ajouter</button>
        </form>
    </div>
     <!-- Manage Reviews -->
     <div class="bg-zinc-900 p-6 rounded-xl mb-12">
            <h2 class="text-xl font-light mb-6">Manage Reviews</h2>
            <table class="min-w-full bg-black bg-opacity-40 rounded-lg">
                <thead>
                    <tr>
                        <th class="py-2 px-4 text-left">Reservation</th>
                        <th class="py-2 px-4 text-left">User</th>
                        <th class="py-2 px-4 text-left">Vehicule</th>
                        <th class="py-2 px-4 text-left">Note</th>
                        <th class="py-2 px-4 text-left">Commentaire</th>
                        <th class="py-2 px-4 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($avisList as $avis) { ?>
                    <tr>
                        <td class="py-2 px-4"><?= $avis['reservation_id']; ?></td>
                        <td class="py-2 px-4"><?= $avis['user_nom'] . ' ' . $avis['user_prenom']; ?></td>
                        <td class="py-2 px-4"><?= $avis['vehicule_modele']; ?></td>
                        <td class="py-2 px-4"><?= $avis['note']; ?></td>
                        <td class="py-2 px-4"><?= $avis['commentaire']; ?></td>
                        <td class="py-2 px-4">
                            <form method="post" action="dashboard.php">
                                <input type="hidden" name="avis_id" value="<?= $avis['avis_id']; ?>">
                                <button type="submit" name="action" value="delete_avis" class="text-red-500 hover:underline">🗑️</button>
                            </form>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    </div>
    <!-- </div> -->


    </div>
    

</body>
</html>
