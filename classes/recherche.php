<?php
class Recherche {
    public static function rechercherVehicules($db, $critere, $date_debut = null, $date_fin = null) {
        $query = "SELECT * FROM vehicules WHERE 
            (modele LIKE :critere OR marque LIKE :critere OR description LIKE :critere OR type_carburant LIKE :critere OR boite_vitesse LIKE :critere OR couleur LIKE :critere)";
        
        $params = [':critere' => '%' . $critere . '%'];

        if ($date_debut && $date_fin) {
            // $query .= " SELECT vehicule_id FROM reservations WHERE date_debut <= :date_fin AND date_fin >= :date_debut)";
            $params[':date_debut'] = $date_debut;
            $params[':date_fin'] = $date_fin;
        }

        $stmt = $db->prepare($query);
        $stmt->execute($params);
        $vehicules = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $vehicules[] = new Vehicule(
                $row['id'],
                $row['modele'],
                $row['marque'],
                $row['categorie_id'],
                $row['description'],
                $row['prix'],
                $row['disponibilite'],
                $row['annee_fabrication'],
                $row['kilometrage'],
                $row['type_carburant'],
                $row['boite_vitesse'],
                $row['puissance_moteur'],
                $row['couleur'],
                $row['equipements_standards'],
                $row['options_supplementaires'],
                $row['dates_disponibles'],
                $row['lieu_prise_en_charge'],
                $row['lieu_retour'],
                $row['image_path']
            );
        }
        return $vehicules;
    }


    public static function filtrerVehiculesParCategorie($db, $categorie_id) {
        $query = "SELECT * FROM vehicules WHERE categorie_id = :categorie_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':categorie_id', $categorie_id);
        $stmt->execute();
        $vehicules = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $vehicules[] = new Vehicule(
                $row['id'],
                $row['modele'],
                $row['marque'],
                $row['categorie_id'],
                $row['description'],
                $row['prix'],
                $row['disponibilite'],
                $row['annee_fabrication'],
                $row['kilometrage'],
                $row['type_carburant'],
                $row['boite_vitesse'],
                $row['puissance_moteur'],
                $row['couleur'],
                $row['equipements_standards'],
                $row['options_supplementaires'],
                $row['dates_disponibles'],
                $row['lieu_prise_en_charge'],
                $row['lieu_retour'],
                $row['image_path']
            );
        }
        return $vehicules;
    }
}
?>
