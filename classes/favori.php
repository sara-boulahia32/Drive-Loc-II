<?php
class Favori {
    private $user_id;
    private $article_id;

    public function __construct($user_id, $article_id) {
        $this->user_id = $user_id;
        $this->article_id = $article_id;
    }

    public function getUserId() { return $this->user_id; }
    public function getArticleId() { return $this->article_id; }

    public static function addFavori($db, $user_id, $article_id) {
        $query = "INSERT INTO Favoris (user_id, article_id) VALUES (:user_id, :article_id)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':article_id', $article_id);
        $stmt->execute();
    }

    public static function deleteFavori($db, $user_id, $article_id) {
        $query = "DELETE FROM Favoris WHERE user_id = :user_id AND article_id = :article_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':article_id', $article_id);
        $stmt->execute();
    }

    public static function getFavorisByUser($db, $user_id) {
        $favoris = [];
        $query = "SELECT * FROM Favoris WHERE user_id = :user_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $favori = new Favori($row['user_id'], $row['article_id']);
            $favoris[] = $favori;
        }
        return $favoris;
    }
}

?>
