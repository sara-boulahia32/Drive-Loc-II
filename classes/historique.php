<?php
class HistoriqueArticle {
    private $user_id;
    private $article_id;
    private $date_consultation;

    public function __construct($user_id, $article_id, $date_consultation) {
        $this->user_id = $user_id;
        $this->article_id = $article_id;
        $this->date_consultation = $date_consultation;
    }

    public function getUserId() { return $this->user_id; }
    public function getArticleId() { return $this->article_id; }
    public function getDateConsultation() { return $this->date_consultation; }

    public static function addHistoriqueArticle($db, $user_id, $article_id) {
        $query = "INSERT INTO HistoriqueArticles (user_id, article_id) VALUES (:user_id, :article_id)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':article_id', $article_id);
        $stmt->execute();
    }

    public static function getHistoriqueByUser($db, $user_id) {
        $historique = [];
        $query = "SELECT * FROM HistoriqueArticles WHERE user_id = :user_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $historiqueArticle = new HistoriqueArticle($row['user_id'], $row['article_id'], $row['date_consultation']);
            $historique[] = $historiqueArticle;
        }
        return $historique;
    }
}
?>