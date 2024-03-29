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
                <label for="title">Titel:</label>
                <input type="text" id="title" name="title" required>
            </div>
            <div>
                <label for="description">Beschrijving:</label>
                <textarea id="description" name="description" required></textarea>
            </div>
            <div>
                <label for="price">Prijs:</label>
                <input type="number" pattern="^\$\d{1,3}(,\d{3})*(\.\d+)?$" placeholder="€0" id="price" name="price" min="0.00" max="99999.99" step="0.01" required>
            </div>
            <div>
                <label for="type">Type advertentie:</label>
                <select id="type" name="type" required>
                    <option value="">Selecteer een type...</option>
                    <option value="Verkoop">Verkoop</option>
                    <option value="Verhuur">Verhuur</option>
                </select>
            </div>
            <div>
                <label for="image">Afbeelding:</label>
                <input type="file" id="image" name="image">
            </div>    
            <button type="submit">Plaats Advertentie</button>
        </form>
    </body>
</html>