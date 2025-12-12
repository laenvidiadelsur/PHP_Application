<x-frontend.layouts.app :pageTitle="$pageTitle">
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="container px-6 md:px-8 mx-auto max-w-7xl">
            
            <!-- Welcome Section -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Hola, {{ $user->name }} 👋</h1>
                <p class="text-gray-600 mt-1">Bienvenido a tu panel de control. Aquí tienes un resumen de tu impacto.</p>
            </div>

            <!-- Platform Features Carousel -->
            <div class="mb-12">
                <div class="swiper features-swiper rounded-2xl overflow-hidden shadow-lg">
                    <div class="swiper-wrapper">
                        <!-- Slide 1: Donate -->
                        <div class="swiper-slide">
                            <div class="relative min-h-[16rem] h-auto py-12 bg-gradient-to-r from-orange-500 to-red-600 flex items-center px-8 md:px-16">
                                <div class="absolute right-0 top-0 h-full w-1/2 bg-white/10 skew-x-12 transform translate-x-20"></div>
                                <div class="relative z-10 text-white max-w-lg">
                                    <h2 class="text-3xl md:text-4xl font-bold mb-4">Tu Ayuda Cambia Vidas ❤️</h2>
                                    <p class="text-lg opacity-90 mb-6">Cada donación cuenta. Apoya a las fundaciones que más lo necesitan y sé parte del cambio.</p>
                                    <a href="{{ route('foundations.index') }}" class="inline-block bg-white text-orange-600 px-6 py-3 rounded-lg font-bold hover:bg-gray-100 transition-colors shadow-lg">
                                        Donar Ahora
                                    </a>
                                </div>
                                <div class="absolute right-10 bottom-0 text-9xl opacity-20 z-0">🤝</div>
                            </div>
                        </div>
                        <!-- Slide 2: Features -->
                        <div class="swiper-slide">
                            <div class="relative min-h-[16rem] h-auto py-12 bg-gradient-to-r from-blue-600 to-indigo-700 flex items-center px-8 md:px-16">
                                <div class="absolute right-0 top-0 h-full w-1/2 bg-white/10 skew-x-12 transform translate-x-20"></div>
                                <div class="relative z-10 text-white max-w-lg">
                                    <h2 class="text-3xl md:text-4xl font-bold mb-4">Transparencia Total 🛡️</h2>
                                    <p class="text-lg opacity-90 mb-6">Sigue el impacto de tus donaciones en tiempo real. Garantizamos que tu ayuda llegue a destino.</p>
                                    <a href="{{ route('reportes.index') }}" class="inline-block bg-white text-blue-600 px-6 py-3 rounded-lg font-bold hover:bg-gray-100 transition-colors shadow-lg">
                                        Ver Reportes
                                    </a>
                                </div>
                                <div class="absolute right-10 bottom-0 text-9xl opacity-20 z-0">📊</div>
                            </div>
                        </div>
                        <!-- Slide 3: Events -->
                        <div class="swiper-slide">
                            <div class="relative min-h-[16rem] h-auto py-12 bg-gradient-to-r from-emerald-500 to-teal-600 flex items-center px-8 md:px-16">
                                <div class="absolute right-0 top-0 h-full w-1/2 bg-white/10 skew-x-12 transform translate-x-20"></div>
                                <div class="relative z-10 text-white max-w-lg">
                                    <h2 class="text-3xl md:text-4xl font-bold mb-4">Participa en Eventos 📅</h2>
                                    <p class="text-lg opacity-90 mb-6">Únete a nuestros eventos benéficos y conoce a la comunidad que hace posible el cambio.</p>
                                    <a href="{{ route('events.index') }}" class="inline-block bg-white text-emerald-600 px-6 py-3 rounded-lg font-bold hover:bg-gray-100 transition-colors shadow-lg">
                                        Explorar Eventos
                                    </a>
                                </div>
                                <div class="absolute right-10 bottom-0 text-9xl opacity-20 z-0">🎉</div>
                            </div>
                        </div>
                        <!-- Slide 4: Volunteer -->
                        <div class="swiper-slide">
                            <div class="relative min-h-[16rem] h-auto py-12 bg-gradient-to-r from-purple-500 to-pink-600 flex items-center px-8 md:px-16">
                                <div class="absolute right-0 top-0 h-full w-1/2 bg-white/10 skew-x-12 transform translate-x-20"></div>
                                <div class="relative z-10 text-white max-w-lg">
                                    <h2 class="text-3xl md:text-4xl font-bold mb-4">Sé Voluntario 🙋‍♀️</h2>
                                    <p class="text-lg opacity-90 mb-6">Dona tu tiempo y talento. Las fundaciones necesitan manos amigas para llevar a cabo su misión.</p>
                                    <a href="#" class="inline-block bg-white text-purple-600 px-6 py-3 rounded-lg font-bold hover:bg-gray-100 transition-colors shadow-lg">
                                        Unirme
                                    </a>
                                </div>
                                <div class="absolute right-10 bottom-0 text-9xl opacity-20 z-0">🙌</div>
                            </div>
                        </div>
                        <!-- Slide 5: Share -->
                        <div class="swiper-slide">
                            <div class="relative min-h-[16rem] h-auto py-12 bg-gradient-to-r from-amber-400 to-orange-500 flex items-center px-8 md:px-16">
                                <div class="absolute right-0 top-0 h-full w-1/2 bg-white/10 skew-x-12 transform translate-x-20"></div>
                                <div class="relative z-10 text-white max-w-lg">
                                    <h2 class="text-3xl md:text-4xl font-bold mb-4">Comparte la Causa 📢</h2>
                                    <p class="text-lg opacity-90 mb-6">Ayúdanos a llegar a más personas. Comparte nuestras campañas en tus redes sociales.</p>
                                    <button class="inline-block bg-white text-amber-600 px-6 py-3 rounded-lg font-bold hover:bg-gray-100 transition-colors shadow-lg">
                                        Compartir
                                    </button>
                                </div>
                                <div class="absolute right-10 bottom-0 text-9xl opacity-20 z-0">📣</div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                <!-- Foundations Supported -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition-shadow">
                    <div class="absolute right-0 top-0 w-32 h-32 bg-orange-50 rounded-full -mr-16 -mt-16 transition-transform group-hover:scale-110"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <div class="p-3 bg-orange-100 text-orange-600 rounded-xl">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-gray-500 font-medium text-sm">Fundaciones Activas</h3>
                                    <span class="text-3xl font-bold text-gray-900">{{ $stats['foundations'] }}</span>
                                </div>
                            </div>
                            <div id="foundations-chart"></div>
                        </div>
                        <div class="flex items-center gap-2 text-sm">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                            <span class="text-green-600 font-medium">Disponibles para apoyar</span>
                        </div>
                    </div>
                </div>

                <!-- Votes Cast -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition-shadow">
                    <div class="absolute right-0 top-0 w-32 h-32 bg-red-50 rounded-full -mr-16 -mt-16 transition-transform group-hover:scale-110"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <div class="p-3 bg-red-100 text-red-600 rounded-xl">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-gray-500 font-medium text-sm">Mis Votos</h3>
                                    <span class="text-3xl font-bold text-gray-900">{{ $stats['votes'] }}</span>
                                </div>
                            </div>
                            <div id="votes-chart"></div>
                        </div>
                        <div class="text-sm text-gray-500">
                            Fundaciones apoyadas
                        </div>
                    </div>
                </div>

                <!-- Active Orders -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 relative overflow-hidden group hover:shadow-md transition-shadow">
                    <div class="absolute right-0 top-0 w-32 h-32 bg-blue-50 rounded-full -mr-16 -mt-16 transition-transform group-hover:scale-110"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <div class="p-3 bg-blue-100 text-blue-600 rounded-xl">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-gray-500 font-medium text-sm">Pedidos Activos</h3>
                                    <span class="text-3xl font-bold text-gray-900">{{ $stats['orders'] }}</span>
                                </div>
                            </div>
                            <div id="orders-chart"></div>
                        </div>
                        <div class="flex items-center gap-2 text-sm">
                            <span class="inline-block w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>
                            <span class="text-blue-600 font-medium">En proceso</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Donation Goal Widget -->
            <div class="mb-12 bg-gradient-to-br from-orange-50 to-red-50 rounded-2xl shadow-lg border border-orange-100 p-8">
                <div class="flex flex-col lg:flex-row items-center gap-8">
                    <!-- Circular Progress -->
                    <div class="flex-shrink-0">
                        <div id="donation-goal-chart" class="relative">
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="text-center">
                                    <div class="text-4xl font-bold text-gray-900">{{ number_format($donationGoal['percentage'] ?? 0, 0) }}%</div>
                                    <div class="text-sm text-gray-500 mt-1">Completado</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Goal Information -->
                    <div class="flex-grow text-center lg:text-left">
                        <h2 class="text-3xl font-bold text-gray-900 mb-2">Meta de Donaciones 🎯</h2>
                        <p class="text-gray-600 mb-6">Ayúdanos a alcanzar nuestra meta mensual de donaciones para apoyar a más fundaciones</p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                            <div class="bg-white rounded-xl p-4 shadow-sm">
                                <div class="text-sm text-gray-500 mb-1">Recaudado</div>
                                <div class="text-2xl font-bold text-orange-600">${{ number_format($donationGoal['current'] ?? 0, 0) }}</div>
                            </div>
                            <div class="bg-white rounded-xl p-4 shadow-sm">
                                <div class="text-sm text-gray-500 mb-1">Meta</div>
                                <div class="text-2xl font-bold text-gray-900">${{ number_format($donationGoal['goal'] ?? 10000, 0) }}</div>
                            </div>
                            <div class="bg-white rounded-xl p-4 shadow-sm">
                                <div class="text-sm text-gray-500 mb-1">Restante</div>
                                <div class="text-2xl font-bold text-red-600">${{ number_format($donationGoal['remaining'] ?? 10000, 0) }}</div>
                            </div>
                        </div>
                        
                        <div class="flex flex-wrap gap-3 justify-center lg:justify-start">
                            <a href="{{ route('foundations.index') }}" class="px-6 py-3 bg-gradient-to-r from-orange-500 to-red-600 text-white rounded-lg font-bold hover:from-orange-600 hover:to-red-700 transition-all shadow-md">
                                Donar Ahora
                            </a>
                            <button class="px-6 py-3 bg-white text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-all shadow-sm border border-gray-200">
                                Compartir Meta
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
                <!-- Top Voted Foundations -->
                <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-900">Fundaciones Más Votadas 🏆</h2>
                        <a href="{{ route('foundations.index') }}" class="text-sm text-orange-600 hover:text-orange-700 font-medium">Ver todas</a>
                    </div>
                    
                    <div class="space-y-4">
                        @foreach($topFoundations as $index => $foundation)
                            <div class="flex items-center gap-4 p-4 rounded-xl hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-100">
                                <div class="flex-shrink-0 w-12 h-12 flex items-center justify-center rounded-full bg-gradient-to-br {{ $index == 0 ? 'from-yellow-100 to-amber-100 text-yellow-600' : ($index == 1 ? 'from-gray-100 to-slate-200 text-gray-600' : ($index == 2 ? 'from-orange-100 to-red-100 text-orange-600' : 'from-gray-50 to-gray-100 text-gray-400')) }}">
                                    <span class="font-bold text-lg">#{{ $index + 1 }}</span>
                                </div>
                                <div class="flex-grow">
                                    <h3 class="font-semibold text-gray-900">{{ $foundation->name }}</h3>
                                    <p class="text-sm text-gray-500 truncate">{{ $foundation->mission ?? 'Sin misión definida' }}</p>
                                </div>
                                <div class="flex-shrink-0">
                                    <x-frontend.vote-button :fundacion="$foundation" :voted="$foundation->isVotedByUser($user->id)" :count="$foundation->votes_count" />
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Recent Orders Ticker -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col h-[400px]">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Últimos Pedidos 📦</h2>
                    
                    <div class="flex-grow overflow-hidden relative">
                        <div class="absolute inset-x-0 top-0 h-8 bg-gradient-to-b from-white to-transparent z-10"></div>
                        <div class="absolute inset-x-0 bottom-0 h-8 bg-gradient-to-t from-white to-transparent z-10"></div>
                        
                        <div class="animate-marquee-vertical space-y-4 hover:pause-animation">
                            @forelse($recentOrders as $order)
                                <div class="bg-gray-50 rounded-xl p-4 border border-gray-100 hover:bg-orange-50 transition-colors group">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <span class="text-xs font-bold text-gray-500">#{{ $order->numero_orden }}</span>
                                            <p class="text-sm font-semibold text-gray-900">{{ $order->created_at->format('d M, H:i') }}</p>
                                        </div>
                                        <span class="px-2 py-1 rounded-full text-xs font-medium 
                                            {{ $order->estado === 'completado' ? 'bg-green-100 text-green-700' : 
                                              ($order->estado === 'pendiente' ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-700') }}">
                                            {{ ucfirst($order->estado) }}
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="text-gray-600">{{ $order->items->count() }} ítems</span>
                                        <span class="font-bold text-gray-900">${{ number_format($order->total, 2) }}</span>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8 text-gray-500">
                                    <p>No hay pedidos recientes</p>
                                </div>
                            @endforelse
                            <!-- Duplicate for seamless loop if enough items -->
                            @if($recentOrders->count() > 3)
                                @foreach($recentOrders as $order)
                                    <div class="bg-gray-50 rounded-xl p-4 border border-gray-100 hover:bg-orange-50 transition-colors group">
                                        <div class="flex justify-between items-start mb-2">
                                            <div>
                                                <span class="text-xs font-bold text-gray-500">#{{ $order->numero_orden }}</span>
                                                <p class="text-sm font-semibold text-gray-900">{{ $order->created_at->format('d M, H:i') }}</p>
                                            <style>
        @keyframes marquee-vertical {
            0% { transform: translateY(0); }
            100% { transform: translateY(-50%); }
        }
        .animate-marquee-vertical {
            animation: marquee-vertical 20s linear infinite;
        }
        .hover\:pause-animation:hover {
            animation-play-state: paused;
        }
    </style>
    </div>
                                            <span class="px-2 py-1 rounded-full text-xs font-medium 
                                                {{ $order->estado === 'completado' ? 'bg-green-100 text-green-700' : 
                                                  ($order->estado === 'pendiente' ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-700') }}">
                                                {{ ucfirst($order->estado) }}
                                            </span>
                                        </div>
                                        <div class="flex justify-between items-center text-sm">
                                            <span class="text-gray-600">{{ $order->items->count() }} ítems</span>
                                            <span class="font-bold text-gray-900">${{ number_format($order->total, 2) }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>



            <!-- Foundations Carousel -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Descubre Nuevas Fundaciones</h2>
                
                <div class="swiper foundations-swiper !pb-14 !px-4 -mx-4">
                    <div class="swiper-wrapper">
                        @foreach($foundations as $foundation)
                            <div class="swiper-slide">
                                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden h-full flex flex-col">
                                    <div class="h-32 bg-gradient-to-br from-orange-100 to-amber-100 flex items-center justify-center">
                                        <span class="text-4xl">🏢</span>
                                    </div>
                                    <div class="p-5 flex-grow flex flex-col">
                                        <h3 class="font-bold text-gray-900 mb-2 truncate">{{ $foundation->name }}</h3>
                                        <p class="text-sm text-gray-500 mb-4 line-clamp-2">{{ $foundation->description ?? 'Apoya esta noble causa.' }}</p>
                                        
                                        <div class="mt-auto flex items-center justify-between pt-4 border-t border-gray-100">
                                            <a href="{{ route('foundations.show', $foundation) }}" class="text-sm font-medium text-orange-600 hover:text-orange-700">Ver perfil</a>
                                            <x-frontend.vote-button :fundacion="$foundation" :voted="$foundation->isVotedByUser($user->id)" :count="$foundation->votes_count" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Circular Progress Charts
            const chartOptions = {
                chart: {
                    type: 'radialBar',
                    height: 80,
                    width: 80,
                    sparkline: {
                        enabled: true
                    }
                },
                plotOptions: {
                    radialBar: {
                        hollow: {
                            size: '50%'
                        },
                        track: {
                            background: '#f3f4f6'
                        },
                        dataLabels: {
                            show: false
                        }
                    }
                },
                stroke: {
                    lineCap: 'round'
                }
            };

            // Foundations Chart
            const foundationsChart = new ApexCharts(document.querySelector("#foundations-chart"), {
                ...chartOptions,
                series: [70],
                colors: ['#ea580c']
            });
            foundationsChart.render();

            // Votes Chart
            const votesPercentage = Math.min(({{ $stats['votes'] }} / Math.max({{ $stats['foundations'] }}, 1)) * 100, 100);
            const votesChart = new ApexCharts(document.querySelector("#votes-chart"), {
                ...chartOptions,
                series: [votesPercentage],
                colors: ['#dc2626']
            });
            votesChart.render();

            // Orders Chart
            const ordersChart = new ApexCharts(document.querySelector("#orders-chart"), {
                ...chartOptions,
                series: [{{ $stats['orders'] > 0 ? 100 : 0 }}],
                colors: ['#2563eb']
            });
            ordersChart.render();

            // Donation Goal Chart (Large)
            const donationGoalChart = new ApexCharts(document.querySelector("#donation-goal-chart"), {
                chart: {
                    type: 'radialBar',
                    height: 280,
                    width: 280,
                },
                plotOptions: {
                    radialBar: {
                        hollow: {
                            size: '65%'
                        },
                        track: {
                            background: '#f3f4f6',
                            strokeWidth: '100%'
                        },
                        dataLabels: {
                            show: false
                        }
                    }
                },
                series: [{{ $donationGoal['percentage'] ?? 0 }}],
                colors: ['#ea580c'],
                stroke: {
                    lineCap: 'round'
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shade: 'dark',
                        type: 'horizontal',
                        shadeIntensity: 0.5,
                        gradientToColors: ['#dc2626'],
                        inverseColors: false,
                        opacityFrom: 1,
                        opacityTo: 1,
                        stops: [0, 100]
                    }
                }
            });
            donationGoalChart.render();

            // Initialize Swiper with a small delay to ensure DOM is ready
            setTimeout(() => {
                const swiper = new Swiper('.foundations-swiper', {
                    slidesPerView: 1,
                    spaceBetween: 24,
                    loop: true,
                    grabCursor: true,
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                        dynamicBullets: true,
                    },
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                    breakpoints: {
                        640: {
                            slidesPerView: 2,
                            spaceBetween: 20,
                        },
                        768: {
                            slidesPerView: 3,
                            spaceBetween: 30,
                        },
                        1024: {
                            slidesPerView: 4,
                            spaceBetween: 30,
                        },
                    },
                    autoplay: {
                        delay: 5000,
                        disableOnInteraction: false,
                    },
                });
            }, 100);

            // Initialize Features Swiper
            new Swiper('.features-swiper', {
                slidesPerView: 1,
                loop: true,
                effect: 'fade',
                autoplay: {
                    delay: 4000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
            });
        });
    </script>
    @endpush
</x-frontend.layouts.app>
