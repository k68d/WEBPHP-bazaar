<x-app-layout>
    <div class="container">
        <h1>Mijn Verhuurde Producten</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Begin Huur</th>
                    <th>Eind Huur</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rentals as $rental)
                    <tr>
                        <td>{{ $rental->title }}</td>
                        <td>{{ $rental->begin_huur->format('d-m-Y') }}</td>
                        <td>{{ $rental->eind_huur->format('d-m-Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>