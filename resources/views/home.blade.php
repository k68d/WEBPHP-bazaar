<x-app-layout>
    <div class="container mx-auto mt-5 px-4">
        <div class="flex flex-col justify-center items-center h-auto">
            <img src="/storage/afbeeldingen/V2lVayS4YquI6M59DjI6IMVOOcedHWSsJa5B6o7q.png" class="max-w-xs md:max-w-sm lg:max-w-md xl:max-w-lg mx-auto mb-4">
            <h1 class="text-xl md:text-3xl lg:text-4xl font-bold text-gray-400 text-center">{{ __('texts.welcome') }}</h1>
        </div>
        <h2 class="text-center text-2xl font-semibold my-6 text-gray-200">{{ __('texts.recent_ads') }}</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach ($advertenties as $advertentie)
                <div class="overflow-hidden shadow-lg rounded-lg h-full flex flex-col">
                    <img src="{{ asset_or_default('storage/' . $advertentie->image_path) }}" alt="{{ $advertentie->title }}" class="w-full h-48 object-cover object-center">
                    <div class="p-4 bg-white flex flex-col flex-grow">
                        <h5 class="text-lg font-bold mb-2">{{ $advertentie->title }}</h5>
                        <p class="text-gray-700 text-base mb-4 flex-grow">{{ Str::limit($advertentie->description, 100) }}</p>
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-sm font-semibold text-gray-900">{{ __('texts.price') }} €{{ $advertentie->price }}</span>
                            <a href="{{ route('advertenties.show', $advertentie) }}" class="text-xs bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">{{ __('texts.view') }}</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
