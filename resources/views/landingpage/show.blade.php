<x-app-layout>

    <div class="container mx-auto p-4">
        @if (isset($pageSetting->components['hero']))
            @php
                $heroData = $componentsData['hero'] ?? null;
                $heroData['template'] = 3;
            @endphp

            {{-- Hero Template 1 --}}
            @if ($heroData['template'] == '1')
                <div class="bg-cover bg-center h-screen rounded-lg"
                    style="background-image: url('{{ $heroData['image'] ?? 'default-image.jpg' }}');">
                    <div class="flex flex-col justify-center items-center h-full">
                        <h1 class="text-white text-5xl font-bold">{{ $heroData['title'] }}</h1>
                        @if (isset($heroData['secondaryTitle']))
                            <h2 class="text-white text-3xl">{{ $heroData['secondaryTitle'] }}</h2>
                        @endif
                    </div>
                </div>
                {{-- Hero Template 2 --}}
            @elseif($heroData['template'] == '2')
                <div class="h-screen flex flex-col justify-center items-center rounded-lg overflow-hidden"
                    style="background: linear-gradient(135deg, {{ $pageSetting->palette['primary'] ?? '#ffffff' }} 0%, {{ $pageSetting->palette['background'] ?? '#007bff' }} 50%, {{ $pageSetting->palette['secondary'] ?? '#6c757d' }} 100%);">
                    <h1 class="text-5xl font-bold" style="color: {{ $pageSetting->palette['text'] ?? '#000000' }}">
                        {{ $heroData['title'] }}</h1>
                    @if (isset($heroData['secondaryTitle']))
                        <h2 class="text-3xl" style="color: {{ $pageSetting->palette['text'] ?? '#000000' }}">
                            {{ $heroData['secondaryTitle'] }}</h2>
                    @endif
                </div>

                {{-- Hero Template 3 --}}
            @elseif($heroData['template'] == '3')
                <div class="flex items-center justify-between py-12 bg-gray-900" style="border-radius: 8px;">
                    <div class="text-left pl-20">
                        <h1 class="text-5xl font-bold text-white"
                            style="text-shadow: 2px 2px 4px rgba(0,0,0,0.5); position: relative;">
                            {{ $heroData['title'] }}
                            <span
                                style="position: absolute; bottom: -5px; left: 0; width: 100%; height: 3px; background-color: {{ $pageSetting->palette['primary'] ?? '#007bff' }};"></span>
                        </h1>
                        @if (isset($heroData['secondaryTitle']))
                            <h2 class="text-3xl text-gray-400" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.5);">
                                {{ $heroData['secondaryTitle'] }}</h2>
                        @endif
                    </div>
                    @if (isset($heroData['image']))
                        <img src="{{ $heroData['image'] }}" alt="Hero Image" class="w-1/2 h-auto object-cover pr-20"
                            style="border-radius: 8px;">
                    @endif
                </div>
            @endif


        @endif

        @if (isset($pageSetting->components['intro']))
            @php
                $introData = $componentsData['intro'] ?? null;
            @endphp
            <div class="my-8 p-6 bg-white shadow-lg rounded-lg"
                style="color: {{ $pageSetting->palette['text'] ?? '#000000' }}; border-left: 5px solid {{ $pageSetting->palette['primary'] ?? '#007bff' }};">
                <p>{{ $introData['text'] }}</p>
            </div>
        @endif


        @if (isset($componentsData['highlighted_ads']))
            <div class="my-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <p>{{ __('highlighted adverisements') }}</p>
                @foreach ($componentsData['highlighted_ads'] as $ad)
                    <div class="bg-white shadow-md rounded-lg overflow-hidden">
                        @if ($ad->afbeelding_path)
                            <img src="{{ asset('storage/' . $ad->afbeelding_path) }}" alt="Ad Image"
                                class="w-full h-48 object-cover">
                        @endif
                        <div class="p-4">
                            <h3 class="text-lg font-semibold"
                                style="color: {{ $pageSetting->palette['primary'] ?? '#007bff' }}">{{ $ad->titel }}
                            </h3>
                            <p class="text-sm text-gray-600"
                                style="color: {{ $pageSetting->palette['text'] ?? '#000000' }}">
                                {{ Str::limit($ad->beschrijving, 100) }}</p>
                            <div class="mt-3 flex justify-between items-center">
                                <span class="font-bold"
                                    style="color: {{ $pageSetting->palette['secondary'] ?? '#6c757d' }}">€{{ number_format($ad->prijs, 2, ',', '.') }}</span>
                                <a href="{{ route('advertenties.show', $ad) }}" class="text-white py-2 px-4 rounded"
                                    style="background-color: {{ $pageSetting->palette['accent'] ?? '#17a2b8' }};">
                                    Meer informatie
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif


    </div>

    @push('styles')
        <style>
            body {
                background-color: {{ $pageSetting->palette['background'] ?? '#ffffff' }};
                color: {{ $pageSetting->palette['text'] ?? '#000000' }};
                font-family: {{ $pageSetting->text_style['font'] ?? 'Arial, sans-serif' }};
                font-size: {{ $pageSetting->text_style['size'] ?? '16' }}px;
            }

            #app {
                background-color: {{ $pageSetting->palette['background'] ?? '#ffffff' }};
            }
        </style>
    @endpush

</x-app-layout>
