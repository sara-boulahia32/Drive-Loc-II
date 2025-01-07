<?php
class ArticleTag {
    private $article_id;
    private $tag_id;

    public function __construct($article_id, $tag_id) {
        $this->article_id = $article_id;
        $this->tag_id = $tag_id;
    }

    public function getArticleId() { return $this->article_id; }
    public function getTagId() { return $this->tag_id; }

    public static function addArticleTag($db, $article_id, $tag_id) {
        $query = "INSERT INTO ArticleTags (article_id, tag_id) VALUES (:article_id, :tag_id)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':article_id', $article_id);
        $stmt->bindParam(':tag_id', $tag_id);
        $stmt->execute();
    }

    public static function deleteArticleTag($db, $article_id, $tag_id) {
        $query = "DELETE FROM ArticleTags WHERE article_id = :article_id AND tag_id = :tag_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':article_id', $article_id);
        $stmt->bindParam(':tag_id', $tag_id);
        $stmt->execute();
    }

    public static function getTagsByArticle($db, $article_id) {
        $tags = [];
        $query = "SELECT t.* FROM Tags t
                  JOIN ArticleTags at ON t.id = at.tag_id
                  WHERE at.article_id = :article_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':article_id', $article_id);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $tag = new Tag($row['id'], $row['nom']);
            $tags[] = $tag;
        }
        return $tags;
    }
}
?>