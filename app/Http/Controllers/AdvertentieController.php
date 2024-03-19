<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Advertentie;
use Illuminate\Support\Facades\Auth;

class AdvertentieController extends Controller
{
    public function index()
    {
        $advertenties = Advertentie::all();
        return view('advertenties.index', compact('advertenties'));
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
}
