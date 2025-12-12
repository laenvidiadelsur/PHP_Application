<?php

namespace App\Http\Controllers\Frontend;

use App\Domain\Lta\Models\Fundacion;
use App\Domain\Lta\Models\FoundationRating;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FoundationRatingController extends Controller
{
    /**
     * Store or update a foundation rating
     */
    public function store(Request $request, Fundacion $fundacion): RedirectResponse
    {
        $user = Auth::user();

        // Validate request
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        // Use updateOrCreate to handle both new ratings and updates
        FoundationRating::updateOrCreate(
            [
                'user_id' => $user->id,
                'foundation_id' => $fundacion->id,
            ],
            [
                'rating' => $validated['rating'],
                'comment' => $validated['comment'] ?? null,
            ]
        );

        return redirect()->back()
            ->with('success', '¡Gracias por tu calificación!');
    }
}
