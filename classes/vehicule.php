<?php
class Vehicule {
    protected $id;
    private $modele;
    private $prix;
    private $disponibilite;
    private $categorie_id;
    private $image_path;

    private $marque;
    private $description;
    private $annee_fabrication;
    private $kilometrage;
    private $type_carburant;
    private $boite_vitesse;
    private $puissance_moteur;
    private $couleur;
    private $equipements_standards;
    private $options_supplementaires;
    private $dates_disponibles;
    private $lieu_prise_en_charge;
    private $lieu_retour;

  
        public function __construct($id,$modele, $marque, $categorie_id, $description, $prix, $disponibilite, $annee_fabrication, $kilometrage, $type_carburant, $boite_vitesse, $puissance_moteur, $couleur, $equipements_standards, $options_supplementaires, $dates_disponibles, $lieu_prise_en_charge, $lieu_retour, $image_path) {
            $this->id = $id;
            $this->modele = $modele;
            $this->marque = $marque;
            $this->categorie_id = $categorie_id;
            $this->description = $description;
            $this->prix = $prix;
            $this->disponibilite = $disponibilite;
            $this->annee_fabrication = $annee_fabrication;
            $this->kilometrage = $kilometrage;
            $this->type_carburant = $type_carburant;
            $this->boite_vitesse = $boite_vitesse;
            $this->puissance_moteur = $puissance_moteur;
            $this->couleur = $couleur;
            $this->equipements_standards = $equipements_standards;
            $this->options_supplementaires = $options_supplementaires;
            $this->dates_disponibles = $dates_disponibles;
            $this->lieu_prise_en_charge = $lieu_prise_en_charge;
            $this->lieu_retour = $lieu_retour;
            $this->image_path = $image_path;
        }
 
    

            public function getId() { return $this->id; }
            public function getModele() { return $this->modele; }
            public function getMarque() { return $this->marque; }
            public function getCategorieId() { return $this->categorie_id; }
            public function getDescription() { return $this->description; }
            public function getPrix() { return $this->prix; }
            public function getDisponibilite() { return $this->disponibilite; }
            public function getAnneeFabrication() { return $this->annee_fabrication; }
            public function getKilometrage() { return $this->kilometrage; }
            public function getTypeCarburant() { return $this->type_carburant; }
            public function getBoiteVitesse() { return $this->boite_vitesse; }
            public function getPuissanceMoteur() { return $this->puissance_moteur; }
            public function getCouleur() { return $this->couleur; }
            public function getEquipementsStandards() { return $this->equipements_standards; }
            public function getOptionsSupplementaires() { return $this->options_supplementaires; }
            public function getDatesDisponibles() { return $this->dates_disponibles; }
            public function getLieuPriseEnCharge() { return $this->lieu_prise_en_charge; }
            public function getLieuRetour() { return $this->lieu_retour; }
            public function getImage() { return $this->image_path; }
      

    public function setId($id) { $this->id = $id; }

    public static function getAllVehicules($db) {
        $vehicules = [];
        $query = "SELECT * FROM vehicules";
        $stmt = $db->prepare($query);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $vehicule = new Vehicule(
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
            $vehicule->setId($row['id']);
            $vehicules[] = $vehicule;
        }
        return $vehicules;
    }

        // $connx = new database();
        // $db = $conn->getConnect();
        // $pagination = new VehiculePagination($db);
        // $response = $pagination->getAllVehicules();
        // echo json_encode($response);


 
        public static function getVehiculeById($db, $id) {
            $query = "SELECT * FROM vehicules WHERE id = :id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                $vehicule = new Vehicule(
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
                $vehicule->setId($row['id']);
                return $vehicule;
            }
            return null;
        }
  
            public function ajouterVehicule($db) {
                $query = "INSERT INTO vehicules (modele, marque, categorie_id, description, prix, disponibilite, annee_fabrication, kilometrage, type_carburant, boite_vitesse, puissance_moteur, couleur, equipements_standards, options_supplementaires, dates_disponibles, lieu_prise_en_charge, lieu_retour, image_path) VALUES (:modele, :marque, :categorie_id, :description, :prix, :disponibilite, :annee_fabrication, :kilometrage, :type_carburant, :boite_vitesse, :puissance_moteur, :couleur, :equipements_standards, :options_supplementaires, :dates_disponibles, :lieu_prise_en_charge, :lieu_retour, :image_path)";
                $stmt = $db->prepare($query);
                $stmt->bindParam(':modele', $this->modele);
                $stmt->bindParam(':marque', $this->marque);
                $stmt->bindParam(':categorie_id', $this->categorie_id);
                $stmt->bindParam(':description', $this->description);
                $stmt->bindParam(':prix', $this->prix);
                $stmt->bindParam(':disponibilite', $this->disponibilite);
                $stmt->bindParam(':annee_fabrication', $this->annee_fabrication);
                $stmt->bindParam(':kilometrage', $this->kilometrage);
                $stmt->bindParam(':type_carburant', $this->type_carburant);
                $stmt->bindParam(':boite_vitesse', $this->boite_vitesse);
                $stmt->bindParam(':puissance_moteur', $this->puissance_moteur);
                $stmt->bindParam(':couleur', $this->couleur);
                $stmt->bindParam(':equipements_standards', $this->equipements_standards);
                $stmt->bindParam(':options_supplementaires', $this->options_supplementaires);
                $stmt->bindParam(':dates_disponibles', $this->dates_disponibles);
                $stmt->bindParam(':lieu_prise_en_charge', $this->lieu_prise_en_charge);
                $stmt->bindParam(':lieu_retour', $this->lieu_retour);
                $stmt->bindParam(':image_path', $this->image_path);
                $stmt->execute();
            }
        }

    


    ?>
    