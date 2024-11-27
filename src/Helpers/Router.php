<?php

declare(strict_types=1);

namespace App\Helpers;

use MongoDB\Client;

class Router
{
    /** @var string */
    protected string $controller_namespace = "App\\Controllers\\";

    /** @var Client */
    protected Client $mongo_client;

    /**
     * @param Client $mongo_client
     */
    public function __construct(Client $mongo_client)
    {
        $this->mongo_client = $mongo_client;
    }

    /**
     * @param string $request_uri
     * @return string
     */
    public function handle(string $request_uri): string
    {
        // Separate URI path and query string
        $uri_parts = explode('?', $request_uri, 2);
        $path = trim($uri_parts[0], '/');
        $query_string = $uri_parts[1] ?? '';

        // Parse query string into $_GET-like array
        parse_str($query_string, $query_params);

        // Extract controller and action from URI path
        $segments = explode('/', $path);
        $controller_name = $segments[0];
        if ($controller_name === '' || $controller_name === '/' || $controller_name === null) {
            $controller_name = 'Home';
        }
        $controller_name = ucfirst($controller_name) . 'Controller';
        $action = $segments[1] ?? 'index';

        $controller_class = $this->controller_namespace . $controller_name;

        // Check if controller and action exist
        if (class_exists($controller_class)) {
            $controller = new $controller_class($this->mongo_client);

            if (method_exists($controller, $action)) {
                return $controller->$action($query_params);
            } else {
                http_response_code(404);

                return "Action '{$action}' not found in {$controller_class}.";
            }
        } else {
            http_response_code(404);

            return "Controller '{$controller_class}' not found.";
        }
    }
}
