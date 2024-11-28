<h1>Pokémon List</h1>
<ul>
    @foreach ($pokemons as $pokemon)
        <li>
            <a href="/pokemons/{{ $pokemon['id'] }}">
                {{ $pokemon['name']['english'] }}
            </a>
        </li>
    @endforeach
</ul>