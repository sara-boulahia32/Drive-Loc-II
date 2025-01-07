<?php
class Article {
    private $id;
    private $titre;
    private $contenu;
    private $image_path;
    private $video_path;
    private $statut;
    private $user_id;
    private $theme_id;
    private $date_creation;
    private $date_modification;

    public function __construct($id, $titre, $contenu, $image_path, $video_path, $statut, $user_id, $theme_id, $date_creation, $date_modification) {
        $this->id = $id;
        $this->titre = $titre;
        $this->contenu = $contenu;
        $this->image_path = $image_path;
        $this->video_path = $video_path;
        $this->statut = $statut;
        $this->user_id = $user_id;
        $this->theme_id = $theme_id;
        $this->date_creation = $date_creation;
        $this->date_modification = $date_modification;
    }

    public function getId() { return $this->id; }
    public function getTitre() { return $this->titre; }
    public function getContenu() { return $this->contenu; }
    public function getImagePath() { return $this->image_path; }
    public function getVideoPath() { return $this->video_path; }
    public function getStatut() { return $this->statut; }
    public function getUserId() { return $this->user_id; }
    public function getThemeId() { return $this->theme_id; }
    public function getDateCreation() { return $this->date_creation; }
    public function getDateModification() { return $this->date_modification; }

    public static function getAllArticles($db) {
        $articles = [];
        $query = "SELECT * FROM Articles";
        $stmt = $db->prepare($query);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $article = new Article($row['id'], $row['titre'], $row['contenu'], $row['image_path'], $row['video_path'], $row['statut'], $row['user_id'], $row['theme_id'], $row['date_creation'], $row['date_modification']);
            $articles[] = $article;
        }
        return $articles;
    }

    public static function addArticle($db, $titre, $contenu, $image_path, $video_path, $user_id, $theme_id) {
        $query = "INSERT INTO Articles (titre, contenu, image_path, video_path, user_id, theme_id) VALUES (:titre, :contenu, :image_path, :video_path, :user_id, :theme_id)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':titre', $titre);
        $stmt->bindParam(':contenu', $contenu);
        $stmt->bindParam(':image_path', $image_path);
        $stmt->bindParam(':video_path', $video_path);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':theme_id', $theme_id);
        $stmt->execute();
    }

    public static function updateArticle($db, $id, $titre, $contenu, $image_path, $video_path, $theme_id) {
        $query = "UPDATE Articles SET titre = :titre, contenu = :contenu, image_path = :image_path, video_path = :video_path, theme_id = :theme_id, statut = 'en_attente' WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':titre', $titre);
        $stmt->bindParam(':contenu', $contenu);
        $stmt->bindParam(':image_path', $image_path);
        $stmt->bindParam(':video_path', $video_path);
        $stmt->bindParam(':theme_id', $theme_id);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public static function deleteArticle($db, $id) {
        $query = "DELETE FROM Articles WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public static function approveArticle($db, $id) {
        $query = "UPDATE Articles SET statut = 'approuve' WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public static function refuseArticle($db, $id) {
        $query = "UPDATE Articles SET statut = 'refuse' WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}

?>