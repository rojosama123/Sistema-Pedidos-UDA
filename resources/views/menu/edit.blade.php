<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Menú - UDA Lunch</title>
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
                    class="block py-2 px-4 rounded font-medium {{ request()->routeIs('menu.edit') ? 'bg-blue-100 text-blue-800' : 'hover:bg-gray-100 text-gray-700' }}">
                    Visualización de Menús
                </a>
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


        <!-- Encabezado -->
        <div class="text-center mb-6">
            <h2 class="text-3xl font-bold text-gray-800">Casino Actual:</h2>
            <p class="text-2xl font-semibold text-blue-600 mt-1" x-text="casinoActual"></p>
        </div>

        <h1 class="text-2xl font-bold text-gray-800 mb-6">Editar Menú del Día ({{ $fecha }})</h1>

        <div class="container mx-auto p-6" x-data="menuFormEdit()">

            <form method="POST" action="{{ route('menu.update', $fecha) }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="casino" value="{{ $casino }}">

                <template x-for="(plato, index) in items" :key="index">
                    <div class="mb-4 bg-white rounded-lg shadow p-4 space-y-2">
                        <input type="hidden" :name="'items[' + index + '][id]'" x-model="plato.id">

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nombre del Plato</label>
                            <input type="text"
                                :name="'items[' + index + '][nombre]'"
                                x-model="plato.nombre"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Descripción</label>
                            <textarea :name="'items[' + index + '][descripcion]'"
                                      x-model="plato.descripcion"
                                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                      rows="2"
                                      required></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Precio ($)</label>
                            <input type="number"
                                :name="'items[' + index + '][precio]'"
                                x-model="plato.precio"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                min="2000"
                                step="50"
                                required>
                        </div>

                        <button type="button" @click="eliminarPlato(index)" x-show="items.length > 1" class="text-red-600 text-sm mt-2 hover:underline">
                            Eliminar este plato
                        </button>
                    </div>
                </template>

                <div class="flex justify-between items-center mt-6">
                    <button type="button" @click="agregarPlato()" class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded">
                        + Agregar otro plato
                    </button>

                    <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                        Actualizar Menú
                    </button>
                </div>
            </form>

        </div>

        <script>
            function menuFormEdit() {
                return {
                    items: @json($items),
                    agregarPlato() {
                        this.items.push({ nombre: '', descripcion: '', precio: '', id: null });
                    },
                    eliminarPlato(index) {
                        this.items.splice(index, 1);
                    }
                }
            }
        </script>

    </main>

</div>

</body>
</html>
