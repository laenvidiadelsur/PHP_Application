<x-frontend.layouts.app pageTitle="Mis Órdenes">
    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-gray-100 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-4xl font-bold mb-2">
                    <span class="bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">
                        Mis Órdenes
                    </span>
                </h1>
                <p class="text-gray-600">Gestiona y revisa todas tus órdenes</p>
            </div>

            <!-- Filters -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <form method="GET" action="{{ route('orders.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="fundacion_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Filtrar por Fundación
                        </label>
                        <select id="fundacion_id" 
                                name="fundacion_id" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                            <option value="">Todas las fundaciones</option>
                            @foreach($fundaciones as $fundacion)
                                <option value="{{ $fundacion->id }}" {{ $filters['fundacion_id'] == $fundacion->id ? 'selected' : '' }}>
                                    {{ $fundacion->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="proveedor_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Filtrar por Proveedor
                        </label>
                        <select id="proveedor_id" 
                                name="proveedor_id" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                            <option value="">Todos los proveedores</option>
                            @foreach($proveedores as $proveedor)
                                <option value="{{ $proveedor->id }}" {{ $filters['proveedor_id'] == $proveedor->id ? 'selected' : '' }}>
                                    {{ $proveedor->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-end">
                        <button type="submit" 
                                class="w-full bg-gradient-to-r from-orange-600 to-amber-600 hover:from-orange-700 hover:to-amber-700 text-white px-6 py-3 rounded-lg font-medium transition-all duration-300 shadow-lg hover:shadow-xl">
                            Filtrar
                        </button>
                    </div>
                </form>
            </div>

            <!-- Orders List -->
            <div class="space-y-4">
                @forelse($ordenes as $orden)
                    <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-4 mb-2">
                                    <h3 class="text-xl font-bold text-gray-900">
                                        Orden #{{ $orden->id }}
                                    </h3>
                                    <span class="px-3 py-1 rounded-full text-sm font-medium
                                        {{ ($orden->estado ?? 'pendiente') === 'completado' ? 'bg-green-100 text-green-800' : 
                                           (($orden->estado ?? 'pendiente') === 'pendiente' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                        {{ ucfirst($orden->estado ?? 'Pendiente') }}
                                    </span>
                                </div>
                                <div class="text-gray-600 space-y-1">
                                    <p><strong>Fecha:</strong> {{ $orden->created_at->format('d/m/Y H:i') }}</p>
                                    <p><strong>Total:</strong> Bs {{ number_format($orden->total_amount, 2) }}</p>
                                    @if($orden->cart->foundation)
                                        <p><strong>Fundación:</strong> {{ $orden->cart->foundation->name }}</p>
                                    @endif
                                    @if($orden->cart->supplier)
                                        <p><strong>Proveedor:</strong> {{ $orden->cart->supplier->name }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="mt-4 md:mt-0 md:ml-4">
                                <a href="{{ route('orders.show', $orden) }}" 
                                   class="inline-block bg-gradient-to-r from-orange-600 to-amber-600 hover:from-orange-700 hover:to-amber-700 text-white px-6 py-2 rounded-lg font-medium transition-all duration-300 shadow-lg hover:shadow-xl">
                                    Ver Detalles
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-lg shadow-lg p-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No hay órdenes</h3>
                        <p class="mt-1 text-sm text-gray-500">Aún no has realizado ninguna orden.</p>
                        <div class="mt-6">
                            <a href="{{ route('products.index') }}" 
                               class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gradient-to-r from-orange-600 to-amber-600 hover:from-orange-700 hover:to-amber-700">
                                Explorar Productos
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($ordenes->hasPages())
                <div class="mt-6">
                    {{ $ordenes->links() }}
                </div>
            @endif
        </div>
    </div>
</x-frontend.layouts.app>

