<?php

namespace App\Http\Controllers;

// Import necessary classes
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Http\Request;
use App\Models\Contract;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;

class ContractController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $contracts = Contract::where('user_id_one', $user->id)
            ->orWhere('user_id_two', $user->id)
            ->get();

        $allContracts = $user->hasRole('Admin') ? Contract::all() : null;

        return view('contracts.index', [
            'contracts' => $contracts,
            'allContracts' => $allContracts
        ]);
    }


    public function download($id)
    {
        $contract = Contract::findOrFail($id);

        // Controleer of de ingelogde gebruiker een admin is of deel uitmaakt van het contract
        $user = Auth::user();
        if (!$user->hasRole('Admin') && $user->id !== $contract->user_id_one && $user->id !== $contract->user_id_two) {
            return redirect()->back()->with('error', 'Je hebt geen toestemming om dit contract te downloaden.');
        }

        // Aannemende dat $contractDate een datumstring is, bijvoorbeeld "2024-03-20"
        $contractDate = Carbon::parse($contract->contract_date);
        // Gegevens voor de PDF
        $data = [
            'userOne' => $contract->userOne, // Zorg ervoor dat je relaties goed zijn gedefinieerd in je modellen
            'userTwo' => $contract->userTwo,
            'description' => $contract->description,
            'contractDate' => $contractDate,
            'status' => $contract->status,
            'additionalInfo' => $contract->additional_info,
        ];

        $pdf = PDF::loadView('contracts.template', $data);

        // Geef een passende naam aan je PDF-bestand
        return $pdf->download('contract-' . $contract->id . '.pdf');
    }



    public function create()
    {
        $users = User::all(); // Haal alle gebruikers op
        return view('contracts.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id_one' => 'required|different:user_id_two',
            'user_id_two' => 'required|different:user_id_one',
            'description' => 'required|string',
            'contract_date' => 'required|date|after_or_equal:today',
            'status' => 'required|string',
            'additional_info' => 'nullable|string',
        ]);


        Contract::create($validatedData);

        return redirect()->route('contracts.index')->with('success', 'Contract succesvol opgeslagen.');
    }


}
