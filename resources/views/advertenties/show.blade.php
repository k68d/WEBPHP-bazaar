<x-app-layout>
    <div class="max-w-4xl mx-auto py-10 px-6 bg-white shadow-md rounded-lg">
        @if ($errors->any())
            <div class="mb-5 p-4 bg-red-100 text-red-600 border border-red-400 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <h1 class="text-3xl font-bold mb-4">{{ $advertentie->title }}</h1>

        @if ($advertentie->image_path)
            <img src="{{ asset('storage/' . $advertentie->image_path) }}" alt="{{ $advertentie->title }}" class="max-w-full h-auto rounded-lg mb-4">
        @endif

        <div class="text-lg space-y-2">
            <p class="text-gray-700">Beschrijving: {{ $advertentie->description }}</p>
            <p class="text-gray-700">Prijs: €{{ number_format($advertentie->price, 2, ',', '.') }}</p>
            <p class="text-gray-700">Type: {{ $advertentie->type }}</p>
            <p class="text-gray-700">Slijtageniveau: {{ $advertentie->wear_level ?? 'Niet gespecificeerd' }}</p>
            {!! $qrCode !!}
        </div>

        <div class="mt-6 space-y-4">
            @if (auth()->user()->id !== $advertentie->user_id)
                @if ($advertentie->type === 'Verkoop')
                    <div>
                        @if ($advertentie->purchasers->count() > 0)
                            <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2">Verkocht</span>
                        @else
                            <form action="{{ route('advertisement.purchase', $advertentie->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Koop</button>
                            </form>
                        @endif
                    </div>
                @elseif ($advertentie->type === 'Verhuur')
                    @if (!$advertentie->begin_huur || !$advertentie->eind_huur || now()->gt($advertentie->eind_huur))
                        <form action="{{ route('advertisement.rent', $advertentie->id) }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label for="begin_huur" class="block text-sm font-medium text-gray-700">Begin Huur</label>
                                <input type="date" id="begin_huur" name="begin_huur" required class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                            <div>
                                <label for="eind_huur" class="block text-sm font-medium text-gray-700">Eind Huur</label>
                                <input type="date" id="eind_huur" name="eind_huur" required class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Huur</button>
                        </form>
                    @else
                        <p class="text-sm text-gray-600">Deze advertentie is momenteel gehuurd en zal beschikbaar zijn na {{ \Carbon\Carbon::parse($advertentie->eind_huur)->format('d-m-Y') }}.</p>
                    @endif
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

            @if(auth()->user()->id === $advertentie->user_id && auth()->user()->role_id === 2)
                @if($isHighlighted)
                    <form action="{{ route('highlighted_ads.remove', $advertentie->id) }}" method="POST" class="mt-4">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            Verwijder Highlight
                        </button>
                    </form>
                @else
                    <form action="{{ route('highlighted_ads.store', $advertentie->id) }}" method="POST" class="mt-4">
                        @csrf
                        <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">
                            Highlight Advertentie
                        </button>
                    </form>
                @endif
            @endif

            @if ($linkedAd !== null)
                    
                    <div class="mt-10 border-t pt-6">
                        <h3 class="text-xl font-semibold mb-2">Gerelateerde Producten</h3>
                        <div class="flex items-center space-x-4">
                            @if ($linkedAd->image_path)
                                <img src="{{ asset('storage/' . $linkedAd->image_path) }}" alt="{{ $linkedAd->title }}" class="w-20 h-20 object-cover rounded-lg">
                            @endif
                            <div>
                                <h4 class="text-lg font-semibold">{{ $linkedAd->title }}</h4>
                                <p class="text-sm text-gray-600">€{{ number_format($linkedAd->price, 2, ',', '.') }}</p>
                                <a href="{{ route('advertenties.show', $linkedAd->id) }}" class="text-blue-500 hover:text-blue-700 font-medium">Bekijk Advertentie</a>
                            </div>
                        </div>
                    </div>
                @endif
        </div>
    </div>
</x-app-layout>
