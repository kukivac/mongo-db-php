<?php

declare(strict_types=1);

namespace App\Controllers;

class HomeController extends AbstractController
{
    public function index(): string
    {
        $query_params = $this->getQueryParams();

        $data = [
            'title' => 'Welcome to the Pokedex!',
            'message' => 'Explore the world of Pokémon.',
        ];

        return $this->render('home.index', $data);
    }
}
