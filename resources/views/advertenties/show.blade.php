<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    @include('layouts.navbar')
    <div class="container">
        <h1>{{ $advertentie->titel }}</h1>
        @if ($advertentie->afbeelding_path)
            <img src="{{ asset('storage/' . $advertentie->afbeelding_path) }}" alt="{{ $advertentie->titel }}"
                class="img-fluid">
        @endif
        <p>Beschrijving: {{ $advertentie->beschrijving }}</p>
        <p>Prijs: €{{ $advertentie->prijs }}</p>
        <p>Type: {{ $advertentie->type }}</p>
    </div>
    <div class="qr-code">
        {!! $qrCode !!}
    </div>



</body>

</html>
