<?php

namespace App\Http\Controllers\Frontend;

use App\Domain\Lta\Models\Evento;
use App\Domain\Lta\Models\EventRegistration;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class EventRegistrationController extends Controller
{
    /**
     * Register user for an event
     */
    public function store(Evento $evento): RedirectResponse
    {
        $user = Auth::user();

        // Check if event is active and published
        if (!$evento->is_active || !$evento->is_published) {
            return redirect()->back()
                ->with('error', 'Este evento no está disponible para registro.');
        }

        // Check if event is not past
        if ($evento->isPast()) {
            return redirect()->back()
                ->with('error', 'No puedes registrarte en un evento que ya finalizó.');
        }

        // Check if user is already registered
        if ($evento->isUserRegistered($user->id)) {
            return redirect()->back()
                ->with('error', 'Ya estás registrado en este evento.');
        }

        // Create registration
        EventRegistration::create([
            'user_id' => $user->id,
            'event_id' => $evento->id,
            'status' => EventRegistration::STATUS_REGISTERED,
            'registered_at' => now(),
        ]);

        return redirect()->back()
            ->with('success', '¡Te has registrado exitosamente en el evento!');
    }

    /**
     * Cancel event registration
     */
    public function destroy(Evento $evento): RedirectResponse
    {
        $user = Auth::user();

        $registration = EventRegistration::where('user_id', $user->id)
            ->where('event_id', $evento->id)
            ->first();

        if (!$registration) {
            return redirect()->back()
                ->with('error', 'No estás registrado en este evento.');
        }

        // Update status to cancelled instead of deleting
        $registration->update([
            'status' => EventRegistration::STATUS_CANCELLED,
        ]);

        return redirect()->back()
            ->with('success', 'Tu registro ha sido cancelado.');
    }
}
