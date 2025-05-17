<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="flex w-full max-w-4xl bg-white rounded-lg shadow-lg overflow-hidden">
        
        <!-- Lado izquierdo: formulario -->
        <div class="w-1/2 bg-[#3e5c53] p-8 text-white flex flex-col justify-center">
            
            <!-- Logo -->
            <div class="flex justify-center mb-6">
                <img src="{{ asset('img/logo.png') }}" alt="Logo" class="h-25 w-25">
            </div>

            <!-- Título -->
            <h2 class="text-3xl font-bold mb-4 flex items-center justify-center gap-2">
                Bienvenido
                <span class="text-[#C3B14D] w-6 h-6 inline-block">
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

            <p class="text-center mb-6 text-sm">Por favor ingresa tus credenciales</p>

            @if ($errors->any())
                <div class="mb-4 text-red-300 bg-red-800 bg-opacity-20 p-2 rounded">
                    <ul class="list-disc pl-5 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <input type="text" name="email" placeholder="Email" required class="w-full mb-4 px-4 py-2 rounded-full text-gray-800 placeholder-gray-500" />
                <input type="password" name="password" placeholder="Contraseña" required class="w-full mb-6 px-4 py-2 rounded-full text-gray-800 placeholder-gray-500" />
                
                <button type="submit" class="w-full py-2 rounded-full bg-yellow-400 text-gray-800 font-semibold hover:bg-yellow-500 transition duration-300">
                    Iniciar sesión
                </button>

                <p class="text-sm text-center mt-4">
                    ¿Olvidaste tu contraseña? 
                    <a href="{{ route('password.request') }}" class="text-yellow-300 hover:underline">Recuperar contraseña</a>
                </p>
            </form>
        </div>

        <!-- Sección derecha: imagen -->
        <div class="hidden md:flex w-full md:w-1/2 bg-[#405A57] items-center justify-center rounded-b-lg md:rounded-b-none md:rounded-r-lg overflow-hidden">
            <img 
                src="{{ asset('img/login-plato.jpg') }}" 
                alt="Plato de comida" 
                class="w-full h-full object-cover"
            />
        </div>
    </div>
</body>
</html>
