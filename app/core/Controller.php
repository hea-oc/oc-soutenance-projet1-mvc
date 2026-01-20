<?php

namespace Core;

class Controller
{
    // Génération et vérification des jetons CSRF
    protected function generateCsrfToken(): string
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // 64 caractères hexadécimaux randomisés
        }
        return $_SESSION['csrf_token']; // Retourne le jeton CSRF
    }

    protected function verifyCsrfToken(): bool
    {
        $token = $_POST['csrf_token'] ?? '';
        return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
    }

    // Rendu des vues et redirections
    protected function render(string $view, array $data = []): void
    {
        // Ajout du jeton CSRF aux données de la vue
        $data['csrf_token'] = $this->generateCsrfToken();
        extract($data); // Extrait les variables pour la vue
        ob_start(); // Attendre le rendu de la vue
        require __DIR__ . '/../views/' . $view . '.php'; // Inclure la vue
        $content = ob_get_clean(); // Récupérer le contenu rendu
        require __DIR__ . '/../views/layout.php'; // inclure la mise en page principale
    }

    protected function redirect(string $url): void
    {
        header("Location: $url"); // Redirection HTTP
        exit;
    }
}
