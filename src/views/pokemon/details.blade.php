<h1>{{ $pokemon['name']['english'] }}</h1>
<p><strong>Type:</strong> {{ implode(', ', $pokemon['type']) }}</p>
<p><strong>Description:</strong> {{ $pokemon['description'] }}</p>
<img src="{{ $pokemon['image']['hires'] }}" alt="{{ $pokemon['name']['english'] }}">
