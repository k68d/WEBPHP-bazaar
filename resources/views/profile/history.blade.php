<x-app-layout>
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Whoops!</strong>
                <span class="block sm:inline">Er zijn problemen met je input.</span>
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if($advertenties->isEmpty())
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mt-5">
                Je hebt nog niks gekocht of gehuurd.
            </div>
        @else
            @foreach ($advertenties as $advertentie)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-5">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-2">{{ $advertentie->title }}</h3>
                        <p class="mb-3">{{ $advertentie->description }}</p>
                        <p class="text-sm text-gray-600 mb-3">Gekocht of gehuurd op: {{ $advertentie->created_at->toFormattedDateString() }}</p>
                        
                        <!-- Product Review Formulier -->
                        @if ($advertentie->type === 'Verhuur')
                            <div class="mt-4">
                                <h4 class="font-semibold text-lg mb-2">Review dit Product</h4>
                                <form action="{{ route('product.reviews.store', $advertentie->id) }}" method="POST" class="mb-4">
                                    @csrf
                                    <textarea name="review" class="w-full rounded-md border-gray-300 shadow-sm" rows="3" placeholder="Jouw productreview..." required></textarea>
                                    <input type="number" name="rating" min="1" max="5" class="mt-2 w-full rounded-md border-gray-300 shadow-sm" placeholder="Productbeoordeling (1-5)" required>
                                    <button type="submit" class="mt-2 inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Review Product</button>
                                </form>
                            </div>
                        @endif

                        <!-- Adverteerder Review Formulier -->
                        <div class="mt-4">
                            <h4 class="font-semibold text-lg mb-2">Review de Adverteerder</h4>
                            <form action="{{ route('advertiser.reviews.store', $advertentie->user_id) }}" method="POST">
                                @csrf
                                <textarea name="review" class="w-full rounded-md border-gray-300 shadow-sm" rows="3" placeholder="Jouw ervaring met de adverteerder..." required></textarea>
                                <input type="number" name="rating" min="1" max="5" class="mt-2 w-full rounded-md border-gray-300 shadow-sm" placeholder="Adverteerderbeoordeling (1-5)" required>
                                <button type="submit" class="mt-2 inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">Review Adverteerder</button>
                            </form>
                        </div>
                        
                        @if ($advertentie->type === 'Verhuur' && $advertentie->renter_id == auth()->id())
                            @if ($advertentie->eind_huur && now()->lessThan($advertentie->eind_huur))
                                @if (empty($advertentie->return_photo_path))
                                    <form action="{{ route('advertisement.return', $advertentie->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="file" name="return_photo" required>
                                        <select name="wear_level" required>
                                            <option value="">Selecteer slijtage niveau...</option>
                                            <option value="Geen">Geen</option>
                                            <option value="Licht">Licht</option>
                                            <option value="Matig">Matig</option>
                                            <option value="Zwaar">Zwaar</option>
                                        </select>
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
                </div>
            @endforeach
        @endif
    </div>
</x-app-layout>


<!-- <x-app-layout>
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
            <form action="{{ route('advertiser.reviews.store', $advertiser->id) }}" method="POST">
        @csrf
        <textarea name="review" required placeholder="Schrijf een review..."></textarea>
        <input type="number" name="rating" min="1" max="5" required>
        <button type="submit">Review Plaatsen</button>
    </form>
        @endif
    </div>
</x-app-layout> -->
