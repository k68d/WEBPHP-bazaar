<x-app-layout>
    <form method="POST" action="{{ route('advertenties.store') }}" enctype="multipart/form-data">
        @csrf
        <div>
            <label for="title">{{ __('texts.title') }}</label>
            <input type="text" id="title" name="title" required>
        </div>
        <div>
            <label for="description">{{ __('texts.description') }}:</label>
            <textarea id="description" name="description" required></textarea>
        </div>
        <div>
            <label for="price">{{ __('texts.price') }}</label>
            <input type="number" placeholder="€0" id="price" name="price" min="0.00" max="99999.99"
                step="0.01" required>
        </div>
        <div>
            <label for="type">{{ __('texts.ad_type') }}</label>
            <select id="type" name="type" required>
                <option value="">{{ __('texts.select_type') }}</option>
                <option value="Verkoop">{{ __('texts.sale') }}</option>
                <option value="Verhuur">{{ __('texts.rent') }}</option>
            </select>
        </div>
        <div>
            <label for="image">{{ __('texts.image') }}</label>
            <input type="file" id="image" name="image">
        </div>
        <button type="submit">{{ __('texts.place_ad') }}</button>
    </form>
</x-app-layout>
