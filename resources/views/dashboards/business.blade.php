<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in! on Business") }}
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (Session::has('token'))
                        <p>{{ __('Warning! save the token, it will not be shown again.') }}</p>
                        <p>{{ __('API token:') }} {{ Session::get('token') }}</p>
                        <a href="{{ route('profile.generateApiToken') }}"
                            class="bg-transparent hover:bg-red-500 text-red-700 font-semibold hover:text-white py-2 px-4 border border-red-500 hover:border-transparent rounded mt-4">{{ __('create key') }}</a>
                    @else
                        @if (auth()->user()->tokens->isNotEmpty())
                            <p>{{ __('You already have generated a token before, are you sure you want to generate a new one?') }}
                            </p>
                            <a href="{{ route('profile.generateApiToken') }}"
                                class="bg-transparent hover:bg-red-500 text-red-700 font-semibold hover:text-white py-2 px-4 border border-red-500 hover:border-transparent rounded mt-4">{{ __('create key') }}</a>
                        @else
                            <a href="{{ route('profile.generateApiToken') }}"
                                class="bg-transparent hover:bg-green-500 text-green-700 font-semibold hover:text-white py-2 px-4 border border-green-500 hover:border-transparent rounded">{{ __('create new key') }}</a>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
