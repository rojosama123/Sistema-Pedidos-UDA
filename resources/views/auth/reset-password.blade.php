<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Establecer Nueva Contraseña - UDA Lunch</title>
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
        }
        .uda-link:hover {
            color: #E8D373;
            text-decoration: underline;
        }

        .uda-error-message {
            color: #EF4444;
            /* También puedes ajustar el tamaño de la fuente aquí si quieres que los mensajes de error sean más grandes */
            font-size: 0.95rem; /* un poco más grande que text-sm */
            margin-top: 0.25rem;
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
                <h1 class="text-3xl font-bold text-uda-lunch-light-gray mb-3 text-center">Establecer Nueva Contraseña</h1>
                <p class="text-lg text-uda-lunch-text-light mb-8 text-center leading-relaxed">
                    Por favor, introduce tu nueva contraseña.
                </p>

                <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
                    @csrf

                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div>
                        <label for="email" class="sr-only">Correo Electrónico</label>
                        <input id="email"
                               class="uda-input-field"
                               type="email"
                               name="email"
                               value="{{ old('email', $request->email) }}"
                               required
                               autofocus
                               autocomplete="username"
                               placeholder="Correo electrónico" />
                        @error('email')
                            <p class="uda-error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label for="password" class="sr-only">Contraseña</label>
                        <input id="password"
                               class="uda-input-field"
                               type="password"
                               name="password"
                               required
                               autocomplete="new-password"
                               placeholder="Nueva Contraseña" />
                        @error('password')
                            <p class="uda-error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <label for="password_confirmation" class="sr-only">Confirmar Contraseña</label>
                        <input id="password_confirmation"
                               class="uda-input-field"
                               type="password"
                               name="password_confirmation"
                               required
                               autocomplete="new-password"
                               placeholder="Confirmar Contraseña" />
                        @error('password_confirmation')
                            <p class="uda-error-message">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                                class="uda-button w-full">
                            Restablecer Contraseña
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="uda-right-panel with-image"
             style="background-image: url('{{ asset('img/uda.jpg') }}');">
            <div class="absolute inset-0 bg-black opacity-30"></div>
        </div>
    </div>
    <div id="modalExito" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg p-8 max-w-sm w-full text-center">
            <h2 class="text-2xl font-bold text-green-700 mb-4">¡Contraseña cambiada con éxito!</h2>
            <p class="text-lg text-gray-700 mb-6">Ahora puedes iniciar sesión con tu nueva contraseña.</p>
            <a href="{{ route('login') }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded font-semibold text-lg">Ir a Iniciar Sesión</a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('status'))
                const statusMessage = "{{ session('status'), 'Contraseña actualizada.' }}";
                if (statusMessage.includes('Contraseña actualizada.') || statusMessage.includes('password') || statusMessage.includes('restablecida') || statusMessage.includes('reset')) {
                    document.getElementById('modalExito').classList.remove('hidden');
                }
            @endif
        });
    </script>
</body>
</html>