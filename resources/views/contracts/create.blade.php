<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Maak een nieuw contract
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('contracts.store') }}">
                        @csrf

                        <div class="mt-4">
                            <label for="user_id_one" class="block font-medium text-sm text-gray-700">Gebruiker 1</label>
                            <select id="user_id_one" name="user_id_one" class="block mt-1 w-full" required>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">
                                        {{ $user->name }}{{ Auth::user()->id == $user->id ? ' (Jezelf)' : '' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id_one')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label for="user_id_two" class="block font-medium text-sm text-gray-700">Gebruiker 2</label>
                            <select id="user_id_two" name="user_id_two" class="block mt-1 w-full" required>
                                @foreach ($users as $user)
                                    @if (Auth::user()->id != $user->id)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('user_id_two')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label for="description"
                                class="block font-medium text-sm text-gray-700">Omschrijving</label>
                            <textarea id="description" name="description" class="block mt-1 w-full" required></textarea>
                            @error('description')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label for="contract_date"
                                class="block font-medium text-sm text-gray-700">Contractdatum</label>
                            <input type="date" id="contract_date" name="contract_date" class="block mt-1 w-full"
                                required>
                            @error('contract_date')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label for="status" class="block font-medium text-sm text-gray-700">Status</label>
                            <input type="text" id="status" name="status" class="block mt-1 w-full" required>
                            @error('status')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label for="additional_info" class="block font-medium text-sm text-gray-700">Aanvullende
                                Informatie</label>
                            <textarea id="additional_info" name="additional_info" class="block mt-1 w-full"></textarea>
                            @error('additional_info')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button dusk="submit-contract-button" type="submit"
                                class="ml-4 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Contract Opslaan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
