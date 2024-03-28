<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>Document</title>
</head>

<body>
    @include ('layouts.navbar')
    <h1>Advertenties</h1>

    <div class="container">
        <div class="row">
            @forelse ($advertenties as $advertentie)
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <img src="{{ asset('storage/' . $advertentie->afbeelding_path) }}" class="card-img-top"
                                alt="{{ $advertentie->titel }}" style="height: 225px; width: 100%; display: block;">
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
    <a href="{{ route('advertenties.upload.show') }}"><button class="button"><i class="fas fa-plus"></i>
            upload</button></a>

    <a href="{{ route('advertenties.create') }}"><button class="button"><i class="fas fa-plus"></i> Maak</button></a>
</body>

</html>
