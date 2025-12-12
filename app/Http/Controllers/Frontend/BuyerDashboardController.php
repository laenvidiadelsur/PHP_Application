<?php

namespace App\Http\Controllers\Frontend;

use App\Domain\Lta\Models\Fundacion;
use App\Domain\Lta\Models\Orden;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BuyerDashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        
        // Statistics
        $totalFoundations = Fundacion::where('activa', true)->count();
        $userVotes = $user->votes()->count(); // Assuming user has votes relationship, otherwise count manually
        $activeOrders = Orden::whereHas('cart', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->whereIn('estado', ['pendiente', 'procesando', 'enviado'])
            ->count();
            
        // Top Voted Foundations
        $topFoundations = Fundacion::where('activa', true)
            ->withCount('votes')
            ->orderByDesc('votes_count')
            ->take(4)
            ->get();
            
        // All active foundations for carousel
        $foundations = Fundacion::where('activa', true)
            ->withCount('votes')
            ->inRandomOrder()
            ->take(10)
            ->get();
            
        // Recent Orders for Ticker
        $recentOrders = Orden::whereHas('cart', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->with(['items.product']) // Eager load items and products
            ->orderByDesc('created_at')
            ->take(10)
            ->get();

        // Donation Goal Calculations
        $monthlyGoal = 10000; // Monthly donation goal in dollars
        
        // Calculate total donations for current month (completed orders)
        $currentMonthDonations = Orden::whereHas('cart', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->where('estado', 'completado')
            ->whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->sum('total_amount');
        
        // Calculate remaining amount
        $remainingAmount = max(0, $monthlyGoal - $currentMonthDonations);
        
        // Calculate percentage (capped at 100%)
        $donationPercentage = min(100, ($currentMonthDonations / $monthlyGoal) * 100);

        return view('frontend.buyer.dashboard', [
            'pageTitle' => 'Mi Panel',
            'user' => $user,
            'stats' => [
                'foundations' => $totalFoundations,
                'votes' => $userVotes,
                'orders' => $activeOrders,
            ],
            'donationGoal' => [
                'current' => $currentMonthDonations,
                'goal' => $monthlyGoal,
                'remaining' => $remainingAmount,
                'percentage' => round($donationPercentage, 1),
            ],
            'topFoundations' => $topFoundations,
            'foundations' => $foundations,
            'recentOrders' => $recentOrders,
        ]);
    }
}
