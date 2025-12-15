<x-frontend.layouts.app pageTitle="Registrarse">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl w-full space-y-8">
            <!-- Logo y Título -->
            <div class="text-center">
                <div class="flex justify-center mb-6">
                    <div class="w-16 h-16 bg-gradient-to-r from-orange-600 to-amber-600 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-2xl">AC</span>
                    </div>
                </div>
                <h2 class="text-4xl font-bold mb-2">
                    <span class="bg-gradient-to-r from-gray-900 to-gray-700 bg-clip-text text-transparent">
                        Crear Cuenta
                    </span>
                </h2>
                <p class="text-gray-600">Únete a nuestra plataforma</p>
            </div>

            <!-- Mensajes -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Formulario -->
            <div class="bg-white rounded-lg shadow-lg p-8">
                <form method="POST" action="{{ route('register') }}" class="space-y-6" x-data="{ userType: 'comprador' }" @submit="
                    // Remover required de campos ocultos antes de enviar
                    const form = $event.target;
                    const hiddenFields = form.querySelectorAll('[x-show]');
                    hiddenFields.forEach(el => {
                        if (el.style.display === 'none' || !el.offsetParent) {
                            el.removeAttribute('required');
                        }
                    });
                ">
                    @csrf

                    <!-- Información del Usuario -->
                    <div class="border-b pb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Información de Usuario</h3>
                        
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nombre Completo <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                        </div>

                        <div class="mt-4">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                        </div>

                        <div class="mt-4">
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                Contraseña <span class="text-red-500">*</span>
                            </label>
                            <input type="password" 
                                   id="password" 
                                   name="password" 
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                        </div>

                        <div class="mt-4">
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                Confirmar Contraseña <span class="text-red-500">*</span>
                            </label>
                            <input type="password" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                        </div>

                        <div class="mt-4">
                            <label for="user_type" class="block text-sm font-medium text-gray-700 mb-2">
                                Tipo de Cuenta <span class="text-red-500">*</span>
                            </label>
                            <select id="user_type" 
                                    name="user_type" 
                                    x-model="userType"
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                <option value="comprador">Comprador</option>
                                <option value="fundacion">Fundación</option>
                                <option value="proveedor">Proveedor</option>
                            </select>
                            <p class="mt-1 text-xs text-gray-500">
                                <span x-show="userType === 'fundacion' || userType === 'proveedor'">
                                    Las cuentas de Fundación y Proveedor requieren aprobación del administrador.
                                </span>
                                <span x-show="userType === 'comprador'">
                                    Los compradores pueden usar la plataforma inmediatamente.
                                </span>
                            </p>
                        </div>
                    </div>

                    <!-- Campos de Fundación -->
                    <div x-show="userType === 'fundacion'" x-transition class="border-b pb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Información de la Fundación</h3>
                        <p class="text-sm text-gray-600 mb-4">
                            Ingresa el nombre básico de tu fundación. Una vez que tu solicitud sea aprobada por el administrador, podrás completar la información adicional (misión, descripción y dirección) mediante un formulario guiado.
                        </p>
                        
                        <div>
                            <label for="fundacion_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nombre de la Fundación <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="fundacion_name" 
                                   name="fundacion_name" 
                                   value="{{ old('fundacion_name') }}" 
                                   x-show="userType === 'fundacion'"
                                   x-bind:required="userType === 'fundacion'"
                                   placeholder="Ej: Fundación Ayuda Social"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                            <small class="text-gray-500 mt-1 block">
                                La información adicional se completará después de la aprobación.
                            </small>
                        </div>
                    </div>

                    <!-- Campos de Proveedor -->
                    <div x-show="userType === 'proveedor'" x-transition class="border-b pb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Información del Proveedor</h3>
                        <p class="text-sm text-gray-600 mb-4">
                            Ingresa el nombre básico de tu proveedor y selecciona las fundaciones a las que proveerás. Una vez que tu solicitud sea aprobada por el administrador, podrás completar la información adicional (contacto, email, teléfono, dirección, NIT) mediante un formulario guiado.
                        </p>
                        
                        <div>
                            <label for="proveedor_fundacion_ids" class="block text-sm font-medium text-gray-700 mb-2">
                                Fundaciones a las que proveerá este proveedor <span class="text-red-500">*</span>
                            </label>
                            <select id="proveedor_fundacion_ids"
                                    name="proveedor_fundacion_ids[]"
                                    x-show="userType === 'proveedor'"
                                    multiple
                                    x-bind:required="userType === 'proveedor'"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                                @foreach($fundaciones as $fundacion)
                                    <option value="{{ $fundacion->id }}"
                                        @if(collect(old('proveedor_fundacion_ids', []))->contains($fundacion->id)) selected @endif>
                                        {{ $fundacion->name }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="mt-1 text-xs text-gray-500">
                                Mantén presionada la tecla Ctrl (o Cmd en Mac) para seleccionar varias fundaciones.
                            </p>
                        </div>

                        <div class="mt-4">
                            <label for="proveedor_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nombre del Proveedor <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="proveedor_name" 
                                   name="proveedor_name" 
                                   value="{{ old('proveedor_name') }}" 
                                   x-show="userType === 'proveedor'"
                                   x-bind:required="userType === 'proveedor'"
                                   placeholder="Ej: Proveedora ABC S.A."
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                            <small class="text-gray-500 mt-1 block">
                                La información adicional se completará después de la aprobación.
                            </small>
                        </div>
                    </div>

                    <div>
                        <button type="submit" 
                                class="w-full bg-gradient-to-r from-orange-600 to-amber-600 hover:from-orange-700 hover:to-amber-700 text-white px-6 py-3 rounded-lg font-medium transition-all duration-300 shadow-lg hover:shadow-xl">
                            Crear Cuenta
                        </button>
                    </div>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-sm text-gray-600">
                        ¿Ya tienes cuenta? 
                        <a href="{{ route('login') }}" class="font-medium text-orange-600 hover:text-orange-700">
                            Inicia sesión aquí
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-frontend.layouts.app>
