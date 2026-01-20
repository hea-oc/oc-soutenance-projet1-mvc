<?php

namespace Controllers;

use Core\Controller;
use Models\User;

class AuthController extends Controller
{
    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // tentatives de connexion limitées
            $now = time();
            if (!isset($_SESSION['login_attempts'])) {
                $_SESSION['login_attempts'] = 0;
                $_SESSION['last_attempt'] = $now;
            }

            if ($_SESSION['login_attempts'] >= 5) {
                $timeSinceLastAttempt = $now - $_SESSION['last_attempt'];

                // Si moins de 15 minutes se sont écoulées, bloquer
                if ($timeSinceLastAttempt < 900) {
                    $secondsRemaining = 900 - $timeSinceLastAttempt;
                    $minutes = floor($secondsRemaining / 60);
                    $seconds = $secondsRemaining % 60;
                    $this->render('auth/login', ['error' => "Trop de tentatives. Réessayez dans {$minutes}m {$seconds}s."]);
                    return;
                } else {
                    // Réinitialiser après 15 minutes
                    $_SESSION['login_attempts'] = 0;
                    $_SESSION['last_attempt'] = $now;
                }
            }
            // Vérification du token CSRF
            if (!$this->verifyCsrfToken()) {
                $this->render('auth/login', ['error' => 'Token de sécurité invalide']);
                return;
            }
            // Récupération et validation des données
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                $this->render('auth/login', ['error' => 'Email et mot de passe requis']);
                return;
            }
            // Authentification de l'utilisateur
            $userModel = new User();
            $user = $userModel->findByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                unset($_SESSION['login_attempts'], $_SESSION['last_attempt']);
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_pseudo'] = $user['pseudo'];
                $this->redirect(BASE_URL . '/profil');
            } else {
                $_SESSION['login_attempts']++;
                $_SESSION['last_attempt'] = $now;
                $this->render('auth/login', ['error' => 'Identifiants invalides']);
            }
        } else {
            $this->render('auth/login');
        }
    }

    public function register(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!$this->verifyCsrfToken()) {
                $this->render('auth/register', ['error' => 'Token de sécurité invalide']);
                return;
            }

            $data = [
                'firstname' => trim($_POST['firstname'] ?? ''),
                'lastname' => trim($_POST['lastname'] ?? ''),
                'pseudo' => trim($_POST['pseudo'] ?? ''),
                'email' => trim($_POST['email'] ?? ''),
                'password' => $_POST['password'] ?? ''
            ];

            // Validation des champs obligatoires
            if (empty($data['firstname']) || empty($data['lastname']) || empty($data['pseudo']) || empty($data['email']) || empty($data['password'])) {
                $this->render('auth/register', ['error' => 'Tous les champs sont requis']);
                return;
            }

            // Validation pseudo
            if (strlen($data['pseudo']) < 4) {
                $this->render('auth/register', ['error' => 'Le pseudo doit contenir au moins 4 caractères']);
                return;
            }

            if (strlen($data['pseudo']) > 50) {
                $this->render('auth/register', ['error' => 'Le pseudo ne doit pas dépasser 50 caractères']);
                return;
            }

            // Validation email
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $this->render('auth/register', ['error' => 'Format d\'email invalide']);
                return;
            }

            // Validation mot de passe
            if (strlen($data['password']) < 8) {
                $this->render('auth/register', ['error' => 'Le mot de passe doit contenir au moins 8 caractères']);
                return;
            }

            // Validation noms (longueur raisonnable)
            if (strlen($data['firstname']) > 50 || strlen($data['lastname']) > 50) {
                $this->render('auth/register', ['error' => 'Les noms ne doivent pas dépasser 50 caractères']);
                return;
            }

            $userModel = new User();
            if ($userModel->findByEmail($data['email'])) {
                $this->render('auth/register', ['error' => 'Cet email est déjà utilisé']);
                return;
            }

            // Vérifier si le pseudo existe déjà
            if ($userModel->findByPseudo($data['pseudo'])) {
                $this->render('auth/register', ['error' => 'Ce pseudo est déjà utilisé']);
                return;
            }

            if ($userModel->create($data)) {
                $this->redirect(BASE_URL . '/login');
            } else {
                $this->render('auth/register', ['error' => 'Erreur lors de l\'inscription']);
            }
        } else {
            $this->render('auth/register');
        }
    }

    public function logout(): void
    {
        $_SESSION = [];
        session_destroy();
        $this->redirect(BASE_URL . '/');
    }
}
