<?php

declare(strict_types=1);

namespace App\Controllers;

class PokemonController extends AbstractController
{
    /**
     * @param array $query_params
     * @return string
     */
    public function index(array $query_params = []): string
    {
        $data = [
            'title' => 'Pokémon List',
            'message'=>'hello world'
        ];

        return $this->render('index', $data);
    }

    /**
     * @param array $query_params
     * @return string
     */
    public function list(array $query_params = []): string
    {
        $collection = $this->mongo_client->pokedex->pokemons;
        $pokemons = $collection->find()->toArray();

        $data = [
            'title' => 'Pokémon List',
            'pokemons' => json_decode(json_encode($pokemons),true),
        ];

        return $this->render('list', $data);
    }
}
