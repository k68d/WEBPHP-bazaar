<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('texts.dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __('texts.logged_in_business') }}
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
                        <a href="{{ route('landingpage-settings.edit') }}"
                            class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">{{ __('texts.edit_landingpage') }}</a>
                    @else
                        <a href="{{ route('landingpage-settings.create') }}"
                            class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">{{ __('texts.create_landingpage') }}</a>
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
                        <p>{{ __('texts.warning_save_token') }}</p>
                        <p>{{ __('texts.api_token') }} <code>{{ Session::get('token') }}</code></p>
                        <a href="{{ route('profile.generateApiToken') }}"
                            class="bg-transparent hover:bg-red-500 text-red-700 font-semibold hover:text-white py-2 px-4 border border-red-500 hover:border-transparent rounded mt-4">{{ __('texts.create_key') }}</a>
                    @else
                        @if (auth()->user()->tokens->isNotEmpty())
                            <p class="pb-2">
                                {{ __('texts.you_already_have_token') }}
                            </p>
                            <a href="{{ route('profile.generateApiToken') }}"
                                class="bg-transparent hover:bg-red-500 text-red-700 font-semibold hover:text-white my-10 py-2 px-4 border border-red-500 hover:border-transparent rounded">{{ __('texts.create_key') }}</a>
                            <p class="pt-2">{{ __('texts.access_api_advertenties') }} <code
                                    class="bg-gray-900 px-1 sm:rounded-sm">{{ route('api.advertenties') }}</code>
                                {{ __('texts.for_all_advertenties') }}</p>
                            <p>{{ __('texts.access_api_advertenties') }} <code
                                    class="bg-gray-900 px-1 sm:rounded-sm">{{ url('api/advertentie/{advertentie_id}') }}</code>
                                {{ __('texts.for_specific_advertentie') }}
                            </p>
                        @else
                            <a href="{{ route('profile.generateApiToken') }}"
                                class="bg-transparent hover:bg-green-500 text-green-700 font-semibold hover:text-white py-2 px-4 border border-green-500 hover:border-transparent rounded">{{ __('texts.create_new_key') }}</a>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
