<?php

declare(strict_types=1);

namespace App\Controllers;

use MongoDB\Client;

abstract class AbstractController
{
    protected Client $mongo_client;

    public function __construct(Client $mongo_client)
    {
        $this->mongo_client = $mongo_client;
    }
}
