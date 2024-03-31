<x-app-layout>
<div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
    @if($advertenties->isEmpty())
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 bg-white border-b border-gray-200">
            Je hebt nog niks gekocht of gehuurd.
        </div>
    @else
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        @foreach ($advertenties as $advertentie)
            <div class="p-6 bg-white border-b border-gray-200">
                <h3 class="text-lg font-semibold">{{ $advertentie->title }}</h3>
                <p>{{ $advertentie->description }}</p>
                <p class="text-sm text-gray-600">Gekocht of gehuurd op: {{ $advertentie->created_at->toFormattedDateString() }}</p>
                
                {{-- Review Formulier voor Verhuur Advertenties --}}
                @if ($advertentie->type === 'Verhuur')
                    <form action="{{ route('product.reviews.store', $advertentie->id) }}" method="POST">
                        @csrf
                        <textarea name="review" required></textarea>
                        <input type="number" name="rating" min="1" max="5" required>
                        <button type="submit">Plaats Review</button>
                    </form>
                @endif
                @if ($advertentie->type === 'Verhuur' && $advertentie->renter_id == auth()->id())
                    @if ($advertentie->eind_huur && now()->lessThan($advertentie->eind_huur))
                        @if (empty($advertentie->return_photo_path))
                            {{-- Foto upload formulier --}}
                            <form action="{{ route('advertisement.return', $advertentie->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="return_photo" required>
                                <button type="submit">Foto Uploaden</button>
                            </form>
                        @else
                            <p>Foto succesvol geüpload. Product kan nu worden teruggebracht.</p>
                            <form action="{{ route('advertisement.return', $advertentie->id) }}" method="POST">
                                @csrf
                                <button type="submit">Terugbrengen</button>
                            </form>
                        @endif
                    @else
                        <span>Huurperiode verlopen</span>
                    @endif
                @endif
            </div>
        @endforeach
    </div>
    @endif
</div>

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
