<?php

declare(strict_types=1);

namespace App\Controllers;

class PokemonController extends AbstractController
{
    public function index(): string
    {
        return "Welcome to the Pokémon API!";
    }

    public function list(): string
    {
        $collection = $this->mongo_client->pokedex->pokemon;
        $pokemons = $collection->find()->toArray();

        return json_encode($pokemons, JSON_PRETTY_PRINT);
    }
}
