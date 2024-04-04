<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Advertisement;
use App\Models\ProductReview;
use Illuminate\Support\Facades\Auth;

class ProductReviewController extends Controller
{
    public function store(Request $request, $advertisementId)
    {
        $request->validate([
            'review' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $advertisement = Advertisement::findOrFail($advertisementId);
        // Optionele check: zorg ervoor dat de advertentie van het type 'Verhuur' is
        if ($advertisement->type !== 'Verhuur') {
            return back()->withErrors(['error' => __('texts.reviews_only_for_rental_ads')]);
        }

        ProductReview::create([
            'reviewer_id' => Auth::id(),
            'advertiser_id' => $advertisement->user_id,
            'product_id' => $advertisementId,
            'review' => $request->review,
            'rating' => $request->rating,
        ]);

        return redirect()->route('advertenties.show', $advertisementId)->with('success', 'Review succesvol geplaatst!');
    }
}
