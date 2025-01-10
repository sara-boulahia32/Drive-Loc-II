<?php
session_start();
require_once('../database/db.php');
require_once('../classes/article.php');
require_once('../classes/tag.php');
require_once('../classes/articletag.php');

$db = dataBase::getInstance()->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['titre'])) {
        // Ajout d'un article
        $titre = $_POST['titre'];
        $contenu = $_POST['contenu'];
        $theme_id = $_POST['theme'];
        $user_id = $_SESSION['user_id']; 
        $tags = explode(',', $_POST['tags']); 
        $image_path = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $image_path = '../uploads/' . basename($_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], $image_path);
        }
        $video_path = null;
        if (isset($_FILES['video']) && $_FILES['video']['error'] == 0) {
            $video_path = '../uploads/' . basename($_FILES['video']['name']);
            move_uploaded_file($_FILES['video']['tmp_name'], $video_path);
        }
        Article::addArticle($db, $titre, $contenu, $image_path, $video_path, $user_id, $theme_id);
        $article_id = $db->lastInsertId();
        foreach ($tags as $tag_name) {
            $tag_name = trim($tag_name);
            if (!empty($tag_name)) {
                $query = "SELECT id FROM Tags WHERE nom = :nom";
                $stmt = $db->prepare($query);
                $stmt->bindParam(':nom', $tag_name);
                $stmt->execute();
                $tag = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($tag) {
                    $tag_id = $tag['id'];
                } else {
                    Tag::addTag($db, $tag_name);
                    $tag_id = $db->lastInsertId();
                }
                ArticleTag::addArticleTag($db, $article_id, $tag_id);
            }
        }
        header("Location: article.php");
        exit();
    } elseif (isset($_POST['search'])) {
        // Recherche d'articles
        $search = trim($_POST['search']);
        $query = "SELECT a.*, t.nom AS theme_name 
                  FROM Articles a 
                  JOIN Themes t ON a.theme_id = t.id 
                  WHERE a.titre LIKE :search OR a.contenu LIKE :search OR t.nom LIKE :search";
        $stmt = $db->prepare($query);
        $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
        $stmt->execute();
        $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($articles);
        exit();
    }
}

$query = "SELECT * FROM Themes";
$stmt = $db->prepare($query);
$stmt->execute();
$themes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Drive & Loc Blog</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
  <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>

</head> 

<body class="bg-gray-50 min-h-screen">
  <div class="min-h-screen bg-neutral-900">
  <!-- Navigation -->
  <nav class="fixed top-0 w-full z-50 px-8 py-6 bg-neutral-900/90 backdrop-blur-sm">
    <div class="flex justify-between items-center max-w-7xl mx-auto">
      <div class="text-white font-bold text-2xl hover:scale-105 transition-all duration-300 cursor-pointer">
        DRIVE & LOC BLOG
      </div>

      <!-- Desktop Menu -->
      <div class="hidden md:flex items-center gap-8">
        <a href="#articles" class="text-white hover:text-gray-300 transition-all duration-300">Articles</a>
        <a href="#experiences" class="text-white hover:text-gray-300 transition-all duration-300">Expériences</a>
        <a href="#destinations" class="text-white hover:text-gray-300 transition-all duration-300">Destinations</a>
        <button class="bg-white text-black px-6 py-2 rounded hover:bg-gray-200 hover:-translate-y-0.5 transition-all duration-300" onclick="toggleArticleForm()">
          Créer un Article
        </button>
      </div>

      <button class="md:hidden text-white" onclick="toggleMenu()">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
      </button>
    </div>
  </nav>

  <!-- Hero Section -->
  <div class="pt-24 px-8 max-w-7xl mx-auto">
    <div class="flex flex-col md:flex-row items-center gap-12 py-16">
      <div class="w-full md:w-1/2">
        <h2 class="text-gray-400 text-xl mb-4 tracking-wider">BLOG AUTOMOBILE DE LUXE</h2>
        <h1 class="text-white text-4xl md:text-6xl font-bold mb-6 leading-tight">
          Découvrez des Expériences Automobiles Uniques
        </h1>
        <div class="relative flex flex">
  <svg class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400" width="20" height="20" fill="none" xmlns="http://www.w3.org/2000/svg">
    <path d="M7 10h10M7 6h10M7 14h10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
  </svg>
  <input
    type="text"
    placeholder="Rechercher des articles..."
    id="searchInput"
    class="w-full pl-12 pr-4 py-3 bg-neutral-800 text-white rounded-lg focus:ring-2 focus:ring-white/20 transition-all duration-300"
  />
  <button type="button" id="searchButton" class="bg-transparent border-2 border-white text-white px-6 py-2 rounded-md hover:bg-white hover:text-black transition-all">Rechercher</button>
