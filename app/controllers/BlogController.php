<?php
require_once __DIR__ . '/../models/BlogModel.php';

class BlogController {
    private $blogModel;

    public function __construct() {
        $this->blogModel = new BlogModel();
    }

    public function index() {
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $this->showArticle($_GET['id']);
        } else {
            $this->listArticles();
        }
    }

    // Méthode pour l'appel AJAX (Vote)
    public function rate() {
        header('Content-Type: application/json');

        if (!isset($_SESSION['user']['id_user'])) {
            echo json_encode(['status' => 'error', 'message' => 'Connectez-vous pour voter !']);
            exit;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        
        if (isset($data['id'], $data['type'])) {
            $userId = $_SESSION['user']['id_user'];
            
            // Appel de la méthode TOGGLE
            $result = $this->blogModel->toggleVote($userId, $data['id'], $data['type']);
            
            echo json_encode($result);
        }
        exit;
    }

    private function listArticles() {
        $articles = $this->blogModel->getAllArticles();
        ob_start();
        require __DIR__ . '/../views/blog.php';
        $content = ob_get_clean();
        require __DIR__ . '/../views/layout/header.php';
        echo $content;
        require __DIR__ . '/../views/layout/footer.php';
    }

    private function showArticle($id) {
        $article = $this->blogModel->getArticleById($id);
        
        // On récupère le vote de l'utilisateur s'il est connecté
        $userVote = null;
        if (isset($_SESSION['user']['id_user'])) {
            $userVote = $this->blogModel->getUserVote($_SESSION['user']['id_user'], $id);
        }

        if (!$article) {
            header('Location: index.php?page=blog');
            exit;
        }

        ob_start(); # temporisation de sortie
        require __DIR__ . '/../views/article_detail.php';
        $content = ob_get_clean(); # stocke le code hmtl de la vue
        require __DIR__ . '/../views/layout/header.php';
        echo $content;
        require __DIR__ . '/../views/layout/footer.php';
    }
}