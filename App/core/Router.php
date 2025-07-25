<?php

namespace App\Core;

class Router
{
    public static function resolve(array $routes)
    {
        $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        
        if (array_key_exists($uri, $routes)) {
            $route = $routes[$uri];
            
            
            if (isset($route['middleware']) && is_array($route['middleware'])) {
                self::runMiddlewares($route['middleware']);
            }
            
            // Exécuter le contrôleur
            $controller = $route['controller'];
            $action = $route['action'];
            
            if (class_exists($controller)) {
                $controllerInstance = new $controller();
                if (method_exists($controllerInstance, $action)) {
                    $controllerInstance->$action();
                } else {
                    throw new \Exception("Action {$action} not found in {$controller}");
                }
            } else {
                throw new \Exception("Controller {$controller} not found");
            }
        } else {
            http_response_code(404);
            echo "Page not found";
        }
    }
    
    private static function runMiddlewares(array $middlewares)
    {
        $middlewareConfig = require __DIR__ . '/../config/middlewares.php';
        
        foreach ($middlewares as $middlewareName) {
            if (isset($middlewareConfig[$middlewareName])) {
                $middlewareClass = $middlewareConfig[$middlewareName];
                $middleware = new $middlewareClass();
                $middleware();
            }
        }
    }
}