{{-- resources/views/contracts/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Overzicht Contracten
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if ($allContracts)
                        <h3 class="text-lg font-medium text-gray-900">Alle Contracten</h3>
                        <form method="GET" action="{{ route('contracts.index') }}">
                            <div>
                                <input type="text" name="all_filter_name" placeholder="Filter by name"
                                    value="{{ request('all_filter_name') }}">
                                <select name="all_sort">
                                    <option value="date_asc"{{ request('all_sort') == 'date_asc' ? ' selected' : '' }}>
                                        Datum oplopend</option>
                                    <option
                                        value="date_desc"{{ request('all_sort') == 'date_desc' ? ' selected' : '' }}>
                                        Datum aflopend</option>
                                </select>
                                <input type="hidden" name="involved_filter_name"
                                    value="{{ request('involved_filter_name') }}">
                                <input type="hidden" name="involved_sort" value="{{ request('involved_sort') }}">
                                <button type="submit">Toepassen</button>
                            </div>
                        </form>
                        @foreach ($allContracts as $contract)
                            <div class="mt-4 p-4 bg-gray-100 rounded-md">
                                <p>Contract ID: <span class="font-semibold">{{ $contract->id }}</span>, Omschrijving:
                                    <span class="font-semibold">{{ $contract->description }}</span>, Verbonden
                                    Gebruikers: <span
                                        class="font-semibold">{{ $contract->userOne->name ?? 'N/A' }}</span>, <span
                                        class="font-semibold">{{ $contract->userTwo->name ?? 'N/A' }}</span>
                                </p>
                                @if (Auth::user()->hasRole('Admin'))
                                    <a href="{{ route('contracts.export', $contract->id) }}" dusk="export-pdf-link"
                                        class="inline-block mt-2 px-4 py-2 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors">Exporteer
                                        PDF</a>
                                @endif
                            </div>
                        @endforeach
                        {{ $allContracts->appends([
                                'all_filter_name' => request('all_filter_name'), // Behoudt de filter voor alle contracten
                                'all_sort' => request('all_sort'), // Behoudt de sorteeroptie voor alle contracten
                                'involved_filter_name' => request('involved_filter_name'), // Behoudt de filter voor betrokken contracten
                                'involved_sort' => request('involved_sort'), // Behoudt de sorteeroptie voor betrokken contracten
                            ])->links() }}

                    @endif

                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Betrokken Contracten</h3>
                        <form method="GET" action="{{ route('contracts.index') }}">
                            <div>
                                <input type="text" name="involved_filter_name" placeholder="Filter by name"
                                    value="{{ request('involved_filter_name') }}">
                                <select name="involved_sort">
                                    <option
                                        value="date_asc"{{ request('involved_sort') == 'date_asc' ? ' selected' : '' }}>
                                        Datum oplopend</option>
                                    <option
                                        value="date_desc"{{ request('involved_sort') == 'date_desc' ? ' selected' : '' }}>
                                        Datum aflopend</option>
                                </select>
                                <input type="hidden" name="all_filter_name" value="{{ request('all_filter_name') }}">
                                <input type="hidden" name="all_sort" value="{{ request('all_sort') }}">
                                <button type="submit">Toepassen</button>
                            </div>
                        </form>

                        @foreach ($contracts as $contract)
                            <div class="mt-4 p-4 bg-gray-100 rounded-md">
                                <p>Contract ID: <span class="font-semibold">{{ $contract->id }}</span>, Omschrijving:
                                    <span class="font-semibold">{{ $contract->description }}</span>, Verbonden
                                    Gebruikers: <span
                                        class="font-semibold">{{ $contract->userOne->name ?? 'N/A' }}</span>, <span
                                        class="font-semibold">{{ $contract->userTwo->name ?? 'N/A' }}</span>

                                </p>
                                @if (Auth::user()->hasRole('Admin'))
                                    <a href="{{ route('contracts.export', $contract->id) }}"
                                        class="inline-block mt-2 px-4 py-2 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors">Exporteer
                                        PDF</a>
                                @endif
                            </div>
                        @endforeach
                        {{ $contracts->appends([
                                'involved_filter_name' => request('involved_filter_name'), // Behoudt de filter voor betrokken contracten
                                'involved_sort' => request('involved_sort'), // Behoudt de sorteeroptie voor betrokken contracten
                                'all_filter_name' => request('all_filter_name'), // Behoudt de filter voor alle contracten
                                'all_sort' => request('all_sort'), // Behoudt de sorteeroptie voor alle contracten
                            ])->links() }}

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
