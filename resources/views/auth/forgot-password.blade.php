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
                        'uda-lunch-dark-green': '#2E4A42',
                        'uda-lunch-yellow': '#F4C518',
                        'uda-lunch-light-gray': '#F5F5F5',
                        'uda-lunch-medium-gray': '#D4D4D4',
                        'uda-lunch-input-bg': '#4A635B',
                        'uda-lunch-input-border': '#6B8B7F',
                        'uda-lunch-text-light': '#E0E0E0',
                        'uda-lunch-text-dark': '#333333',
                        'uda-lunch-accent-green': '#3B7A57',
                        'uda-lunch-white': '#FFFFFF',
                    },
                    fontFamily: {
                        'sans': ['Roboto', 'Arial', 'sans-serif'],
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
            background-color: #2E4A42;
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

        .uda-left-panel::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
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

        .uda-right-panel {
            flex-grow: 1;
            width: 60%;
            background-color: #D4D4D4;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .uda-right-panel.with-image {
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .uda-form-content-wrapper {
            width: 100%;
            max-width: 320px;
        }

        .uda-input-field {
            background-color: #4A635B;
            border: 1px solid #6B8B7F;
            color: #E0E0E0;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            width: 100%;
            transition: all 0.2s ease-in-out;
            box-shadow: inset 0 1px 3px rgba(0,0,0,0.2);
            /* Aumenta el tamaño de la fuente para los inputs */
            font-size: 1.125rem; /* text-lg en Tailwind */
        }
        .uda-input-field::placeholder {
            color: #A0B9B0;
        }
        .uda-input-field:focus {
            outline: none;
            border-color: #F4C518;
            box-shadow: 0 0 0 2px rgba(244, 197, 24, 0.3);
            background-color: #3E544C;
        }

        .uda-button {
            background-color: #F4C518;
            color: #2E4A42;
            font-weight: 700;
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            transition: all 0.2s ease-in-out;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            /* Aumenta el tamaño de la fuente para el botón */
            font-size: 1.125rem; /* text-lg en Tailwind */
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
            color: #F4C518;
            font-weight: 500;
            transition: all 0.2s ease-in-out;
            /* Aumenta el tamaño de la fuente para los enlaces */
            font-size: 1.125rem; /* text-lg en Tailwind */
        }
        .uda-link:hover {
            color: #E8D373;
            text-decoration: underline;
        }

        /* Estilo para los mensajes de estado y error */
        .status-message {
            font-size: 1.05rem; /* Un poco más grande que text-base, pero más pequeño que text-lg */
        }
        .error-message {
            font-size: 0.95rem; /* Un poco más grande que text-sm */
        }


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
        }

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
            </div>

            <div class="uda-form-content-wrapper z-10">
                <h1 class="text-3xl font-bold text-uda-lunch-light-gray mb-3 text-center">Restablecer Contraseña</h1>
                <p class="text-lg text-uda-lunch-text-light mb-8 text-center leading-relaxed">
                    Ingresa tu correo electrónico institucional para reestablecer su contraseña.
                </p>

                @if (session('status'))
                    <div class="mb-4 p-3 bg-uda-lunch-yellow bg-opacity-20 text-uda-lunch-yellow rounded-md border border-uda-lunch-yellow border-opacity-30 **status-message**">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
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
                               autocomplete="username"
                               placeholder="Correo electrónico" />

                        @error('email')
                            <p class="mt-1 text-red-400 **error-message**">{{ $message }}</p>
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
                    <a href="{{ route('login') }}" class="uda-link">
                        ← Volver al inicio de sesión
                    </a>
                </div>
            </div>
        </div>

        <div class="uda-right-panel with-image"
             style="background-image: url('{{ asset('img/uda.jpg') }}');">
            <div class="absolute inset-0 bg-black opacity-30"></div>
        </div>
    </div>
</body>
</html>