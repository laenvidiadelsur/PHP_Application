<header class="border-b bg-white/80 backdrop-blur-sm sticky top-0 z-50 shadow-sm">
    <div class="container px-6 md:px-8 mx-auto max-w-7xl">
        <div class="flex items-center justify-between h-16 md:h-20">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <div class="w-10 h-10 bg-gradient-to-r from-orange-600 to-amber-600 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-xl">AC</span>
                    </div>
                    <span class="text-2xl font-bold bg-gradient-to-r from-orange-600 via-amber-600 to-orange-600 bg-clip-text text-transparent">
                        Alas Chiquitanas
                    </span>
                </a>
            </div>
            
            <!-- Navigation -->
            <nav class="hidden md:flex items-center space-x-8">
                <a href="{{ route('home') }}" class="text-gray-700 hover:text-orange-600 transition-colors font-medium">
                    Inicio
                </a>
                <a href="{{ route('products.index') }}" class="text-gray-700 hover:text-orange-600 transition-colors font-medium">
                    Productos
                </a>
                <a href="{{ route('foundations.index') }}" class="text-gray-700 hover:text-orange-600 transition-colors font-medium">
                    Fundaciones
                </a>
                <a href="{{ route('suppliers.index') }}" class="text-gray-700 hover:text-orange-600 transition-colors font-medium">
                    Proveedores
                </a>
            </nav>
            
            <!-- Actions -->
            <div class="flex items-center space-x-4">
                @auth
                    @if(Route::has('cart.index'))
                        <a href="{{ route('cart.index') }}" class="relative p-2 text-gray-700 hover:text-orange-600 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span class="absolute top-0 right-0 bg-orange-600 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                                {{ session('cart_count', 0) }}
                            </span>
                        </a>
                    @endif
                    <div class="relative group">
                        <button class="flex items-center space-x-2 text-gray-700 hover:text-orange-600 transition-colors">
                            <span>{{ auth()->user()->name }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                            @if(Route::has('orders.index'))
                                <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Mis Pedidos
                                </a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}" class="block">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Cerrar Sesión
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-orange-600 transition-colors font-medium">
                        Iniciar Sesión
                    </a>
                    @if(Route::has('register'))
                        <a href="{{ route('register') }}" class="bg-gradient-to-r from-orange-600 to-amber-600 hover:from-orange-700 hover:to-amber-700 text-white px-6 py-2 rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 font-medium">
                            Registrarse
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</header>

