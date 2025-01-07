<?php
class Theme {
    private $id;
    private $nom;
    private $description;
    private $date_creation;

    public function __construct($id, $nom, $description, $date_creation) {
        $this->id = $id;
        $this->nom = $nom;
        $this->description = $description;
        $this->date_creation = $date_creation;
    }

    public function getId() { return $this->id; }
    public function getNom() { return $this->nom; }
    public function getDescription() { return $this->description; }
    public function getDateCreation() { return $this->date_creation; }

    public static function getAllThemes($db) {
        $themes = [];
        $query = "SELECT * FROM Themes";
        $stmt = $db->prepare($query);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $theme = new Theme($row['id'], $row['nom'], $row['description'], $row['date_creation']);
            $themes[] = $theme;
        }
        return $themes;
    }

    public static function addTheme($db, $nom, $description) {
        $query = "INSERT INTO Themes (nom, description) VALUES (:nom, :description)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':description', $description);
        $stmt->execute();
    }
}

?>