<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
        <h2 class="text-2xl font-semibold leading-tight">Mijn Gehuurde Producten</h2>
        <div class="bg-white shadow-md rounded my-6">
            <table class="min-w-full table-auto">
                <thead class="justify-between">
                    <tr class="bg-gray-800">
                        <th class="px-16 py-2">
                            <span class="text-gray-300">Product</span>
                        </th>
                        <th class="px-16 py-2">
                            <span class="text-gray-300">Begin Huur</span>
                        </th>
                        <th class="px-16 py-2">
                            <span class="text-gray-300">Eind Huur</span>
                        </th>
                        <th class="px-16 py-2">
                            <span class="text-gray-300">Retour Foto</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-gray-200">
                    @foreach($rentals as $rental)
                        <tr class="bg-white border-4 border-gray-200">
                            <td class="px-16 py-2">{{ $rental->title }}</td>
                            <td class="px-16 py-2">{{ $rental->begin_huur->format('d-m-Y') }}</td>
                            <td class="px-16 py-2">{{ $rental->eind_huur->format('d-m-Y') }}</td>
                            <td class="px-16 py-2">
                                @if($rental->return_photo_path)
                                    <img src="{{ asset('storage/' . $rental->return_photo_path) }}" alt="Retour foto" class="w-20 h-20 object-cover rounded">
                                @else
                                    Geen foto
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
