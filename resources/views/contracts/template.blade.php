{{-- resources/views/contracts/template.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Contract</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }
    </style>
</head>

<body>
    <h1>Contract</h1>
    <p><strong>Gebruiker 1:</strong> {{ $userOne->name }}</p>
    <p><strong>Gebruiker 2:</strong> {{ $userTwo->name }}</p>
    <p><strong>Omschrijving:</strong> {{ $description }}</p>
    <p><strong>Datum:</strong> {{ $contractDate->format('Y-m-d') }}</p>
    <p><strong>Status:</strong> {{ $status }}</p>
    <p><strong>Aanvullende Info:</strong> {{ $additionalInfo }}</p>

    <div class="signatures">
        <p>Handtekening Gebruiker 1: _______________________________</p>
        <p>Handtekening Gebruiker 2: _______________________________</p>
    </div>
</body>

</html>
