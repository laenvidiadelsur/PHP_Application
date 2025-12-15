<x-frontend.layouts.app pageTitle="Eventos">
    <div class="container px-6 md:px-8 mx-auto max-w-7xl py-12">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">
                <span class="bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">
                    Próximos Eventos
                </span>
            </h1>
            <p class="text-xl text-gray-600">
                Participa en nuestros eventos y contribuye a la causa
            </p>
        </div>

        <!-- Filtros -->
        <div class="mb-8 bg-white rounded-xl shadow-md p-6 border border-gray-100">
            <form method="GET" action="{{ route('events.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <!-- Filtro por tipo de fecha -->
                    <div>
                        <label for="date_filter" class="block text-sm font-medium text-gray-700 mb-2">
                            Tipo de Fecha
                        </label>
                        <select name="date_filter" id="date_filter" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="upcoming" {{ ($filters['date_filter'] ?? 'upcoming') === 'upcoming' ? 'selected' : '' }}>Próximos</option>
                            <option value="past" {{ ($filters['date_filter'] ?? '') === 'past' ? 'selected' : '' }}>Pasados</option>
                            <option value="all" {{ ($filters['date_filter'] ?? '') === 'all' ? 'selected' : '' }}>Todos</option>
                        </select>
                    </div>

                    <!-- Filtro por fecha desde -->
                    <div>
                        <label for="date_from" class="block text-sm font-medium text-gray-700 mb-2">
                            Fecha Desde
                        </label>
                        <input type="date" name="date_from" id="date_from" value="{{ $filters['date_from'] ?? '' }}" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>

                    <!-- Filtro por fecha hasta -->
                    <div>
                        <label for="date_to" class="block text-sm font-medium text-gray-700 mb-2">
                            Fecha Hasta
                        </label>
                        <input type="date" name="date_to" id="date_to" value="{{ $filters['date_to'] ?? '' }}" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="px-6 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white rounded-lg font-medium transition-all duration-300">
                        Filtrar
                    </button>
                    <a href="{{ route('events.index') }}" class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-medium transition-all duration-300">
                        Limpiar Filtros
                    </a>
                </div>
            </form>
        </div>

        <!-- Events Grid -->
        @if($events->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach($events as $event)
                    <a href="{{ route('events.show', $event) }}" class="block group">
                        <x-frontend.card class="h-full transition-all duration-300 hover:shadow-xl hover:-translate-y-1 cursor-pointer">
                            <div class="relative">
                                <div class="w-full h-48 bg-gradient-to-br from-purple-100 to-indigo-100 rounded-lg mb-4 flex items-center justify-center group-hover:from-purple-200 group-hover:to-indigo-200 transition-colors">
                                    <span class="text-5xl">📅</span>
                                </div>
                                
                                <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-sm font-semibold text-purple-600 shadow-sm">
                                    {{ $event->start_date->format('d/m') }}
                                </div>

                                <h3 class="text-xl font-bold mb-3 group-hover:text-purple-600 transition-colors">{{ $event->name }}</h3>
                                
                                <!-- Información del evento con iconos -->
                                <div class="space-y-2 mb-4">
                                    <!-- Fecha de inicio -->
                                    <div class="flex items-center gap-2 text-gray-600 text-sm">
                                        <svg class="w-4 h-4 text-purple-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span class="font-medium">Inicio:</span>
                                        <span>{{ $event->start_date->format('d/m/Y H:i') }}</span>
                                    </div>

                                    <!-- Fecha de finalización -->
                                    <div class="flex items-center gap-2 text-gray-600 text-sm">
                                        <svg class="w-4 h-4 text-indigo-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span class="font-medium">Fin:</span>
                                        <span>{{ $event->end_date->format('d/m/Y H:i') }}</span>
                                    </div>

                                    <!-- Ubicación -->
                                    <div class="flex items-center gap-2 text-gray-600 text-sm">
                                        <svg class="w-4 h-4 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <span>{{ $event->location }}</span>
                                    </div>

                                    <!-- Capacidad -->
                                    @if($event->capacity)
                                        <div class="flex items-center gap-2 text-gray-600 text-sm">
                                            <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg>
                                            <span>{{ $event->capacity }} personas</span>
                                        </div>
                                    @endif
                                </div>

                                @if($event->description)
                                    <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ Str::limit($event->description, 100) }}</p>
                                @endif

                                <div class="mt-4 pt-4 border-t border-gray-200">
                                    <span class="text-purple-600 font-medium text-sm group-hover:underline">
                                        Ver Detalles →
                                    </span>
                                </div>
                            </div>
                        </x-frontend.card>
                    </a>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-8">
                {{ $events->links() }}
            </div>
        @else
            <div class="text-center py-12 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                <div class="text-6xl mb-4">📅</div>
                <h3 class="text-xl font-medium text-gray-900 mb-2">No hay eventos disponibles</h3>
                <p class="text-gray-500">Intenta ajustar los filtros o vuelve pronto para ver nuevos eventos.</p>
            </div>
        @endif
    </div>
</x-frontend.layouts.app>
