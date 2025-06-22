<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>UDA Lunch - Reseñas</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
                <a href="{{ route('dashboard') }}"
                   class="block py-2 px-4 rounded-lg font-medium transition {{ request()->routeIs('dashboard') ? 'bg-blue-100 text-blue-800' : 'hover:bg-gray-100 text-gray-700' }}">
                    🏠 Inicio
                </a>
                <a href="{{ route('pedidos.historial') }}"
                   class="block py-2 px-4 rounded-lg hover:bg-gray-100 text-gray-700 font-medium">
                   📜 Historial de Pedidos
                </a>
                <a href="{{ route('menu.index') }}"
                   class="block py-2 px-4 rounded-lg hover:bg-gray-100 text-gray-700 font-medium">
                   🍽️ Visualización de Menús
                </a>
                <a href="{{ route('reseñas.index') }}"
                   class="block py-2 px-4 rounded-lg bg-blue-100 text-blue-800 font-medium">
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

        <!-- Popup Modal -->
        <div x-show="open" x-transition class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-xl shadow-lg w-96" @click.away="open = false">
                <h3 class="text-xl font-semibold mb-4 text-gray-800">Selecciona un Casino</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('reseñas.index', ['casino' => 'Casino Norte']) }}" class="block px-4 py-2 rounded-lg hover:bg-blue-100">🍽️ Casino Norte</a></li>
                    <li><a href="{{ route('reseñas.index', ['casino' => 'Casino Teplinsky']) }}" class="block px-4 py-2 rounded-lg hover:bg-blue-100">🍽️ Casino Teplinsky</a></li>
                    <li><a href="{{ route('reseñas.index', ['casino' => 'Casino Sur']) }}" class="block px-4 py-2 rounded-lg hover:bg-blue-100">🍽️ Casino Sur</a></li>
                </ul>
                <div class="mt-4 text-right">
                    <button @click="open = false" class="text-sm text-blue-600 hover:underline">Cerrar</button>
                </div>
            </div>
        </div>

        <!-- Casino Actual -->
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

        <h1 class="text-2xl font-bold mb-4">🌟 Reseñas</h1>
        <form method="GET" class="mb-6 flex flex-wrap gap-4 items-end">
            <!-- Calificación -->
            <div>
                <label for="calificacion" class="block text-sm font-medium text-gray-700">Calificación</label>
                <select name="calificacion" id="calificacion" class="mt-1 block w-40 border-gray-300 rounded-md shadow-sm">
                    <option value="">Todas</option>
                    @for ($i = 5; $i >= 1; $i--)
                        <option value="{{ $i }}" {{ request('calificacion') == $i ? 'selected' : '' }}>{{ $i }} estrellas</option>
                    @endfor
                </select>
            </div>

            <!-- Fecha desde -->
            <div>
                <label for="desde" class="block text-sm font-medium text-gray-700">Desde</label>
                <input type="date" name="desde" id="desde" value="{{ request('desde') }}"
                    class="mt-1 block w-40 border-gray-300 rounded-md shadow-sm" />
            </div>

            <!-- Fecha hasta -->
            <div>
                <label for="hasta" class="block text-sm font-medium text-gray-700">Hasta</label>
                <input type="date" name="hasta" id="hasta" value="{{ request('hasta') }}"
                    class="mt-1 block w-40 border-gray-300 rounded-md shadow-sm" />
            </div>

            <div>
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700">
                    Filtrar
                </button>
            </div>
        </form>
        <div class="bg-white rounded-xl shadow overflow-x-auto">
            <table class="min-w-full text-sm text-left">
                <thead class="bg-gray-100 text-gray-600 uppercase">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Usuario</th>
                        <th class="px-4 py-3">Comentario</th>
                        <th class="px-4 py-3">Casino</th>
                        <th class="px-4 py-3">Calificación</th>
                        <th class="px-4 py-3">Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @php $contador = ($reseñas->currentPage() - 1) * $reseñas->perPage() + 1; @endphp

                    @forelse ($reseñas as $resena)
                        <tr class="hover:bg-gray-50 border-t">
                            <td class="px-4 py-3">{{ $contador++ }}</td>
                            <td class="px-4 py-3">{{ $resena->user->nombre ?? 'Anónimo' }}</td>
                            <td class="px-4 py-3">{{ $resena->comentario }}</td>
                            <td class="px-4 py-3">{{ $resena->casino}}</td>
                            <td class="px-4 py-3">
                                @for ($i = 1; $i <= 5; $i++)
                                    <span class="{{ $i <= $resena->calificacion ? 'text-yellow-400' : 'text-gray-300' }}">★</span>
                                @endfor
                            </td>
                            <td class="px-4 py-3">{{ $resena->created_at->format('d/m/Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-6 text-gray-500">No hay reseñas registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $reseñas->withQueryString()->links() }}
        </div>
    </main>
</div>

</body>
</html>
