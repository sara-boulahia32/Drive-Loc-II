<?php
require_once('utilisateur.php');

class Admin extends Utilisateur {
    public function ajouterVehicule($db, $vehicule) {
        $query = "INSERT INTO vehicules (modele, prix, disponibilite, categorie_id, image_path) VALUES (:modele, :prix, :disponibilite, :categorie_id, :image_path)";
        $stmt = $db->prepare($query);
        echo '<pre>';
print_r($stmt->debugDumpParams());
echo '</pre>';
        $image_path = $vehicule->getImage();
        $stmt->bindParam(':modele', $vehicule->getModele());
        $stmt->bindParam(':prix', $vehicule->getPrix());
        $stmt->bindParam(':disponibilite', $vehicule->getDisponibilite());
        $stmt->bindParam(':categorie_id', $vehicule->getCategorieId());
        // $stmt->bindParam(':image_path', $vehicule->getImage());
        $stmt->bindParam(':image_path', $image_path);
        $stmt->execute();
    }

    



    public function modifierVehicule($db, $vehicule) {
        $query = "UPDATE vehicules SET modele = :modele, prix = :prix, disponibilite = :disponibilite, categorie_id = :categorie_id WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':modele', $vehicule->getModele());
        $stmt->bindParam(':prix', $vehicule->getPrix());
        $stmt->bindParam(':disponibilite', $vehicule->getDisponibilite());
        $stmt->bindParam(':categorie_id', $vehicule->getCategorieId());
        $stmt->bindParam(':id', $vehicule->getId());
        $stmt->execute();
    }

    public function supprimerVehicule($db, $vehicule_id) {
        $query = "DELETE FROM vehicules WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $vehicule_id);
        $stmt->execute();
    }

    public function approuverReservation($db, $reservation_id) {
        $query = "UPDATE reservations SET statut = 'approuvée' WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $reservation_id);
        $stmt->execute();
    }

    public function refuserReservation($db, $reservation_id) {
        $query = "UPDATE reservations SET statut = 'refusée' WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $reservation_id);
        $stmt->execute();
    }

    public function ajouterCategorie($db, $categorie) {
        $query = "INSERT INTO categories (nom, description) VALUES (:nom, :description)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':nom', $categorie->getNom());
        $stmt->bindParam(':description', $categorie->getDescription());
        $stmt->execute();
    }

    public function supprimerCategorie($db, $categorie_id) {
        $query = "DELETE FROM categories WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $categorie_id);
        $stmt->execute();
    }

    public function afficherStatistiques($db) {
        $query = "SELECT * FROM statistiques";
        $stmt = $db->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
