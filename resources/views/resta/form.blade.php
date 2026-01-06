@extends('layouts.app')

@section('title', 'Verifika - Generar Restas')

@section('content')
<link rel="stylesheet" href="{{ asset('css/base.css') }}">

<style>
    :root {
        --primary-color: rgb(38,186,165);
        --secondary-color: rgb(55,95,122);
        --white: #fff;
        --gray: #f4f6f8;
        --gray-dark: #bfc9d1;

        --radius-xl: 1.25rem;
        --radius-lg: 1rem;
        --radius-md: .85rem;

        --shadow-soft: 0 14px 40px rgba(16, 24, 40, .10);
        --shadow-glow: 0 18px 60px rgba(38,186,165,.18);
        --ring: 0 0 0 4px rgba(38,186,165,.18);
    }

    /* Fondo bonito */
    .restas-page {
        min-height: 100vh;
        background:
            radial-gradient(900px 600px at 12% 10%, rgba(38,186,165,.18), transparent 55%),
            radial-gradient(900px 600px at 88% 18%, rgba(55,95,122,.18), transparent 55%),
            linear-gradient(180deg, #fbfdff 0%, #f3f7f9 55%, #f7fafb 100%);
        padding: clamp(28px, 4vw, 48px) 0;
    }

    /* Card premium */
    .form-card {
        position: relative;
        border: 1px solid rgba(38,186,165,.35);
        border-radius: var(--radius-xl);
        background: rgba(255,255,255,.78);
        backdrop-filter: blur(10px);
        box-shadow: var(--shadow-soft);
        overflow: hidden;
        transform: translateY(0);
        transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease;
    }
    .form-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-soft), var(--shadow-glow);
        border-color: rgba(38,186,165,.55);
    }

    /* Glow decorativo */
    .form-card::before {
        content: "";
        position: absolute;
        inset: -2px;
        background: linear-gradient(90deg, rgba(38,186,165,.55), rgba(55,95,122,.55));
        opacity: .22;
        filter: blur(18px);
        z-index: 0;
    }
    .form-card > * { position: relative; z-index: 1; }

    /* Header bonito */
    .form-header {
        padding: 18px 18px 14px 18px;
        color: var(--white);
        background: linear-gradient(115deg, var(--primary-color), var(--secondary-color));
        border-bottom: 1px solid rgba(255,255,255,.22);
    }
    .header-badge {
        display: inline-flex;
        gap: .5rem;
        align-items: center;
        font-weight: 700;
        font-size: 1.05rem;
        letter-spacing: .2px;
    }
    .header-subtitle {
        margin-top: 6px;
        font-size: .95rem;
        opacity: .92;
    }

    /* Body spacing */
    .card-body {
        padding: clamp(18px, 3vw, 28px) !important;
    }

    /* Labels */
    .form-label {
        color: var(--secondary-color);
        font-weight: 650;
        font-size: .95rem;
        margin-bottom: .35rem;
    }

    /* Inputs */
    .input-wrap {
        position: relative;
    }
    .input-icon {
        position: absolute;
        top: 50%;
        left: 12px;
        transform: translateY(-50%);
        width: 34px;
        height: 34px;
        border-radius: 10px;
        display: grid;
        place-items: center;
        background: rgba(38,186,165,.12);
        color: var(--secondary-color);
        border: 1px solid rgba(38,186,165,.25);
        pointer-events: none;
    }


    .form-control, .form-select {
        border: 1.6px solid rgba(38,186,165,.55);
        border-radius: var(--radius-md);
        font-size: 1.05em;
        padding: .78rem .9rem .78rem 3.2rem; /* espacio para icono */
        background: rgba(255,255,255,.9);
        transition: box-shadow .2s ease, border-color .2s ease, transform .08s ease;
        width: 100%;
        min-width: 0;
        box-sizing: border-box;
        max-width: 100%;
    }
    .form-select { padding-left: 3.2rem; }

    .form-control:focus, .form-select:focus {
        border-color: rgba(55,95,122,.85);
        box-shadow: var(--ring);
        outline: none;
    }
    .form-control:active { transform: scale(.995); }

    /* Ayuditas / hint */
    .hint {
        margin-top: .35rem;
        font-size: .85rem;
        color: rgba(55,95,122,.78);
    }

    /* Botón pro */
    .btn-corporativo {
        width: 100%;
        max-width: 340px;
        background: linear-gradient(115deg, var(--primary-color), var(--secondary-color));
        color: #fff;
        border: none;
        border-radius: .95rem;
        padding: .95rem 1.1rem;
        font-weight: 750;
        letter-spacing: .2px;
        box-shadow: 0 10px 24px rgba(38,186,165,.22);
        transition: transform .12s ease, box-shadow .2s ease, filter .2s ease;
    }
    .btn-corporativo:hover {
        filter: brightness(1.03);
        transform: translateY(-1px);
        box-shadow: 0 14px 34px rgba(55,95,122,.18), 0 14px 34px rgba(38,186,165,.18);
        color: #fff;
    }
    .btn-corporativo:active {
        transform: translateY(0);
        box-shadow: 0 10px 20px rgba(38,186,165,.16);
    }

    /* Layout responsivo fino */
    /* Eliminar grid-2, ya no se usa */
    @media (max-width: 768px) {
        .form-control, .form-select {
            font-size: 1.02em;
            width: 100%;
            min-width: 0;
            max-width: 100%;
        }
    }

    /* Micro animación */
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-in { animation: fadeUp .45s ease both; }
</style>

