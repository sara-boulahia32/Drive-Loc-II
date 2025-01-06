<?php
class Reservation {
    private $id;
    private $user_id;
    private $vehicule_id;
    private $date_debut;
    private $date_fin;
    private $statut;

    function __construct($user_id, $vehicule_id, $date_debut, $date_fin, $statut = 'en attente') {
        $this->user_id = $user_id;
        $this->vehicule_id = $vehicule_id;
        $this->date_debut = $date_debut;
        $this->date_fin = $date_fin;
        $this->statut = $statut;
    }

    public function getId() { return $this->id; }
    public function getUserId() { return $this->user_id; }
    public function getVehiculeId() { return $this->vehicule_id; }
    public function getDateDebut() { return $this->date_debut; }
    public function getDateFin() { return $this->date_fin; }
    public function getStatut() { return $this->statut; }
    
    public function setId($id) { $this->id = $id; }

    public function ajouterReservation($db) {
        $query = "INSERT INTO reservations (user_id, vehicule_id, date_debut, date_fin, statut) VALUES (:user_id, :vehicule_id, :date_debut, :date_fin, :statut)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':vehicule_id', $this->vehicule_id);
        $stmt->bindParam(':date_debut', $this->date_debut);
        $stmt->bindParam(':date_fin', $this->date_fin);
        $stmt->bindParam(':statut', $this->statut);
        $stmt->execute();
    }

    public static function getReservationsByUserId($db, $user_id) {
        $query = "SELECT * FROM reservations WHERE user_id = :user_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getAllReservations($db) {
        $reservations = [];
        $query = "SELECT * FROM reservations";
        $stmt = $db->prepare($query);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $reservations[] = new Reservation(
                $row['user_id'],
                $row['vehicule_id'],
                $row['date_debut'],
                $row['date_fin'],
                $row['statut']
            );
        }
        return $reservations;
    }

    public function save($db) {
        $query = "INSERT INTO reservations (user_id, vehicule_id, date_debut, date_fin, statut) VALUES (:user_id, :vehicule_id, :date_debut, :date_fin, :statut)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':vehicule_id', $this->vehicule_id);
        $stmt->bindParam(':date_debut', $this->date_debut);
        $stmt->bindParam(':date_fin', $this->date_fin);
        $stmt->bindParam(':statut', $this->statut);
        $stmt->execute();
    }

    public static function updateReservationStatus($db, $id, $status) {
        $query = "UPDATE reservations SET status = :status WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':statut', $status);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}
?>
