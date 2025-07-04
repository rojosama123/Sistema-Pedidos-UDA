<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña - UDA Lunch</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        // Colores de la imagen "UDA LUNCH"
                        'uda-lunch-dark-green': '#2E4A42',   // Verde oscuro de fondo izquierdo
                        'uda-lunch-yellow': '#F4C518',       // Amarillo/Dorado del botón y acentos
                        'uda-lunch-light-gray': '#F5F5F5',   // Gris claro del fondo general
                        'uda-lunch-medium-gray': '#D4D4D4',  // Un gris intermedio para el fondo derecho si no hay imagen
                        'uda-lunch-input-bg': '#4A635B',     // Fondo para inputs en el panel oscuro
                        'uda-lunch-input-border': '#6B8B7F', // Borde para inputs
                        'uda-lunch-text-light': '#E0E0E0',   // Texto claro para el panel oscuro
                        'uda-lunch-text-dark': '#333333',    // Texto oscuro para el panel claro (si existiera)
                        'uda-lunch-accent-green': '#3B7A57',// Un verde más claro para acentos
                        'uda-lunch-white': '#FFFFFF',        // Blanco puro
                    },
                    fontFamily: {
                        'sans': ['Roboto', 'Arial', 'sans-serif'], // Usaremos Roboto
                    }
                }
            }
        }
    </script>

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #F5F5F5; 
        }

        .uda-login-container {
            display: flex;
            min-height: 100vh;
            overflow: hidden;
            background-color: #F5F5F5;
        }

        .uda-left-panel {
            background-color: #2E4A42; /* Verde oscuro */
            width: 40%; 
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            position: relative;
            overflow: hidden;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Patrón de cubiertos sutil */
        .uda-left-panel::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            /* Aquí puedes usar tu SVG de cubiertos si lo tienes, o mantener este degradado */
            /* background-image: url('{{ asset('images/cubiertos-pattern.svg') }}'); */
            background-image: radial-gradient(circle at 15% 20%, rgba(255, 255, 255, 0.03) 0%, transparent 20%),
                              radial-gradient(circle at 85% 70%, rgba(255, 255, 255, 0.03) 0%, transparent 20%);
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            opacity: 0.8;
            z-index: 0;
        }

        .uda-left-panel > * { 
            position: relative;
            z-index: 1;
        }

        /* Panel derecho, flexible para imagen o contenido */
        .uda-right-panel {
            flex-grow: 1; 
            width: 60%; 
            background-color: #D4D4D4; /* Gris intermedio por defecto */
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        /* Clase para cuando el panel derecho tiene una imagen de fondo */
        .uda-right-panel.with-image {
            background-size: cover;
            /* Ajusta la posición de la imagen aquí para que se vea bien */
            background-position: center; /* O prueba 'top center', 'bottom center', '50% 30%' */
            background-repeat: no-repeat;
        }

        .uda-form-content-wrapper { 
            width: 100%;
            max-width: 320px; /* Ancho máximo del formulario como en la imagen de referencia */
        }

        .uda-input-field {
            background-color: #4A635B; /* Fondo de input */
            border: 1px solid #6B8B7F; /* Borde de input */
            color: #E0E0E0; /* Color del texto del input */
            border-radius: 8px; 
            padding: 0.75rem 1rem; 
            width: 100%;
            transition: all 0.2s ease-in-out;
            box-shadow: inset 0 1px 3px rgba(0,0,0,0.2); 
        }
        .uda-input-field::placeholder {
            color: #A0B9B0; 
        }
        .uda-input-field:focus {
            outline: none;
            border-color: #F4C518; /* Borde amarillo al enfocar */
            box-shadow: 0 0 0 2px rgba(244, 197, 24, 0.3); 
            background-color: #3E544C; 
        }

        .uda-button {
            background-color: #F4C518; /* Amarillo/Dorado del botón */
            color: #2E4A42; /* Texto en verde oscuro */
            font-weight: 700; 
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            transition: all 0.2s ease-in-out;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); 
            text-transform: uppercase; 
            letter-spacing: 0.05em; 
        }
        .uda-button:hover {
            background-color: #E8D373; 
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
            transform: translateY(-2px);
        }
        .uda-button:active {
            background-color: #DDAA00; 
            transform: translateY(0);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .uda-link {
            color: #F4C518; /* Amarillo/Dorado para enlaces */
            font-weight: 500;
            transition: all 0.2s ease-in-out;
        }
        .uda-link:hover {
            color: #E8D373; 
            text-decoration: underline;
        }

        /* Media queries para responsividad */
        @media (max-width: 768px) {
            .uda-login-container {
                flex-direction: column; 
            }
            .uda-left-panel {
                width: 100%; 
                min-height: 50vh; 
                padding: 1.5rem;
            }
            .uda-right-panel {
                width: 100%;
                min-height: 50vh; 
                display: flex; 
                background-color: #D4D4D4; 
            }
            .uda-right-panel.with-image {
                 /* Mantener la imagen de fondo en móvil si se desea */
            }
        }

        /* Opcional: Ajuste para pantallas muy pequeñas */
        @media (max-width: 480px) {
            .uda-left-panel, .uda-right-panel {
                min-height: 45vh; 
            }
            .uda-left-panel {
                padding: 1rem;
            }
            .uda-form-content-wrapper {
                max-width: 100%; 
            }
        }
    </style>
</head>
<body class="bg-uda-lunch-light-gray">
    <div class="uda-login-container">
        <div class="uda-left-panel">
            <div class="text-center mb-8 z-10">
                <img src="{{ asset('img/logo.png') }}" alt="Logo UDA Lunch" class="h-48 w-auto mx-auto mb-4">
                
                {{-- Si el logo real es el escudo con "UDA LUNCH" como en la imagen de referencia, la ruta sería algo como: --}}
                {{-- <img src="{{ asset('images/uda_lunch_logo_full.png') }}" alt="Logo UDA Lunch" class="h-48 w-auto mx-auto mb-4"> --}}
                {{-- Asegúrate de que 'img/logo.png' apunta a la imagen correcta en tu proyecto. --}}

            </div>
            
            <div class="uda-form-content-wrapper z-10">
                <h1 class="text-2xl font-bold text-uda-lunch-light-gray mb-2 text-center">Restablecer contraseña</h1>
                <p class="text-sm text-uda-lunch-text-light mb-6 text-center leading-relaxed">
                    Ingresa tu correo electrónico institucional para recibir el enlace de restablecimiento.
                </p>

                @if (session('status'))
                    <div class="mb-4 p-3 bg-uda-lunch-yellow bg-opacity-20 text-uda-lunch-yellow rounded-md text-sm border border-uda-lunch-yellow border-opacity-30">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label for="email" class="sr-only">Correo Electrónico Institucional</label>
                        <input id="email" 
                               class="uda-input-field" 
                               type="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required 
                               autofocus 
                               placeholder="Correo electrónico" />
                        
                        @error('email')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-2">
                        <button type="submit" 
                                class="uda-button w-full">
                            Enviar enlace de restablecimiento
                        </button>
                    </div>
                </form>
                
                <div class="mt-6 text-center">
                    <a href="{{ route('login') }}" class="uda-link text-sm">
                        ← Volver al inicio de sesión
                    </a>
                </div>
            </div>
        </div>

        <div class="uda-right-panel with-image" 
             style="background-image: url('{{ asset('img/uda.jpg') }}');"> 
             {{-- Usando directamente la imagen de la universidad que proporcionaste --}}
             {{-- Ajusta 'background-position' en el CSS de .uda-right-panel.with-image si la imagen no se centra bien --}}

           
            <div class="absolute inset-0 bg-black opacity-30"></div>
        </div>
    </div>
</body>
</html>