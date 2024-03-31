<x-app-layout>
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('texts.my_favorites') }}
                </h2>

                @if ($favorites->isEmpty())
                    <p>{{ __('texts.no_favorites_added') }}</p>
                @else
                    <ul>
                        @foreach ($favorites as $favorite)
                            <li>{{ $favorite->title }} - <a href="{{ route('profile.removefavorite', $favorite->id) }}"
                                    onclick="event.preventDefault(); document.getElementById('remove-favorite-{{ $favorite->id }}-form').submit();">{{ __('texts.remove') }}</a>
                            </li>

                            <form id="remove-favorite-{{ $favorite->id }}-form"
                                action="{{ route('profile.removefavorite', $favorite->id) }}" method="POST"
                                style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        @endforeach
                    </ul>

                    {{ $favorites->links() }} {{-- Pagination links --}}
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
