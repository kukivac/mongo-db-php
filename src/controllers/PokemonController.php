<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Pokemon;

class PokemonController extends AbstractController
{
    public function index(): string
    {
        $query_params = $this->getQueryParams();

        return $this->render('pokemon.index', ['query' => $query_params]);
    }

    /**
     * @return string
     */
    public function list(): string
    {
        $query_params = $this->getQueryParams();
        $collection = $this->mongo_client->pokedex->pokemons;
        $pokemons = $collection->find()->toArray();

        $data = [
            'title' => 'Pokémon List',
            'pokemons' => json_decode(json_encode($pokemons), true),
            'query' => $query_params,
        ];

        return $this->render('pokemon.list', $data);
    }

    public function details(string $id): string
    {
        $pokemon_model = new Pokemon($this->mongo_client);
        $pokemon = $pokemon_model->findById((int)$id);

        if (!$pokemon) {
            http_response_code(404);

            return $this->render('error', ['message' => "Pokémon with ID {$id} not found."]);
        }

        return $this->render('pokemon.details', ['pokemon' => $pokemon]);
    }
}
