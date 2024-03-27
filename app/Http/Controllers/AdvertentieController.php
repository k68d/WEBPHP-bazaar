<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Advertentie;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Validator;
use League\Csv\Reader;

class AdvertentieController extends Controller
{
    public function index()
    {
        $advertenties = Advertentie::all();
        return view('advertenties.index', compact('advertenties'));
    }


    public function show($id)
    {
        $advertentie = Advertentie::find($id);
        if (!$advertentie) {
            abort(404);
        }

        $qrCode = QrCode::size(200)->generate(route('advertenties.show', $advertentie->id));

        return view('advertenties.show', compact('advertentie', 'qrCode'));
    }


    public function create()
    {
        return view('advertenties.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titel' => 'required',
            'beschrijving' => 'required',
            'prijs' => 'required|numeric',
            'type' => 'required|in:normaal,verhuur',
            'afbeelding' => 'image|nullable',
        ]);

        $path = $request->file('afbeelding') ? $request->file('afbeelding')->store('afbeeldingen', 'public') : null;

        Advertentie::create([
            'titel' => $request->titel,
            'beschrijving' => $request->beschrijving,
            'prijs' => $request->prijs,
            'type' => $request->type,
            'afbeelding_path' => $path,
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
            $advertentie = Advertentie::create([
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
        $advertenties = Advertentie::whereIn('id', $advertentieIds)->get();

        return view('advertenties.overview', compact('advertenties'));
    }

    public function uploadImages(Request $request)
    {
        $request->validate([
            'afbeeldingen.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        foreach ($request->afbeeldingen as $advertentieId => $afbeelding) {
            $path = $afbeelding->store('afbeeldingen', 'public');

            $advertentie = Advertentie::find($advertentieId);
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
