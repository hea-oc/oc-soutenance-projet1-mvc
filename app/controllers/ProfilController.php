<?php

namespace Controllers;

use Core\Controller;
use Models\User;

class ProfilController extends Controller
{
    public function index(): void
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect(BASE_URL . '/login');
        }

        $userModel = new User();
        $user = $userModel->findById($_SESSION['user_id']);

        // Récupérer les livres de l'utilisateur
        $bookModel = new \Models\Book();
        $books = $bookModel->getByUserId($_SESSION['user_id']);

        $this->render('profil/index', [
            'user' => $user,
            'books' => $books,
            'csrf_token' => $this->generateCsrfToken()
        ]);
    }

    public function edit(): void
    {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect(BASE_URL . '/login');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->verifyCsrfToken()) {
                $_SESSION['error'] = 'Jeton CSRF invalide';
                $this->redirect(BASE_URL . '/profil');
                return;
            }

            $userModel = new User();
            $email = trim($_POST['email'] ?? '');
            $pseudo = trim($_POST['pseudo'] ?? '');
            $password = trim($_POST['password'] ?? '');

            // Validation
            if (empty($email) || empty($pseudo)) {
                $_SESSION['error'] = 'Email et pseudo sont requis';
                $this->redirect(BASE_URL . '/profil');
                return;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = 'Email invalide';
                $this->redirect(BASE_URL . '/profil');
                return;
            }

            if (strlen($pseudo) < 3) {
                $_SESSION['error'] = 'Le pseudo doit contenir au moins 3 caractères';
                $this->redirect(BASE_URL . '/profil');
                return;
            }

            // Vérifier si l'email existe déjà
            $existingUser = $userModel->findByEmail($email);
            if ($existingUser && $existingUser['id'] != $_SESSION['user_id']) {
                $_SESSION['error'] = 'Cet email est déjà utilisé';
                $this->redirect(BASE_URL . '/profil');
                return;
            }

            // Vérifier si le pseudo existe déjà
            $existingUser = $userModel->findByPseudo($pseudo);
            if ($existingUser && $existingUser['id'] != $_SESSION['user_id']) {
                $_SESSION['error'] = 'Ce pseudo est déjà utilisé';
                $this->redirect(BASE_URL . '/profil');
                return;
            }

            // Préparer les données à mettre à jour
            $data = [
                'email' => $email,
                'pseudo' => $pseudo
            ];

            // Si un nouveau mot de passe est fourni
            if (!empty($password)) {
                if (strlen($password) < 6) {
                    $_SESSION['error'] = 'Le mot de passe doit contenir au moins 6 caractères';
                    $this->redirect(BASE_URL . '/profil');
                    return;
                }
                $data['password'] = password_hash($password, PASSWORD_DEFAULT);
            }

            // Mettre à jour les informations de base
            if (!$userModel->updateUser($_SESSION['user_id'], $data)) {
                $_SESSION['error'] = 'Erreur lors de la mise à jour';
                $this->redirect(BASE_URL . '/profil');
                return;
            }

            // Gestion de l'avatar
            if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
                $userUploadDir = __DIR__ . '/../../public/storage/uploads/' . $_SESSION['user_id'] . '/';
                $uploadDir = $userUploadDir . 'avatars/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                $fileType = $_FILES['avatar']['type'];
                $fileSize = $_FILES['avatar']['size'];

                if (!in_array($fileType, $allowedTypes)) {
                    $_SESSION['error'] = 'Format d\'image non supporté';
                    $this->redirect(BASE_URL . '/profil');
                    return;
                }

                // 2MB max
                if ($fileSize > 2 * 1024 * 1024) {
                    $_SESSION['error'] = 'Image trop grande (max 2MB)';
                    $this->redirect(BASE_URL . '/profil');
                    return;
                }

                $extension = strtolower(pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION));
                $filename = 'avatar_' . $_SESSION['user_id'] . '_' . time() . '.' . $extension;
                $uploadFile = $uploadDir . $filename;

                if (move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile)) {
                    $avatarPath = 'storage/uploads/' . $_SESSION['user_id'] . '/avatars/' . $filename;
                    $userModel->updateAvatar($_SESSION['user_id'], $avatarPath);
                }
            }

            $_SESSION['user_pseudo'] = $pseudo;
            $_SESSION['success'] = 'Profil mis à jour avec succès';
            $this->redirect(BASE_URL . '/profil');
        } else {
            $userModel = new User();
            $user = $userModel->findById($_SESSION['user_id']);
            $this->render('profil/edit', ['user' => $user, 'csrf_token' => $this->generateCsrfToken()]);
        }
    }
    
    // profil public d'un utilisateur
    public function publicProfile(): void
    {
        $userId = $_GET['id'] ?? null;
        if (!$userId) {
            $this->redirect(BASE_URL . '/books');
        }

        $userModel = new User();
        $user = $userModel->findById((int)$userId);

        if (!$user) {
            $this->redirect(BASE_URL . '/books');
        }

        // Récupérer les livres de l'utilisateur
        $bookModel = new \Models\Book();
        $books = $bookModel->getByUserId((int)$userId);

        $this->render('profil/public', [
            'user' => $user,
            'books' => $books,
            'isOwnProfile' => isset($_SESSION['user_id']) && $_SESSION['user_id'] == $userId
        ]);
    }
}
