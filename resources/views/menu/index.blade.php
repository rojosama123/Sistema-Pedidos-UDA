<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>UDA Lunch - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 text-gray-800" x-data="{ open: false, casinoActual: '{{ $casino }}' }">

<div class="flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-md flex flex-col justify-between">
        <div>
            <div class="h-16 flex items-center justify-center border-b">
                <h1 class="text-2xl font-bold text-blue-700">UDA Lunch</h1>
            </div>
            <nav class="px-6 py-4 space-y-2">
                <a href="{{ route('dashboard') }}"
                   class="block py-2 px-4 rounded-lg font-medium transition {{ request()->routeIs('dashboard') ? 'bg-blue-100 text-blue-800' : 'hover:bg-gray-100 text-gray-700' }}">
                    🏠 Inicio
                </a>
                <a href="{{ route('pedidos.historial') }}" 
                   class="block py-2 px-4 rounded-lg hover:bg-gray-100 text-gray-700 font-medium">
                   📜 Historial de Pedidos
                </a>
                <a href="{{ route('menu.index') }}" 
                   class="block py-2 px-4 rounded-lg font-medium {{ request()->routeIs('menu.index') ? 'bg-blue-100 text-blue-800' : 'hover:bg-gray-100 text-gray-700' }}">
                   🍽️ Visualización de Menús
                </a>
                <a href="{{ route('reseñas.index') }}"
                   class="block py-2 px-4 rounded-lg hover:bg-gray-100 text-gray-700 font-medium">
                   🌟 Ver Reseñas
                </a>
                <button @click="open = true" 
                        class="block w-full text-left py-2 px-4 rounded-lg hover:bg-gray-100 text-gray-700 font-medium">
                    🔁 Cambiar de Casino
                </button>
            </nav>
        </div>
        <div class="px-6 py-4 space-y-2 border-t">
            <a href="#" class="block py-2 px-4 rounded-lg hover:bg-gray-100 text-gray-700 font-medium">📩 Contáctanos</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left py-2 px-4 rounded-lg text-red-600 hover:bg-red-100 font-medium">
                    🔓 Cerrar sesión
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8 overflow-y-auto">

        <!-- Modal: Cambiar Casino -->
        <div x-show="open" x-transition class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-xl shadow-lg w-96" @click.away="open = false">
                <h3 class="text-xl font-semibold mb-4 text-gray-800">Selecciona un Casino</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('menu.index', ['casino' => 'Casino Norte']) }}" class="block px-4 py-2 rounded-lg hover:bg-blue-100">🍽️ Casino Norte</a></li>
                    <li><a href="{{ route('menu.index', ['casino' => 'Casino Teplinsky']) }}" class="block px-4 py-2 rounded-lg hover:bg-blue-100">🍽️ Casino Teplinsky</a></li>
                    <li><a href="{{ route('menu.index', ['casino' => 'Casino Sur']) }}" class="block px-4 py-2 rounded-lg hover:bg-blue-100">🍽️ Casino Sur</a></li>
                </ul>
                <div class="mt-4 text-right">
                    <button @click="open = false" class="text-sm text-blue-600 hover:underline">Cerrar</button>
                </div>
            </div>
        </div>

        <!-- Casino actual -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold text-gray-800">Casino Actual:</h2>
            <p class="text-2xl font-semibold text-blue-600 mt-1" x-text="casinoActual"></p>
        </div>

        <!-- Promedio de calificación -->
        <div class="text-center mb-6">
            <h3 class="text-xl font-semibold text-gray-700">Promedio de Calificación:</h3>
            <p class="text-lg text-yellow-500 font-bold">
                @for ($i = 1; $i <= 5; $i++)
                    <span class="{{ $i <= round($promedio) ? 'text-yellow-400' : 'text-gray-300' }}">★</span>
                @endfor
                <span class="text-sm text-gray-600 ml-2">({{ number_format($promedio, 2) }} estrellas)</span>
            </p>
        </div>

        <!-- Menús del Día -->
        <div>
            <h1 class="text-2xl font-bold mb-6">🍽️ Menús del Día</h1>

            <div class="flex justify-between items-center mb-6">
                <a href="{{ route('menu.create_menu') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                    ➕ Agregar Menú
                </a>
            </div>

            @forelse ($menusAgrupados as $fecha => $menus)
                <div class="bg-white rounded-xl shadow p-6 mb-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-lg font-semibold text-gray-800">
                            📅 {{ \Carbon\Carbon::parse($fecha)->format('d/m/Y') }}
                        </h2>
                        <div class="flex space-x-3">
                            <a href="{{ route('menu.edit', $fecha) }}" 
                               class="text-blue-600 hover:text-blue-800 hover:underline flex items-center">
                                ✏️ Editar
                            </a>
                            <form method="POST" action="{{ route('menu.destroy', $fecha) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('¿Estás seguro de eliminar este menú?')" 
                                        class="text-red-600 hover:text-red-800 hover:underline flex items-center">
                                    🗑️ Eliminar
                                </button>
                            </form>
                        </div>
                    </div>

                    <ul class="space-y-3">
                        @foreach ($menus as $item)
                            <li class="flex justify-between items-center py-2 border-b last:border-b-0">
                                <span class="font-medium">{{ $item->nombre }}</span>
                                <span class="text-gray-600 font-semibold">${{ number_format($item->precio, 0, ',', '.') }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @empty
                <div class="bg-white rounded-xl shadow p-6 text-center">
                    <p class="text-gray-500">No hay menús disponibles para {{ $casino }}.</p>
                </div>
            @endforelse

        </div>

    </main>

</div>

</body>
</html>