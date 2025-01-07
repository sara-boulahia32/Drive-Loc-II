<?php
class LikeCommentaire {
    private $user_id;
    private $commentaire_id;
    private $type;

    public function __construct($user_id, $commentaire_id, $type) {
        $this->user_id = $user_id;
        $this->commentaire_id = $commentaire_id;
        $this->type = $type;
    }

    public function getUserId() { return $this->user_id; }
    public function getCommentaireId() { return $this->commentaire_id; }
    public function getType() { return $this->type; }

    public static function addLikeCommentaire($db, $user_id, $commentaire_id, $type) {
        $query = "INSERT INTO LikesCommentaires (user_id, commentaire_id, type) VALUES (:user_id, :commentaire_id, :type)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':commentaire_id', $commentaire_id);
        $stmt->bindParam(':type', $type);
        $stmt->execute();
    }

    public static function deleteLikeCommentaire($db, $user_id, $commentaire_id) {
        $query = "DELETE FROM LikesCommentaires WHERE user_id = :user_id AND commentaire_id = :commentaire_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':commentaire_id', $commentaire_id);
        $stmt->execute();
    }

    public static function getLikesByCommentaire($db, $commentaire_id) {
        $likes = [];
        $query = "SELECT * FROM LikesCommentaires WHERE commentaire_id = :commentaire_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':commentaire_id', $commentaire_id);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $likeCommentaire = new LikeCommentaire($row['user_id'], $row['commentaire_id'], $row['type']);
            $likes[] = $likeCommentaire;
        }
        return $likes;
    }
}
?>