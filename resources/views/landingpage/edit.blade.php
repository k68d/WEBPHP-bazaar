@php
    $components = json_decode($pageSetting->components, true);
@endphp
<x-app-layout>
    <div class="container mx-auto p-4">
        <div class="flex flex-wrap">
            <div id="menu" class="w-full lg:w-1/2 p-4">
                <form action="{{ route('landingpage-settings.update', $pageSetting->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <!-- URL Field -->
                    <div class="mb-4">
                        <label for="page_url"
                            class="block text-gray-700 text-sm font-bold mb-2">{{ __('texts.page_url') }}</label>
                        <input type="text" name="page_url" id="page_url"
                            value="{{ old('page_url', $pageSetting->page_url) }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('page_url')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Color Palette Fields Start -->
                    <div class="mb-4">
                        <div class="block text-gray-700 text-sm font-bold mb-2">{{ __('texts.color_palette') }}</div>
                        <div class="flex flex-wrap -mx-2">
                            <!-- Background Color -->
                            <div class="px-2 w-1/2 md:w-1/4">
                                <label for="palette_background"
                                    class="block text-xs font-bold mb-1">{{ __('texts.background') }}</label>
                                <input type="color" name="palette[background]" id="palette_background"
                                    value="{{ old('palette.background', json_decode($pageSetting->palette, true)['background']) }}"
                                    class="mb-2 w-full">
                                <span id="background_swatch" class="inline-block w-6 h-6 border"
                                    style="background-color: {{ old('palette.background', json_decode($pageSetting->palette, true)['background']) }};"></span>
                                @error('palette.background')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                @enderror
                            </div>
                            <!-- Text Color -->
                            <div class="px-2 w-1/2 md:w-1/4">
                                <label for="palette_text"
                                    class="block text-xs font-bold mb-1">{{ __('texts.text') }}</label>
                                <input type="color" name="palette[text]" id="palette_text"
                                    value="{{ old('palette.text', json_decode($pageSetting->palette, true)['text']) }}"
                                    class="mb-2 w-full">
                                <span id="text_swatch" class="inline-block w-6 h-6 border"
                                    style="background-color: {{ old('palette.text', json_decode($pageSetting->palette, true)['text']) }};"></span>
                                @error('palette.text')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Primary Color -->
                            <div class="px-2 w-1/2 md:w-1/4">
                                <label for="palette_primary"
                                    class="block text-xs font-bold mb-1">{{ __('texts.primary') }}</label>
                                <input type="color" name="palette[primary]" id="palette_primary"
                                    value="{{ old('palette.primary', json_decode($pageSetting->palette, true)['primary']) }}"
                                    class="mb-2 w-full">
                                <span id="primary_swatch" class="inline-block w-6 h-6 border"
                                    style="background-color: {{ old('palette.primary', json_decode($pageSetting->palette, true)['primary']) }};"></span>
                                @error('palette.primary')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Secondary Color -->
                            <div class="px-2 w-1/2 md:w-1/4">
                                <label for="palette_secondary"
                                    class="block text-xs font-bold mb-1">{{ __('texts.secondary') }}</label>
                                <input type="color" name="palette[secondary]" id="palette_secondary"
                                    value="{{ old('palette.secondary', json_decode($pageSetting->palette, true)['secondary']) }}"
                                    class="mb-2 w-full">
                                <span id="secondary_swatch" class="inline-block w-6 h-6 border"
                                    style="background-color: {{ old('palette.secondary', json_decode($pageSetting->palette, true)['secondary']) }};"></span>
                                @error('palette.secondary')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Accent Color -->
                            <div class="px-2 w-1/2 md:w-1/4">
                                <label for="palette_accent"
                                    class="block text-xs font-bold mb-1">{{ __('texts.accent') }}</label>
                                <input type="color" name="palette[accent]" id="palette_accent"
                                    value="{{ old('palette.accent', json_decode($pageSetting->palette, true)['accent']) }}"
                                    class="mb-2 w-full">
                                <span id="accent_swatch" class="inline-block w-6 h-6 border"
                                    style="background-color: {{ old('palette.accent', json_decode($pageSetting->palette, true)['accent']) }};"></span>
                                @error('palette.accent')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Text Style Fields Start -->
                    <div class="mb-4">
                        <label for="text_style_font"
                            class="block text-gray-700 text-sm font-bold mb-2">{{ __('texts.lettertype') }}</label>
                        <input type="text" name="text_style[font]" id="text_style_font"
                            value="{{ old('text_style.font', json_decode($pageSetting->text_style, true)['font']) }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('text_style.font')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                        <label for="text_style_size"
                            class="block text-gray-700 text-sm font-bold mb-2 mt-4">{{ __('texts.lettergrootte') }}</label>
                        <input type="number" name="text_style[size]" id="text_style_size"
                            value="{{ old('text_style.size', json_decode($pageSetting->text_style, true)['size']) }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            required>
                        @error('text_style.size')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Componenten Selectie en Instellingen --}}
                    <div class="mb-4">
                        <label
                            class="block text-gray-700 text-sm font-bold mb-2">{{ __('texts.select_components') }}</label>

                        {{-- Hero Component --}}
                        <div>
                            <input type="checkbox" name="components[hero]" id="components_hero"
                                {{ isset($components['hero']['hero']) ? 'checked' : '' }} class="mr-2">
                            <label for="components_hero">{{ __('texts.hero') }}</label>
                            <div id="hero_details"
                                style="{{ isset($components['hero']['hero']) ? '' : 'display:none;' }}">
                                <div class="mb-2">
                                    <label for="hero_template"
                                        class="block text-gray-700 text-sm font-bold mb-1">{{ __('texts.hero_template') }}</label>
                                    <select name="hero[template]" id="hero_template"
                                        class="block appearance-none w-full p-2 border rounded leading-tight focus:outline-none focus:shadow-outline">
                                        <option value="1"
                                            {{ isset($components['hero']['hero']['template']) && $components['hero']['hero']['template'] == '1' ? 'selected' : '' }}>
                                            {{ __('texts.template_1_full_width_bg') }}</option>
                                        <option value="2"
                                            {{ isset($components['hero']['hero']['template']) && $components['hero']['hero']['template'] == '2' ? 'selected' : '' }}>
                                            {{ __('texts.template_2_minimalist_solid_color') }}</option>
                                        <option value="3"
                                            {{ isset($components['hero']['hero']['template']) && $components['hero']['hero']['template'] == '3' ? 'selected' : '' }}>
                                            {{ __('texts.template_3_with_overlapping_image') }}</option>
                                    </select>
                                </div>

                                <div class="mb-2">
                                    <label for="hero_title"
                                        class="block text-gray-700 text-sm font-bold mb-1">{{ __('texts.main_title') }}</label>
                                    <input type="text" name="hero[title]" id="hero_title"
                                        value="{{ $components['hero']['hero']['title'] ?? '' }}"
                                        class="block w-full p-2 border rounded leading-tight focus:outline-none focus:shadow-outline">
                                </div>

                                <div class="mb-2">
                                    <label for="hero_secondaryTitle"
                                        class="block text-gray-700 text-sm font-bold mb-1">{{ __('texts.secondary_title') }}</label>
                                    <input type="text" name="hero[secondaryTitle]" id="hero_secondaryTitle"
                                        value="{{ $components['hero']['hero']['secondaryTitle'] ?? '' }}"
                                        class="block w-full p-2 border rounded leading-tight focus:outline-none focus:shadow-outline">
                                </div>

                                <div class="mb-4">
                                    <label for="hero_image"
                                        class="block text-gray-700 text-sm font-bold mb-1">{{ __('texts.image_url') }}</label>
                                    <p class="text-sm text-gray-600 mb-1">{{ __('texts.image_url_help') }}</p>
                                    <input type="url" name="hero[image]" id="hero_image"
                                        value="{{ $components['hero']['hero']['image'] ?? '' }}"
                                        class="block w-full p-2 border rounded leading-tight focus:outline-none focus:shadow-outline">
                                </div>
                            </div>
                        </div>

                        {{-- Introduction Component --}}
                        <div>
                            <input type="checkbox" name="components[intro]" id="components_intro"
                                {{ isset($components['intro']['intro']) ? 'checked' : '' }} class="mr-2">
                            <label for="components_intro"
                                class="text-gray-700 text-sm font-bold">{{ __('texts.introduction') }}</label>
                            <div id="intro_details"
                                style="{{ isset($components['intro']['intro']) ? '' : 'display:none;' }}">
                                <textarea name="intro[text]" id="intro_text" placeholder="{{ __('texts.introduction_text') }}"
                                    class="block w-full mb-2 p-2 text-gray-700 border rounded leading-tight focus:outline-none focus:shadow-outline"
                                    style="height: 150px; resize: vertical; background-color: #fff; border-color: #d1d5db;">{{ $components['intro']['intro']['text'] ?? '' }}</textarea>
                            </div>
                        </div>


                        {{-- Highlighted Ads Component --}}
                        <div>
                            <input type="checkbox" name="components[highlighted_ads]" id="components_highlighted_ads"
                                {{ isset($components['highlighted_ads']) ? 'checked' : '' }} class="mr-2">
                            <label for="components_highlighted_ads">{{ __('texts.featured_ads') }}</label>
                        </div>
                    </div>

                    <script>
                        document.getElementById('components_hero').addEventListener('change', function() {
                            document.getElementById('hero_details').style.display = this.checked ? '' : 'none';
                        });
                        document.getElementById('components_intro').addEventListener('change', function() {
                            document.getElementById('intro_details').style.display = this.checked ? '' : 'none';
                        });
                        // Add similar JavaScript for other components as necessary
                    </script>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">{{ __('texts.update') }}</button>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
