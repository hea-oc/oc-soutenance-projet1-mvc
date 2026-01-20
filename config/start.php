<?php

ini_set('session.cookie_httponly', 1); // Empêche l'accès au cookie via JavaScript
ini_set('session.cookie_samesite', 'Lax'); // Protège contre les attaques CSRF
ini_set('session.use_only_cookies', 1); // N'autorise pas l'utilisation de l'ID de session dans l'URL
ini_set('session.gc_maxlifetime', 3600); // 1 heure de durée de vie de la session

session_start();

error_reporting(E_ALL); // Signaler toutes les erreurs
ini_set('display_errors', 0); // Ne pas afficher les erreurs à l'utilisateur final
ini_set('log_errors', 1); // Activer la journalisation des erreurs
ini_set('error_log', __DIR__ . '/../logs/php_errors.log'); // Fichier de log des erreurs

spl_autoload_register(function ($class) {
    $path = str_replace('\\', '/', $class); // Convertit les backslashes en slashes
    $baseDir = __DIR__ . '/../'; // Répertoire de base de l'application
    // Map des namespaces aux répertoires
    $namespaceMap = [
        'Controllers' => 'app/controllers/',
        'Models' => 'app/models/',
        'Core' => 'app/core/',
        'Config' => 'config/',
    ];

    $file = null;
    foreach ($namespaceMap as $namespace => $dir) {
        if (strpos($path, $namespace) === 0) {
            $relativePath = str_replace($namespace . '/', '', $path);
            $file = $baseDir . $dir . $relativePath . '.php';
            break;
        }
    }

    if ($file && file_exists($file)) {
        require $file;
    }
});