</div>
</div>
      <div class="w-full md:w-1/2">
        <div class="grid grid-cols-2 gap-4">
         <div key="${i}" class="relative group overflow-hidden rounded-lg">
              <img
                src="../img2/Van Life.jpg"
                alt="Luxury car"
                class="w-full h-48 object-cover transform group-hover:scale-110 transition-all duration-500"
              />
              <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent">
                
              </div>
            </div>`
         
        </div>
      </div>
    </div>

        <!-- Themes Section -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <h2 class="text-3xl font-bold text-white mb-8">Thèmes</h2>
      <div id="themesContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- Data will be loaded here via Ajax -->
      </div>
    </div>

    <!-- Articles Section --> 
     <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12"> 
      <h2 class="text-3xl font-bold text-white mb-8">Articles</h2> 
      <div class="flex justify-end mb-4"> 
        <label for="itemsPerPage" class="text-white mr-2">Articles par page:</label> 
        <select id="itemsPerPage" class="p-2 rounded"> 
          <option value="6">6</option> 
          <option value="12">12</option> 
          <option value="18">18</option> 
          <option value="24">24</option> 
          <option value="30">30</option> 
        </select> 
      </div> 
      <div id="articlesContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"> 
        <!-- Data will be loaded here via Ajax --> 
        </div> 
        <div id="pagination" class="flex justify-center mt-8"> 
          <!-- Pagination buttons will be added here --> 
          </div> 
        </div>



  

<!-- Article Form Modal -->
<div id="articleFormModal" class="fixed hidden inset-0 bg-black bg-opacity-50  flex items-center justify-center z-50">
  <div class="bg-black p-8 rounded-lg">
    <h2 class="text-2xl mb-4 text-white">Créer un Article</h2>
    <form id="articleForm" method="post" action="article.php" enctype="multipart/form-data">
      <label for="titre" class="text-white">Titre:</label>
      <input type="text" id="titre" name="titre" required class="mb-4 p-2 border rounded text-black w-full"><br>

      <label for="contenu" class="text-white">Contenu:</label>
      <textarea id="contenu" name="contenu" required class="mb-4 p-2 border rounded text-black w-full"></textarea><br>

      <label for="image" class="text-white">Image (optionnel):</label>
      <input type="file" id="image" name="image" class="mb-4 p-2 border rounded text-black w-full"><br>

      <label for="video" class="text-white">Vidéo (optionnel):</label>
      <input type="file" id="video" name="video" class="mb-4 p-2 border rounded text-black w-full"><br>

      <label for="theme" class="text-white">Thème:</label>
      <select id="theme" name="theme" required class="mb-4 p-2 border rounded text-black w-full">
        <?php foreach ($themes as $theme): ?>
          <option value="<?= $theme['id'] ?>"><?= $theme['nom'] ?></option>
        <?php endforeach; ?>
      </select><br>

      <label for="tags" class="text-white">Tags (séparés par des virgules):</label>
      <input type="text" id="tags" name="tags" class="mb-4 p-2 border rounded text-black w-full"><br>

      <div class="flex justify-end">
        <button type="button" class="border border-white text-white px-8 py-3 rounded-sm hover:bg-white/10 transition-all mr-2" onclick="document.getElementById('articleFormModal').classList.add('hidden')">Annuler</button>
        <button type="submit" class="bg-white text-black px-8 py-3 rounded-sm hover:bg-gray-200 transition-all">Créer</button>
      </div>
      </form>
      </div>
      </div>

      

    </div>
      <!-- Mobile Menu -->
      <div id="mobileMenu" class="hidden fixed inset-0 bg-neutral-800 bg-opacity-90 z-40">
        <div class="flex justify-end p-6">
          <button onclick="toggleMenu()" class="text-white">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </button>
        </div>
      
        <div class="flex flex-col items-center py-8">
          <a href="#articles" class="text-white text-xl py-4 hover:text-gray-300 transition-all duration-300">Articles</a>
          <a href="#experiences" class="text-white text-xl py-4 hover:text-gray-300 transition-all duration-300">Expériences</a>
          <a href="#destinations" class="text-white text-xl py-4 hover:text-gray-300 transition-all duration-300">Destinations</a>
          <button class="bg-white text-black px-6 py-2 rounded mt-6 hover:bg-gray-200 hover:-translate-y-0.5 transition-all duration-300">
            Créer un Article
          </button>
        </div>
      </div>
      
      <!-- Main Content -->
      <div class="pt-24 px-8 max-w-7xl mx-auto">
        <section class="py-16">
          <!-- Featured Articles -->
          <div class="flex justify-between items-center mb-8">
            <h2 class="text-white text-3xl font-bold">Articles Tendance</h2>
            <button class="text-gray-400 hover:text-white transition-colors duration-300 flex items-center gap-2">
              Voir tout
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
              </svg>
            </button>
          </div>
      
          <!-- Article Grid -->
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Article Example (Repeatable Block) -->
            <article class="bg-neutral-800 rounded-lg overflow-hidden group hover:transform hover:scale-[1.02] transition-all duration-300">
              <div class="relative">
                <img src="../img2/5d323a2a-5f8b-4e50-bf7b-aa191f5da2b6.jpg" alt="Article thumbnail" class="w-full h-64 object-cover" />
                <div class="absolute top-4 left-4 px-3 py-1 bg-white/10 backdrop-blur-sm rounded-full text-white text-sm">
                  Supercar
                </div>
              </div>
              <div class="p-6">
                <h3 class="text-white text-xl font-semibold mb-3 group-hover:text-orange-500 transition-colors duration-300">
                  Les Routes Mythiques des Alpes
                </h3>
                <p class="text-gray-400 mb-4">
                  Découvrez les plus beaux parcours alpins au volant d'une voiture d'exception...
                </p>
                <div class="flex justify-between items-center">
                  <div class="flex items-center gap-4">
                    <button class="text-gray-400 hover:text-white transition-colors duration-300 flex items-center gap-1">
                        ❤️ 245
                    </button>
                    <button class="text-gray-400 hover:text-white transition-colors duration-300 flex items-center gap-1">
                        💬
                      48
                    </button>
                  </div>
                  <button class="text-gray-400 hover:text-white transition-colors duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path d="M12 19l7-7-7-7"></path>
                    </svg>
                  </button>
                </div>
              </div>
            </article>
          </div>
        </section>
      </div>
      <script>
        function toggleMenu() {
          const menu = document.getElementById('mobileMenu');
          menu.classList.toggle('hidden');
        }
        function toggleArticleForm() {
          const formModal = document.getElementById('articleFormModal');
          formModal.classList.toggle('hidden');
        }
        $(document).ready(function() {
    var currentPage = 1;
    var itemsPerPage = 6;

    function loadArticles(page, itemsPerPage) {
        $.ajax({
            url: "fetch_articles.php",
            type: "POST",
            data: {
                start: (page - 1) * itemsPerPage,
                length: itemsPerPage,
                search: $('#searchInput').val()
            },
            dataType: "json",
            success: function(json) {
                var articlesContainer = $('#articlesContainer');
                articlesContainer.empty();
                if (json.data && json.data.length > 0) {
                    $.each(json.data, function(index, article) {
                        var articleHtml = `
                            <div class="bg-black rounded-lg shadow-md overflow-hidden transform hover:-translate-y-1 transition-transform duration-300">
                                <div class="h-48 bg-silver-300">
                                    <img src="../uploads/${article.image_path}" alt="Article Image" class="w-full h-full object-cover">
                                </div>
                                <div class="p-6">
                                    <h3 class="text-white text-xl font-semibold mb-3 group-hover:text-orange-500 transition-colors duration-300">${article.titre}</h3>
                                    <p class="text-silver-300 mb-4">${article.contenu}</p>
                                    <div class="flex justify-between">
                                        <a href="article_details.php?id=${article.id}" class="bg-transparent border-2 border-white text-white px-4 py-2 rounded-md hover:bg-white hover:text-black transition-all">Voir Détails</a>
                                    </div>
                                </div>
                            </div>
                        `;
                        articlesContainer.append(articleHtml);
                    });
                    updatePagination(json.recordsTotal, page, itemsPerPage);
                } else {
                    articlesContainer.append('<p class="text-white">Aucun article trouvé.</p>');
                }
            }
        });
    }

    function updatePagination(totalItems, currentPage, itemsPerPage) {
        var totalPages = Math.ceil(totalItems / itemsPerPage);
        var pagination = $('#pagination');
        pagination.empty();
        for (var i = 1; i <= totalPages; i++) {
            var pageButton = $('<button>')
                .text(i)
                .addClass('bg-transparent border-2 border-white text-white px-4 py-2 rounded-md hover:bg-white hover:text-black transition-all mx-1')
                .data('page', i)
                .click(function() {
                    loadArticles($(this).data('page'), itemsPerPage);
                });
            if (i === currentPage) {
                pageButton.addClass('bg-white text-black');
            }
            pagination.append(pageButton);
        }
    }

    $('#itemsPerPage').change(function() {
        itemsPerPage = $(this).val();
        loadArticles(currentPage, itemsPerPage);
    });

    $('#searchInput').keyup(function() {
      console.log('hel');

        loadArticles(currentPage, itemsPerPage);
    });
    $('#searchButton').click(function() { 
      console.log('hel');
      loadArticles(currentPage, itemsPerPage); 
    });

    loadArticles(currentPage, itemsPerPage);
});


$(document).ready(function() {
    function loadThemes() {
        $.ajax({
            url: "fetch_themes.php",
            type: "POST",
            data: {
                search: $('#searchInput').val()
            },
            dataType: "json",
            success: function(json) {
                var themesContainer = $('#themesContainer');
                themesContainer.empty();
                if (json.data && json.data.length > 0) {
                    $.each(json.data, function(index, theme) {
                        var themeHtml = `
                        
                            <div class="bg-gray-800 p-4 rounded-md shadow-md text-center">
                            <h3 class="text-xl font-bold text-white ">${theme.nom}</h3>
                              
                            </div>
                        `;
                        themesContainer.append(themeHtml);
                    });
                } else {
                    themesContainer.append('<p class="text-white">Aucun thème trouvé.</p>');
                }
            }
        });
    }

    $('#searchInput').keyup(function() {
        loadThemes();
    });

    loadThemes();
});
document.querySelector('button[type="submit"]').addEventListener('click', function (event) {
    event.preventDefault();
    const searchValue = document.getElementById('searchInput').value.trim();
    
    if (searchValue) {
        // Faire une requête Ajax pour chercher des articles
        fetch(`search.php?q=${encodeURIComponent(searchValue)}`)
            .then(response => response.json())
            .then(data => {
                const articlesContainer = document.getElementById('articlesContainer');
                articlesContainer.innerHTML = ''; // Vider les anciens articles
                data.forEach(article => {
                    articlesContainer.innerHTML += `
                        <div class="article">
                            <h3>${article.title}</h3>
                            <p>${article.content}</p>
                        </div>
                    `;
                });
            })
            .catch(error => console.error('Erreur lors de la recherche:', error));
    }
});


      </script>

</body>

</html>
