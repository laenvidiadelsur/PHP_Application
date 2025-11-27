<x-frontend.layouts.app pageTitle="Proveedores">
    <div class="container px-6 md:px-8 mx-auto max-w-7xl py-12">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">
                <span class="bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">
                    Nuestros Proveedores
                </span>
            </h1>
            <p class="text-xl text-gray-600">
                Proveedores confiables y verificados
            </p>
        </div>
        
        <!-- Suppliers Grid -->
        @if($proveedores->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                @foreach($proveedores as $proveedor)
                    <x-frontend.card>
                        <div>
                            <div class="w-full h-48 bg-gradient-to-br from-orange-100 to-amber-100 rounded-lg mb-4 flex items-center justify-center">
                                <span class="text-5xl">🤝</span>
                            </div>
                            <h3 class="text-xl font-bold mb-2">{{ $proveedor->name }}</h3>
                            @if($proveedor->contact_name)
                                <p class="text-sm text-gray-600 mb-2">
                                    <strong>Contacto:</strong> {{ $proveedor->contact_name }}
                                </p>
                            @endif
                            @if($proveedor->email)
                                <p class="text-sm text-gray-600 mb-2">
                                    <strong>Email:</strong> {{ $proveedor->email }}
                                </p>
                            @endif
                            @if($proveedor->phone)
                                <p class="text-sm text-gray-600 mb-4">
                                    <strong>Teléfono:</strong> {{ $proveedor->phone }}
                                </p>
                            @endif
                            <div class="flex items-center gap-2 mb-4">
                                @if($proveedor->activo)
                                    <span class="px-3 py-1 bg-emerald-100 text-emerald-800 rounded-full text-xs font-medium">
                                        Activo
                                    </span>
                                @endif
                            </div>
                            <a href="{{ route('suppliers.show', $proveedor) }}" 
                               class="block w-full bg-gradient-to-r from-orange-600 to-amber-600 hover:from-orange-700 hover:to-amber-700 text-white px-4 py-2 rounded-lg font-medium transition-all duration-300 text-center">
                                Ver Productos
                            </a>
                        </div>
                    </x-frontend.card>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-8">
                {{ $proveedores->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <p class="text-xl text-gray-600">No hay proveedores disponibles</p>
            </div>
        @endif
    </div>
</x-frontend.layouts.app>

