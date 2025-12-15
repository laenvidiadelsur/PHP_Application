<x-frontend.layouts.app pageTitle="Detalle de Orden">
    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-gray-100 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-4xl font-bold mb-2">
                            <span class="bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">
                                Orden #{{ $orden->id }}
                            </span>
                        </h1>
                        <p class="text-gray-600">Detalle completo de tu orden</p>
                    </div>
                    <a href="{{ route('orders.index') }}" 
                       class="text-gray-600 hover:text-orange-600 transition-colors">
                        ← Volver a Mis Órdenes
                    </a>
                </div>
            </div>

            <!-- Order Info -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <h2 class="text-2xl font-bold mb-4 text-gray-900">Información de la Orden</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-600">Estado</p>
                        <p class="font-medium text-gray-900">
                            <span class="px-3 py-1 rounded-full text-sm font-medium
                                {{ ($orden->estado ?? 'pendiente') === 'completado' ? 'bg-green-100 text-green-800' : 
                                   (($orden->estado ?? 'pendiente') === 'pendiente' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                {{ ucfirst($orden->estado ?? 'Pendiente') }}
                            </span>
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-600">Fecha</p>
                        <p class="font-medium text-gray-900">{{ $orden->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Total</p>
                        <p class="font-medium text-gray-900 text-2xl">Bs {{ number_format($orden->total_amount, 2) }}</p>
                    </div>
                    @if($orden->cart->foundation)
                        <div>
                            <p class="text-gray-600">Fundación</p>
                            <p class="font-medium text-gray-900">{{ $orden->cart->foundation->name }}</p>
                        </div>
                    @endif
                    @if($orden->cart->supplier)
                        <div>
                            <p class="text-gray-600">Proveedor</p>
                            <p class="font-medium text-gray-900">{{ $orden->cart->supplier->name }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Order Items -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-2xl font-bold mb-4 text-gray-900">Productos</h2>
                <div class="space-y-4">
                    @forelse($orden->cart->items as $item)
                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                            <div class="flex-1">
                                <h3 class="font-medium text-gray-900">{{ $item->product->name }}</h3>
                                <p class="text-sm text-gray-600">
                                    Cantidad: {{ $item->quantity }} × Bs {{ number_format($item->product->price, 2) }}
                                </p>
                                @if($item->product->supplier)
                                    <p class="text-xs text-gray-500 mt-1">
                                        Proveedor: {{ $item->product->supplier->name }}
                                    </p>
                                @endif
                            </div>
                            <div class="text-right">
                                <p class="font-medium text-gray-900">
                                    Bs {{ number_format($item->quantity * $item->product->price, 2) }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-8">No hay productos en esta orden.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-frontend.layouts.app>

