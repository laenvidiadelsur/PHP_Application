@extends('proveedor.layouts.app')

@section('content')
    @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            {{ session('info') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Corrige los errores antes de continuar:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card">
        <div class="card-header bg-gradient-primary">
            <h3 class="card-title text-white">
                <i class="fas fa-info-circle mr-2"></i>
                Completar Información del Proveedor
            </h3>
        </div>
        <div class="card-body">
            <p class="text-muted mb-4">
                <i class="fas fa-check-circle text-success mr-2"></i>
                ¡Felicidades! Tu solicitud ha sido aprobada. Por favor, completa la información de tu proveedor para continuar.
            </p>

            <!-- Progress Stepper -->
            <div class="mb-5" x-data="{ 
                currentStep: 1,
                name: '{{ old('name', $proveedor->name ?? '') }}',
                contact_name: '{{ old('contact_name', $proveedor->contact_name ?? '') }}',
                email: '{{ old('email', $proveedor->email ?? '') }}',
                phone: '{{ old('phone', $proveedor->phone ?? '') }}',
                address: '{{ old('address', $proveedor->address ?? '') }}',
                tax_id: '{{ old('tax_id', $proveedor->tax_id ?? '') }}',
                fundacion_ids: {{ json_encode(old('fundacion_ids', $fundacionesAsociadas->pluck('id')->toArray())) }}
            }">
                <div class="stepper-wrapper">
                    <div class="stepper-item" :class="{ 'active': currentStep >= 1, 'completed': currentStep > 1 }">
                        <div class="step-counter">1</div>
                        <div class="step-name">Información Básica</div>
                    </div>
                    <div class="stepper-item" :class="{ 'active': currentStep >= 2, 'completed': currentStep > 2 }">
                        <div class="step-counter">2</div>
                        <div class="step-name">Contacto</div>
                    </div>
                    <div class="stepper-item" :class="{ 'active': currentStep >= 3, 'completed': currentStep > 3 }">
                        <div class="step-counter">3</div>
                        <div class="step-name">Ubicación y NIT</div>
                    </div>
                    <div class="stepper-item" :class="{ 'active': currentStep >= 4, 'completed': currentStep > 4 }">
                        <div class="step-counter">4</div>
                        <div class="step-name">Fundaciones</div>
                    </div>
                    <div class="stepper-item" :class="{ 'active': currentStep >= 5, 'completed': currentStep > 5 }">
                        <div class="step-counter">5</div>
                        <div class="step-name">Finalizar</div>
                    </div>
                </div>

                <form action="{{ route('proveedor.complete-info.store') }}" method="POST" id="proveedor-form" enctype="multipart/form-data">
                    @csrf

                    <!-- Step 1: Información Básica -->
                    <div x-show="currentStep === 1" x-transition class="step-content">
                        <h4 class="mb-4">
                            <i class="fas fa-building text-primary mr-2"></i>
                            Paso 1: Información Básica
                        </h4>
                        
                        <div class="form-group">
                            <label for="name">
                                Nombre del Proveedor <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $proveedor->name ?? '') }}" 
                                   required
                                   x-model="name"
                                   placeholder="Ej: Proveedora ABC S.A.">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Este será el nombre público de tu proveedor en la plataforma.
                            </small>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="button" 
                                    @click="if(document.getElementById('name').value.trim() !== '') { currentStep = 2; } else { alert('Por favor, completa el nombre del proveedor.'); }" 
                                    class="btn btn-primary">
                                Siguiente <i class="fas fa-arrow-right ml-2"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Step 2: Contacto -->
                    <div x-show="currentStep === 2" x-transition class="step-content">
                        <h4 class="mb-4">
                            <i class="fas fa-user text-primary mr-2"></i>
                            Paso 2: Información de Contacto
                        </h4>
                        
                        <div class="form-group">
                            <label for="contact_name">
                                Nombre de Contacto <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('contact_name') is-invalid @enderror" 
                                   id="contact_name" 
                                   name="contact_name" 
                                   value="{{ old('contact_name', $proveedor->contact_name ?? '') }}" 
                                   required
                                   x-model="contact_name"
                                   placeholder="Ej: Juan Pérez">
                            @error('contact_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">
                                Email <span class="text-danger">*</span>
                            </label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email', $proveedor->email ?? '') }}" 
                                   required
                                   x-model="email"
                                   placeholder="Ej: contacto@proveedor.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="phone">
                                Teléfono <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" 
                                   name="phone" 
                                   value="{{ old('phone', $proveedor->phone ?? '') }}" 
                                   required
                                   x-model="phone"
                                   placeholder="Ej: +591 70000000">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" @click="currentStep = 1" class="btn btn-secondary">
                                <i class="fas fa-arrow-left mr-2"></i> Anterior
                            </button>
                            <button type="button" 
                                    @click="if(document.getElementById('contact_name').value.trim() !== '' && document.getElementById('email').value.trim() !== '' && document.getElementById('phone').value.trim() !== '') { currentStep = 3; } else { alert('Por favor, completa todos los campos de contacto.'); }" 
                                    class="btn btn-primary">
                                Siguiente <i class="fas fa-arrow-right ml-2"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Step 3: Ubicación y NIT -->
                    <div x-show="currentStep === 3" x-transition class="step-content">
                        <h4 class="mb-4">
                            <i class="fas fa-map-marker-alt text-primary mr-2"></i>
                            Paso 3: Ubicación y NIT
                        </h4>
                        
                        <div class="form-group">
                            <label for="address">
                                Dirección <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('address') is-invalid @enderror" 
                                   id="address" 
                                   name="address" 
                                   value="{{ old('address', $proveedor->address ?? '') }}" 
                                   required
                                   x-model="address"
                                   placeholder="Ej: Av. Principal #123, Ciudad, Departamento">
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="tax_id">
                                NIT / Tax ID <span class="text-muted">(Opcional)</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('tax_id') is-invalid @enderror" 
                                   id="tax_id" 
                                   name="tax_id" 
                                   value="{{ old('tax_id', $proveedor->tax_id ?? '') }}" 
                                   x-model="tax_id"
                                   placeholder="Ej: 123456789">
                            @error('tax_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Número de identificación tributaria (opcional pero recomendado).
                            </small>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" @click="currentStep = 2" class="btn btn-secondary">
                                <i class="fas fa-arrow-left mr-2"></i> Anterior
                            </button>
                            <button type="button" 
                                    @click="if(document.getElementById('address').value.trim() !== '') { currentStep = 4; } else { alert('Por favor, completa la dirección.'); }" 
                                    class="btn btn-primary">
                                Siguiente <i class="fas fa-arrow-right ml-2"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Step 4: Fundaciones -->
                    <div x-show="currentStep === 4" x-transition class="step-content">
                        <h4 class="mb-4">
                            <i class="fas fa-handshake text-primary mr-2"></i>
                            Paso 4: Fundaciones
                        </h4>
                        
                        <div class="form-group">
                            <label for="fundacion_ids">
                                Fundaciones a las que proveerás <span class="text-danger">*</span>
                            </label>
                            <select class="form-control @error('fundacion_ids') is-invalid @enderror" 
                                    id="fundacion_ids" 
                                    name="fundacion_ids[]" 
                                    multiple 
                                    required
                                    size="8">
                                @foreach($todasFundaciones as $fundacion)
                                    <option value="{{ $fundacion->id }}"
                                        @if(in_array($fundacion->id, old('fundacion_ids', $fundacionesAsociadas->pluck('id')->toArray()))) selected @endif>
                                        {{ $fundacion->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('fundacion_ids')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Mantén presionada la tecla Ctrl (o Cmd en Mac) para seleccionar varias fundaciones. Debes seleccionar al menos una.
                            </small>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" @click="currentStep = 3" class="btn btn-secondary">
                                <i class="fas fa-arrow-left mr-2"></i> Anterior
                            </button>
                            <button type="button" 
                                    @click="if(document.getElementById('fundacion_ids').selectedOptions.length > 0) { currentStep = 5; } else { alert('Por favor, selecciona al menos una fundación.'); }" 
                                    class="btn btn-primary">
                                Siguiente <i class="fas fa-arrow-right ml-2"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Step 5: Revisar y Finalizar -->
                    <div x-show="currentStep === 5" x-transition class="step-content">
                        <h4 class="mb-4">
                            <i class="fas fa-check-circle text-primary mr-2"></i>
                            Paso 5: Revisar y Finalizar
                        </h4>

                        <div class="form-group mb-4">
                            <label for="image">
                                Logo / Imagen del Proveedor <span class="text-muted">(Opcional)</span>
                            </label>
                            <input type="file"
                                   class="form-control-file @error('image') is-invalid @enderror"
                                   id="image"
                                   name="image"
                                   accept="image/*">
                            @error('image')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Se usará como avatar del proveedor (máx. 2MB).
                            </small>
                        </div>
                        
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle mr-2"></i>
                            Por favor, revisa la información antes de guardar. Podrás editarla más tarde desde tu panel de control.
                        </div>

                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h5 class="mb-0">Resumen de la Información</h5>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-3 font-weight-bold">Nombre:</div>
                                    <div class="col-md-9" x-text="name || 'No especificado'"></div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-3 font-weight-bold">Contacto:</div>
                                    <div class="col-md-9" x-text="contact_name || 'No especificado'"></div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-3 font-weight-bold">Email:</div>
                                    <div class="col-md-9" x-text="email || 'No especificado'"></div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-3 font-weight-bold">Teléfono:</div>
                                    <div class="col-md-9" x-text="phone || 'No especificado'"></div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-3 font-weight-bold">Dirección:</div>
                                    <div class="col-md-9" x-text="address || 'No especificada'"></div>
                                </div>
                                <div class="row mb-3" x-show="tax_id">
                                    <div class="col-md-3 font-weight-bold">NIT:</div>
                                    <div class="col-md-9" x-text="tax_id || 'No especificado'"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 font-weight-bold">Fundaciones:</div>
                                    <div class="col-md-9">
                                        <span x-text="document.getElementById('fundacion_ids').selectedOptions.length + ' seleccionada(s)'"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" @click="currentStep = 4" class="btn btn-secondary">
                                <i class="fas fa-arrow-left mr-2"></i> Anterior
                            </button>
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-save mr-2"></i> Guardar Información
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .stepper-wrapper {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2rem;
            position: relative;
        }

        .stepper-wrapper::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 0;
            right: 0;
            height: 2px;
            background-color: #e0e0e0;
            z-index: 0;
        }

        .stepper-item {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;
            z-index: 1;
        }

        .stepper-item::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 50%;
            width: 100%;
            height: 2px;
            background-color: #e0e0e0;
            z-index: -1;
        }

        .stepper-item:first-child::before {
            display: none;
        }

        .stepper-item.completed::before {
            background-color: #28a745;
        }

        .step-counter {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #e0e0e0;
            color: #666;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-bottom: 0.5rem;
            transition: all 0.3s ease;
        }

        .stepper-item.active .step-counter {
            background-color: #007bff;
            color: white;
            transform: scale(1.1);
        }

        .stepper-item.completed .step-counter {
            background-color: #28a745;
            color: white;
        }

        .stepper-item.completed .step-counter::before {
            content: '✓';
        }

        .step-name {
            font-size: 0.875rem;
            color: #666;
            text-align: center;
        }

        .stepper-item.active .step-name {
            color: #007bff;
            font-weight: bold;
        }

        .stepper-item.completed .step-name {
            color: #28a745;
        }

        .step-content {
            min-height: 400px;
            padding: 2rem;
            background-color: #f8f9fa;
            border-radius: 0.5rem;
        }
    </style>
@endsection

