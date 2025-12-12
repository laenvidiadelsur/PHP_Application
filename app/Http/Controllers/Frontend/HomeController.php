<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $user = \Illuminate\Support\Facades\Auth::user();

        if ($user && $user->isComprador()) {
            // Statistics
            $totalFoundations = \App\Domain\Lta\Models\Fundacion::where('activa', true)->count();
            $userVotes = $user->votes()->count();
            
            $activeOrders = \App\Domain\Lta\Models\Orden::whereHas('cart', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->whereIn('estado', ['pendiente', 'procesando', 'enviado'])
                ->count();
                
            // Top Voted Foundations
            $topFoundations = \App\Domain\Lta\Models\Fundacion::where('activa', true)
                ->withCount('votes')
                ->orderByDesc('votes_count')
                ->take(4)
                ->get();
                
            // All active foundations for carousel
            $foundations = \App\Domain\Lta\Models\Fundacion::where('activa', true)
                ->withCount('votes')
                ->inRandomOrder()
                ->take(10)
                ->get();
                
            // Recent Orders for Ticker
            $recentOrders = \App\Domain\Lta\Models\Orden::whereHas('cart', function ($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->with(['items.product']) // Eager load items and products
                ->orderByDesc('created_at')
                ->take(10)
                ->get();

            return view('frontend.buyer.dashboard', [
                'pageTitle' => 'Mi Panel',
                'user' => $user,
                'stats' => [
                    'foundations' => $totalFoundations,
                    'votes' => $userVotes,
                    'orders' => $activeOrders,
                ],
                'topFoundations' => $topFoundations,
                'foundations' => $foundations,
                'recentOrders' => $recentOrders,
            ]);
        }

        return view('frontend.home.index', [
            'pageTitle' => 'Inicio',
        ]);
    }
}

