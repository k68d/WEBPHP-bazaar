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
        <h1>{{ $advertenties->titel }}</h1>
        @if($advertenties->afbeelding_path)
        <img src="{{ asset('storage/' . $advertenties->afbeelding_path) }}" alt="{{ $advertenties->titel }}" class="img-fluid">
        @endif
        <p>Beschrijving: {{ $advertenties->beschrijving }}</p>
        <p>Prijs: €{{ $advertenties->prijs }}</p>
        <p>Type: {{ $advertenties->type }}</p>
    </div>


</body>
</html>