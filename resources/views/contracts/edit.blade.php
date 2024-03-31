<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('texts.edit_contract') }} {{-- Change the header to indicate editing --}}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('contracts.update', $contract->id) }}"> {{-- Change the route to update --}}
                        @csrf
                        @method('PUT') {{-- Add this line to spoof a PUT request --}}

                        <div class="mt-4">
                            <label for="user_id_one"
                                class="block font-medium text-sm text-gray-700">{{ __('texts.user_1') }}</label>
                            <select id="user_id_one" name="user_id_one" class="block mt-1 w-full" required>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ $contract->user_id_one == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}{{ Auth::user()->id == $user->id ? ' (' . __('texts.yourself') . ')' : '' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id_one')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label for="user_id_two"
                                class="block font-medium text-sm text-gray-700">{{ __('texts.user_2') }}</label>
                            <select id="user_id_two" name="user_id_two" class="block mt-1 w-full" required>
                                @foreach ($users as $user)
                                    @if (Auth::user()->id != $user->id)
                                        <option value="{{ $user->id }}"
                                            {{ $contract->user_id_two == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            @error('user_id_two')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label for="description"
                                class="block font-medium text-sm text-gray-700">{{ __('texts.description') }}</label>
                            <textarea id="description" name="description" class="block mt-1 w-full" required>{{ $contract->description }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label for="contract_date"
                                class="block font-medium text-sm text-gray-700">{{ __('texts.contract_date') }}</label>
                            <input type="date" id="contract_date" name="contract_date" class="block mt-1 w-full"
                                value="{{ $contract->contract_date }}" required>
                            @error('contract_date')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label for="status"
                                class="block font-medium text-sm text-gray-700">{{ __('texts.status') }}</label>
                            <input type="text" id="status" name="status" class="block mt-1 w-full"
                                value="{{ $contract->status }}" required>
                            @error('status')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <label for="additional_info"
                                class="block font-medium text-sm text-gray-700">{{ __('texts.additional_info') }}</label>
                            <textarea id="additional_info" name="additional_info" class="block mt-1 w-full">{{ $contract->additional_info }}</textarea>
                            @error('additional_info')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button dusk="update-contract-button" type="submit"
                                class="ml-4 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('texts.update_contract') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
