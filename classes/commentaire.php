<?php
class Commentaire {
    private $id;
    private $contenu;
    private $user_id;
    private $article_id;
    private $date_creation;
    private $date_modification;

    public function __construct($id, $contenu, $user_id, $article_id, $date_creation, $date_modification) {
        $this->id = $id;
        $this->contenu = $contenu;
        $this->user_id = $user_id;
        $this->article_id = $article_id;
        $this->date_creation = $date_creation;
        $this->date_modification = $date_modification;
    }

    public function getId() { return $this->id; }
    public function getContenu() { return $this->contenu; }
    public function getUserId() { return $this->user_id; }
    public function getArticleId() { return $this->article_id; }
    public function getDateCreation() { return $this->date_creation; }
    public function getDateModification() { return $this->date_modification; }

    public static function getAllCommentaires($db) {
        $commentaires = [];
        $query = "SELECT * FROM Commentaires";
        $stmt = $db->prepare($query);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $commentaire = new Commentaire($row['id'], $row['contenu'], $row['user_id'], $row['article_id'], $row['date_creation'], $row['date_modification']);
            $commentaires[] = $commentaire;
        }
        return $commentaires;
    }

    public static function addCommentaire($db, $contenu, $user_id, $article_id) {
        $query = "INSERT INTO Commentaires (contenu, user_id, article_id) VALUES (:contenu, :user_id, :article_id)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':contenu', $contenu);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':article_id', $article_id);
        $stmt->execute();
    }

    public static function updateCommentaire($db, $id, $contenu) {
        $query = "UPDATE Commentaires SET contenu = :contenu, date_modification = CURRENT_TIMESTAMP WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':contenu', $contenu);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public static function deleteCommentaire($db, $id) {
        $query = "DELETE FROM Commentaires WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public static function approveCommentaire($db, $id) {
        $query = "UPDATE Commentaires SET statut = 'approuve' WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public static function refuseCommentaire($db, $id) {
        $query = "UPDATE Commentaires SET statut = 'refuse' WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}
?>