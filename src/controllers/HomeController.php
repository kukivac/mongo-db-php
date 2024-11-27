<?php

declare(strict_types=1);

namespace App\Controllers;

class HomeController extends AbstractController
{
    public function index(): string
    {
        return "Welcome to the Pokedex!";
    }
}
