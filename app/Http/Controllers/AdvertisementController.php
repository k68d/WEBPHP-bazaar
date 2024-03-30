<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Advertisement;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Validator;
use League\Csv\Reader;

class AdvertisementController extends Controller
{
    public function index(Request $request)
    {
        // Bouw de query op basis van de filter- en sorteerinput
        $query = Advertisement::query();
        Advertisement::factory(1)->create();

        // Als er een filter voor de titel is opgegeven
        if ($request->filled('filter_titel')) {
            $query->where('titel', 'like', '%' . $request->filter_titel . '%');
        }

        // Sorteer de resultaten
        if ($request->filled('sorteer')) {
            switch ($request->sorteer) {
                case 'titel_asc':
                    $query->orderBy('titel', 'asc');
                    break;
                case 'titel_desc':
                    $query->orderBy('titel', 'desc');
                    break;
                case 'prijs_laag':
                    $query->orderBy('prijs', 'asc');
                    break;
                case 'prijs_hoog':
                    $query->orderBy('prijs', 'desc');
                    break;
            }
        }

        // Voer de query uit met paginatie
        $advertenties = $query->paginate(20)->withQueryString();
        return view('advertenties.index', compact('advertenties'));
    }


    public function show(Request $request, $id)
    {
        $advertentie = Advertisement::findOrFail($id);

        // Het genereren van een QR-code voor de advertentie.
        $qrCode = QrCode::size(200)->generate(route('advertenties.show', $advertentie->id));

        // Check of de advertentie al een favoriet is van de gebruiker.
        $isFavorite = false;
        if ($user = $request->user()) {
            $isFavorite = $user->favorites()->where('advertisement_id', $advertentie->id)->exists();
        }

        return view('advertenties.show', compact('advertentie', 'qrCode', 'isFavorite'));
    }


    public function create()
    {
        return view('advertenties.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'type' => 'required|in:Verkoop,Verhuur',
            'image' => 'image|nullable',
        ]);

        $path = $request->file('image') ? $request->file('image')->store('afbeeldingen', 'public') : null;

        Advertisement::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'type' => $request->type,
            'image_path' => $path,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('advertenties.index')->with('success', 'Advertentie succesvol aangemaakt!');
    }

    public function edit()
    {

    }

    public function update(Request $request)
    {

    }

    public function destroy()
    {

    }

    public function purchase($advertisementId)
    {
        $user = Auth::user(); // Haal de momenteel ingelogde gebruiker op
        $advertisement = Advertisement::findOrFail($advertisementId); // Vind de advertentie of gooi een fout als deze niet bestaat

        // Controleer of de ingelogde gebruiker niet de eigenaar is van de advertentie
        if ($advertisement->user_id == $user->id) {
            return back()->with('error', 'Je kunt je eigen advertenties niet kopen.');
        }

        if ($advertisement->purchasers->count() > 0) {
            return back()->with('error', 'Deze advertentie is al verkocht.');
        }

        // Voeg de advertentie toe aan de gekochte advertenties van de gebruiker
        $user->purchasedAdvertisements()->attach($advertisement);

        return redirect()->route('advertisements.index')->with('success', 'Advertentie succesvol gekocht.');
    }

    public function showUploadForm()
    {
        return view('advertenties.upload');
    }

    public function processCsvUpload(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048', // Verifieer dat het een CSV-bestand is.
        ]);

        $path = $request->file('csv_file')->getRealPath();
        $csv = Reader::createFromPath($path, 'r');
        $csv->setHeaderOffset(0); // Stel de eerste rij van CSV in als header.

        $records = $csv->getRecords(); // Haal de records uit het CSV-bestand.

        $advertentieIds = [];
        foreach ($records as $record) {
            // Voer validatie uit op elk record voordat je het opslaat
            $validatedData = Validator::make($record, [
                'titel' => 'required|string|max:255',
                'beschrijving' => 'required|string',
                'prijs' => 'required|numeric',
                'type' => 'required|in:normaal,verhuur',
            ])->validate();

            // Maak een nieuwe advertentie aan met het gevalideerde record
            $advertentie = Advertisement::create([
                'titel' => $validatedData['titel'],
                'beschrijving' => $validatedData['beschrijving'],
                'prijs' => $validatedData['prijs'],
                'type' => $validatedData['type'],
                'user_id' => auth()->id(), // Zorg dat je de geauthenticeerde gebruiker's ID opslaat.
            ]);

            // Sla de ID van de nieuwe advertentie op voor latere weergave
            $advertentieIds[] = $advertentie->id;
        }

        // Sla de IDs op in de sessie voor weergave op de overzichtspagina
        session(['uploaded_advertenties' => $advertentieIds]);

        // Redirect naar de overzichtspagina
        return redirect()->route('advertenties.upload.overview');
    }


    public function showUploadOverview()
    {
        $advertentieIds = session('uploaded_advertenties', []);
        $advertenties = Advertisement::whereIn('id', $advertentieIds)->get();

        return view('advertenties.overview', compact('advertenties'));
    }

    public function uploadImages(Request $request)
    {
        $request->validate([
            'afbeeldingen.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        foreach ($request->afbeeldingen as $advertentieId => $afbeelding) {
            $path = $afbeelding->store('afbeeldingen', 'public');

            $advertentie = Advertisement::find($advertentieId);
            if ($advertentie) {
                $advertentie->update(['afbeelding_path' => $path]);
            }
        }

        return redirect()->route('advertenties.index')->with('success', 'Alle afbeeldingen zijn succesvol geüpload.');
    }



    public function getUserAdvertenties(Request $request)
    {
        $user = $request->user();
        if (!$user->api_access) {
            return response()->json(['message' => 'No endpoint.'], 403);
        }
        $advertenties = $user->advertenties()->get();

        return response()->json($advertenties);
    }

    public function GetAdvertentie(Request $request, $advertentieId)
    {
        $user = $request->user();
        if (!$user->api_access) {
            return response()->json(['message' => 'No endpoint.'], 403);
        }
        $advertentie = $user->advertenties()->find($advertentieId);

        if (!$advertentie) {
            return response()->json(['message' => 'Advertentie not found.'], 404);
        }

        return response()->json($advertentie);
    }
}
