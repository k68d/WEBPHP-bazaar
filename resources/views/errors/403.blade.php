<x-app-layout>
    <div class="text-center mt-10">
        <h1 class="text-3xl font-bold">403 | Forbidden</h1> {{-- EXCLUDED FROM LANGUAGE LIST --}}
        <p class="mt-4">{{ __('texts.no_access') }}</p>
        <a href="{{ url('/') }}"
            class="mt-5 inline-block px-6 py-2 bg-blue-500 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">{{ __('texts.go_home') }}</a>
    </div>
</x-app-layout>
