<?php

namespace App\Http\Controllers;

// Import necessary classes
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Http\Request;
use App\Models\Contract;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class ContractController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::user();

        // Filters en sortering voor alle contracten
        $allContractsQuery = Contract::query();
        if ($request->filled('all_filter_name')) {
            $allContractsQuery->whereHas('userOne', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->all_filter_name . '%');
            })->orWhereHas('userTwo', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->all_filter_name . '%');
            });
        }
        if ($request->filled('all_sort')) {
            $allContractsQuery->orderBy('contract_date', $request->all_sort == 'date_asc' ? 'asc' : 'desc');
        }
        $allContracts = $user->hasRole('Admin') ? $allContractsQuery->paginate(10, ['*'], 'allContractsPage')->withQueryString() : null;

        // Filters en sortering voor betrokken contracten
        $contractsQuery = Contract::where('user_id_one', $user->id)->orWhere('user_id_two', $user->id);
        if ($request->filled('involved_filter_name')) {
            $contractsQuery->whereHas('userOne', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->involved_filter_name . '%');
            })->orWhereHas('userTwo', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->involved_filter_name . '%');
            });
        }
        if ($request->filled('involved_sort')) {
            $contractsQuery->orderBy('contract_date', $request->involved_sort == 'date_asc' ? 'asc' : 'desc');
        }
        $contracts = $contractsQuery->paginate(10, ['*'], 'contractsPage')->withQueryString();

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
        $users = User::all();
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

    public function edit($id)
    {
        $contract = Contract::findOrFail($id);
        $users = User::all();
        return view('contracts.edit', compact('contract', 'users'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'user_id_one' => 'required|different:user_id_two',
            'user_id_two' => 'required|different:user_id_one',
            'description' => 'required|string',
            'contract_date' => 'required|date|after_or_equal:today',
            'status' => 'required|string',
            'additional_info' => 'nullable|string',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $contract = Contract::findOrFail($id);
        $contract->update($request->all());

        return redirect()->route('contracts.index')->with('success', 'Contract updated successfully.');
    }

    public function destroy($id)
    {
        $contract = Contract::findOrFail($id);
        $contract->delete();

        return redirect()->route('contracts.index')->with('success', 'Contract deleted successfully.');
    }


}
