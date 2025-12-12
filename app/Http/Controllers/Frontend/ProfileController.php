<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Load registered events with event and foundation details
        // Load registered events
        $registeredEvents = $user->registeredEvents()
            ->wherePivot('status', 'registered')
            ->orderBy('start_date')
            ->get();
        
        return view('frontend.profile.index', [
            'user' => $user,
            'registeredEvents' => $registeredEvents,
            'pageTitle' => 'Mi Perfil',
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:test.users,email,' . $user->id,
            'password' => 'nullable|confirmed|' . Password::defaults(),
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if ($request->filled('password')) {
            $user->password = $validated['password'];
        }

        $user->save();

        return redirect()->route('profile.index')
            ->with('success', 'Perfil actualizado exitosamente.');
    }
}

