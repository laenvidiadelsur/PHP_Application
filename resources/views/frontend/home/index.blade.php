<x-frontend.layouts.app pageTitle="Inicio">
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mx-4 mt-4 rounded" role="alert">
            <div class="flex">
                <div class="py-1">
                    <svg class="fill-current h-6 w-6 text-green-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-bold">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Hero Section -->
    <section class="relative py-20 md:py-32 overflow-hidden">
        <!-- Background Effects -->
        <div class="absolute inset-0 bg-gradient-to-br from-gray-50/50 via-transparent to-gray-100/30"></div>
        <div class="absolute top-20 right-20 w-72 h-72 bg-gray-200 rounded-full mix-blend-multiply filter blur-xl opacity-10 animate-pulse"></div>
        <div class="absolute bottom-20 left-20 w-72 h-72 bg-orange-200 rounded-full mix-blend-multiply filter blur-xl opacity-10 animate-pulse delay-300"></div>
        
        <div class="container px-6 md:px-8 mx-auto max-w-7xl relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Content -->
                <div>
                    <div class="inline-block px-4 py-2 bg-orange-100 text-orange-800 rounded-full text-sm font-semibold mb-6">
                        Conectando Comunidades
                    </div>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl xl:text-7xl font-bold mb-6 leading-tight">
                        <span class="bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 bg-clip-text text-transparent">
                            Apoyando Fundaciones
                        </span>
                        <br>
                        <span class="bg-gradient-to-r from-orange-600 via-amber-600 to-orange-600 bg-clip-text text-transparent">
                            con Productos de Calidad
                        </span>
                    </h1>
                    <p class="text-xl text-gray-600 leading-relaxed mb-8">
                        Plataforma que conecta fundaciones con proveedores confiables para obtener los productos que necesitan y hacer una diferencia real en nuestras comunidades.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <x-frontend.button href="{{ route('products.index') }}" size="lg">
                            Ver Productos
                        </x-frontend.button>
                        <x-frontend.button href="{{ route('foundations.index') }}" variant="outline" size="lg">
                            Conocer Fundaciones
                        </x-frontend.button>
                    </div>
                    @guest
                        <div class="flex flex-col sm:flex-row gap-4 mt-4">
                            <x-frontend.button href="{{ route('login') }}" variant="outline" size="lg">
                                Iniciar Sesión
                            </x-frontend.button>
                            @if(Route::has('register'))
                                <x-frontend.button href="{{ route('register') }}" size="lg">
                                    Registrarse
                                </x-frontend.button>
                            @endif
                        </div>
                    @endguest
                </div>
                
                <!-- Image/Illustration -->
                <div class="relative">
                    <div class="relative z-10">
                        <div class="bg-gradient-to-br from-orange-500 to-amber-500 rounded-2xl p-8 shadow-2xl">
                            <div class="bg-white rounded-lg p-6">
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="bg-orange-50 p-4 rounded-lg">
                                        <div class="text-3xl font-bold text-orange-600 mb-2">150+</div>
                                        <div class="text-sm text-gray-600">Fundaciones</div>
                                    </div>
                                    <div class="bg-amber-50 p-4 rounded-lg">
                                        <div class="text-3xl font-bold text-amber-600 mb-2">500+</div>
                                        <div class="text-sm text-gray-600">Productos</div>
                                    </div>
                                    <div class="bg-orange-50 p-4 rounded-lg">
                                        <div class="text-3xl font-bold text-orange-600 mb-2">50+</div>
                                        <div class="text-sm text-gray-600">Proveedores</div>
                                    </div>
                                    <div class="bg-amber-50 p-4 rounded-lg">
                                        <div class="text-3xl font-bold text-amber-600 mb-2">1000+</div>
                                        <div class="text-sm text-gray-600">Órdenes</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Features Section -->
    <section class="py-20 md:py-32 bg-white">
        <div class="container px-6 md:px-8 mx-auto max-w-7xl">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4">
                    <span class="bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">
                        ¿Por qué elegirnos?
                    </span>
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Ofrecemos una plataforma completa para conectar fundaciones con proveedores de confianza
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <x-frontend.card>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-gradient-to-r from-orange-600 to-amber-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Confiable</h3>
                        <p class="text-gray-600">Todas las fundaciones y proveedores son verificados para garantizar transparencia y confiabilidad.</p>
                    </div>
                </x-frontend.card>
                
                <x-frontend.card>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-gradient-to-r from-orange-600 to-amber-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Rápido</h3>
                        <p class="text-gray-600">Proceso simplificado para encontrar productos y realizar pedidos de manera eficiente.</p>
                    </div>
                </x-frontend.card>
                
                <x-frontend.card>
                    <div class="text-center">
                        <div class="w-16 h-16 bg-gradient-to-r from-orange-600 to-amber-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Accesible</h3>
                        <p class="text-gray-600">Precios competitivos y opciones de pago flexibles para facilitar las compras.</p>
                    </div>
                </x-frontend.card>
            </div>
        </div>
    </section>
    
    <!-- CTA Section -->
    <section class="py-20 md:py-32 bg-gradient-to-r from-orange-600 to-amber-600">
        <div class="container px-6 md:px-8 mx-auto max-w-7xl text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">
                ¿Listo para comenzar?
            </h2>
            <p class="text-xl text-orange-100 mb-8 max-w-2xl mx-auto">
                Únete a nuestra plataforma y comienza a hacer una diferencia hoy mismo
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @auth
                    <x-frontend.button href="{{ route('products.index') }}" variant="outline" size="lg" class="bg-white text-orange-600 border-white hover:bg-gray-100">
                        Explorar Productos
                    </x-frontend.button>
                @else
                    @if(Route::has('register'))
                        <x-frontend.button href="{{ route('register') }}" variant="outline" size="lg" class="bg-white text-orange-600 border-white hover:bg-gray-100">
                            Crear Cuenta
                        </x-frontend.button>
                    @endif
                    <x-frontend.button href="{{ route('login') }}" variant="outline" size="lg" class="bg-transparent text-white border-white hover:bg-white/10">
                        Iniciar Sesión
                    </x-frontend.button>
                @endauth
            </div>
        </div>
    </section>
</x-frontend.layouts.app>

