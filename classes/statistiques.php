<?php
class Statistiques {
    public $total_clients;
    public $total_reservations;
    public $reservations_approuvees;
    public $reservations_en_attente;
    public $reservations_refusees;

    public function __construct($total_clients, $total_reservations, $reservations_approuvees, $reservations_en_attente, $reservations_refusees) {
        $this->total_clients = $total_clients;
        $this->total_reservations = $total_reservations;
        $this->reservations_approuvees = $reservations_approuvees;
        $this->reservations_en_attente = $reservations_en_attente;
        $this->reservations_refusees = $reservations_refusees;
    }

    public static function getStatistiques($db) {
        $query = "SELECT 
                    (SELECT COUNT(*) FROM users WHERE role = 'client') AS total_clients,
                    (SELECT COUNT(*) FROM reservations) AS total_reservations,
                    (SELECT COUNT(*) FROM reservations WHERE statut = 'approuvée') AS reservations_approuvees,
                    (SELECT COUNT(*) FROM reservations WHERE statut = 'en attente') AS reservations_en_attente,
                    (SELECT COUNT(*) FROM reservations WHERE statut = 'refusée') AS reservations_refusees";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return new Statistiques(
            $row['total_clients'],
            $row['total_reservations'],
            $row['reservations_approuvees'],
            $row['reservations_en_attente'],
            $row['reservations_refusees']
        );
    }
}
?>
