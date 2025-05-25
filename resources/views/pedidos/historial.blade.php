<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de pedidos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- TailwindCSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js CDN -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100" x-data="{ open: false, casinoActual: 'Casino Norte' }">

<div class="flex h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-lg flex flex-col justify-between">
        <div>
            <div class="h-16 flex items-center justify-center border-b">
                <h1 class="text-xl font-bold text-gray-800">UDA Lunch</h1>
            </div>
            <nav class="px-6 py-4 space-y-2">
                <a href="{{ route('dashboard') }}" class="block py-2 px-4 rounded hover:bg-gray-100 text-gray-700 font-medium">Inicio</a>
                <a href="{{ route('historial.pedidos') }}"
                    class="block py-2 px-4 rounded font-medium {{ request()->routeIs('historial.pedidos') ? 'bg-blue-100 text-blue-800' : 'hover:bg-gray-100 text-gray-700' }}">
                    Historial de Pedidos
                </a>
                <a href="#" class="block py-2 px-4 rounded hover:bg-gray-100 text-gray-700 font-medium">Finanzas</a>
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
                    <li><button @click="casinoActual = 'Casino Norte'; open = false" class="w-full text-left px-4 py-2 rounded hover:bg-gray-100">Casino Norte</button></li>
                    <li><button @click="casinoActual = 'Casino Teplinsky'; open = false" class="w-full text-left px-4 py-2 rounded hover:bg-gray-100">Casino Teplinsky</button></li>
                    <li><button @click="casinoActual = 'Casino Sur'; open = false" class="w-full text-left px-4 py-2 rounded hover:bg-gray-100">Casino Sur</button></li>
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

        <h2 class="text-xl font-semibold mb-4 text-gray-700">Historial de Pedidos</h2>

        <!-- Filtros -->
        <form method="GET" class="flex flex-wrap items-end gap-4 mb-6">
            <!-- Select de filtro_fecha -->
            <div>
                <label class="block text-sm text-gray-700 mb-1" for="filtro_fecha">Filtrar por fecha</label>
                <select name="filtro_fecha" id="filtro_fecha" class="border-gray-300 rounded px-3 py-2 w-full">
                    <option value="">-- Seleccionar --</option>
                    <option value="hoy" {{ request('filtro_fecha') == 'hoy' ? 'selected' : '' }}>Hoy</option>
                    <option value="7dias" {{ request('filtro_fecha') == '7dias' ? 'selected' : '' }}>Últimos 7 días</option>
                    <option value="mes" {{ request('filtro_fecha') == 'mes' ? 'selected' : '' }}>Este mes</option>
                    <option value="rango" {{ request('filtro_fecha') == 'rango' ? 'selected' : '' }}>Rango personalizado</option>
                </select>
            </div>

            <!-- Campo fecha_inicio -->
            <div>
                <label class="block text-sm text-gray-700 mb-1" for="fecha_inicio">Desde</label>
                <input type="date" name="fecha_inicio" id="fecha_inicio" value="{{ request('fecha_inicio') }}" class="border-gray-300 rounded px-3 py-2 w-full">
            </div>

            <!-- Campo fecha_fin -->
            <div>
                <label class="block text-sm text-gray-700 mb-1" for="fecha_fin">Hasta</label>
                <input type="date" name="fecha_fin" id="fecha_fin" value="{{ request('fecha_fin') }}" class="border-gray-300 rounded px-3 py-2 w-full">
            </div>

            <!-- Campo estado -->
            <div>
                <label class="block text-sm text-gray-700 mb-1" for="estado">Estado</label>
                <select name="estado" id="estado" class="border-gray-300 rounded px-3 py-2 w-full">
                    <option value="todos">Todos</option>
                    <option value="En Preparación" {{ request('estado') == 'En Preparación' ? 'selected' : '' }}>En Preparación</option>
                    <option value="Listo para retirar" {{ request('estado') == 'Listo para retirar' ? 'selected' : '' }}>Listo para retirar</option>
                    <option value="Entregado" {{ request('estado') == 'Entregado' ? 'selected' : '' }}>Entregado</option>
                    <option value="Cancelado" {{ request('estado') == 'Cancelado' ? 'selected' : '' }}>Cancelado</option>
                </select>
            </div>

            <!-- Botones de acción -->
            <div class="flex items-center gap-2 mt-6">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Filtrar</button>
                <a href="{{ route('historial.pedidos') }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Limpiar</a>
            </div>
        </form>

        <!-- Tabla de pedidos -->
        <div class="bg-white shadow rounded-lg overflow-x-auto">
            <table class="min-w-full text-sm text-left border">
                <thead class="bg-gray-100 text-gray-600 uppercase">
                    <tr>
                        <th class="px-4 py-3 border-b">N° Pedido</th>
                        <th class="px-4 py-3 border-b">Nombre</th>
                        <th class="px-4 py-3 border-b">Menú</th>
                        <th class="px-4 py-3 border-b">Fecha</th>
                        <th class="px-4 py-3 border-b">Hora</th>
                        <th class="px-4 py-3 border-b">Nota</th>
                        <th class="px-4 py-3 border-b">Casino</th>
                        <th class="px-4 py-3 border-b">Estado</th>
                    </tr>
                </thead>
                <tbody class="text-gray-800">
                    @forelse ($pedidos as $pedido)
                        <tr class="hover:bg-gray-50 border-b">
                            <td class="px-4 py-3">{{ $pedido->id }}</td>
                            <td class="px-4 py-3">{{ $pedido->nombre }}</td>
                            <td class="px-4 py-3">{{ $pedido->menu }}</td>
                            <td class="px-4 py-3">{{ $pedido->fecha }}</td>
                            <td class="px-4 py-3">{{ $pedido->hora }}</td>
                            <td class="px-4 py-3">
                                @if ($pedido->nota_cliente)
                                    {{ $pedido->nota_cliente }}
                                @else
                                    <span class="text-gray-400 italic">📝 Sin nota</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">{{ $pedido->casino }}</td>
                            <td class="px-4 py-3">
                                @php
                                    $estilos = [
                                        'Entregado' => 'bg-green-100 text-green-800',
                                        'En Preparación' => 'bg-yellow-100 text-yellow-800',
                                        'Listo para retirar' => 'bg-blue-100 text-blue-800',
                                        'Cancelado' => 'bg-red-100 text-red-800',
                                    ];
                                @endphp
                                <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $estilos[$pedido->estado] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $pedido->estado }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-gray-500 py-6">No se encontraron pedidos con los filtros seleccionados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <div class="mt-6">
            @if ($pedidos->lastPage() > 1)
                {{ $pedidos->withQueryString()->links() }}
            @else
                <div class="text-sm text-gray-500 mt-4">Mostrando todos los pedidos (1 página)</div>
            @endif
        </div>

    </main>

</div>

</body>
</html>
