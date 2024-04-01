<x-app-layout>
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 py-12">
    @if($rentals->isEmpty())
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                Je hebt nog geen producten verhuurd.
            </div>
        @else
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Begin Huur</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Eind Huur</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Retour Foto</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Afloop Advertentie</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($rentals as $rental)
                        <tr class="border-b">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $rental->title }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ optional($rental->begin_huur)->format('d-m-Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ optional($rental->eind_huur)->format('d-m-Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if ($rental->return_photo_path)
                                    <img src="{{ asset_or_default('storage/' . $rental->return_photo_path) }}"
                                        alt="{{ __('texts.return_photo') }}" class="w-20 h-20 object-cover rounded-md">
                                @else
                                    {{ __('texts.no_photo') }}
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ optional($rental->einddatum)->format('d-m-Y') }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-app-layout>
