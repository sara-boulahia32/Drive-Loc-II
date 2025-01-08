<?php
class Tag {
    private $id;
    private $nom;

    public function __construct($id, $nom) {
        $this->id = $id;
        $this->nom = $nom;
    }

    public function getId() { return $this->id; }
    public function getNom() { return $this->nom; }

    public static function getAllTags($db) {
        $tags = [];
        $query = "SELECT * FROM Tags";
        $stmt = $db->prepare($query);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $tag = new Tag($row['id'], $row['nom']);
            $tags[] = $tag;
        }
        return $tags;
    }

    public static function addTag($db, $nom) {
        $query = "INSERT INTO Tags (nom) VALUES (:nom)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':nom', $nom);
        $stmt->execute();
    }

    public static function deleteTag($db, $id) {
        $query = "DELETE FROM Tags WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
        
    public static function getOrCreateTag($db, $nom) {
        $query = "SELECT id FROM Tags WHERE nom = :nom";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':nom', $nom);
        $stmt->execute();
        $tag = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($tag) {
            return $tag['id'];
        } else {
            // Ajouter le tag s'il n'existe pas
            self::addTag($db, $nom);
            return $db->lastInsertId();
        }
    }
}

?>