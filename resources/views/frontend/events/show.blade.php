@php
    $registeredCount = $event->registrations()->where('status', 'registered')->count();
    $availableSpots = $event->capacity ? ($event->capacity - $registeredCount) : null;
@endphp

<x-frontend.layouts.app :pageTitle="($event->name ?? 'Detalle del Evento')">
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
        <div class="container px-6 md:px-8 mx-auto max-w-7xl py-8">
            <!-- Breadcrumb -->
            <div class="mb-6">
                <a href="{{ route('events.index') }}" class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-900 transition-colors group">
                    <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span class="font-medium">Volver a Eventos</span>
                </a>
            </div>

            <!-- Hero Section -->
            <div class="relative mb-8 rounded-3xl overflow-hidden shadow-2xl">
                @if($event->image_url)
                    <div class="relative h-64 md:h-96 lg:h-[500px]">
                        <img src="{{ $event->image_url }}" alt="{{ $event->name }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                    </div>
                @else
                    <div class="relative h-64 md:h-96 lg:h-[500px] bg-gradient-to-br from-purple-600 via-indigo-600 to-purple-800">
                        <div class="absolute inset-0 opacity-20" style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.4\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
                    </div>
                @endif
                
                <div class="absolute bottom-0 left-0 right-0 p-8 md:p-12 text-white">
                    <div class="max-w-4xl">
                        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 drop-shadow-lg">
                            {{ $event->name }}
                        </h1>
                        
                        <div class="flex flex-wrap gap-4 mb-4">
                            <div class="flex items-center gap-2 bg-white/20 backdrop-blur-md px-4 py-2 rounded-full text-sm md:text-base font-medium">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>{{ $event->start_date->format('d M, Y') }}</span>
                            </div>
                            
                            <div class="flex items-center gap-2 bg-white/20 backdrop-blur-md px-4 py-2 rounded-full text-sm md:text-base font-medium">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>{{ $event->start_date->format('H:i') }} - {{ $event->end_date->format('H:i') }}</span>
                            </div>
                            
                            <div class="flex items-center gap-2 bg-white/20 backdrop-blur-md px-4 py-2 rounded-full text-sm md:text-base font-medium">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>{{ $event->location }}</span>
                            </div>
                        </div>

                        @if($event->start_date->isFuture())
                            <div class="inline-flex items-center gap-2 bg-emerald-500/90 backdrop-blur-md px-4 py-2 rounded-full text-sm font-semibold">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                <span>Evento Próximo</span>
                            </div>
                        @elseif($event->end_date->isPast())
                            <div class="inline-flex items-center gap-2 bg-gray-500/90 backdrop-blur-md px-4 py-2 rounded-full text-sm font-semibold">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                                <span>Evento Finalizado</span>
                            </div>
                        @else
                            <div class="inline-flex items-center gap-2 bg-blue-500/90 backdrop-blur-md px-4 py-2 rounded-full text-sm font-semibold">
                                <svg class="w-4 h-4 animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                </svg>
                                <span>En Curso</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Content Section -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Description Card -->
                    <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
                        <h2 class="text-3xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                            <div class="w-1 h-8 bg-gradient-to-b from-purple-600 to-indigo-600 rounded-full"></div>
                            Sobre el Evento
                        </h2>
                        <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed">
                            @if($event->description)
                                <p class="text-lg whitespace-pre-line">{{ $event->description }}</p>
                            @else
                                <p class="text-gray-500 italic">No hay descripción disponible para este evento.</p>
                            @endif
                        </div>
                    </div>

                    <!-- Additional Info Card -->
                    <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-3">
                            <div class="w-1 h-6 bg-gradient-to-b from-purple-600 to-indigo-600 rounded-full"></div>
                            Información Adicional
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-xl">
                                <div class="flex-shrink-0 w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 mb-1">Fecha de Inicio</p>
                                    <p class="text-lg font-semibold text-gray-900">{{ $event->start_date->format('l, d F Y') }}</p>
                                    <p class="text-sm text-gray-600 mt-1">{{ $event->start_date->format('H:i') }} horas</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-xl">
                                <div class="flex-shrink-0 w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 mb-1">Fecha de Finalización</p>
                                    <p class="text-lg font-semibold text-gray-900">{{ $event->end_date->format('l, d F Y') }}</p>
                                    <p class="text-sm text-gray-600 mt-1">{{ $event->end_date->format('H:i') }} horas</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-xl">
                                <div class="flex-shrink-0 w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500 mb-1">Ubicación</p>
                                    <p class="text-lg font-semibold text-gray-900">{{ $event->location }}</p>
                                </div>
                            </div>

                            @if($event->capacity)
                                <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-xl">
                                    <div class="flex-shrink-0 w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-500 mb-1">Capacidad</p>
                                        <p class="text-lg font-semibold text-gray-900">{{ $event->capacity }} personas</p>
                                        <p class="text-sm text-gray-600 mt-1">
                                            {{ $registeredCount }} registrados • {{ $availableSpots }} disponibles
                                        </p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Registration Card -->
                    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 sticky top-8">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Registro</h3>
                        
                        <div class="space-y-4 mb-6">
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <span class="text-sm text-gray-600">Estado</span>
                                @if($event->start_date->isFuture())
                                    <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-semibold">Próximo</span>
                                @elseif($event->end_date->isPast())
                                    <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-semibold">Finalizado</span>
                                @else
                                    <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">En Curso</span>
                                @endif
                            </div>

                            @if($event->capacity && $availableSpots !== null)
                                <div class="p-3 bg-gray-50 rounded-lg">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-sm text-gray-600">Cupos Disponibles</span>
                                        <span class="text-sm font-semibold text-gray-900">{{ $availableSpots }} / {{ $event->capacity }}</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 h-2 rounded-full" style="width: {{ ($registeredCount / $event->capacity) * 100 }}%"></div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="pt-6 border-t border-gray-200">
                            @auth
                                @if(auth()->user()->registeredEvents()->where('event_id', $event->id)->exists())
                                    <div class="bg-green-50 border border-green-200 rounded-xl p-4 text-center">
                                        <div class="flex items-center justify-center gap-2 text-green-700 font-semibold mb-2">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                            <span>Ya estás registrado</span>
                                        </div>
                                        <form action="{{ route('events.cancel', $event) }}" method="POST" class="mt-3">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-sm text-red-600 hover:text-red-700 font-medium">
                                                Cancelar Registro
                                            </button>
                                        </form>
                                    </div>
                                @elseif($event->start_date->isFuture() && (!$event->capacity || ($availableSpots !== null && $availableSpots > 0)))
                                    <form action="{{ route('events.register', $event) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white px-6 py-4 rounded-xl font-bold shadow-lg shadow-purple-200 transition-all duration-300 transform hover:-translate-y-0.5 hover:shadow-xl">
                                            Registrarme Ahora
                                        </button>
                                    </form>
                                @else
                                    <div class="bg-gray-100 border border-gray-200 rounded-xl p-4 text-center text-gray-600">
                                        <p class="text-sm">No disponible para registro</p>
                                    </div>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="block w-full bg-gray-900 hover:bg-gray-800 text-white px-6 py-4 rounded-xl font-bold text-center transition-all duration-300">
                                    Iniciar Sesión para Registrarse
                                </a>
                            @endauth
                        </div>
                    </div>

                    <!-- Quick Info Card -->
                    <div class="bg-gradient-to-br from-purple-50 to-indigo-50 rounded-2xl shadow-lg p-6 border border-purple-100">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Información Rápida</h3>
                        <ul class="space-y-3">
                            <li class="flex items-center gap-3 text-sm text-gray-700">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Duración: {{ $event->start_date->diffForHumans($event->end_date, true) }}</span>
                            </li>
                            <li class="flex items-center gap-3 text-sm text-gray-700">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>Inicia: {{ $event->start_date->diffForHumans() }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-frontend.layouts.app>
