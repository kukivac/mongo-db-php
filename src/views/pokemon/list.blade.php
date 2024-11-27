<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
</head>
<body>
<h1>{{ $title }}</h1>
<ul>
    @foreach ($pokemons as $pokemon)
        <li>{{ $pokemon['name']['english'] }}</li>
    @endforeach
</ul>
</body>
</html>
