<x-app-layout>
    <h1>{{ __('texts.ads') }}</h1>
    <div class="container mx-auto mb-4">
        <div class="flex flex-wrap -mx-3">
            <div class="w-full px-3">
                <form action="{{ route('advertenties.index') }}" method="GET" class="flex items-center space-x-4">
                    <input type="text" class="form-input px-4 py-3 rounded" name="filter_titel"
                        placeholder="{{ __('texts.filter_by_title') }}" value="{{ request('filter_titel') }}">
                    <select class="form-select px-4 py-3 rounded" name="sorteer" style="min-width: 170px;">
                        <option value="titel_asc" {{ request('sorteer') == 'titel_asc' ? 'selected' : '' }}>
                            {{ __('texts.title_asc') }}</option>
                        <option value="titel_desc" {{ request('sorteer') == 'titel_desc' ? 'selected' : '' }}>
                            {{ __('texts.title_desc') }}</option>
                        <option value="prijs_laag" {{ request('sorteer') == 'prijs_laag' ? 'selected' : '' }}>
                            {{ __('texts.price_low_high') }}</option>
                        <option value="prijs_hoog" {{ request('sorteer') == 'prijs_hoog' ? 'selected' : '' }}>
                            {{ __('texts.price_high_low') }}</option>
                    </select>
                    <button type="submit"
                        class="btn bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        {{ __('texts.apply') }}
                    </button>
                </form>
            </div>
        </div>
        <div class="mt-6 px-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @forelse ($advertenties as $advertentie)
                    <div class="border border-gray-200 rounded-lg shadow-lg bg-white">
                        <img src="{{ asset_or_default('storage/' . $advertentie->image_path) }}"
                            alt="{{ __('texts.title') }}" class="object-cover w-full h-48 rounded-t-lg">
                        <div class="p-4 bg-gray-50">
                            <h5 class="text-lg font-bold text-gray-900">{{ $advertentie->title }}</h5>
                            <p class="text-gray-800 mt-2">{{ Str::limit($advertentie->description, 100) }}</p>
                            <p class="text-gray-600 mt-2">{{ $advertentie->type }}</p>
                            <div class="flex justify-between items-center mt-4">
                                <div>
                                    <a href="{{ route('advertenties.show', $advertentie) }}"
                                        class="text-blue-600 hover:text-blue-700">{{ __('texts.view') }}</a> TODO
                                    <a href="{{ route('advertenties.edit', $advertentie) }}"
                                        class="ml-2 text-blue-600 hover:text-blue-700">{{ __('texts.edit') }}</a> TODO
                                </div>
                                <span class="text-sm text-gray-900">€{{ $advertentie->price }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="col-span-full text-gray-800">{{ __('texts.no_ads_found') }}</p>
                @endforelse
            </div>
        </div>


    </div>
    @if ($advertenties->count())
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                {{ $advertenties->links() }}
            </div>
        </div>
    @else
        <p>{{ __('texts.no_ads_found') }}</p>
    @endif
    <a href="{{ route('advertenties.upload.show') }}"><button class="button"><i class="fas fa-plus"></i>
            {{ __('texts.upload') }}</button></a>

    <a href="{{ route('advertenties.create') }}"><button class="button"><i class="fas fa-plus"></i>
            {{ __('texts.create') }}</button></a>

</x-app-layout>
