<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #606965 0%, #606965 50%, #606965 100%);
            min-height: 100vh;
        }
        .auth-container {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }
        @media (max-width: 767px) {
            .auth-container {
                margin: 1rem;
                border-radius: 0.75rem;
            }
            .form-section {
                padding: 2rem 1.5rem;
            }
        }
    </style>
</head>
<body class="flex items-center justify-center p-4">
    <div class="flex w-full max-w-5xl auth-container rounded-xl overflow-hidden">
        
        <!-- Lado izquierdo: formulario - Siempre visible -->
        <div class="w-full md:w-1/2 bg-[#2D4A44] p-8 md:p-10 text-white flex flex-col justify-center">
            <div class="max-w-md mx-auto w-full">
                <!-- Logo con tamaño responsive -->
                <div class="flex justify-center mb-6 md:mb-8">
                    <img src="{{ asset('img/logo.png') }}" alt="Logo" class="h-50 w-auto">
                </div>

                <!-- Título -->
                <div class="text-center mb-6 md:mb-8">
                    <h2 class="text-2xl md:text-3xl font-semibold mb-2 flex items-center justify-center gap-2">
                        Bienvenido
                        <span class="text-[#E8C547] w-5 h-5 md:w-6 md:h-6 inline-block">
                            <svg viewBox="0 -57 400 400" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="m100.921875 140.949219c-1.855469 2.25-4.785156 3.308593-7.652344 2.765625-2.699219-.496094-5.441406-.753906-8.1875-.769532-9.449219.019532-18.234375 2.734376-24.746093 7.738282-2.519532 2.140625-4.753907 4.601562-6.640626 7.316406h292.632813c-6.617187-11-25.144531-17.9375-42.121094-13.855469-2.175781.574219-4.492187.1875-6.367187-1.0625-1.871094-1.25-3.117188-3.242187-3.417969-5.472656-2.601563-18.027344-18.160156-33.910156-40.609375-41.449219-35.792969-12.019531-77.453125.050782-92.871094 26.914063-1.761718 3.066406-5.332031 4.613281-8.777344 3.796875-19.539062-4.613282-40.613281 1.171875-51.242187 14.078125zm0 0"/>
                                <path d="m0 202c.00390625 3.3125 2.6875 5.996094 6 6h388c3.3125-.003906 5.996094-2.6875 6-6v-28h-400zm0 0"/>
                                <path d="m372.550781 258.078125 4.382813-34.078125h-353.867188l4.382813 34.078125c2.082031 15.949219 15.65625 27.890625 31.738281 27.921875h281.625c16.082031-.03125 29.65625-11.972656 31.738281-27.921875zm0 0"/>
                                <path d="m208 53v-45c0-4.417969-3.582031-8-8-8s-8 3.582031-8 8v45c0 4.417969 3.582031 8 8 8s8-3.582031 8-8zm0 0"/>
                                <path d="m148 53v-25c0-4.417969-3.582031-8-8-8s-8 3.582031-8 8v25c0 4.417969 3.582031 8 8 8s8-3.582031 8-8zm0 0"/>
                                <path d="m260 61c4.417969 0 8-3.582031 8-8v-25c0-4.417969-3.582031-8-8-8s-8 3.582031-8 8v25c0 4.417969 3.582031 8 8 8zm0 0"/>
                            </svg>
                        </span>
                    </h2>
                    <p class="text-gray-300 text-sm md:text-base">Por favor ingresa tus credenciales</p>
                </div>

                @if ($errors->any())
                    <div class="mb-4 md:mb-6 text-red-200 bg-red-900 bg-opacity-30 p-3 rounded-lg border border-red-800 text-sm">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-4 md:space-y-5">
                    @csrf
                    <div>
                        <input 
                            type="text" 
                            name="email" 
                            placeholder="Correo electrónico" 
                            required 
                            class="w-full px-4 py-2 md:px-5 md:py-3 rounded-lg bg-[#3A5650] border border-[#4A6A63] focus:border-[#E8C547] focus:ring-1 focus:ring-[#E8C547] outline-none transition duration-200 placeholder-gray-400 text-sm md:text-base" 
                        />
                    </div>
                    
                    <div>
                        <input 
                            type="password" 
                            name="password" 
                            placeholder="Contraseña" 
                            required 
                            class="w-full px-4 py-2 md:px-5 md:py-3 rounded-lg bg-[#3A5650] border border-[#4A6A63] focus:border-[#E8C547] focus:ring-1 focus:ring-[#E8C547] outline-none transition duration-200 placeholder-gray-400 text-sm md:text-base" 
                        />
                    </div>
                    
                    <button 
                        type="submit" 
                        class="w-full py-2 md:py-3 rounded-lg bg-[#E8C547] text-[#2D4A44] font-medium hover:bg-[#F0D05A] focus:outline-none focus:ring-2 focus:ring-[#E8C547] focus:ring-offset-2 focus:ring-offset-[#2D4A44] transition duration-200 text-sm md:text-base"
                    >
                        Iniciar sesión
                    </button>

                    <div class="text-center pt-1 md:pt-2">
                        <a 
                            href="{{ route('password.request') }}" 
                            class="text-xs md:text-sm text-gray-300 hover:text-[#E8C547] transition duration-200"
                        >
                            ¿Olvidaste tu contraseña?
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sección derecha: imagen - Solo en desktop -->
        <div class="hidden md:flex w-1/2 bg-[#3A5650] items-center justify-center relative">
            <div class="absolute inset-0 bg-gradient-to-r from-[#3A5650] to-[#2D4A44] opacity-50"></div>
            <div class="relative w-full h-full">
                <img 
                    src="{{ asset('img/login-plato.jpg') }}" 
                    alt="Plato de comida" 
                    class="w-full h-full object-cover"
                />
                <div class="absolute inset-0 bg-gradient-to-t from-[#2D4A44] to-transparent opacity-40"></div>
                <div class="absolute bottom-8 left-0 right-0 text-center px-8">
                </div>
            </div>
        </div>
    </div>
</body>
</html>