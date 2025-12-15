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

        // Donation Goal Calculations - Meta global (todas las órdenes)
        $monthlyGoal = 10000; // Monthly donation goal in bolivianos
        
        // Calculate total donations for current month (completed orders) - TODAS las órdenes, no solo del usuario
        // Usa 'completada' que es el estado correcto en el sistema
        // Usar whereBetween para asegurar que incluya todo el mes actual
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();
        
        $currentMonthDonations = (float) (Orden::where('estado', 'completada')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->sum('total_amount') ?? 0);
        
        // Calculate remaining amount
        $remainingAmount = max(0, $monthlyGoal - $currentMonthDonations);
        
        // Calculate percentage (capped at 100%)
        $donationPercentage = $monthlyGoal > 0 ? min(100, ($currentMonthDonations / $monthlyGoal) * 100) : 0;


        return view('frontend.buyer.dashboard', [
            'pageTitle' => 'Mi Panel',
            'user' => $user,
            'stats' => [
                'foundations' => $totalFoundations,
                'votes' => $userVotes,
                'orders' => $activeOrders,
            ],
            'donationGoal' => [
                'current' => (float) $currentMonthDonations,
                'goal' => (float) $monthlyGoal,
                'remaining' => (float) $remainingAmount,
                'percentage' => (float) round($donationPercentage, 1),
            ],
            'topFoundations' => $topFoundations,
            'foundations' => $foundations,
            'recentOrders' => $recentOrders,
        ]);
    }
}
