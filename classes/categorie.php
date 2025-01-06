<?php
class Categorie {
    private $id;
    private $nom;
    private $description;

    function __construct($nom, $description) {
        $this->nom = $nom;
        $this->description = $description;
    }

    public function getId() { return $this->id; }
    public function getNom() { return $this->nom; }
    public function getDescription() { return $this->description; }


    public function setId($id) { $this->id = $id; }

    public static function getAllCategories($db) {
        $categories = [];
        $query = "SELECT * FROM categories";
        $stmt = $db->prepare($query);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $categories[] = new Categorie($row['nom'], $row['description']);
            // $categorie->setId($row['id']); 
            // $categories[] = $categorie;
        }
        return $categories;
    }

    public function save($db) {
        $query = "INSERT INTO categories (nom, description) VALUES (:nom, :description)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':description', $this->description);
        $stmt->execute();
    }

    public static function delete($db, $id) {
        $query = "DELETE FROM categories WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}
?>
