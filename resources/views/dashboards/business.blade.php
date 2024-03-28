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

    <!-- Check for page setting existence and display corresponding link -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (\App\Models\PageSetting::where('user_id', auth()->user()->id)->count() > 0)
                        <!-- Link to edit page settings if they exist -->
                        <a href="{{ route('landingpage-settings.edit') }}"
                            class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">Edit
                            landingpage</a>
                    @else
                        <!-- Link to create page settings if they don't exist -->
                        <a href="{{ route('landingpage-settings.create') }}"
                            class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">Create
                            landingpage</a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (Session::has('token'))
                        <p>{{ __('Warning! Save the token, it will not be shown again.') }}</p>
                        <p>{{ __('API token:') }} <code>{{ Session::get('token') }}</code></p>
                        <a href="{{ route('profile.generateApiToken') }}"
                            class="bg-transparent hover:bg-red-500 text-red-700 font-semibold hover:text-white py-2 px-4 border border-red-500 hover:border-transparent rounded mt-4">{{ __('Create key') }}</a>
                    @else
                        @if (auth()->user()->tokens->isNotEmpty())
                            <p class="pb-2">
                                {{ __('You already have generated a token before, are you sure you want to generate a new one?') }}
                            </p>
                            <a href="{{ route('profile.generateApiToken') }}"
                                class="bg-transparent hover:bg-red-500 text-red-700 font-semibold hover:text-white my-10 py-2 px-4 border border-red-500 hover:border-transparent rounded">{{ __('Create key') }}</a>
                            <p class="pt-2">{{ __('Access API by') }} <code
                                    class="bg-gray-900 px-1 sm:rounded-sm">{{ route('api.advertenties') }}</code>
                                {{ __('for all advertenties') }}</p>
                            <p>{{ __('Access API by') }} <code
                                    class="bg-gray-900 px-1 sm:rounded-sm">{{ url('api/advertentie/{advertentie_id}') }}</code>
                                {{ __('for a specific advertentie (replace {advertentie_id} with the actual ID)') }}
                            </p>
                        @else
                            <a href="{{ route('profile.generateApiToken') }}"
                                class="bg-transparent hover:bg-green-500 text-green-700 font-semibold hover:text-white py-2 px-4 border border-green-500 hover:border-transparent rounded">{{ __('Create new key') }}</a>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
