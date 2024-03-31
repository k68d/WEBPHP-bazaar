<x-app-layout>
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        @if ($advertenties->isEmpty())
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 bg-white border-b border-gray-200">
                {{ __('texts.no_purchases') }}
            </div>
        @else
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @foreach ($advertenties as $advertentie)
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-semibold">{{ $advertentie->title }}</h3>
                        <p>{{ $advertentie->description }}</p>
                        <p class="text-sm text-gray-600">{{ __('texts.purchased_on') }}
                            {{ $advertentie->created_at->toFormattedDateString() }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
