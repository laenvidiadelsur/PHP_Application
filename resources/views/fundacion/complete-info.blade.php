@extends('fundacion.layouts.app')

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
                Completar Información de la Fundación
            </h3>
        </div>
        <div class="card-body">
            <p class="text-muted mb-4">
                <i class="fas fa-check-circle text-success mr-2"></i>
                ¡Felicidades! Tu solicitud ha sido aprobada. Por favor, completa la información de tu fundación para continuar.
            </p>

            <!-- Progress Stepper -->
            <div class="mb-5" x-data="{ 
                currentStep: 1,
                name: '{{ old('name', $fundacion->name ?? '') }}',
                mission: '{{ old('mission', $fundacion->mission ?? '') }}',
                description: '{{ old('description', $fundacion->description ?? '') }}',
                address: '{{ old('address', $fundacion->address ?? '') }}'
            }">
                <div class="stepper-wrapper">
                    <div class="stepper-item" :class="{ 'active': currentStep >= 1, 'completed': currentStep > 1 }">
                        <div class="step-counter">1</div>
                        <div class="step-name">Información Básica</div>
                    </div>
                    <div class="stepper-item" :class="{ 'active': currentStep >= 2, 'completed': currentStep > 2 }">
                        <div class="step-counter">2</div>
                        <div class="step-name">Misión y Descripción</div>
                    </div>
                    <div class="stepper-item" :class="{ 'active': currentStep >= 3, 'completed': currentStep > 3 }">
                        <div class="step-counter">3</div>
                        <div class="step-name">Ubicación</div>
                    </div>
                    <div class="stepper-item" :class="{ 'active': currentStep >= 4, 'completed': currentStep > 4 }">
                        <div class="step-counter">4</div>
                        <div class="step-name">Finalizar</div>
                    </div>
                </div>

                <form action="{{ route('fundacion.complete-info.store') }}" method="POST" id="fundacion-form">
                    @csrf

                    <!-- Step 1: Información Básica -->
                    <div x-show="currentStep === 1" x-transition class="step-content">
                        <h4 class="mb-4">
                            <i class="fas fa-building text-primary mr-2"></i>
                            Paso 1: Información Básica
                        </h4>
                        
                        <div class="form-group">
                            <label for="name">
                                Nombre de la Fundación <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $fundacion->name ?? '') }}" 
                                   required
                                   x-model="name"
                                   placeholder="Ej: Fundación Ayuda Social">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Este será el nombre público de tu fundación en la plataforma.
                            </small>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="button" 
                                    @click="if(document.getElementById('name').value.trim() !== '') { currentStep = 2; } else { alert('Por favor, completa el nombre de la fundación.'); }" 
                                    class="btn btn-primary">
                                Siguiente <i class="fas fa-arrow-right ml-2"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Step 2: Misión y Descripción -->
                    <div x-show="currentStep === 2" x-transition class="step-content">
                        <h4 class="mb-4">
                            <i class="fas fa-bullseye text-primary mr-2"></i>
                            Paso 2: Misión y Descripción
                        </h4>
                        
                        <div class="form-group">
                            <label for="mission">
                                Misión <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('mission') is-invalid @enderror" 
                                      id="mission" 
                                      name="mission" 
                                      rows="4" 
                                      required
                                      x-model="mission"
                                      placeholder="Describe la misión principal de tu fundación...">{{ old('mission', $fundacion->mission ?? '') }}</textarea>
                            @error('mission')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Explica cuál es el propósito y objetivo principal de tu fundación.
                            </small>
                        </div>

                        <div class="form-group">
                            <label for="description">
                                Descripción <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="5" 
                                      required
                                      x-model="description"
                                      placeholder="Describe en detalle qué hace tu fundación, sus actividades, programas, etc...">{{ old('description', $fundacion->description ?? '') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Proporciona información detallada sobre las actividades y programas de tu fundación.
                            </small>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" @click="currentStep = 1" class="btn btn-secondary">
                                <i class="fas fa-arrow-left mr-2"></i> Anterior
                            </button>
                            <button type="button" 
                                    @click="if(document.getElementById('mission').value.trim() !== '' && document.getElementById('description').value.trim() !== '') { currentStep = 3; } else { alert('Por favor, completa la misión y descripción.'); }" 
                                    class="btn btn-primary">
                                Siguiente <i class="fas fa-arrow-right ml-2"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Step 3: Ubicación -->
                    <div x-show="currentStep === 3" x-transition class="step-content">
                        <h4 class="mb-4">
                            <i class="fas fa-map-marker-alt text-primary mr-2"></i>
                            Paso 3: Ubicación
                        </h4>
                        
                        <div class="form-group">
                            <label for="address">
                                Dirección <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('address') is-invalid @enderror" 
                                   id="address" 
                                   name="address" 
                                   value="{{ old('address', $fundacion->address ?? '') }}" 
                                   required
                                   x-model="address"
                                   placeholder="Ej: Av. Principal #123, Ciudad, Departamento">
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Dirección física de la fundación (calle, número, ciudad, departamento).
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

                    <!-- Step 4: Revisar y Finalizar -->
                    <div x-show="currentStep === 4" x-transition class="step-content">
                        <h4 class="mb-4">
                            <i class="fas fa-check-circle text-primary mr-2"></i>
                            Paso 4: Revisar y Finalizar
                        </h4>
                        
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
                                    <div class="col-md-3 font-weight-bold">Misión:</div>
                                    <div class="col-md-9" x-text="mission || 'No especificada'"></div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-3 font-weight-bold">Descripción:</div>
                                    <div class="col-md-9" x-text="description ? (description.length > 100 ? description.substring(0, 100) + '...' : description) : 'No especificada'"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 font-weight-bold">Dirección:</div>
                                    <div class="col-md-9" x-text="address || 'No especificada'"></div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" @click="currentStep = 3" class="btn btn-secondary">
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

