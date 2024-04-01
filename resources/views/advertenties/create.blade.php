<x-app-layout>
    <form method="POST" action="{{ route('advertenties.store') }}" enctype="multipart/form-data"
        class="max-w-xl mx-auto py-8 px-4 space-y-6 bg-white shadow-md rounded-lg mt-4">
        @csrf
        <div class="flex flex-col">
            <label for="title" class="mb-2 font-semibold">{{ __('texts.title') }}</label>
            <input type="text" id="title" name="title" required
                class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm">
        </div>
        <div class="flex flex-col">
            <label for="description" class="mb-2 font-semibold">{{ __('texts.description') }}:</label>
            <textarea id="description" name="description" required
                class="form-textarea mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
        </div>
        <div class="flex flex-col">
            <label for="price" class="mb-2 font-semibold">{{ __('texts.price') }}</label>
            <input type="number" placeholder="€0" id="price" name="price" min="0.00" max="99999.99"
                step="0.01" required class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm">
        </div>
        <div class="flex flex-col">
            <label for="type" class="mb-2 font-semibold">{{ __('texts.ad_type') }}</label>
            <select id="type" name="type" required
                class="form-select mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                <option value="">{{ __('texts.select_type') }}</option>
                <option value="Verkoop">{{ __('texts.sale') }}</option>
                <option value="Verhuur">{{ __('texts.rent') }}</option>
            </select>
        </div>
        <div class="flex flex-col">
            <label for="image" class="mb-2 font-semibold">{{ __('texts.image') }}</label>
            <input type="file" id="image" name="image"
                class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm">
        </div>
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            {{ __('texts.place_ad') }}
        </button>
    </form>
</x-app-layout>
