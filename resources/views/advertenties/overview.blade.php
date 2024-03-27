<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Advertisement Overview') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-gray-800 text-white">
                    <div class="mb-4 p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700">
                        <p>{{ __('The advertisements have been uploaded. You are now adding an additional image to each advertisement.') }}
                        </p>
                    </div>

                    <form action="{{ route('advertenties.images.upload') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @foreach ($advertenties as $advertentie)
                            <div class="mb-4">
                                <h4 class="font-bold">{{ $advertentie->titel }}</h4>
                                <div>
                                    <label for="afbeelding_{{ $advertentie->id }}"
                                        class="block text-sm font-medium text-gray-300">
                                        {{ __('Choose an Image for ":title"', ['title' => $advertentie->titel]) }}
                                    </label>
                                    <input type="file" id="afbeelding_{{ $advertentie->id }}"
                                        name="afbeeldingen[{{ $advertentie->id }}]"
                                        class="mt-1 block w-full rounded-md border-gray-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        required>
                                </div>
                            </div>
                        @endforeach
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                            {{ __('Upload All Images') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
