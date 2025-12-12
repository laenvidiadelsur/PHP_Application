<x-frontend.layouts.app pageTitle="Reportes de Transparencia">
    <div class="container px-6 md:px-8 mx-auto max-w-7xl py-12">
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">
                <span class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                    Transparencia y Rendición de Cuentas
                </span>
            </h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                En Alas Chiquitanas, creemos que la confianza es la base de la solidaridad. Aquí puedes ver cómo se gestionan y distribuyen las donaciones.
            </p>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
            <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 text-center">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl">
                    💰
                </div>
                <h3 class="text-4xl font-bold text-gray-900 mb-2">100%</h3>
                <p class="text-gray-600">De las donaciones llegan a las fundaciones</p>
            </div>
            <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl">
                    ✅
                </div>
                <h3 class="text-4xl font-bold text-gray-900 mb-2">Verificado</h3>
                <p class="text-gray-600">Todas las fundaciones son auditadas</p>
            </div>
            <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 text-center">
                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl">
                    🔒
                </div>
                <h3 class="text-4xl font-bold text-gray-900 mb-2">Seguro</h3>
                <p class="text-gray-600">Pagos encriptados y protegidos</p>
            </div>
        </div>

        <!-- Content Placeholder -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="p-8 md:p-12">
                <div class="flex flex-col md:flex-row items-center gap-12">
                    <div class="flex-1">
                        <h2 class="text-3xl font-bold text-gray-900 mb-6">Nuestros Reportes Anuales</h2>
                        <p class="text-gray-600 mb-6 leading-relaxed">
                            Publicamos informes detallados sobre el impacto de cada campaña, los fondos recaudados y su destino final. Nuestro compromiso es mantener una plataforma abierta y honesta para todos nuestros donantes y beneficiarios.
                        </p>
                        <div class="space-y-4">
                            <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                                <span class="text-2xl">📄</span>
                                <div>
                                    <h4 class="font-bold text-gray-900">Informe de Impacto 2024</h4>
                                    <p class="text-sm text-gray-500">Publicado el 15 de Enero, 2025</p>
                                </div>
                                <button class="ml-auto text-blue-600 font-medium hover:underline">Descargar PDF</button>
                            </div>
                            <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                                <span class="text-2xl">📄</span>
                                <div>
                                    <h4 class="font-bold text-gray-900">Auditoría Financiera Q4 2024</h4>
                                    <p class="text-sm text-gray-500">Publicado el 10 de Enero, 2025</p>
                                </div>
                                <button class="ml-auto text-blue-600 font-medium hover:underline">Descargar PDF</button>
                            </div>
                        </div>
                    </div>
                    <div class="flex-1 flex justify-center">
                        <div class="relative w-full max-w-md aspect-square bg-gradient-to-br from-blue-50 to-indigo-50 rounded-full flex items-center justify-center">
                            <div class="text-9xl">📊</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-frontend.layouts.app>
