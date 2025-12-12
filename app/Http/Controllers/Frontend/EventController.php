<?php

namespace App\Http\Controllers\Frontend;

use App\Domain\Lta\Models\Evento;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(Request $request): View
    {
        $query = Evento::query();

        // Filtro por estado
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            $query->where('status', 'active');
        }

        // Filtro por tipo de fecha
        if ($request->filled('date_filter')) {
            switch ($request->date_filter) {
                case 'upcoming':
                    $query->where('start_date', '>', now());
                    break;
                case 'past':
                    $query->where('end_date', '<', now());
                    break;
                case 'all':
                    // No filtrar por fecha
                    break;
            }
        } else {
            // Por defecto mostrar próximos
            $query->where('start_date', '>', now());
        }



        // Filtro por rango de fechas
        if ($request->filled('date_from')) {
            $query->where('start_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('start_date', '<=', $request->date_to);
        }

        // Ordenar por fecha de inicio
        $query->orderBy('start_date');

        $events = $query->paginate(9)->withQueryString();



        return view('frontend.events.index', [
            'pageTitle' => 'Eventos',
            'events' => $events,
            'filters' => $request->only(['status', 'date_filter', 'date_from', 'date_to']),
        ]);
    }

    public function show(Evento $evento): View
    {
        return view('frontend.events.show', [
            'pageTitle' => $evento->name ?? 'Detalle del Evento',
            'event' => $evento,
        ]);
    }

    public function register(Evento $evento)
    {
        $user = Auth::user();
        
        if ($user->registeredEvents()->where('event_id', $evento->id)->exists()) {
            return back()->with('error', 'Ya estás registrado en este evento.');
        }

        $user->registeredEvents()->attach($evento->id, [
            'status' => 'registered',
            'registered_at' => now(),
        ]);

        return back()->with('success', 'Te has registrado exitosamente en el evento.');
    }

    public function cancel(Evento $evento)
    {
        $user = Auth::user();
        
        $user->registeredEvents()->updateExistingPivot($evento->id, [
            'status' => 'cancelled',
        ]);

        return back()->with('success', 'Tu registro ha sido cancelado.');
    }
}
