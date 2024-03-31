<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Advertisement;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use League\Csv\Reader;

class AdvertisementController extends Controller
{
    public function index(Request $request)
    {
        // Bouw de query op basis van de filter- en sorteerinput
        $query = Advertisement::query();

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
            'begin_huur' => 'nullable|date',
            'eind_huur' => 'nullable|date',
        ]);

        $path = $request->file('image') ? $request->file('image')->store('afbeeldingen', 'public') : null;

        Advertisement::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'type' => $request->type,
            'image_path' => $path,
            'user_id' => Auth::id(),
            'begin_huur' => $validatedData['begin_huur'] ?? null,
            'eind_huur' => $validatedData['eind_huur'] ?? null,
        ]);

        return redirect()->route('advertenties.index')->with('success', 'Advertentie succesvol aangemaakt!');
    }

    public function edit()
    {

    }

    public function update(Request $request)
    {

    }

    public function rentalOverview()
    {
        $user = Auth::user();
        $rentals = Advertisement::where('renter_id', $user->id)
                                ->whereNotNull('begin_huur')
                                ->whereNotNull('eind_huur')
                                ->orderBy('begin_huur', 'desc')
                                ->get();

        return view('advertenties.rentaloverview', compact('rentals'));          
    }

    public function purchase($advertisementId)
    {
        $user = Auth::user(); 
        $advertisement = Advertisement::findOrFail($advertisementId); 

        if ($advertisement->user_id == $user->id) {
            return back()->with('error', 'Je kunt je eigen advertenties niet kopen.');
        }

        if ($advertisement->purchasers->count() > 0) {
            return back()->with('error', 'Deze advertentie is al verkocht.');
        }

        $user->purchasedAdvertisements()->attach($advertisement);
        return redirect()->route('advertisements.index')->with('success', 'Advertentie succesvol gekocht.');
    }

    public function rent(Request $request, $advertisementId)
    {
        
        $advertisement = Advertisement::findOrFail($advertisementId);
        $user = $advertisement->user;

        if ($advertisement->type !== 'Verhuur') {
            return back()->with('error', 'Deze advertentie kan niet gehuurd worden.');
        }

        $request->validate([
            'begin_huur' => 'required|date|after_or_equal:today',
            'eind_huur' => 'required|date|after:begin_huur',
            'renter_id' => 'required',
        ]);

        $beginHuur = Carbon::parse($request->begin_huur);
        $eindHuur = Carbon::parse($request->eind_huur);

        if ($advertisement->begin_huur && $advertisement->eind_huur) {
            $bestaandeBeginHuur = Carbon::parse($advertisement->begin_huur);
            $bestaandeEindHuur = Carbon::parse($advertisement->eind_huur);
            if ($beginHuur->between($bestaandeBeginHuur, $bestaandeEindHuur) || 
                $eindHuur->between($bestaandeBeginHuur, $bestaandeEindHuur)) {
                return back()->with('error', 'Deze advertentie is al gehuurd voor de opgegeven periode.');
            }
        }

        $advertisement->update([
            'renter_id' => Auth::id(),
            'begin_huur' => $beginHuur,
            'eind_huur' => $eindHuur,
        ]);

        $user->purchasedAdvertisements()->attach($advertisement);
        return redirect()->route('advertisements.index')->with('success', 'De advertentie is succesvol gehuurd voor de opgegeven periode.');
    }

    public function returnProduct(Request $request, $advertisementId)
    {
        $request->validate([
            'return_photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = Auth::user();
        $advertisement = Advertisement::findOrFail($advertisementId);

        if ($advertisement->renter_id !== $user->id) {
            return back()->with('error', 'Je kunt alleen je eigen advertenties retourneren.');
        }

        $path = $request->file('return_photo')->store('afbeeldingen', 'public');

        $advertisement->update([
            'return_photo_path' => $path,
            'begin_huur' => null,
            'eind_huur' => null,
            'renter_id' => null,
        ]);

        return redirect()->route('advertisements.index')->with('success', 'Advertentie succesvol geretourneerd.');
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
