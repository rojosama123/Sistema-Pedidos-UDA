<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>UDA Lunch - Historial</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- TailwindCSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js CDN -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 text-gray-800" 
      x-data="{ 
          open: false, 
          casinoActual: '{{ $casino }}',
          showDetalle: false,
          pedidoSeleccionado: {}
      }">

<div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-md flex flex-col justify-between">
        <div>
            <div class="h-16 flex items-center justify-center border-b">
                <h1 class="text-2xl font-bold text-blue-700">UDA Lunch</h1>
            </div>
            <nav class="px-6 py-4 space-y-2">
                <a href="{{ route('dashboard') }}" class="block py-2 px-4 rounded-lg hover:bg-gray-100 text-gray-700 font-medium">
                    🏠 Inicio
                </a>
                <a href="{{ route('pedidos.historial') }}"
                    class="block py-2 px-4 rounded-lg font-medium {{ request()->routeIs('pedidos.historial') ? 'bg-blue-100 text-blue-800' : 'hover:bg-gray-100 text-gray-700' }}">
                    📜 Historial de Pedidos
                </a>
                <a href="{{ route('menu.index') }}" class="block py-2 px-4 rounded-lg hover:bg-gray-100 text-gray-700 font-medium">
                    🍽️ Visualización de Menús
                </a>
                <button @click="open = true" class="block w-full text-left py-2 px-4 rounded-lg hover:bg-gray-100 text-gray-700 font-medium">
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

    <!-- Contenido principal -->
    <main class="flex-1 p-8 overflow-y-auto space-y-8">

        <!-- Popup Modal -->
        <div x-show="open" x-transition class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-xl shadow-lg w-96" @click.away="open = false">
                <h3 class="text-xl font-semibold mb-4 text-gray-800">Selecciona un Casino</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('pedidos.historial', ['casino' => 'Casino Norte']) }}" class="block px-4 py-2 rounded-lg hover:bg-blue-100">🍽️ Casino Norte</a></li>
                    <li><a href="{{ route('pedidos.historial', ['casino' => 'Casino Teplinsky']) }}" class="block px-4 py-2 rounded-lg hover:bg-blue-100">🍽️ Casino Teplinsky</a></li>
                    <li><a href="{{ route('pedidos.historial', ['casino' => 'Casino Sur']) }}" class="block px-4 py-2 rounded-lg hover:bg-blue-100">🍽️ Casino Sur</a></li>
                </ul>
                <div class="mt-4 text-right">
                    <button @click="open = false" class="text-sm text-blue-600 hover:underline">Cerrar</button>
                </div>
            </div>
        </div>

        <!-- Modal de Detalles del Pedido -->
        <div x-show="showDetalle" x-transition class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-xl shadow-lg w-full max-w-xl relative" @click.away="showDetalle = false">
                <h2 class="text-2xl font-bold text-blue-700 mb-4">Detalles del Pedido</h2>

                <template x-if="pedidoSeleccionado">
                    <div class="space-y-2">
                        <div><strong>👤 Nombre:</strong> <span x-text="pedidoSeleccionado.nombre"></span></div>
                        <div><strong>📅 Fecha:</strong> <span x-text="pedidoSeleccionado.fecha"></span></div>
                        <div><strong>🕒 Hora:</strong> <span x-text="pedidoSeleccionado.hora"></span></div>
                        <div><strong>🏢 Casino:</strong> <span x-text="pedidoSeleccionado.casino"></span></div>
                        <div><strong>📌 Estado:</strong> <span x-text="pedidoSeleccionado.estado"></span></div>

                        <template x-if="pedidoSeleccionado.platos && pedidoSeleccionado.platos.length">
                            <div class="mt-4">
                                <p class="font-semibold text-gray-800 mb-2">🍛 Platos solicitados:</p>
                                <ul class="space-y-3 border-t pt-2">
                                    <template x-for="(plato, index) in pedidoSeleccionado.platos" :key="plato.id">
                                        <li class="bg-gray-100 p-3 rounded-lg shadow-sm">
                                            <div class="font-semibold">Plato #<span x-text="index + 1"></span></div>
                                            <div><strong>Nombre:</strong> <span x-text="plato.nombre"></span></div>
                                            <div><strong>Precio:</strong> $<span x-text="plato.precio"></span></div>
                                            <template x-if="plato.nota">
                                                <div><strong>Nota:</strong> <span x-text="plato.nota"></span></div>
                                            </template>
                                        </li>
                                    </template>
                                </ul>
                            </div>
                        </template>
                    </div>
                </template>

                <div class="mt-6 text-right">
                    <button @click="showDetalle = false" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded">Cerrar</button>
                </div>
            </div>
        </div>

        <!-- Casino Actual -->
        <div class="text-center">
            <h2 class="text-3xl font-bold text-gray-800">Casino Actual:</h2>
            <p class="text-2xl font-semibold text-blue-600 mt-1" x-text="casinoActual"></p>
        </div>

        <h1 class="text-2xl font-bold mb-4">📋 Historial de Pedidos</h1>

        <!-- Filtros -->
        <form method="GET" class="flex flex-wrap items-end gap-4 mb-6 bg-white p-4 rounded-xl shadow">
            <input type="hidden" name="casino" value="{{ $casino }}">

            <!-- Select de filtro_fecha -->
            <div>
                <label class="block text-sm text-gray-700 mb-1" for="filtro_fecha">Filtrar por fecha</label>
                <select name="filtro_fecha" id="filtro_fecha" class="border-gray-300 rounded-lg px-3 py-2 w-full">
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
                <input type="date" name="fecha_inicio" id="fecha_inicio" value="{{ request('fecha_inicio') }}" class="border-gray-300 rounded-lg px-3 py-2 w-full">
            </div>

            <!-- Campo fecha_fin -->
            <div>
                <label class="block text-sm text-gray-700 mb-1" for="fecha_fin">Hasta</label>
                <input type="date" name="fecha_fin" id="fecha_fin" value="{{ request('fecha_fin') }}" class="border-gray-300 rounded-lg px-3 py-2 w-full">
            </div>

            <!-- Campo estado -->
            <div>
                <label class="block text-sm text-gray-700 mb-1" for="estado">Estado</label>
                <select name="estado" id="estado" class="border-gray-300 rounded-lg px-3 py-2 w-full">
                    <option value="todos">Todos</option>
                    <option value="En Preparación" {{ request('estado') == 'En Preparación' ? 'selected' : '' }}>En Preparación</option>
                    <option value="Listo para retirar" {{ request('estado') == 'Listo para retirar' ? 'selected' : '' }}>Listo para retirar</option>
                    <option value="Entregado" {{ request('estado') == 'Entregado' ? 'selected' : '' }}>Entregado</option>
                    <option value="Cancelado" {{ request('estado') == 'Cancelado' ? 'selected' : '' }}>Cancelado</option>
                </select>
            </div>

            <!-- Campo ordenar por -->
            <div>
                <label class="block text-sm text-gray-700 mb-1" for="orden">Orden</label>
                <select name="orden" id="orden" class="border-gray-300 rounded-lg px-3 py-2 w-full">
                    <option value="desc" {{ request('orden') == 'desc' ? 'selected' : '' }}>Descendente</option>
                    <option value="asc" {{ request('orden') == 'asc' ? 'selected' : '' }}>Ascendente</option>
                </select>
            </div>

            <!-- Botones de acción -->
            <div class="flex items-center gap-2">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">🔍 Filtrar</button>
                <a href="{{ route('pedidos.historial', ['casino' => $casino]) }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400 transition">🔄 Limpiar</a>
            </div>
        </form>

        <!-- Tabla de pedidos -->
        <div class="bg-white rounded-xl shadow overflow-x-auto">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-100 text-gray-600 uppercase">
                    <tr>
                        <th class="px-4 py-3">N° Pedido</th>
                        <th class="px-4 py-3">Nombre</th>
                        <th class="px-4 py-3">Fecha</th>
                        <th class="px-4 py-3">Hora</th>
                        <th class="px-4 py-3">Casino</th>
                        <th class="px-4 py-3">Estado</th>
                        <th class="px-4 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-gray-800">
                    @forelse ($pedidos as $pedido)
                        <tr class="hover:bg-gray-50 border-t">
                            <td class="px-4 py-3">{{ $pedido->id }}</td>
                            <td class="px-4 py-3">{{ $pedido->nombre }}</td>
                            <td class="px-4 py-3">{{ $pedido->fecha }}</td>
                            <td class="px-4 py-3">{{ $pedido->hora }}</td>
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
                                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $estilos[$pedido->estado] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $pedido->estado }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                @php
                                    $pedidoData = $pedido->toArray();
                                    $pedidoData['platos'] = $pedido->detalles->map(function ($detalle) {
                                        return [
                                            'id'     => $detalle->id,
                                            'nombre' => $detalle->plato,
                                            'precio' => $detalle->precio,
                                            'nota'   => $detalle->nota_cliente ?: null,
                                        ];
                                    })->toArray();
                                @endphp

                                <a href="#"
                                @click.prevent='pedidoSeleccionado = @json($pedidoData); showDetalle = true'
                                class="inline-block px-3 py-1 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition">
                                    👁️ Ver detalles
                                </a>
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