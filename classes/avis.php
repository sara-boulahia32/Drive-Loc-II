<?php
class Avis {
    private $id;
    private $reservation_id;
    private $user_id;
    private $vehicule_id;
    private $note;
    private $commentaire;
    private $deleted_at;
    private $created_at;

    function __construct($reservation_id, $user_id, $vehicule_id, $note, $commentaire, $deleted_at = null, $created_at = null) {
        $this->reservation_id = $reservation_id;
        $this->user_id = $user_id;
        $this->vehicule_id = $vehicule_id;
        $this->note = $note;
        $this->commentaire = $commentaire;
        $this->deleted_at = $deleted_at;
        $this->created_at = $created_at;
    }

    public function getId() { return $this->id; }
    public function getReservationId() { return $this->reservation_id; }
    public function getUserId() { return $this->user_id; }
    public function getVehiculeId() { return $this->vehicule_id; }
    public function getNote() { return $this->note; }
    public function getCommentaire() { return $this->commentaire; }
    public function getDeletedAt() { return $this->deleted_at; }
    public function getCreatedAt() { return $this->created_at; }

    public static function getAllAvis($db) {
        $avis = [];
        $query = "SELECT * FROM avis WHERE deleted_at IS NULL";
        $stmt = $db->prepare($query);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $avis[] = new Avis(
                $row['reservation_id'],
                $row['user_id'],
                $row['vehicule_id'],
                $row['note'],
                $row['commentaire'],
                $row['deleted_at'],
                $row['created_at']
            );
        }
        return $avis;
    }

    public function save($db) {
        $query = "INSERT INTO avis (reservation_id, user_id, vehicule_id, note, commentaire, created_at) VALUES (:reservation_id, :user_id, :vehicule_id, :note, :commentaire, NOW())";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':reservation_id', $this->reservation_id);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':vehicule_id', $this->vehicule_id);
        $stmt->bindParam(':note', $this->note);
        $stmt->bindParam(':commentaire', $this->commentaire);
        $stmt->execute();
    }

    public static function softDelete($db, $id) {
        $query = "UPDATE avis SET deleted_at = NOW() WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public static function restore($db, $id) {
        $query = "UPDATE avis SET deleted_at = NULL WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public static function getAvisByUser($db, $user_id) {
        $avis = [];
        $query = "SELECT * FROM avis WHERE user_id = :user_id AND deleted_at IS NULL";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $avis[] = new Avis(
                $row['reservation_id'],
                $row['user_id'],
                $row['vehicule_id'],
                $row['note'],
                $row['commentaire'],
                $row['deleted_at'],
                $row['created_at']
            );
        }
        return $avis;
    }
}
?>
