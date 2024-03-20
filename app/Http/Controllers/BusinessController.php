<?php

namespace App\Http\Controllers;

// Import necessary classes
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Http\Request;
use App\Models\Advertentie;
use Illuminate\Support\Facades\Auth;

class BusinessController extends Controller
{

    public function showCreateForm()
    {
        $business = Auth::user();
        $advertenties = Advertentie::where('user_id', $business->id)->get();

        return view('/business/create_contract', compact('advertenties'));
    }

    public function createContract(Request $request)
    {
        $business = Auth::user();

        $clientName = $request->input('client_name');
        $clientEmail = $request->input('client_email');

        $advertentie = Advertentie::findOrFail($request->input('advertentie_id'));

        $date = now()->toDateString();

        // Generate the PDF using the provided details
        $pdf = PDF::loadView('Business.template', [
            'business' => $business,
            'clientName' => $clientName,
            'clientEmail' => $clientEmail,
            'advertentie' => $advertentie,
            'date' => $date
        ]);

        return $pdf->download("contract-$date-$clientName.pdf");
    }

}
