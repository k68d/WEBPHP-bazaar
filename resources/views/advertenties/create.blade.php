<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plaats een nieuwe advertentie</title>
    
</head>
    <body>
        <form method="POST" action="{{ route('advertenties.store') }}" enctype="multipart/form-data">
            @csrf
            <div>
                <label for="titel">Titel:</label>
                <input type="text" id="titel" name="titel" required>
            </div>
            <div>
                <label for="beschrijving">Beschrijving:</label>
                <textarea id="beschrijving" name="beschrijving" required></textarea>
            </div>
            <div>
                <label for="prijs">Prijs:</label>
                <input type="text" id="prijs" name="prijs" required>
            </div>
            <div>
                <label for="type">Type advertentie:</label>
                <select id="type" name="type" required>
                    <option value="">Selecteer een type...</option>
                    <option value="normaal">Normaal</option>
                    <option value="verhuur">Verhuur</option>
                </select>
            </div>
            <div>
                <label for="afbeelding">Afbeelding:</label>
                <input type="file" id="afbeelding" name="afbeelding">
            </div>    
            <button type="submit">Plaats Advertentie</button>
        </form>
    </body>
</html>