<?php

declare(strict_types=1);

namespace App\Controllers;

class HomeController extends AbstractController
{
    public function index(): string
    {
        $data = [
            'title' => 'Welcome to the Pokedex!',
            'message' => 'Explore the world of Pokémon.',
        ];

        return $this->render('index', $data);
    }
}
