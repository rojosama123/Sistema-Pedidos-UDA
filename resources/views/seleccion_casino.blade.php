<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido a UDA Lunch</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2E4A42',
                        secondary: '#F4C518',
                        accent: '#3B7A57',
                        light: '#F5F5F5',
                    }
                }
            }
        }
    </script>
    <style>
        body {
            background-color: #F5F5F5;
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(46, 74, 66, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(244, 197, 24, 0.08) 0%, transparent 50%);
            background-attachment: fixed;
            background-size: 100% 100%;
        }
        .casino-card {
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            overflow: hidden;
            background: white;
        }
        .casino-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }
    </style>
</head>
<body class="min-h-screen font-poppins flex items-center justify-center p-6">
    <div class="w-full max-w-2xl mx-auto">
        <!-- Encabezado -->
        <div class="bg-primary rounded-2xl p-8 text-center text-white shadow-xl mb-8">
            <h1 class="text-3xl font-bold mb-2">¡Bienvenido a UDA Lunch!</h1>
            <p class="text-lg opacity-90">Selecciona el casino donde deseas realizar tus pedidos hoy</p>
        </div>

        <!-- Opciones de casino -->
        <div class="grid grid-cols-1 gap-5 mb-8">
            <!-- Casino Norte -->
            <a href="{{ route('pedidos.casino', ['nombre' => 'Casino Norte']) }}" class="casino-card">
                <div class="relative h-48 overflow-hidden">
                    <img src="{{ asset('img/casino norte.jpg') }}" alt="Casino Norte" 
                         class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent flex items-end p-4">
                        <h2 class="text-xl font-bold text-white">Casino Norte</h2>
                    </div>
                </div>
            </a>

            <!-- Casino Teplinky -->
            <a href="{{ route('pedidos.casino', ['nombre' => 'Casino Teplinsky']) }}" class="casino-card">
                <div class="relative h-48 overflow-hidden">
                    <img src="{{ asset('img/casino teplinsky.jpg') }}" alt="Casino Teplinky" 
                         class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent flex items-end p-4">
                        <h2 class="text-xl font-bold text-white">Casino Teplinsky</h2>
                    </div>
                </div>
            </a>

            <!-- Casino Sur -->
            <a href="{{ route('pedidos.casino', ['nombre' => 'Casino Sur']) }}" class="casino-card">
                <div class="relative h-48 overflow-hidden">
                    <img src="{{ asset('img/casino sur.jpg') }}" alt="Casino Sur" 
                         class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent flex items-end p-4">
                        <h2 class="text-xl font-bold text-white">Casino Sur</h2>
                    </div>
                </div>
            </a>
        </div>

        <!-- Botón de cerrar sesión -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" 
                    class="w-full flex items-center justify-center bg-secondary hover:bg-yellow-500 text-primary font-medium py-3 px-6 rounded-full transition shadow-md hover:shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd" />
                </svg>
                Cerrar sesión
            </button>
        </form>
    </div>
</body>
</html>