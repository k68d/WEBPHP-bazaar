<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- TODO: Change naar Tailwind -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body>
    @include ('layouts.navbar')
    <h1>Advertenties</h1>
    <div>
        <div class="container mb-4">
            <div class="row">
                <div class="col-12">
                    <form action="{{ route('advertenties.index') }}" method="GET">
                        <div class="form-row align-items-center">
                            <div class="col-auto">
                                <input type="text" class="form-control mb-2" name="filter_titel"
                                    placeholder="Filter op titel" value="{{ request('filter_titel') }}">
                            </div>
                            <div class="col-auto">
                                <select class="form-control mb-2" name="sorteer" style="min-width: 170px;">
                                    <option value="titel_asc" {{ request('sorteer') == 'titel_asc' ? 'selected' : '' }}>
                                        Titel
                                        A-Z</option>
                                    <option value="titel_desc"
                                        {{ request('sorteer') == 'titel_desc' ? 'selected' : '' }}>
                                        Titel
                                        Z-A</option>
                                    <option value="prijs_laag"
                                        {{ request('sorteer') == 'prijs_laag' ? 'selected' : '' }}>
                                        Prijs
                                        Laag-Hoog</option>
                                    <option value="prijs_hoog"
                                        {{ request('sorteer') == 'prijs_hoog' ? 'selected' : '' }}>
                                        Prijs
                                        Hoog-Laag</option>
                                </select>
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary mb-2">Toepassen</button>
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
                                    <img src="{{ asset('storage/' . $advertentie->afbeelding_path) }}"
                                        class="card-img-top" alt="{{ $advertentie->titel }}"
                                        style="height: 225px; width: 100%; display: block;">
                                    <h5 class="card-title">{{ $advertentie->titel }}</h5>
                                    <p class="card-text">{{ Str::limit($advertentie->beschrijving, 100) }}</p>
                                    <p class="card-text">{{ $advertentie->type }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="btn-group">
                                            <a href="{{ route('advertenties.show', $advertentie) }}"
                                                class="btn btn-sm btn-outline-secondary">Bekijk</a>
                                            <a href="{{ route('advertenties.edit', $advertentie) }}"
                                                class="btn btn-sm btn-outline-secondary">Bewerk</a>
                                        </div>
                                        <small class="text-muted">€{{ $advertentie->prijs }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p>Geen advertenties gevonden.</p>
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
            <p>Geen advertenties gevonden.</p>
        @endif
        <a href="{{ route('advertenties.upload.show') }}"><button class="button"><i class="fas fa-plus"></i>
                upload</button></a>

        <a href="{{ route('advertenties.create') }}"><button class="button"><i class="fas fa-plus"></i>
                Maak</button></a>

</body>

</html>
