<x-frontend.layouts.app pageTitle="Checkout">
    <div class="container px-6 md:px-8 mx-auto max-w-4xl py-12" x-data="{ step: 1 }">
        <!-- Stepper -->
        <div class="mb-12">
            <div class="flex items-center justify-between">
                <!-- Step 1 -->
                <div class="flex items-center">
                    <div class="flex flex-col items-center">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center font-bold text-lg transition-all duration-300"
                             :class="step >= 1 ? 'bg-gradient-to-r from-orange-600 to-amber-600 text-white' : 'bg-gray-200 text-gray-500'">
                            <span x-show="step > 1">✓</span>
                            <span x-show="step <= 1">1</span>
                        </div>
                        <span class="mt-2 text-sm font-medium" :class="step >= 1 ? 'text-orange-600' : 'text-gray-500'">
                            Resumen
                        </span>
                    </div>
                </div>
                
                <!-- Line 1 -->
                <div class="flex-1 h-1 mx-4 transition-all duration-300" :class="step >= 2 ? 'bg-gradient-to-r from-orange-600 to-amber-600' : 'bg-gray-200'"></div>
                
                <!-- Step 2 -->
                <div class="flex items-center">
                    <div class="flex flex-col items-center">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center font-bold text-lg transition-all duration-300"
                             :class="step >= 2 ? 'bg-gradient-to-r from-orange-600 to-amber-600 text-white' : 'bg-gray-200 text-gray-500'">
                            <span x-show="step > 2">✓</span>
                            <span x-show="step <= 2">2</span>
                        </div>
                        <span class="mt-2 text-sm font-medium" :class="step >= 2 ? 'text-orange-600' : 'text-gray-500'">
                            Datos
                        </span>
                    </div>
                </div>
                
                <!-- Line 2 -->
                <div class="flex-1 h-1 mx-4 transition-all duration-300" :class="step >= 3 ? 'bg-gradient-to-r from-orange-600 to-amber-600' : 'bg-gray-200'"></div>
                
                <!-- Step 3 -->
                <div class="flex items-center">
                    <div class="flex flex-col items-center">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center font-bold text-lg transition-all duration-300"
                             :class="step >= 3 ? 'bg-gradient-to-r from-orange-600 to-amber-600 text-white' : 'bg-gray-200 text-gray-500'">
                            3
                        </div>
                        <span class="mt-2 text-sm font-medium" :class="step >= 3 ? 'text-orange-600' : 'text-gray-500'">
                            Pago
                        </span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Error/Success Messages -->
        @if(session('error'))
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                {!! session('error') !!}
            </div>
        @endif
        
        @if(session('warning'))
            <div class="mb-6 bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded-lg">
                {!! session('warning') !!}
            </div>
        @endif
        
        @if(session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif
        
        <!-- Step 1: Cart Review -->
        <div x-show="step === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <h2 class="text-2xl font-bold mb-6">Resumen del Pedido</h2>
                
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b">
                                <th class="text-left py-3 px-4">Producto</th>
                                <th class="text-center py-3 px-4">Cantidad</th>
                                <th class="text-right py-3 px-4">Precio</th>
                                <th class="text-right py-3 px-4">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                                <tr class="border-b">
                                    <td class="py-4 px-4">
                                        <div class="font-medium">{{ $item['producto']->name }}</div>
                                        <div class="text-sm text-gray-500">Bs {{ number_format($item['price'], 2) }} c/u</div>
                                    </td>
                                    <td class="text-center py-4 px-4">{{ $item['quantity'] }}</td>
                                    <td class="text-right py-4 px-4">Bs {{ number_format($item['price'], 2) }}</td>
                                    <td class="text-right py-4 px-4 font-medium">Bs {{ number_format($item['total'], 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-6 pt-6 border-t">
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600">Subtotal:</span>
                        <span class="font-medium">Bs {{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600">Impuestos (15%):</span>
                        <span class="font-medium">Bs {{ number_format($tax, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-xl font-bold pt-2 border-t">
                        <span>Total:</span>
                        <span class="text-orange-600">Bs {{ number_format($total, 2) }}</span>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-end">
                <x-frontend.button @click="step = 2" size="lg">
                    Continuar
                </x-frontend.button>
            </div>
        </div>
        
        <!-- Step 2: Customer Info -->
        <div x-show="step === 2" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <h2 class="text-2xl font-bold mb-6">Información de Contacto</h2>
                
                <form id="checkout-form" method="POST" action="{{ route('checkout.process') }}">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nombre Completo <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="name" name="name" required
                                   value="{{ old('name', auth()->user()->name ?? '') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" id="email" name="email" required
                                   value="{{ old('email', auth()->user()->email ?? '') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                Teléfono
                            </label>
                            <input type="tel" id="phone" name="phone"
                                   value="{{ old('phone') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                                Dirección <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="address" name="address" required
                                   value="{{ old('address') }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                            @error('address')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Hidden fields for step 3 -->
                    <input type="hidden" name="payment_method" id="payment_method" value="card">
                </form>
            </div>
            
            <div class="flex justify-between">
                <x-frontend.button @click="step = 1" variant="outline" size="lg">
                    ← Volver
                </x-frontend.button>
                <x-frontend.button @click="step = 3" size="lg">
                    Continuar
                </x-frontend.button>
            </div>
        </div>
        
        <!-- Step 3: Payment & Confirm -->
        <div x-show="step === 3" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-4" x-transition:enter-end="opacity-100 transform translate-x-0">
            <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
                <h2 class="text-2xl font-bold mb-6">Método de Pago</h2>
                
                <div class="space-y-4 mb-6" x-data="{ paymentMethod: 'card' }">
                    <label class="flex items-center p-4 border-2 rounded-lg cursor-pointer hover:border-orange-500 transition-colors" 
                           :class="paymentMethod === 'card' ? 'border-orange-600 bg-orange-50' : 'border-gray-200'">
                        <input type="radio" name="payment_method_radio" value="card" x-model="paymentMethod" @change="document.getElementById('payment_method').value = 'card'" checked class="mr-4">
                        <div class="flex-1">
                            <div class="font-medium">Tarjeta de Crédito/Débito</div>
                            <div class="text-sm text-gray-500">Pago seguro con tarjeta</div>
                        </div>
                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </label>
                    
                    <label class="flex items-center p-4 border-2 rounded-lg cursor-pointer hover:border-orange-500 transition-colors"
                           :class="paymentMethod === 'transfer' ? 'border-orange-600 bg-orange-50' : 'border-gray-200'">
                        <input type="radio" name="payment_method_radio" value="transfer" x-model="paymentMethod" @change="document.getElementById('payment_method').value = 'transfer'" class="mr-4">
                        <div class="flex-1">
                            <div class="font-medium">Transferencia Bancaria</div>
                            <div class="text-sm text-gray-500">Transferencia directa</div>
                        </div>
                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                        </svg>
                    </label>
                    
                    <label class="flex items-center p-4 border-2 rounded-lg cursor-pointer hover:border-orange-500 transition-colors"
                           :class="paymentMethod === 'cash' ? 'border-orange-600 bg-orange-50' : 'border-gray-200'">
                        <input type="radio" name="payment_method_radio" value="cash" x-model="paymentMethod" @change="document.getElementById('payment_method').value = 'cash'" class="mr-4">
                        <div class="flex-1">
                            <div class="font-medium">Efectivo</div>
                            <div class="text-sm text-gray-500">Pago al recibir</div>
                        </div>
                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </label>
                </div>
                
                <!-- Final Review -->
                <div class="bg-gray-50 rounded-lg p-6 mb-6">
                    <h3 class="font-bold mb-4">Resumen Final</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Total a pagar:</span>
                            <span class="font-bold text-lg text-orange-600">Bs {{ number_format($total, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-between">
                <x-frontend.button @click="step = 2" variant="outline" size="lg">
                    ← Volver
                </x-frontend.button>
                <button type="submit" form="checkout-form" 
                        class="bg-gradient-to-r from-orange-600 to-amber-600 hover:from-orange-700 hover:to-amber-700 text-white px-8 py-4 text-lg rounded-lg font-medium transition-all duration-300 shadow-lg hover:shadow-xl">
                    Confirmar Orden
                </button>
            </div>
        </div>
    </div>
    
</x-frontend.layouts.app>

