<x-frontend.layouts.app pageTitle="Mi Perfil">
    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-gray-100 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-4xl font-bold mb-2">
                    <span class="bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">
                        Mi Perfil
                    </span>
                </h1>
                <p class="text-gray-600">Gestiona tu información personal y configuraciones</p>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Profile Form -->
            <div class="bg-white rounded-lg shadow-lg p-8">
                <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nombre Completo <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $user->name) }}" 
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email', $user->email) }}" 
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Nueva Contraseña
                        </label>
                        <input type="password" 
                               id="password" 
                               name="password" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                        <p class="mt-1 text-xs text-gray-500">Deja en blanco si no deseas cambiar la contraseña</p>
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            Confirmar Nueva Contraseña
                        </label>
                        <input type="password" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t">
                        <a href="{{ route('home') }}" class="text-gray-600 hover:text-orange-600 transition-colors">
                            Cancelar
                        </a>
                        <button type="submit" 
                                class="bg-gradient-to-r from-orange-600 to-amber-600 hover:from-orange-700 hover:to-amber-700 text-white px-6 py-3 rounded-lg font-medium transition-all duration-300 shadow-lg hover:shadow-xl">
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>

            <!-- Registered Events Section -->
            <div class="bg-white rounded-lg shadow-lg p-8 mt-6">
                <h2 class="text-2xl font-bold mb-4 text-gray-900">Mis Eventos Registrados</h2>
                
                @if($registeredEvents->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($registeredEvents as $evento)
                            <div class="block bg-gradient-to-br from-gray-50 to-white border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow relative group">
                                <a href="{{ route('events.show', $evento) }}" class="flex items-start gap-3">
                                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <span class="text-2xl">📅</span>
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-bold text-gray-900 mb-1">{{ $evento->name }}</h3>
                                        <p class="text-sm text-gray-600 mb-1">
                                            {{ $evento->start_date->format('d M Y, H:i') }}
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            📍 {{ $evento->location }}
                                        </p>
                                        @if($evento->start_date->isFuture())
                                            <span class="inline-block mt-2 px-2 py-1 bg-emerald-100 text-emerald-700 text-xs rounded-full">
                                                Próximamente
                                            </span>
                                        @else
                                            <span class="inline-block mt-2 px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded-full">
                                                Finalizado
                                            </span>
                                        @endif
                                    </div>
                                </a>
                                
                                <!-- Cancel Registration Button -->
                                @if($evento->start_date->isFuture())
                                    <form action="{{ route('events.cancel', $evento) }}" method="POST" class="mt-3 pt-3 border-t border-gray-100 text-right">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs text-red-600 hover:text-red-800 font-medium transition-colors">
                                            Cancelar Registro
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p class="text-gray-500 mb-3">No estás registrado en ningún evento</p>
                        <a href="{{ route('events.index') }}" class="text-orange-600 hover:text-orange-700 font-medium">
                            Explorar Eventos →
                        </a>
                    </div>
                @endif
            </div>

            <!-- Account Info -->
            <div class="bg-white rounded-lg shadow-lg p-8 mt-6">
                <h2 class="text-2xl font-bold mb-4 text-gray-900">Información de la Cuenta</h2>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Rol:</span>
                        <span class="font-medium text-gray-900">{{ ucfirst($user->rol ?? 'Comprador') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Estado:</span>
                        <span class="font-medium {{ $user->isApproved() ? 'text-green-600' : 'text-yellow-600' }}">
                            {{ $user->isApproved() ? 'Aprobado' : ($user->isPending() ? 'Pendiente' : 'Rechazado') }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Miembro desde:</span>
                        <span class="font-medium text-gray-900">{{ $user->created_at->format('d/m/Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-frontend.layouts.app>

