<x-app-layout>
    <div class="max-w-4xl mx-auto py-10 px-6 bg-white shadow-md rounded-lg mt-4">
        @if ($errors->any())
            <div class="mb-5 p-4 bg-red-100 text-red-600 border border-red-400 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <h1 class="text-3xl font-bold mb-4 text-gray-800">{{ $advertentie->title }}</h1>

        @if ($advertentie->image_path)
            <img src="{{ asset_or_default('storage/' . $advertentie->image_path) }}" alt="{{ $advertentie->title }}"
                class="max-w-full h-auto rounded-lg mb-4">
        @endif

        <div class="text-lg space-y-2">
            <p><span class="font-semibold text-gray-900">{{ __('texts.description') }}:</span>
                {{ $advertentie->description }}</p>
            <p><span class="font-semibold text-gray-900">{{ __('texts.price') }}:</span>
                €{{ number_format($advertentie->price, 2, ',', '.') }}</p>
            <p><span class="font-semibold text-gray-900">{{ __('texts.type') }}:</span> {{ $advertentie->type }}</p>
            <p><span class="font-semibold text-gray-900">{{ __('texts.rental_wear_level') }}:</span>
                {{ $advertentie->wear_level ?? __('texts.not_specified') }}</p>
            @isset($qrCode)
                <div class="qr-code">
                    {!! $qrCode !!}
                </div>
            @endisset
        </div>

        <div class="mt-6 space-y-4">
            @if (auth()->user()->id !== $advertentie->user_id)
                @if ($advertentie->type === __('texts.sale'))
                    <div>
                        @if ($advertentie->purchasers->count() > 0)
                            <span
                                class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2">{{ __('texts.sold') }}</span>
                        @else
                            <form action="{{ route('advertisement.purchase', $advertentie->id) }}" method="POST"
                                class="inline">
                                @csrf
                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">{{ __('texts.buy') }}</button>
                            </form>
                        @endif
                    </div>
                @elseif ($advertentie->type === __('texts.rental'))
                    <form action="{{ route('advertisement.rent', $advertentie->id) }}" method="POST"
                        class="space-y-4">
                        @csrf
                        <div>
                            <label for="begin_huur"
                                class="block text-sm font-medium text-gray-700">{{ __('texts.start_rent') }}</label>
                            <input type="date" id="begin_huur" name="begin_huur" required
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label for="eind_huur"
                                class="block text-sm font-medium text-gray-700">{{ __('texts.end_rent') }}</label>
                            <input type="date" id="eind_huur" name="eind_huur" required
                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                        </div>
                        <button type="submit"
                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">{{ __('texts.rent') }}</button>
                    </form>
                @endif
            @endif



            <div class="flex gap-4">
                @if ($isFavorite)
                    <form action="{{ route('profile.removefavorite', $advertentie->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('texts.remove_from_favorites') }}
                        </button>
                    </form>
                @else
                    <form action="{{ route('profile.addfavorite', $advertentie->id) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">
                            {{ __('texts.add_to_favorites') }}
                        </button>
                    </form>
                @endif
                @if (auth()->user()->id === $advertentie->user_id)
                    <form action="{{ route('highlighted_ads.store', $advertentie->id) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('texts.highlight_ad') }}
                        </button>
                    </form>
                @endif
            </div>
        </div>
</x-app-layout>