<div class="restas-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-9 col-lg-6">
                <div class="form-card animate-in">
                    <!-- Eliminado logo duplicado y título superior -->
                        <div class="form-header d-flex align-items-center gap-3">
                            
                            <div>
                               
                                <div class="header-subtitle">
                                    Configura dificultad, dígitos y cantidad. Genera ejercicios listos para imprimir.
                                </div>
                            </div>
                        </div>

                    <div class="card-body">
                        <form action="{{ route('restas.store') }}" method="POST" novalidate>
                            @csrf

                            <div class="mb-3">
                                <label for="digitos_minuendo" class="form-label">Dígitos</label>
                                <div class="input-wrap">
                                    <div class="input-icon">#</div>
                                    <input
                                        type="number"
                                        name="digitos_minuendo"
                                        id="digitos_minuendo"
                                        class="form-control"
                                        min="1"
                                        value="{{ old('digitos_minuendo') }}"
                                        required
                                    >
                                </div>
                                <!-- Ayuda eliminada para limpieza visual -->
                                @error('digitos_minuendo')
                                    <div class="text-danger small mt-1" style="color:#dc3545;">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="cantidad_restas" class="form-label">Cantidad de restas</label>
                                <div class="input-wrap">
                                    <div class="input-icon">📄</div>
                                    <input
                                        type="number"
                                        name="cantidad_restas"
                                        id="cantidad_restas"
                                        class="form-control"
                                        min="1"
                                        value="{{ old('cantidad_restas') }}"
                                        required
                                    >
                                </div>
                                <!-- Ayuda eliminada para limpieza visual -->
                                @error('cantidad_restas')
                                    <div class="text-danger small mt-1" style="color:#dc3545;">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mt-3">
                                <label for="dificultad" class="form-label">Dificultad</label>
                                <div class="input-wrap">
                                    <div class="input-icon">⚙️</div>
                                    <select
                                        name="dificultad"
                                        id="dificultad"
                                        class="form-select"
                                        required
                                        onchange="actualizaMinimos()"
                                    >
                                        <option value="FACILINGO" {{ old('dificultad') == 'FACILINGO' ? 'selected' : '' }}>FACILINGO (0,1,2) - Sin acarreo</option>
                                        <option value="FACIL" {{ old('dificultad') == 'FACIL' ? 'selected' : '' }}>FACIL (1,2,3) - Sin acarreo</option>
                                        <option value="NORMAL" {{ old('dificultad') == 'NORMAL' ? 'selected' : '' }}>NORMAL (1,2,3,4) - Sin acarreo</option>
                                        <option value="DIFICIL" {{ old('dificultad') == 'DIFICIL' ? 'selected' : '' }}>DIFICIL (1,2,3,4,5) - 1 acarreo (unidades)</option>
                                        <option value="SUPERDIFICIL" {{ old('dificultad') == 'SUPERDIFICIL' ? 'selected' : '' }}>SUPERDIFICIL (1,2,3,4,5,6) - 2 acarreos (min. 3 dígitos)</option>
                                        <option value="ULTRADIFICIL" {{ old('dificultad') == 'ULTRADIFICIL' ? 'selected' : '' }}>ULTRADIFICIL (1,2,3,4,5,7) - 3 acarreos (min. 4 dígitos)</option>
                                        <option value="TIPOEXAMEN" {{ old('dificultad') == 'TIPOEXAMEN' ? 'selected' : '' }}>TIPOEXAMEN (0-9) - acarreos en todas menos la primera (min. 5 dígitos)</option>
                                    </select>
                                </div>
                                <div class="hint" id="hint-dificultad">
                                    Consejo: sube la dificultad solo cuando el niño resuelva sin borrar demasiado.
                                </div>
                                @error('dificultad')
                                    <div class="text-danger small mt-1" style="color:#dc3545;">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-center mt-4">
                                <button type="submit" class="btn-corporativo">
                                    Generar Restas
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="text-center mt-3" style="color: rgba(55,95,122,.7); font-size:.9rem;">
                    Hecho con 💚 para práctica rápida y ordenada.
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function actualizaMinimos() {
    const dif = document.getElementById('dificultad').value;
    const input = document.getElementById('digitos_minuendo');
    const hint = document.getElementById('hint-digitos');

    let minMinuendo = 1;
    let msg = "Mínimo según dificultad seleccionada.";

    if (dif === 'SUPERDIFICIL') { minMinuendo = 3; msg = "Esta dificultad requiere mínimo 3 dígitos."; }
    if (dif === 'ULTRADIFICIL') { minMinuendo = 4; msg = "Esta dificultad requiere mínimo 4 dígitos."; }
    if (dif === 'TIPOEXAMEN')   { minMinuendo = 5; msg = "Tipo examen requiere mínimo 5 dígitos."; }

    input.min = minMinuendo;
    hint.textContent = msg;

    if (parseInt(input.value || "0", 10) < minMinuendo) {
        input.value = minMinuendo;
    }
}

document.addEventListener('DOMContentLoaded', actualizaMinimos);
</script>
@endsection
