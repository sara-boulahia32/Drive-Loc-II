<?php
class Option {
    private $id;
    private $nom;
    private $description;
    private $prix;

    public function __construct($nom, $description, $prix) {
        $this->nom = $nom;
        $this->description = $description;
        $this->prix = $prix;
    }

    public function getId() { return $this->id; }
    public function getNom() { return $this->nom; }
    public function getDescription() { return $this->description; }
    public function getPrix() { return $this->prix; }

    public static function getAllOptions($db) {
        $options = [];
        $query = "SELECT * FROM options";
        $stmt = $db->prepare($query);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $options[] = new Option(
                $row['nom'],
                $row['description'],
                $row['prix']
            );
        }
        return $options;
    }

    public function save($db) {
        $query = "INSERT INTO options (nom, description, prix) VALUES (:nom, :description, :prix)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':prix', $this->prix);
        $stmt->execute();
    }
}
?>
