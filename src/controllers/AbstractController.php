<?php

declare(strict_types=1);

namespace App\Controllers;

use MongoDB\Client;
use App\Helpers\View;

abstract class AbstractController
{
    protected Client $mongo_client;
    protected View $view;

    public function __construct(Client $mongo_client)
    {
        $this->mongo_client = $mongo_client;
        $this->view = new View();
    }

    protected function render(string $view, array $data = []): string
    {
        // Determine the controller name dynamically
        $controller_name = strtolower(str_replace('Controller', '', (new \ReflectionClass($this))->getShortName()));

        // Construct the view path
        $view_path = "{$controller_name}/{$view}";

        return $this->view->render($view_path, $data);
    }
}
