<x-frontend.layouts.app pageTitle="Fundaciones">
    <div class="container px-6 md:px-8 mx-auto max-w-7xl py-12">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">
                <span class="bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">
                    Fundaciones Verificadas
                </span>
            </h1>
            <p class="text-xl text-gray-600">
                Conoce las fundaciones que están haciendo la diferencia
            </p>
        </div>
        
        <!-- Foundations Grid -->
        @if($fundaciones->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach($fundaciones as $fundacion)
                    <x-frontend.card>
                        <div>
                            <div class="w-full h-48 bg-gradient-to-br from-orange-100 to-amber-100 rounded-lg mb-4 flex items-center justify-center">
                                <span class="text-5xl">🏢</span>
                            </div>
                            <h3 class="text-xl font-bold mb-2">{{ $fundacion->name }}</h3>
                            @if($fundacion->mission)
                                <p class="text-sm text-gray-600 mb-4 line-clamp-3">{{ Str::limit($fundacion->mission, 120) }}</p>
                            @endif
                            <div class="flex items-center gap-2 mb-4">
                                @if($fundacion->verified)
                                    <span class="px-3 py-1 bg-emerald-100 text-emerald-800 rounded-full text-xs font-medium">
                                        ✓ Verificada
                                    </span>
                                @endif
                                @if($fundacion->activa)
                                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">
                                        Activa
                                    </span>
                                @endif
                            </div>
                            <a href="{{ route('foundations.show', $fundacion) }}" 
                               class="block w-full bg-gradient-to-r from-orange-600 to-amber-600 hover:from-orange-700 hover:to-amber-700 text-white px-4 py-2 rounded-lg font-medium transition-all duration-300 text-center">
                                Ver Más
                            </a>
                        </div>
                    </x-frontend.card>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-8">
                {{ $fundaciones->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <p class="text-xl text-gray-600">No hay fundaciones disponibles</p>
            </div>
        @endif
    </div>
</x-frontend.layouts.app>

