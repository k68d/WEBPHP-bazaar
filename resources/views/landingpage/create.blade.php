<x-app-layout>
    <div class="container mx-auto p-4">
        <div class="flex flex-wrap">
            <div id="menu" class="w-full lg:w-1/2 p-4">
                <form action="{{ route('landingpage-settings.store') }}" method="POST">
                    @csrf
                    <!-- URL veld -->
                    <div class="mb-4">
                        <label for="page_url" class="block text-gray-700 text-sm font-bold mb-2">Pagina URL:</label>
                        <input type="text" name="page_url" id="page_url" value="{{ old('page_url') }}"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @error('page_url')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror

                    </div>

                    <!-- Kleurenpalet velden -->
                    <div class="mb-4">
                        <div class="block text-gray-700 text-sm font-bold mb-2">Color Palette:</div>
                        <div class="flex flex-wrap -mx-2">
                            <!-- Background Color -->
                            <div class="px-2 w-1/2 md:w-1/4">
                                <label for="palette_background" class="block text-xs font-bold mb-1">Background:</label>
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
                                <label for="palette_text" class="block text-xs font-bold mb-1">Text:</label>
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
                                <label for="palette_primary" class="block text-xs font-bold mb-1">Primary:</label>
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
                                <label for="palette_secondary" class="block text-xs font-bold mb-1">Secondary:</label>
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
                                <label for="palette_accent" class="block text-xs font-bold mb-1">Accent:</label>
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



                    <!-- Tekststijl velden -->
                    <div class="mb-4">
                        <label for="text_style_font"
                            class="block text-gray-700 text-sm font-bold mb-2">Lettertype:</label>
                        <input type="text" name="text_style[font]" id="text_style_font" placeholder="Bijv. Arial"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            value="{{ old('text_style.font') }}" required>

                        <label for="text_style_size"
                            class="block text-gray-700 text-sm font-bold mb-2 mt-4">Lettergrootte:</label>
                        <input type="number" name="text_style[size]" id="text_style_size" placeholder="16"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            value="{{ old('text_style.size') }}" required>
                    </div>


                    {{-- Componenten Selectie en Instellingen --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Selecteer Componenten:</label>

                        {{-- Hero Component Keuze --}}
                        <div>
                            <input type="checkbox" name="components[hero]" id="components_hero"
                                {{ old('components.hero') ? 'checked' : '' }} class="mr-2">
                            <label for="components_hero">Hero</label>
                            <div id="hero_details" style="{{ old('components.hero') ? '' : 'display:none;' }}">
                                <div class="mb-2">
                                    <label for="hero_template" class="block text-gray-700 text-sm font-bold mb-1">Hero
                                        Template:</label>
                                    <select name="hero[template]" id="hero_template"
                                        class="block appearance-none w-full p-2 border rounded leading-tight focus:outline-none focus:shadow-outline">
                                        <option value="1">Template 1: Volledige Breedte Achtergrond</option>
                                        <option value="2">Template 2: Minimalistisch met Solide Kleur</option>
                                        <option value="3">Template 3: Met Overlappende Afbeelding</option>
                                    </select>
                                </div>

                                <div class="mb-2">
                                    <label for="hero_title"
                                        class="block text-gray-700 text-sm font-bold mb-1">Hoofdtitel:</label>
                                    <input type="text" name="hero[title]" id="hero_title"
                                        placeholder="Hoofdtitel" value="{{ old('hero.title') }}"
                                        class="block w-full p-2 border rounded leading-tight focus:outline-none focus:shadow-outline">
                                </div>

                                <div class="mb-2">
                                    <label for="hero_secondaryTitle"
                                        class="block text-gray-700 text-sm font-bold mb-1">Secundaire Titel:</label>
                                    <input type="text" name="hero[secondaryTitle]" id="hero_secondaryTitle"
                                        placeholder="Secundaire Titel" value="{{ old('hero.secondaryTitle') }}"
                                        class="block w-full p-2 border rounded leading-tight focus:outline-none focus:shadow-outline">
                                </div>

                                {{-- Uitleg voor Afbeeldings URL --}}
                                <div class="mb-4">
                                    <label for="hero_image"
                                        class="block text-gray-700 text-sm font-bold mb-1">Afbeeldings URL:</label>
                                    <p class="text-sm text-gray-600 mb-1">Gebruik de volledige URL naar de afbeelding
                                        om te zorgen voor constante beschikbaarheid. Zorg ervoor dat de afbeelding
                                        publiekelijk toegankelijk is.</p>
                                    <input type="url" name="hero[image]" id="hero_image"
                                        placeholder="https://voorbeeld.com/afbeelding.jpg"
                                        value="{{ old('hero.image') }}"
                                        class="block w-full p-2 border rounded leading-tight focus:outline-none focus:shadow-outline">
                                </div>
                            </div>
                        </div>

                        <script>
                            document.getElementById('components_hero').addEventListener('change', function() {
                                document.getElementById('hero_details').style.display = this.checked ? '' : 'none';
                            });
                        </script>



                        {{-- Introductie Component --}}
                        <div>
                            <input type="checkbox" name="components[intro]" id="components_intro"
                                {{ old('components.intro') ? 'checked' : '' }} class="mr-2">
                            <label for="components_intro">Introductie</label>
                            <div id="intro_details" style="{{ old('components.intro') ? '' : 'display:none;' }}">
                                <textarea name="intro[text]" placeholder="Introductie Tekst" class="block w-full mb-2"></textarea>
                            </div>
                        </div>

                        {{-- Uitgelichte Advertenties Component --}}
                        <div>
                            <input type="checkbox" name="components[highlighted_ads]" id="components_highlighted_ads"
                                {{ old('components.highlighted_ads') ? 'checked' : '' }} class="mr-2">
                            <label for="components_highlighted_ads">Uitgelichte Advertenties</label>
                            {{-- Geen extra details vereist voor uitgelichte advertenties, worden automatisch geladen --}}
                        </div>
                    </div>

                    <script>
                        document.getElementById('components_hero').addEventListener('change', function() {
                            document.getElementById('hero_details').style.display = this.checked ? '' : 'none';
                        });
                        document.getElementById('components_intro').addEventListener('change', function() {
                            document.getElementById('intro_details').style.display = this.checked ? '' : 'none';
                        });
                        // Voeg soortgelijke JavaScript toe voor andere componenten indien nodig
                    </script>


                    <!-- Submit knop -->
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Opslaan</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
