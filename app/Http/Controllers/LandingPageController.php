<?php

namespace App\Http\Controllers;

use App\Models\PageSetting;
use App\Models\Advertentie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LandingPageController extends Controller
{
    // Toont een formulier voor het creëren van een nieuwe landingpagina
    public function create()
    {
        // Toon het formulier voor het aanmaken van nieuwe pagina-instellingen
        return view('landingpage.create');
    }


    public function store(Request $request)
    {
        // Definieer de validatieregels
        $rules = [
            'page_url' => 'required|unique:page_settings,page_url',
            'palette.background' => 'nullable|string',
            'palette.text' => 'nullable|string',
            'palette.primary' => 'nullable|string',
            'palette.secondary' => 'nullable|string',
            'palette.accent' => 'nullable|string',
            'text_style.font' => 'nullable|string',
            'text_style.size' => 'nullable|numeric',
            'components.hero' => 'nullable',
            'hero.template' => 'nullable|required_if:components.hero,on|in:1,2,3',
            'hero.title' => 'nullable|required_if:components.hero,on|string|max:255',
            'hero.secondaryTitle' => 'nullable|string|max:255',
            'hero.image' => 'nullable|url',
            'components.intro' => 'nullable',
            'intro.text' => 'nullable|required_if:components.intro,on|string|max:1000',
            'components.highlighted_ads' => 'nullable',
        ];


        // Voer validatie uit
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {

            return redirect('landingpage-settings/create')
                ->withErrors($validator)
                ->withInput();
        }

        // Haal gevalideerde data op
        $validatedData = $validator->validated();

        // Bereid componenten data voor
        $componentsData = $this->prepareComponentsData($request);

        // Sla de pagina-instellingen op met gestructureerde componenten data
        $test = PageSetting::create([
            'user_id' => Auth::id(),
            'page_url' => $validatedData['page_url'],
            'palette' => isset ($validatedData['palette']) ? json_encode($request->input('palette')) : null,
            'text_style' => isset ($validatedData['text_style']) ? json_encode($request->input('text_style')) : null,
            'components' => $componentsData ? json_encode($componentsData) : null,
        ]);

        return redirect()->route('dashboard')->with('success', 'Pagina-instellingen succesvol opgeslagen.');
    }

    protected function prepareComponentsData(Request $request)
    {
        $componentsData = [];

        if ($request->input('components.hero')) {
            $componentsData['hero'] = $request->only([
                'hero.template',
                'hero.title',
                'hero.secondaryTitle',
                'hero.image'
            ]);
        }

        if ($request->input('components.intro')) {
            $componentsData['intro'] = $request->only(['intro.text']);
        }

        if ($request->input('components.highlighted_ads')) {
            // Indicator dat deze component is ingeschakeld
            $componentsData['highlighted_ads'] = true;
        }

        return $componentsData;
    }

    public function show(Request $request, $url)
    {
        // Vind de pagina-instellingen op basis van de ingevoerde URL
        $pageSetting = PageSetting::where('page_url', $url)->firstOrFail();

        // Decodeer de JSON-velden naar arrays
        $pageSetting->palette = json_decode($pageSetting->palette, true);
        $pageSetting->text_style = json_decode($pageSetting->text_style, true);
        $pageSetting->components = json_decode($pageSetting->components, true);

        // Bereid data voor dynamische componenten voor
        $componentsData = [];
        foreach ($pageSetting->components as $component => $details) {
            if ($component === 'highlighted_ads' && $details === true) {
                // Ophalen van uitgelichte advertenties uit de database als 'highlighted_ads' actief is
                $componentsData['highlighted_ads'] = $this->getHighlightedAdsData();
            } else {
                // Voor andere componenten, direct de details toewijzen
                $componentsData[$component] = $details[$component] ?? $details;
            }
        }

        return view('landingpage.show', ['pageSetting' => $pageSetting, 'componentsData' => $componentsData]);
    }

    protected function getHighlightedAdsData()
    {
        return Advertentie::where('user_id', Auth::id())->get();
    }

}

