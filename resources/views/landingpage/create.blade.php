<x-app-layout>
    <div class="container mx-auto p-4">
        <div class="flex flex-wrap">
            <div id="menu" class="w-full lg:w-1/2 p-4">
                <form action="{{ route('landingpage-settings.store') }}" method="POST">
                    @csrf
                    <!-- URL Field -->
                    <div class="mb-4">
                        <label for="page_url"
                            class="block text-white text-sm font-bold mb-2">{{ __('texts.page_url') }}</label>
                        <input type="text" name="page_url" id="page_url" value="{{ old('page_url') }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-white leading-tight focus:outline-none focus:shadow-outline">
                        @error('page_url')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Color Palette Fields -->
                    <div class="mb-4">
                        <div class="block text-white text-sm font-bold mb-2">{{ __('texts.color_palette') }}</div>
                        <div class="flex flex-wrap -mx-2">
                            <!-- Background Color -->
                            <div class="px-2 w-1/2 md:w-1/4">
                                <label for="palette_background"
                                    class="block text-xs font-bold mb-1">{{ __('texts.background') }}</label>
                                <input type="color" name="palette[background]" id="palette_background"
                                    value="{{ old('palette.background', '#ffffff') }}" class="mb-2 w-full">
                                <span id="background_swatch" class="inline-block w-6 h-6 border"
                                    style="background-color: {{ old('palette.background', '#ffffff') }};"></span>
                                @error('palette.background')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Text Color -->
                            <div class="px-2 w-1/2 md:w-1/4">
                                <label for="palette_text"
                                    class="block text-xs font-bold mb-1">{{ __('texts.text') }}</label>
                                <input type="color" name="palette[text]" id="palette_text"
                                    value="{{ old('palette.text', '#000000') }}" class="mb-2 w-full">
                                <span id="text_swatch" class="inline-block w-6 h-6 border"
                                    style="background-color: {{ old('palette.text', '#000000') }};"></span>
                                @error('palette.text')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Primary Color -->
                            <div class="px-2 w-1/2 md:w-1/4">
                                <label for="palette_primary"
                                    class="block text-xs font-bold mb-1">{{ __('texts.primary') }}</label>
                                <input type="color" name="palette[primary]" id="palette_primary"
                                    value="{{ old('palette.primary', '#007bff') }}" class="mb-2 w-full">
                                <span id="primary_swatch" class="inline-block w-6 h-6 border"
                                    style="background-color: {{ old('palette.primary', '#007bff') }};"></span>
                                @error('palette.primary')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Secondary Color -->
                            <div class="px-2 w-1/2 md:w-1/4">
                                <label for="palette_secondary"
                                    class="block text-xs font-bold mb-1">{{ __('texts.secondary') }}</label>
                                <input type="color" name="palette[secondary]" id="palette_secondary"
                                    value="{{ old('palette.secondary', '#6c757d') }}" class="mb-2 w-full">
                                <span id="secondary_swatch" class="inline-block w-6 h-6 border"
                                    style="background-color: {{ old('palette.secondary', '#6c757d') }};"></span>
                                @error('palette.secondary')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Accent Color -->
                            <div class="px-2 w-1/2 md:w-1/4">
                                <label for="palette_accent"
                                    class="block text-xs font-bold mb-1">{{ __('texts.accent') }}</label>
                                <input type="color" name="palette[accent]" id="palette_accent"
                                    value="{{ old('palette.accent', '#17a2b8') }}" class="mb-2 w-full">
                                <span id="accent_swatch" class="inline-block w-6 h-6 border"
                                    style="background-color: {{ old('palette.accent', '#17a2b8') }};"></span>
                                @error('palette.accent')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Text Style Fields -->
                    <div class="mb-4">
                        <label for="text_style_font"
                            class="block text-white text-sm font-bold mb-2">{{ __('texts.lettertype') }}</label>
                        <input type="text" name="text_style[font]" id="text_style_font"
                            placeholder="{{ __('texts.lettertype') }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-white leading-tight focus:outline-none focus:shadow-outline"
                            value="{{ old('text_style.font') }}" required>

                        <label for="text_style_size"
                            class="block text-white text-sm font-bold mb-2 mt-4">{{ __('texts.lettergrootte') }}</label>
                        <input type="number" name="text_style[size]" id="text_style_size"
                            placeholder="{{ __('texts.lettergrootte') }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-white leading-tight focus:outline-none focus:shadow-outline"
                            value="{{ old('text_style.size') }}" required>
                    </div>

                    <!-- Components Selection and Settings -->
                    <div class="mb-4">
                        <label
                            class="block text-white text-sm font-bold mb-2">{{ __('texts.select_components') }}</label>

                        <!-- Hero Component Choice -->
                        <div>
                            <input type="checkbox" name="components[hero]" id="components_hero"
                                {{ old('components.hero') ? 'checked' : '' }} class="mr-2">
                            <label for="components_hero" class="mb-2 text-white">{{ __('texts.hero') }}</label>
                            <div id="hero_details" style="{{ old('components.hero') ? '' : 'display:none;' }}">
                                <!-- Hero Template Choice -->
                                <div class="mb-2">
                                    <label for="hero_template"
                                        class="block text-white text-sm font-bold mb-1">{{ __('texts.hero_template') }}</label>
                                    <select name="hero[template]" id="hero_template"
                                        class="block appearance-none w-full p-2 border rounded leading-tight focus:outline-none focus:shadow-outline">
                                        <option value="1">{{ __('texts.template_1_full_width_bg') }}</option>
                                        <option value="2">{{ __('texts.template_2_minimalist_solid_color') }}
                                        </option>
                                        <option value="3">{{ __('texts.template_3_with_overlapping_image') }}
                                        </option>
                                    </select>
                                </div>

                                <!-- Main Title -->
                                <div class="mb-2">
                                    <label for="hero_title"
                                        class="block text-white text-sm font-bold mb-1">{{ __('texts.main_title') }}</label>
                                    <input type="text" name="hero[title]" id="hero_title"
                                        placeholder="{{ __('texts.main_title') }}" value="{{ old('hero.title') }}"
                                        class="block w-full p-2 border rounded leading-tight focus:outline-none focus:shadow-outline">
                                </div>

                                <!-- Secondary Title -->
                                <div class="mb-2">
                                    <label for="hero_secondaryTitle"
                                        class="block text-white text-sm font-bold mb-1">{{ __('texts.secondary_title') }}</label>
                                    <input type="text" name="hero[secondaryTitle]" id="hero_secondaryTitle"
                                        placeholder="{{ __('texts.secondary_title') }}"
                                        value="{{ old('hero.secondaryTitle') }}"
                                        class="block w-full p-2 border rounded leading-tight focus:outline-none focus:shadow-outline">
                                </div>

                                <!-- Image URL Explanation -->
                                <div class="mb-4">
                                    <label for="hero_image"
                                        class="block text-white text-sm font-bold mb-1">{{ __('texts.image_url') }}</label>
                                    <p class="text-sm text-white mb-1">{{ __('texts.image_url_help') }}</p>
                                    <input type="url" name="hero[image]" id="hero_image"
                                        placeholder="https://example.com/image.jpg" value="{{ old('hero.image') }}"
                                        class="block w-full p-2 border rounded leading-tight focus:outline-none focus:shadow-outline">
                                </div>
                            </div>
                        </div>

                        <script>
                            document.getElementById('components_hero').addEventListener('change', function() {
                                document.getElementById('hero_details').style.display = this.checked ? '' : 'none';
                            });
                        </script>

                        <!-- Introduction Component -->
                        <div>
                            <input type="checkbox" name="components[intro]" id="components_intro"
                                {{ old('components.intro') ? 'checked' : '' }} class="mr-2">
                            <label for="components_intro"
                                class="mb-2 text-white">{{ __('texts.introduction') }}</label>
                            <div id="intro_details" style="{{ old('components.intro') ? '' : 'display:none;' }}">
                                <textarea name="intro[text]" placeholder="{{ __('texts.introduction_text') }}" class="block w-full mb-2"></textarea>
                            </div>
                        </div>

                        <!-- Featured Ads Component -->
                        <div>
                            <input type="checkbox" name="components[highlighted_ads]" id="components_highlighted_ads"
                                {{ old('components.highlighted_ads') ? 'checked' : '' }} class="mr-2">
                            <label for="components_highlighted_ads"
                                class="mb-2 text-white">{{ __('texts.featured_ads') }}</label>
                        </div>
                    </div>

                    <script>
                        document.getElementById('components_hero').addEventListener('change', function() {
                            document.getElementById('hero_details').style.display = this.checked ? '' : 'none';
                        });
                        document.getElementById('components_intro').addEventListener('change', function() {
                            document.getElementById('intro_details').style.display = this.checked ? '' : 'none';
                        });
                    </script>

                    <!-- Save Button -->
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">{{ __('texts.save') }}</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
