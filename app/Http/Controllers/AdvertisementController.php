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
use Illuminate\Support\Str;

class AdvertisementController extends Controller
{
    public function index(Request $request)
    {
        $query = Advertisement::query();

        if ($request->filled('filter_titel')) {
            $query->where('title', 'like', '%' . $request->filter_titel . '%');
        }

        // Sorteer de resultaten
        if ($request->filled('sorteer')) {
            switch ($request->sorteer) {
                case 'titel_asc':
                    $query->orderBy('title', 'asc');
                    break;
                case 'titel_desc':
                    $query->orderBy('title', 'desc');
                    break;
                case 'prijs_laag':
                    $query->orderBy('price', 'asc');
                    break;
                case 'prijs_hoog':
                    $query->orderBy('price', 'desc');
                    break;
            }
        }

        $advertenties = $query->paginate(20)->withQueryString();
        return view('advertenties.index', compact('advertenties'));
    }

    public function highlightAd(Request $request, $advertisementId)
    {
        $user = $request->user();
        $user->highlightedAds()->attach($advertisementId);
        return back()->with('success', 'Advertentie succesvol gehighlight.');
    }

    public function removeHighlight(Request $request, $advertisementId)
    {
        $user = $request->user();
        $user->highlightedAds()->detach($advertisementId);
        return back()->with('success', 'Highlight van advertentie succesvol verwijderd.');
    }


    public function show(Request $request, $id)
    {
        $advertentie = Advertisement::findOrFail($id);

        $qrCode = QrCode::size(200)->generate(route('advertenties.show', $advertentie->id));

        $isFavorite = false;
        if ($user = $request->user()) {
            $isFavorite = $user->favorites()->where('advertisement_id', $advertentie->id)->exists();
        }

        $isHighlighted = false;
        if ($user) {
            $isHighlighted = $user->highlightedAds()->where('advertisement_id', $advertentie->id)->exists();
        }

        $linkedAd = null;
        if ($advertentie->link_ad) {
            $linkedAd = Advertisement::find($advertentie->link_ad);
        }

        return view('advertenties.show', compact('advertentie', 'qrCode', 'isFavorite', 'linkedAd', 'isHighlighted'));
    }


    public function create()
    {
        $otherAds = Advertisement::where('user_id', '!=', auth()->id())->get();
        $verkoopCount = Advertisement::where('user_id', auth()->id())
            ->where('type', 'Verkoop')
            ->count();

        $verhuurCount = Advertisement::where('user_id', auth()->id())
            ->where('type', 'Verhuur')
            ->count();
        if (($verhuurCount + $verkoopCount) >= 8) {
            return redirect()->back()->with('error', 'Je hebt het maximumaantal advertenties van het type gekregen');
        }
        return view('advertenties.create', compact('otherAds', 'verkoopCount', 'verhuurCount'));

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
            'link_ad' => 'nullable|uuid|exists:advertisements,id',
        ]);

        $path = $request->file('image') ? $request->file('image')->store('afbeeldingen', 'public') : null;

        Advertisement::create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'type' => $request->type,
            'image_path' => $path,
            'user_id' => Auth::id(),
            'begin_huur' => null,
            'eind_huur' => null,
        ]);

        return redirect()->route('advertenties.index')->with('success', 'Advertentie succesvol aangemaakt!');
    }

    public function rentalOverview()
    {
        $user = Auth::user();
        $rentals = Advertisement::where('user_id', $user->id)
            ->whereNotNull('begin_huur')
            ->whereNotNull('eind_huur')
            ->orderBy('begin_huur', 'desc')
            ->get();

        return view('advertenties.rentaloverview', compact('rentals'));
    }

    public function rentedOverview()
    {
        $rentals = Advertisement::where('renter_id', Auth::id())
            ->whereNotNull('begin_huur')
            ->whereNotNull('eind_huur')
            ->orderBy('begin_huur', 'desc')
            ->get();

        return view('advertenties.rentedOverview', compact('rentals'));
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

        $currentRentals = $user->rentedAdvertisements()->count();
        if ($currentRentals >= 4) {
            return back()->with('error', 'Je hebt al het maximum aantal van 4 artikelen gehuurd.');
        }

        $request->validate([
            'begin_huur' => 'required|date|after_or_equal:today',
            'eind_huur' => 'required|date|after:begin_huur',
        ]);

        $beginHuur = Carbon::parse($request->begin_huur);
        $eindHuur = Carbon::parse($request->eind_huur);

        if ($advertisement->begin_huur && $advertisement->eind_huur) {
            $bestaandeBeginHuur = Carbon::parse($advertisement->begin_huur);
            $bestaandeEindHuur = Carbon::parse($advertisement->eind_huur);
            if (
                $beginHuur->between($bestaandeBeginHuur, $bestaandeEindHuur) ||
                $eindHuur->between($bestaandeBeginHuur, $bestaandeEindHuur)
            ) {
                return back()->with('error', 'Deze advertentie is al gehuurd voor de opgegeven periode.');
            }
        }

        $advertisement->update([
            'renter_id' => Auth::id(),
            'begin_huur' => $beginHuur,
            'eind_huur' => $eindHuur,
            'return_photo_path' => null,
            'wear_level' => null,
        ]);

        $user->purchasedAdvertisements()->attach($advertisement);
        return redirect()->route('advertisements.index')->with('success', 'De advertentie is succesvol gehuurd voor de opgegeven periode.');
    }

    public function returnProduct(Request $request, $advertisementId)
    {
        $request->validate([
            'return_photo' => 'required|image',
            'wear_level' => 'required|string',
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
            'wear_level' => $request->wear_level,
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
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        $path = $request->file('csv_file')->getRealPath();
        $csv = Reader::createFromPath($path, 'r');
        $csv->setHeaderOffset(0);

        $records = $csv->getRecords();
        $advertentieIds = [];
        foreach ($records as $record) {
            // Normaliseer de record sleutels en waarden
            $record = $this->normalizeData($record);

            $validatedData = Validator::make($record, [
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric',
                'type' => 'required|in:Verkoop,Verhuur',
            ])->validate();

            $advertentie = Advertisement::create([
                'title' => $validatedData['title'],
                'description' => $validatedData['description'],
                'price' => $validatedData['price'],
                'type' => $validatedData['type'],
                'user_id' => auth()->id(),
            ]);

            $advertentieIds[] = $advertentie->id;
        }

        session(['uploaded_advertenties' => $advertentieIds]);

        return redirect()->route('advertenties.upload.overview');
    }

    protected function normalizeData($record)
    {
        $fieldsMapping = [
            'titel' => 'title',
            'beschrijving' => 'description',
            'prijs' => 'price',
            'type' => 'type',
        ];

        $typeValues = [
            'sale' => 'Verkoop',
            'rent' => 'Verhuur',
            'verkoop' => 'Verkoop',
            'verhuur' => 'Verhuur',
        ];

        $normalizedRecord = [];
        foreach ($record as $key => $value) {
            // Sleutelnaam normaliseren
            $normalizedKey = $fieldsMapping[strtolower($key)] ?? strtolower($key);
            // Waarde normaliseren
            $normalizedValue = $normalizedKey === 'type' ? $typeValues[strtolower($value)] ?? $value : ucfirst(strtolower($value));
            $normalizedRecord[$normalizedKey] = $normalizedValue;
        }

        return $normalizedRecord;
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
