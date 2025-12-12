<?php

namespace App\Http\Controllers\Frontend;

use App\Domain\Lta\Models\FoundationVote;
use App\Domain\Lta\Models\Fundacion;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FoundationVoteController extends Controller
{
    public function toggle(Fundacion $fundacion): JsonResponse
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $existingVote = FoundationVote::where('user_id', $user->id)
            ->where('foundation_id', $fundacion->id)
            ->first();

        if ($existingVote) {
            $existingVote->delete();
            $voted = false;
        } else {
            FoundationVote::create([
                'user_id' => $user->id,
                'foundation_id' => $fundacion->id,
            ]);
            $voted = true;
        }

        return response()->json([
            'voted' => $voted,
            'votes_count' => $fundacion->votes()->count(),
        ]);
    }
}
