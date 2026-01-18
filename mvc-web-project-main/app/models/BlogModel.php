<?php
require_once __DIR__ . '/Model.php';

class BlogModel extends Model {
    
    public function getAllArticles() {
        $sql = "SELECT * FROM articles ORDER BY date_creation DESC";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getArticleById($id) {
        $sql = "SELECT * FROM articles WHERE id_article = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Récupérer le vote actuel d'un utilisateur pour un article
    public function getUserVote($userId, $articleId) {
        $sql = "SELECT vote_type FROM article_votes WHERE id_user = ? AND id_article = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId, $articleId]);
        return $stmt->fetchColumn(); // Retourne 'like', 'dislike' ou false
    }

    // Gestion intelligente du vote (Ajout / Suppression / Changement)
    public function toggleVote($userId, $articleId, $type) {
        try {
            $this->db->beginTransaction();

            // 1. On regarde ce qu'il a déjà fait
            $currentVote = $this->getUserVote($userId, $articleId);
            $action = '';

            if ($currentVote === $type) {
                // CAS 1 : Il clique sur la même chose -> ON ANNULE (Suppression)
                $this->db->prepare("DELETE FROM article_votes WHERE id_user=? AND id_article=?")->execute([$userId, $articleId]);
                
                // Décrémentation sécurisée (ne descend pas sous 0)
                $col = ($type === 'like') ? 'likes' : 'dislikes';
                $this->db->prepare("UPDATE articles SET $col = GREATEST(0, $col - 1) WHERE id_article=?")->execute([$articleId]);
                
                $action = 'removed';
            } 
            elseif ($currentVote) {
                // CAS 2 : Il change d'avis (ex: était Like, clique Dislike) -> ON CHANGE
                $this->db->prepare("UPDATE article_votes SET vote_type=? WHERE id_user=? AND id_article=?")->execute([$type, $userId, $articleId]);

                // Mise à jour des compteurs (+1 nouveau, -1 ancien)
                $newCol = ($type === 'like') ? 'likes' : 'dislikes';
                $oldCol = ($currentVote === 'like') ? 'likes' : 'dislikes';
                $this->db->prepare("UPDATE articles SET $newCol = $newCol + 1, $oldCol = GREATEST(0, $oldCol - 1) WHERE id_article=?")->execute([$articleId]);
                
                $action = 'switched';
            } 
            else {
                // CAS 3 : C'est un nouveau vote -> ON AJOUTE
                $this->db->prepare("INSERT INTO article_votes (id_user, id_article, vote_type) VALUES (?, ?, ?)")->execute([$userId, $articleId, $type]);

                // Incrémentation
                $col = ($type === 'like') ? 'likes' : 'dislikes';
                $this->db->prepare("UPDATE articles SET $col = $col + 1 WHERE id_article=?")->execute([$articleId]);
                
                $action = 'added';
            }

            // CRUCIAL : On récupère les VRAIS totaux pour mettre à jour le JS
            $stmt = $this->db->prepare("SELECT likes, dislikes FROM articles WHERE id_article = ?");
            $stmt->execute([$articleId]);
            $newTotals = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->db->commit();
            
            // On renvoie tout au Javascript
            return ['status' => 'success', 'action' => $action, 'totals' => $newTotals];

        } catch (Exception $e) {
            $this->db->rollBack();
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}