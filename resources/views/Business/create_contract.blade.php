{{-- create_contract.blade.php adjusted for direct client detail input --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Create Contract
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('contracts.generate') }}" method="POST">
                        @csrf
                        <!-- Client Details Input -->
                        <div class="mb-4">
                            <label for="client_name" class="block text-sm font-medium text-gray-700">Client Name</label>
                            <input type="text" id="client_name" name="client_name" required
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        </div>
                        <div class="mb-4">
                            <label for="client_email" class="block text-sm font-medium text-gray-700">Client
                                Email</label>
                            <input type="email" id="client_email" name="client_email" required
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        </div>

                        <!-- Advertentie Selection -->
                        <div class="mb-4">
                            <label for="advertentie_id" class="block text-sm font-medium text-gray-700">Select
                                Advertentie</label>
                            <select id="advertentie_id" name="advertentie_id"
                                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
                                required>
                                @foreach ($advertenties as $advertentie)
                                    <option value="{{ $advertentie->id }}">{{ $advertentie->titel }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Generate Contract
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
