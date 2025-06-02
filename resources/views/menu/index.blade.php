<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>UDA Lunch - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100" x-data="{ open: false, casinoActual: '{{ $casino }}' }">

<div class="flex h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-lg flex flex-col justify-between">
        <div>
            <div class="h-16 flex items-center justify-center border-b">
                <h1 class="text-xl font-bold text-gray-800">UDA Lunch</h1>
            </div>
            <nav class="px-6 py-4 space-y-2">
                <a href="{{ route('dashboard') }}"
                    class="block py-2 px-4 rounded font-medium {{ request()->routeIs('dashboard') ? 'bg-blue-100 text-blue-800' : 'hover:bg-gray-100 text-gray-700' }}">
                    Inicio
                </a>
                <a href="{{ route('pedidos.historial') }}" class="block py-2 px-4 rounded hover:bg-gray-100 text-gray-700 font-medium">Historial de Pedidos</a>
                <a href="{{ route('menu.index') }}"
                    class="block py-2 px-4 rounded font-medium {{ request()->routeIs('menu.index') ? 'bg-blue-100 text-blue-800' : 'hover:bg-gray-100 text-gray-700' }}">
                    Visualización de Menús
                </a>
                <button @click="open = true" class="block w-full text-left py-2 px-4 rounded hover:bg-gray-100 text-gray-700 font-medium">
                    Cambiar de Casino
                </button>
            </nav>
        </div>
        <div class="px-6 py-4 space-y-2 border-t">
            <a href="#" class="block py-2 px-4 rounded hover:bg-gray-100 text-gray-700 font-medium">Contáctanos</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left py-2 px-4 rounded text-red-600 hover:bg-red-100 font-medium">
                    Cerrar sesión
                </button>
            </form>
        </div>
    </aside>

    <!-- Contenido principal -->
    <main class="flex-1 p-8 overflow-y-auto">

        <!-- Popup Modal -->
        <div x-show="open" x-transition class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-80" @click.away="open = false">
                <h3 class="text-lg font-semibold mb-4 text-gray-800">Selecciona un Casino</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('menu.index', ['casino' => 'Casino Norte']) }}" class="w-full text-left block px-4 py-2 rounded hover:bg-gray-100">Casino Norte</a></li>
                    <li><a href="{{ route('menu.index', ['casino' => 'Casino Teplinsky']) }}" class="w-full text-left block px-4 py-2 rounded hover:bg-gray-100">Casino Teplinsky</a></li>
                    <li><a href="{{ route('menu.index', ['casino' => 'Casino Sur']) }}" class="w-full text-left block px-4 py-2 rounded hover:bg-gray-100">Casino Sur</a></li>
                </ul>
                <div class="mt-4 text-right">
                    <button @click="open = false" class="text-sm text-blue-600 hover:underline">Cerrar</button>
                </div>
            </div>
        </div>

        <!-- Casino Actual (centrado y grande) -->
        <div class="text-center mb-6">
            <h2 class="text-3xl font-bold text-gray-800">Casino Actual:</h2>
            <p class="text-2xl font-semibold text-blue-600 mt-1" x-text="casinoActual"></p>
        </div>

        <h1 class="text-2xl font-bold text-gray-800 mb-6">Menús del Día</h1>

        <!-- Tabla de Pedidos -->
        <div class="container mx-auto p-4">

            <div class="flex justify-between items-center mb-6">
                <a href="{{ route('menu.create_menu') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Agregar Menú
                </a>
            </div>

            @forelse ($menusAgrupados as $fecha => $menus)
                <div class="bg-white rounded-xl shadow p-4 mb-6">
                    <div class="flex justify-between items-center mb-3">
                        <h2 class="text-lg font-semibold text-gray-800">
                            {{ \Carbon\Carbon::parse($fecha)->format('d/m/Y') }}
                        </h2>
                        <div class="flex space-x-2">
                            <a href="{{ route('menu.edit', $fecha) }}" class="text-blue-600 hover:underline">Editar</a>
                            <form method="POST" action="{{ route('menu.destroy', $fecha) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('¿Estás seguro de eliminar este menú?')" class="text-red-600 hover:underline">
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    </div>

                    <ul class="space-y-1">
                        @foreach ($menus as $item)
                            <li class="flex justify-between border-b py-1 text-sm">
                                <span>{{ $item->nombre }}</span>
                                <span class="text-gray-600">${{ number_format($item->precio, 0, ',', '.') }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @empty
                <p class="text-gray-500">No hay menús disponibles para {{ $casino }}.</p>
            @endforelse

        </div>

    </main>

</div>

</body>
</html>
