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
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900">Alle Contracten</h3>
                            @foreach ($allContracts as $contract)
                                <div class="mt-4 p-4 bg-gray-100 rounded-md">
                                    <p>Contract ID: <span class="font-semibold">{{ $contract->id }}</span>, Omschrijving:
                                        <span class="font-semibold">{{ $contract->description }}</span></p>
                                    @if (Auth::user()->hasRole('Admin'))
                                        <a href="{{ route('contracts.export', $contract->id) }}"
                                            class="inline-block mt-2 px-4 py-2 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors">Exporteer
                                            PDF</a>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Betrokken Contracten</h3>
                        @foreach ($contracts as $contract)
                            <div class="mt-4 p-4 bg-gray-100 rounded-md">
                                <p>Contract ID: <span class="font-semibold">{{ $contract->id }}</span>, Omschrijving:
                                    <span class="font-semibold">{{ $contract->description }}</span></p>
                                @if (Auth::user()->hasRole('Admin'))
                                    <a href="{{ route('contracts.export', $contract->id) }}"
                                        class="inline-block mt-2 px-4 py-2 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors">Exporteer
                                        PDF</a>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
