<x-app-layout>
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Mijn Favorieten
                </h2>

                @if ($favorites->isEmpty())
                    <p>Je hebt nog geen favorieten toegevoegd.</p>
                @else
                    <ul>
                        @foreach ($favorites as $favorite)
                            <li>{{ $favorite->title }} - <a href="{{ route('profile.removefavorite', $favorite->id) }}" onclick="event.preventDefault(); document.getElementById('remove-favorite-{{ $favorite->id }}-form').submit();">Verwijderen</a></li>

                            <form id="remove-favorite-{{ $favorite->id }}-form" action="{{ route('profile.removefavorite', $favorite->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        @endforeach
                    </ul>

                    {{ $favorites->links() }} {{-- Paginatie links --}}
                @endif
            </div>
        </div>
    </div>
</x-app-layout>