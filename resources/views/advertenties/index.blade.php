<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('texts.ads') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    @include ('layouts.navbar')
    <h1>{{ __('texts.ads') }}</h1>
    <div class="container mb-4">
        <div class="row">
            <div class="col-12">
                <form action="{{ route('advertenties.index') }}" method="GET">
                    <div class="form-row align-items-center">
                        <div class="col-auto">
                            <input type="text" class="form-control mb-2" name="filter_titel"
                                placeholder="{{ __('texts.filter_by_title') }}" value="{{ request('filter_titel') }}">
                        </div>
                        <div class="col-auto">
                            <select class="form-control mb-2" name="sorteer" style="min-width: 170px;">
                                <option value="titel_asc" {{ request('sorteer') == 'titel_asc' ? 'selected' : '' }}>
                                    {{ __('texts.title_asc') }}</option>
                                <option value="titel_desc" {{ request('sorteer') == 'titel_desc' ? 'selected' : '' }}>
                                    {{ __('texts.title_desc') }}</option>
                                <option value="prijs_laag" {{ request('sorteer') == 'prijs_laag' ? 'selected' : '' }}>
                                    {{ __('texts.price_low_high') }}</option>
                                <option value="prijs_hoog" {{ request('sorteer') == 'prijs_hoog' ? 'selected' : '' }}>
                                    {{ __('texts.price_high_low') }}</option>
                            </select>
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary mb-2">{{ __('texts.apply') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="container">
            <div class="row">
                @forelse ($advertenties as $advertentie)
                    <div class="col-md-4">
                        <div class="card mb-4 shadow-sm">
                            <div class="card-body">
                                <img src="{{ asset('storage/' . $advertentie->afbeelding_path) }}" class="card-img-top"
                                    alt="{{ $advertentie->titel }}"
                                    style="height: 225px; width: 100%; display: block;">
                                <h5 class="card-title">{{ $advertentie->title }}</h5>
                                <p class="card-text">{{ Str::limit($advertentie->description, 100) }}</p>
                                <p class="card-text">{{ $advertentie->type }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <a href="{{ route('advertenties.show', $advertentie) }}"
                                            class="btn btn-sm btn-outline-secondary">{{ __('texts.view') }}</a>
                                        <a href="{{ route('advertenties.edit', $advertentie) }}"
                                            class="btn btn-sm btn-outline-secondary">{{ __('texts.edit') }}</a>
                                    </div>
                                    <small class="text-muted">€{{ $advertentie->price }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p>{{ __('texts.no_ads_found') }}</p>
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

</body>

</html>
