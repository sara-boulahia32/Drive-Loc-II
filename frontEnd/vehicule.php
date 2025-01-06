<?php
session_start();
require_once('../database/db.php');
require_once('../classes/categorie.php');
require_once('../classes/vehicule.php');
require_once('../classes/recherche.php');

$db = dataBase::getInstance()->getConnection();
$categories = Categorie::getAllCategories($db);
$car = new Vehicule(44,"","","","","","","","","","","","","","","","","","");
$vehicules = Vehicule::getAllVehicules($db);
$search = $_GET['search'] ?? '';
$date_debut = $_GET['date_debut'] ?? '';
$date_fin = $_GET['date_fin'] ?? '';
$categorie_id = $_GET['categorie_id'] ?? null;


if ($_SERVER["REQUEST_METHOD"] == "GET") {
  if (isset($_GET['search']) || isset($_GET['categorie_id'])) {
    
    if ($categorie_id) { 
      $vehicules = Recherche::filtrerVehiculesParCategorie($db, $categorie_id); 
    } else { 
      $vehicules = Recherche::rechercherVehicules($db, $search, $date_debut, $date_fin); 
    } 
  } else {
    echo "Aucun ID fourni.";
  }
} else {
  echo "pas encore de recherche à faire .";
}



?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Drive & Loc</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link href="//cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css"> 
  <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script> 
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"> <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css"> <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script> <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>
</head>

