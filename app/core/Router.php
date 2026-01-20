<?php

namespace Core;

class Router
{
    private array $routes = [];

    public function addRoute(string $method, string $path, string $controller, string $action): void
    {
        $this->routes[$method][$path] = ['controller' => $controller, 'action' => $action];
    }

    public function dispatch(string $method, string $uri): void
    {
        $path = parse_url($uri, PHP_URL_PATH);
        $path = trim($path, '/');

        if (isset($this->routes[$method][$path])) {
            $route = $this->routes[$method][$path];
            $controllerName = $route['controller'];
            $action = $route['action'];

            $controllerClass = "Controllers\\$controllerName";
            if (class_exists($controllerClass)) {
                $controller = new $controllerClass();
                if (method_exists($controller, $action)) {
                    $controller->$action();
                } else {
                    $this->notFound();
                }
            } else {
                $this->notFound();
            }
        } else {
            $this->notFound();
        }
    }

    private function notFound(): void
    {
        http_response_code(404);
        echo "<!DOCTYPE html>
            <html lang='fr'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>404 - Page non trouvée</title>
                <style>
                    body { font-family: Arial, sans-serif; text-align: center; padding: 50px; }
                    h1 { color: #d9534f; }
                    a { color: #337ab7; text-decoration: none; }
                </style>
            </head>
            <body>
                <h1>404 - Page non trouvée</h1>
                <p>Désolé, la page que vous cherchez n'existe pas.</p>
                <a href='" . BASE_URL . "'>Retour à l'accueil</a>
            </body>
        </html>";
    }
}
