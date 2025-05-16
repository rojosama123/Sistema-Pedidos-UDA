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
            <h2 class="text-3xl font-bold text-center mb-2">Bienvenido 🍲</h2>
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
                <input type="email" name="email" placeholder="Email" required class="w-full mb-4 px-4 py-2 rounded-full text-gray-800 placeholder-gray-500" />
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