<body class="min-h-screen bg-black text-white">



   <!-- Navigation --> 
    <nav class="bg-black shadow-lg"> 
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"> 
        <div class="flex justify-between h-16 items-center"> 
          <div class="flex items-center"> 
            <svg class="w-8 h-8 text-silver-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"> 
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /> 
            </svg> <span class="ml-2 text-xl font-bold text-white">Drive & Loc</span> 
          </div> 
          <div class="hidden md:flex items-center space-x-8"> 
            <a href="../index.html" class="text-white hover:text-silver-300 transition-colors">Accueil</a> 
            <a href="#" class="text-white hover:text-silver-300 transition-colors">Véhicules</a> 
            <a href="mes_reservations.php" class="text-white hover:text-silver-300 transition-colors">Réservations</a> 
            <a href="#" class="text-white hover:text-silver-300 transition-colors">Contact</a> 
            <a href="logout.php" class="bg-transparent border-2 border-white text-white px-4 py-2 rounded-md hover:bg-white hover:text-black transition-all">Log out</a> 
          </div> 
        </div> 
      </div> 
    </nav> 
    <!-- Hero Section --> 
     <div class="relative bg-black overflow-hidden"> 
      <div class="max-w-7xl mx-auto"> 
        <div class="relative z-10  bg-black  "> 
          <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 lg:mt-16 lg:px-8 xl:mt-20"> 
            <div class="text-center lg:text-left"> 
              <h1 class="text-4xl tracking-tight font-extrabold text-white sm:text-5xl md:text-6xl"> 
                <span class="block">Trouvez votre</span> 
                <span class="block text-silver-300">voiture idéale</span> 
              </h1> 
              <p class="mt-3 text-base text-silver-300 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0"> Découvrez notre large sélection de véhicules et réservez en quelques clics. </p> 
            </div> 
            <!-- Search Form --> 
             <div class="mt-8 rounded-lg bg-black shadow-lg p-6 transform "> 
              <form method="get" action=""> 
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4"> 
                  <div class="flex items-center space-x-2 border-b-2 border-silver-300 pb-2"> 
                    <svg class="w-5 h-5 text-silver-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"> 
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 10H3M21 6H3M21 14H3M21 18H3" /> 
                    </svg> 
                    <input type="text" name="search" placeholder="Rechercher un véhicule" class="w-full focus:outline-none bg-black text-white"> 
                  </div> <div class="flex items-center space-x-2 border-b-2 border-silver-300 pb-2"> 
                    <svg class="w-5 h-5 text-silver-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"> 
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4V2h18v2M3 10V8h18v2M3 16V14h18v2M3 22v-2h18v2" /> 
                    </svg> <input type="date" name="date_debut" class="w-full focus:outline-none bg-black text-white"> 
                  </div> <div class="flex items-center space-x-2 border-b-2 border-silver-300 pb-2"> 
                    <svg class="w-5 h-5 text-silver-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"> 
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4V2h18v2M3 10V8h18v2M3 16V14h18v2M3 22v-2h18v2" /> 
                    </svg> 
                    <input type="date" name="date_fin" class="w-full focus:outline-none bg-black text-white"> 
                  </div> 
                  <button type="submit" class="bg-transparent border-2 border-white text-white px-6 py-2 rounded-md hover:bg-white hover:text-black transition-all"> Rechercher </button> 
                </div> 
              </form> 
            </div> 
        </div>
        </div>

        </main>
      </div>
    </div>
  </div>

   <!-- Categories Section -->
   <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h2 class="text-3xl font-bold text-white mb-8">Catégories</h2>
        <ul class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <?php foreach ($categories as $categorie) { ?>
                <li class="bg-gray-800 p-4 rounded-md shadow-md text-center">
                  <form method="get" action=""> 
                    <input type="hidden" name="categorie_id" value="<?php echo $categorie->getId(); ?>"> 
                    <button type="submit" class="text-lg font-semibold text-white"><?php echo $categorie->getNom(); ?></button> 
                  </form>
                </li>
            <?php } ?>
        </ul>
    </div>

    <!-- Vehicules Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h2 class="text-3xl font-bold text-white mb-8">Véhicules</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($vehicules as $vehicule) { ?>
                <div class="bg-black rounded-lg shadow-md overflow-hidden transform hover:-translate-y-1 transition-transform duration-300">
                  <div class="h-48 bg-silver-300">
              <img src="../uploads/<?php echo $vehicule->getImage(); ?>" alt="Car" class="w-full h-full object-cover">
            </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-white mb-2"><?php echo $vehicule->getModele(); ?></h3>
                        <p class="text-silver-300 mb-4">Prix : <?php echo $vehicule->getPrix(); ?>€/jour</p>
                        <p class="text-silver-300 mb-4">Disponibilité : <?php echo $vehicule->getDisponibilite() ? 'Disponible' : 'Indisponible'; ?></p>
                        <div class="flex justify-between">
                        <a href="reserver.php?id=<?php echo $vehicule->getId(); ?>" class="bg-transparent border-2 border-white text-white px-4 py-2 rounded-md hover:bg-white hover:text-black transition-all"> Réserver </a>
                        <a href="vehicule_details.php?id=<?php echo $vehicule->getId(); ?>" class="bg-transparent border-2 border-white text-white px-4 py-2 rounded-md hover:bg-white hover:text-black transition-all"> Voir Détails </a>
                    </div></div>
                </div>
            <?php } ?>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h2 class="text-3xl font-bold text-white mb-8">Véhicules</h2>
    <div id="vehiculesContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- Data will be loaded here via Ajax -->
    </div>
    <div id="pagination" class="flex justify-center mt-8"> 
      <!-- Pagination buttons will be added here --> 
      </div>
</div>





        

  <!-- Featured Cars Section -->
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h2 class="text-3xl font-bold text-white mb-8">Véhicules Populaires</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      <div class="bg-black rounded-lg shadow-md overflow-hidden transform hover:-translate-y-1 transition-transform duration-300">
        <div class="h-48 bg-silver-300">
          <img src="../img/pexels-mohammad-hammad-2148098658-29981161.jpg" alt="Car" class="w-full h-full object-cover">
        </div>
        <div class="p-6">
          <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold text-white">BMW C50</h3>
            <div class="flex items-center">
              <svg class="w-5 h-5 text-yellow-300 fill-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14M5 12h14" />
              </svg>
              <span class="ml-1 text-yellow-300">4.8</span>
            </div>
          </div>
          <p class="text-silver-300 mb-4">Description courte de la voiture avec ses caractéristiques principales.</p>
          <div class="flex justify-between items-center">
            <span class="text-2xl font-bold text-white">50€/jour</span>
            <button class="bg-transparent border-2 border-white text-white px-4 py-2 rounded-md hover:bg-white hover:text-black transition-all">
              Réserver
            </button>
          </div>
        </div>
      </div>
      <!-- Repeat similar blocks for other cars -->
      <div class="bg-black rounded-lg shadow-md overflow-hidden transform hover:-translate-y-1 transition-transform duration-300">
        <div class="h-48 bg-silver-300">
          <img src="../img/pexels-107932638-29913289.jpg" alt="Car" class="w-full h-full object-cover">
        </div>
        <div class="p-6">
          <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold text-white">BMW C50</h3>
            <div class="flex items-center">
              <svg class="w-5 h-5 text-yellow-300 fill-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14M5 12h14" />
              </svg>
              <span class="ml-1 text-yellow-300">4.8</span>
            </div>
          </div>
          <p class="text-silver-300 mb-4">Description courte de la voiture avec ses caractéristiques principales.</p>
          <div class="flex justify-between items-center">
            <span class="text-2xl font-bold text-white">50€/jour</span>
            <a href="reserver.php?id=<?php echo $vehicule->getId(); ?>" class="bg-transparent border-2 border-white text-white px-4 py-2 rounded-md hover:bg-white hover:text-black transition-all">
    Réserver
