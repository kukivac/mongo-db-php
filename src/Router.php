<?php

declare(strict_types=1);

namespace App;

use MongoDB\Client;

class Router
{
    protected string $controller_namespace = "App\\Controllers\\";

    protected Client $mongo_client;

    public function __construct(Client $mongo_client)
    {
        $this->mongo_client = $mongo_client;
    }

    public function handle(string $request_uri): string
    {
        // Parse the request URI
        $request_uri = trim($request_uri, '/');
        $request_parts = explode('/', $request_uri);

        // Determine controller and action
        $request_part_1 = $request_parts[0];
        if ($request_part_1 === '' || $request_part_1 === '/' || $request_part_1 === null) {
            $request_part_1 = 'Home';
        }
        $controller_name = ucfirst($request_part_1) . 'Controller';
        $action = $request_parts[1] ?? 'index';

        $controller_class = $this->controller_namespace . $controller_name;

        // Attempt to invoke the controller and action
        if (class_exists($controller_class)) {
            $controller = new $controller_class($this->mongo_client);
            if (method_exists($controller, $action)) {
                return $controller->$action();
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
