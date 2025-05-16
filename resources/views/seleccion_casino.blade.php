<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Selecciona tu Casino</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#F5F5F5] min-h-screen flex items-center justify-center">
    <div class="w-full max-w-7xl mx-auto text-center py-10 px-4">
        <div class="bg-[#2E4A42] rounded-3xl p-10 shadow-2xl">
            <h1 class="text-5xl font-extrabold mb-6 text-white">¡Bienvenido!</h1>
            <p class="text-2xl text-gray-100 mb-12">¿Dónde deseas realizar tus pedidos?</p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <!-- Casino Norte -->
                <a href="{{ route('pedidos.casino', ['nombre' => 'norte']) }}" class="block bg-white rounded-2xl shadow-md p-6 hover:shadow-xl transition duration-300 transform hover:scale-105">
                    <img src="{{ asset('img/casino norte.jpg') }}" alt="Casino Norte" class="w-full h-64 object-cover rounded-xl mb-5">
                    <h2 class="text-xl font-semibold text-[#2E4A42]">Casino Norte</h2>
                </a>

                <!-- Casino Teplinky -->
                <a href="{{ route('pedidos.casino', ['nombre' => 'teplinky']) }}" class="block bg-white rounded-2xl shadow-md p-6 hover:shadow-xl transition duration-300 transform hover:scale-105">
                    <img src="{{ asset('img/casino teplinsky.jpg') }}" alt="Casino Teplinky" class="w-full h-64 object-cover rounded-xl mb-5">
                    <h2 class="text-xl font-semibold text-[#2E4A42]">Casino Teplinky</h2>
                </a>

                <!-- Casino Sur -->
                <a href="{{ route('pedidos.casino', ['nombre' => 'sur']) }}" class="block bg-white rounded-2xl shadow-md p-6 hover:shadow-xl transition duration-300 transform hover:scale-105">
                    <img src="{{ asset('img/casino sur.jpg') }}" alt="Casino Sur" class="w-full h-64 object-cover rounded-xl mb-5">
                    <h2 class="text-xl font-semibold text-[#2E4A42]">Casino Sur</h2>
                </a>
            </div>

            <div class="mt-10">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="inline-block bg-[#F4C518] text-[#2E4A42] font-semibold px-6 py-3 rounded-full hover:bg-yellow-400 transition">
                        Cerrar sesión
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