</a>
          </div>
        </div>
      </div>
    </div>
  </div>
<script type="text/javascript" src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js">
  

</script>


<script>
$(document).ready(function() {
    var currentPage = 1;
    var itemsPerPage = 3;

    function loadVehicles(page) {
        $.ajax({
            url: "fetch_vehicules.php",
            type: "POST",
            data: {
                start: (page - 1) * itemsPerPage,
                length: itemsPerPage
            },
            dataType: "json",
            success: function(json) {
                console.log("JSON Data:", json); // Debugging: Log the JSON data returned
                var vehiculesContainer = $('#vehiculesContainer');
                vehiculesContainer.empty();
                if (json.data && json.data.length > 0) {
                    $.each(json.data, function(index, vehicule) {
                        console.log("Vehicle Data:", vehicule); // Debugging: Log each vehicle data
                        var vehiculeHtml = `
                            <div class="bg-black rounded-lg shadow-md overflow-hidden transform hover:-translate-y-1 transition-transform duration-300">
                                <div class="h-48 bg-silver-300">
                                    <img src="../uploads/${vehicule.image}" alt="Car" class="w-full h-full object-cover">
                                </div>
                                <div class="p-6">
                                    <h3 class="text-xl font-bold text-white mb-2">${vehicule.modele}</h3>
                                    <p class="text-silver-300 mb-4">Prix : ${vehicule.prix}€/jour</p>
                                    <p class="text-silver-300 mb-4">Disponibilité : ${vehicule.disponibilite ? 'Disponible' : 'Indisponible'}</p>
                                    <div class="flex justify-between">
                                        
                                        <a href="reserver.php?id=<?php echo $vehicule->getId(); ?>" class="bg-transparent border-2 border-white text-white px-4 py-2 rounded-md hover:bg-white hover:text-black transition-all"> Réserver </a>

                                        <a href="vehicule_details.php?id=${vehicule.id}" class="bg-transparent border-2 border-white text-white px-4 py-2 rounded-md hover:bg-white hover:text-black transition-all">Voir Détails</a>
                                    </div>
                                </div>
                            </div>
                        `;
                        vehiculesContainer.append(vehiculeHtml);
                    });
                    updatePagination(json.recordsTotal, page);
                } else {
                    console.log("No vehicles found."); // Debugging: Log if no vehicles are found
                }
            },
            error: function(xhr, status, error) {
                console.error("Error fetching vehicles:", status, error); // Debugging: Log any errors
            }
        });
    }

    function updatePagination(totalItems, currentPage) {
        var totalPages = Math.ceil(totalItems / itemsPerPage);
        var pagination = $('#pagination');
        pagination.empty();
        for (var i = 1; i <= totalPages; i++) {
            var pageButton = $('<button>')
                .text(i)
                .addClass('bg-transparent border-2 border-white text-white px-4 py-2 rounded-md hover:bg-white hover:text-black transition-all mx-1')
                .data('page', i)
                .click(function() {
                    loadVehicles($(this).data('page'));
                });
            if (i === currentPage) {
                pageButton.addClass('bg-white text-black');
            }
            pagination.append(pageButton);
        }
    }

    loadVehicles(currentPage);
});
</script>


</body>

</html>
