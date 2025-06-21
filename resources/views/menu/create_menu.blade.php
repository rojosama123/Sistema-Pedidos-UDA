<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>UDA Lunch - Crear Menú</title>
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
                   class="block py-2 px-4 rounded-lg font-medium transition {{ request()->routeIs('menu.create_menu') ? 'bg-blue-100 text-blue-800' : 'hover:bg-gray-100 text-gray-700' }}">
                   🍽️ Visualización de Menús
                </a>
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
    <main class="flex-1 p-8 overflow-y-auto space-y-8">

        <!-- Casino actual -->
        <div class="text-center">
            <h2 class="text-3xl font-bold text-gray-800">Casino Actual:</h2>
            <p class="text-2xl font-semibold text-blue-600 mt-1" x-text="casinoActual"></p>
        </div>

        @if($menuExistente)
            <div class="max-w-4xl mx-auto bg-yellow-100 text-yellow-900 p-6 rounded-lg shadow">
                <h2 class="text-xl font-semibold mb-2">⚠️ Ya existe un menú creado para hoy en este casino.</h2>
                <p>Solo puedes crear un menú por día. Puedes editar el menú existente desde la sección de visualización.</p>
                <a href="{{ route('menu.index') }}" class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Ver Menú Actual
                </a>
            </div>
        @else
             <!-- Formulario de creación -->
            <div class="max-w-4xl mx-auto" x-data="menuForm()">
                <div class="bg-white rounded-xl shadow p-6 mb-6">
                    <h1 class="text-2xl font-bold text-gray-800 mb-6">🍽️ Agregar plato/s al menú del día</h1>

                    <form method="POST" action="{{ route('menu.store') }}" class="space-y-6">
                        @csrf
                        <input type="hidden" name="casino" value="{{ $casino }}">

                        <template x-for="(plato, index) in items" :key="index">
                            <div class="bg-gray-50 rounded-lg shadow-sm p-5 space-y-4 border border-gray-200 mb-6 relative">
                                <!-- Separador visual mejorado -->
                                <div class="absolute -top-4 left-0 right-0 flex items-center justify-center">
                                    <div class="flex-grow h-px bg-gray-300"></div>
                                    <div class="mx-3 bg-white px-3">
                                        <span class="text-sm font-medium text-gray-600">Plato #</span>
                                        <span x-text="index + 1" class="text-base font-semibold text-blue-600"></span>
                                    </div>
                                    <div class="flex-grow h-px bg-gray-300"></div>
                                </div>
                                
                                <!-- Campos del formulario -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">🍛 Nombre del Plato</label>
                                    <input type="text"
                                        :name="'items[' + index + '][nombre]'"
                                        x-model="items[index].nombre"
                                        class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2"
                                        required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">📝 Descripción</label>
                                    <textarea :name="'items[' + index + '][descripcion]'"
                                            x-model="items[index].descripcion"
                                            class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2"
                                            rows="3"
                                            required></textarea>
                                </div>

                                <div x-data="{
                                    items: [
                                        { precio: 2600 } // Puedes agregar más objetos si necesitas más inputs
                                    ]
                                }">
                                    <template x-for="(item, index) in items" :key="index">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                                💰 Precio (mínimo = $2600)
                                            </label>
                                            <input type="number"
                                                :name="'items[' + index + '][precio]'"
                                                x-model="items[index].precio"
                                                class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2"
                                                min="2600"
                                                step="0"
                                                required>
                                        </div>
                                    </template>
                                </div>

                                <!-- Botón de eliminar como botón sólido -->
                                <button type="button" 
                                        @click="eliminarPlato(index)" 
                                        x-show="items.length > 1" 
                                        class="mt-3 flex items-center justify-center gap-2 bg-red-100 hover:bg-red-200 text-red-700 px-4 py-2 rounded-lg transition-colors border border-red-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Eliminar plato
                                </button>
                            </div>
                        </template>


                        <div class="flex justify-between items-center mt-8">
                            <button type="button" 
                                    @click="agregarPlato()" 
                                    class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded-lg transition flex items-center">
                                ➕ Agregar otro plato
                            </button>

                            <div class="flex space-x-4">
                                <a href="{{ route('menu.index') }}" 
                                class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg transition">
                                    Cancelar
                                </a>
                                <button type="submit" 
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition flex items-center">
                                    💾 Guardar Menú
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        @endif
       

        <script>
            function menuForm() {
                return {
                    items: [{ nombre: '', descripcion: '', precio: '' }],
                    agregarPlato() {
                        this.items.push({ nombre: '', descripcion: '', precio: '' });
                    },
                    eliminarPlato(index) {
                        if (this.items.length > 1) {
                            if (confirm('¿Estás seguro de eliminar este plato?')) {
                                this.items.splice(index, 1);
                            }
                        }
                    }
                }
            }
        </script>

    </main>
</div>

</body>
</html>