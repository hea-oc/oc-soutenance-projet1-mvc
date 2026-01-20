<?php

require '../config/start.php';

use Core\Router;

$router = new Router();

// Home routes
$router->addRoute('GET', '', 'HomeController', 'index');

// Auth routes
$router->addRoute('GET', 'login', 'AuthController', 'login');
$router->addRoute('POST', 'login', 'AuthController', 'login');
$router->addRoute('GET', 'register', 'AuthController', 'register');
$router->addRoute('POST', 'register', 'AuthController', 'register');
$router->addRoute('GET', 'logout', 'AuthController', 'logout');

// Book routes
$router->addRoute('GET', 'books', 'BookController', 'index');
$router->addRoute('GET', 'books/show', 'BookController', 'show');
$router->addRoute('GET', 'books/create', 'BookController', 'create');
$router->addRoute('POST', 'books/create', 'BookController', 'create');
$router->addRoute('GET', 'books/edit', 'BookController', 'edit');
$router->addRoute('POST', 'books/edit', 'BookController', 'edit');
$router->addRoute('GET', 'my-books', 'BookController', 'myBooks');
$router->addRoute('GET', 'books/search', 'BookController', 'search');
$router->addRoute('GET', 'books/delete', 'BookController', 'delete');
$router->addRoute('GET', 'books/toggle-status', 'BookController', 'toggleStatus');

// Profile routes
$router->addRoute('GET', 'profil', 'ProfilController', 'index');
$router->addRoute('GET', 'profil/edit', 'ProfilController', 'edit');
$router->addRoute('POST', 'profil/edit', 'ProfilController', 'edit');
$router->addRoute('GET', 'user', 'ProfilController', 'publicProfile');

// Message routes
$router->addRoute('GET', 'messages', 'MessageController', 'index');
$router->addRoute('GET', 'messages/conversation', 'MessageController', 'conversation');
$router->addRoute('POST', 'messages/send', 'MessageController', 'send');
$router->addRoute('GET', 'messages/delete', 'MessageController', 'delete');
$router->addRoute('GET', 'messages/poll', 'MessageController', 'poll');
$router->addRoute('POST', 'messages/save-preference', 'MessageController', 'savePreference');

// Détermination de l'URI demandée
$requestUri = $_SERVER['REQUEST_URI']; 
$scriptName = $_SERVER['SCRIPT_NAME'];

// Calcule du BASE_URL
// Extrait le chemin de base en supprimant '/public/index.php' du script name
$baseUri = str_replace('/public/index.php', '', $scriptName);
define('BASE_URL', $baseUri); // Définit la constante BASE_URL
$uri = str_replace($baseUri, '', $requestUri); 
// Nettoie l'URI en supprimant les paramètres de requête
$uri = trim($uri, '/');
// Dispatche la requête
$router->dispatch($_SERVER['REQUEST_METHOD'], $uri);
