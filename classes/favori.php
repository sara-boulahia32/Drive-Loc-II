<?php
class Favori {
    private $user_id;
    private $vehicule_id;

    public function __construct($user_id, $vehicule_id) {
        $this->user_id = $user_id;
        $this->vehicule_id = $vehicule_id;
    }

    public function getUserId() { return $this->user_id; }
    public function getVehiculeId() { return $this->vehicule_id; }

    public static function getAllFavoris($db, $user_id) {
        $favoris = [];
        $query = "SELECT * FROM favoris WHERE user_id = :user_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $favoris[] = new Favori(
                $row['user_id'],
                $row['vehicule_id']
            );
        }
        return $favoris;
    }

    public function save($db) {
        $query = "INSERT INTO favoris (user_id, vehicule_id) VALUES (:user_id, :vehicule_id)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':vehicule_id', $this->vehicule_id);
        $stmt->execute();
    }
}
?>
