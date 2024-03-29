<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $advertentie->title }}</title>
    @vite('resources/css/app.css')
</head>
<body>
    @include('layouts.navbar')
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-bold mt-5">{{ $advertentie->title }}</h1>
        @if ($advertentie->image_path)
            <img src="{{ asset('storage/' . $advertentie->image_path) }}" alt="{{ $advertentie->title }}"
                class="max-w-full h-auto mt-4 rounded">
        @endif
        <p class="mt-4">Beschrijving: {{ $advertentie->description }}</p>
        <p>Prijs: €{{ $advertentie->price }}</p>
        <p>Type: {{ $advertentie->type }}</p>
        
        @if (auth()->user()->id !== $advertentie->user_id)
            @if ($advertentie->type === 'Verkoop')
            <div>
                @if ($advertentie->purchasers->count() > 0)
                    <span>Verkocht</span>
                @else
                    <form action="{{ route('advertisement.purchase', $advertentie->id) }}" method="POST">
                        @csrf
                        <button type="submit">Koop</button>
                    </form>
                @endif
            </div>
            @elseif ($advertentie->type === 'Verhuur')
                <div class="my-4">
                    <label for="start_date" class="block text-sm font-medium text-gray-700">Start datum</label>
                    <input type="date" id="start_date" name="start_date" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mt-4">Eind datum</label>
                    <input type="date" id="end_date" name="end_date" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Huren
                </button>
            @endif
            @if ($isFavorite)
            <form action="{{ route('profile.removefavorite', $advertentie->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit">Verwijderen van Favorieten</button>
            </form>
            @else
                <form action="{{ route('profile.addfavorite', $advertentie->id) }}" method="POST">
                    @csrf
                    <button type="submit">Toevoegen aan Favorieten</button>
                </form>
            @endif

        @endif

    </div>
    <div class="qr-code">
        {!! $qrCode !!}
    </div>
</body>
</html>
