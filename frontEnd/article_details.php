<?php
session_start();
require_once('../database/db.php');
require_once('../classes/article.php');
require_once('../classes/theme.php');
require_once('../classes/tag.php');
require_once('../classes/articleTag.php');

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$db = dataBase::getInstance()->getConnection();
$article_id = $_GET['id'];
$article = Article::getArticleById($db, $article_id);

if (!$article) {
    echo "Article non trouvé.";
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['article_id']) && isset($_POST['titre'])) {
        // Modification de l'article
        $article_id = $_POST['article_id'];
        $titre = $_POST['titre'];
        $contenu = $_POST['contenu'];
        $theme_id = $_POST['theme'];
        $tags = explode(',', $_POST['tags']);
        $image_path = null;
                $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'mp4', 'avi'];
        $file_extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        if (!in_array($file_extension, $allowed_extensions)) {
            echo "Type de fichier non autorisé.";
            exit();
        }
        $contenu = isset($_POST['contenu']) ? trim($_POST['contenu']) : '';
        if (empty($contenu)) {
            echo "Le contenu est obligatoire.";
            exit();
        }

        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            
            $image_path = '../uploads/' . basename($_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], $image_path);
        }
        $video_path = null;
        if (isset($_FILES['video']) && $_FILES['video']['error'] == 0) {
            $video_path = '../uploads/' . basename($_FILES['video']['name']);
            move_uploaded_file($_FILES['video']['tmp_name'], $video_path);
        }

        Article::updateArticle($db, $article_id, $titre, $contenu, $image_path, $video_path, $theme_id);

        // Update tags
        ArticleTag::deleteArticleTag($db, $article_id, $tag_id);
        foreach ($tags as $tag_name) {
            $tag_name = trim($tag_name);
            if (!empty($tag_name)) {
                $tag_id = Tag::getOrCreateTag($db, $tag_name);
                ArticleTag::addArticleTag($db, $article_id, $tag_id);
            }
        }

        header("Location: article_details.php?id=$article_id");
        exit();
    } elseif (isset($_POST['article_id']) && !isset($_POST['titre'])) {
        // Suppression de l'article
        $article_id = $_POST['article_id'];
        Article::deleteArticle($db, $article_id);
        header("Location: article.php");
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
    <title>Détails de l'Article</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="min-h-screen bg-black text-white p-8">

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
            <a href="articles.php" class="text-white hover:text-silver-300 transition-colors">Articles</a> 
            <a href="mes_articles.php" class="text-white hover:text-silver-300 transition-colors">Mes Articles</a> 
            <a href="#" class="text-white hover:text-silver-300 transition-colors">Contact</a> 
            <a href="logout.php" class="bg-transparent border-2 border-white text-white px-4 py-2 rounded-md hover:bg-white hover:text-black transition-all">Log out</a> 
          </div> 
        </div> 
      </div> 
    </nav> 

    <!-- Article Details Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h2 class="text-3xl font-bold text-white mb-8">Détails de l'Article</h2>
        <div class="bg-black rounded-lg shadow-md overflow-hidden">
            <div class="h-64 bg-silver-300">
                <img src="../uploads/<?php echo $article->getImagePath(); ?>" alt="Article Image" class="w-full h-full object-cover">
            </div>
            <div class="p-6">
            <h3 ><?php echo htmlspecialchars($article->getTitre(), ENT_QUOTES, 'UTF-8'); ?></h3>
            <p class="text-silver-300 mb-4">Contenu : <?php echo $article->getContenu(); ?></p>
                <p class="text-silver-300 mb-4">Statut : <?php echo $article->getStatut(); ?></p>
                <p class="text-silver-300 mb-4">Date de création : <?php echo $article->getDateCreation(); ?></p>
                <p class="text-silver-300 mb-4">Date de modification : <?php echo $article->getDateModification(); ?></p>
                <p class="text-silver-300 mb-4">Thème : <?php echo htmlspecialchars($article->getThemeName(), ENT_QUOTES, 'UTF-8'); ?></p>
                <p class="text-silver-300 mb-4">Auteur : <?php echo htmlspecialchars($article->getUserName(), ENT_QUOTES, 'UTF-8'); ?></p>
                
<button class="bg-white text-black px-6 py-2 rounded hover:bg-gray-200 hover:-translate-y-0.5 transition-all duration-300" onclick="toggleEditArticleForm()">
          Modifier
        </button>

<button class="bg-transparent border-2 border-white text-white px-4 py-2 rounded-md hover:bg-white hover:text-black transition-all" onclick="toggleDeleteArticleForm()">
          Supprimer
        </button>

            </div>
        </div>
    </div>

    <!-- Article Form Modal for Modification -->
<div id="editArticleFormModal" class="fixed  inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
  <div class="bg-black p-8 rounded-lg">
    <h2 class="text-2xl mb-4 text-white">Modifier l'Article</h2>
    <form id="editArticleForm" method="post" enctype="multipart/form-data">
      <input type="hidden" id="edit_article_id" name="article_id" value="<?php echo $article->getId(); ?>">
      <label for="edit_titre" class="text-white">Titre:</label>
      <input type="text" id="edit_titre" name="titre" value="<?php echo $article->getTitre(); ?>" required class="mb-4 p-2 border rounded text-black w-full"><br>

      <label for="edit_contenu" class="text-white">Contenu:</label>
      <textarea id="edit_contenu" name="contenu" required class="mb-4 p-2 border rounded text-black w-full"><?php echo $article->getContenu(); ?></textarea><br>

      <label for="edit_image" class="text-white">Image (optionnel):</label>
      <input type="file" id="edit_image" name="image" class="mb-4 p-2 border rounded text-black w-full"><br>

      <label for="edit_video" class="text-white">Vidéo (optionnel):</label>
      <input type="file" id="edit_video" name="video" class="mb-4 p-2 border rounded text-black w-full"><br>

      <label for="edit_theme" class="text-white">Thème:</label>
      <select id="edit_theme" name="theme" required class="mb-4 p-2 border rounded text-black w-full">
        <?php foreach ($themes as $theme): ?>
          <option value="<?= $theme['id'] ?>" <?php if ($theme['id'] == $article->getThemeId()) echo 'selected'; ?>><?= $theme['nom'] ?></option>
        <?php endforeach; ?>
      </select><br>

      <label for="edit_tags" class="text-white">Tags (séparés par #):</label>
      <input type="text" id="edit_tags" name="tags" value="<?php echo implode('#', $article->getTags($db)); ?>" class="mb-4 p-2 border rounded text-black w-full"><br>

      <div class="flex justify-end">
        <button type="button" class="border border-white text-white px-8 py-3 rounded-sm hover:bg-white/10 transition-all mr-2" onclick="document.getElementById('editArticleFormModal').classList.add('hidden')">Annuler</button>
        <button type="submit" class="bg-white text-black px-8 py-3 rounded-sm hover:bg-gray-200 transition-all">Modifier</button>
      </div>
    </form>
  </div>
</div>

<!-- Article Form Modal for Suppression -->
<div id="deleteArticleFormModal" class="fixed hidden inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
  <div class="bg-black p-8 rounded-lg">
    <h2 class="text-2xl mb-4 text-white">Supprimer l'Article</h2>
    <form id="deleteArticleForm" method="post">
      <input type="hidden" id="delete_article_id" name="article_id" value="<?php echo $article->getId(); ?>">
      <p class="text-white mb-4">Êtes-vous sûr de vouloir supprimer cet article ?</p>
      <div class="flex justify-end">
        <button type="button" class="border border-white text-white px-8 py-3 rounded-sm hover:bg-white/10 transition-all mr-2" onclick="document.getElementById('deleteArticleFormModal').classList.add('hidden')">Annuler</button>
        <button type="submit" class="bg-red-500 text-white px-8 py-3 rounded-sm hover:bg-red-700 transition-all">Supprimer</button>
      </div>
    </form>
  </div>
</div>

<script>
  function toggleEditArticleForm() {
    const formModal = document.getElementById('editArticleFormModal');
    formModal.classList.toggle('hidden');
  }

  function toggleDeleteArticleForm() {
    const formModal = document.getElementById('deleteArticleFormModal');
    formModal.classList.toggle('hidden');
  }
</script>


</body>

</html>
