<?php

declare(strict_types=1);

namespace App\Helpers;

use MongoDB\Client;

class Router
{
    protected string $controller_namespace = "App\\Controllers\\";
    protected Client $mongo_client;
    protected array $routes = [];

    public function __construct(Client $mongo_client)
    {
        $this->mongo_client = $mongo_client;
    }

    public function addRoute(string $path, string $controller, string $method): void
    {
        $this->routes[$path] = [
            'controller' => $controller,
            'method' => $method,
        ];
    }

    public function handle(string $request_uri): string
    {
        $uri_parts = explode('?', $request_uri, 2);
        $path = trim($uri_parts[0], '/');
        $query_string = $uri_parts[1] ?? '';

        parse_str($query_string, $query_params);

        foreach ($this->routes as $route => $handler) {
            $pattern = preg_replace('#\{([a-zA-Z0-9_]+)\}#', '([^/]+)', $route);
            $pattern = "#^" . $pattern . "$#";

            if (preg_match($pattern, $path, $matches)) {
                array_shift($matches);

                $controller_class = $this->controller_namespace . $handler['controller'];
                $method = $handler['method'];

                if (class_exists($controller_class)) {
                    $controller = new $controller_class($this->mongo_client);
                    $controller->setQueryParams($query_params);

                    if (method_exists($controller, $method)) {
                        return $controller->$method(...$matches);
                    } else {
                        http_response_code(404);
                        return $this->renderError("Method '{$method}' not found in {$controller_class}.");
                    }
                } else {
                    http_response_code(404);
                    return $this->renderError("Controller '{$controller_class}' not found.");
                }
            }
        }

        http_response_code(404);
        return $this->renderError("Route '{$path}' not found.");
    }

    protected function renderError(string $message): string
    {
        return "<h1>404 Not Found</h1><p>{$message}</p>";
    }
}
