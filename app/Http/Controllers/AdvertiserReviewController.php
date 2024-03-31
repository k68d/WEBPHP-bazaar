<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdvertiserReview;
use Illuminate\Support\Facades\Auth;

class AdvertiserReviewController extends Controller
{
    public function store(Request $request, $advertiserId)
    {
        $request->validate([
            'review' => 'required|string|max:500',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        AdvertiserReview::create([
            'advertiser_id' => $advertiserId,
            'reviewer_id' => Auth::id(),
            'review' => $request->review,
            'rating' => $request->rating,
        ]);

        return back()->with('success', 'Je review is succesvol geplaatst.');
    }
}
