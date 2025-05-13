<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>UDA Lunch - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
                <a href="#" class="block py-2 px-4 rounded hover:bg-gray-100 text-gray-700 font-medium">Inicio</a>
                <a href="#" class="block py-2 px-4 rounded hover:bg-gray-100 text-gray-700 font-medium">Historial de Pedidos</a>
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

    <!-- Main Content -->
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

        <!-- Tabla de Pedidos -->
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4 text-gray-700">Pedidos Recientes</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full text-left border border-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 border-b">N° Pedido</th>
                            <th class="px-4 py-2 border-b">Nombre</th>
                            <th class="px-4 py-2 border-b">Menú</th>
                            <th class="px-4 py-2 border-b">Fecha</th>
                            <th class="px-4 py-2 border-b">Hora</th>
                            <th class="px-4 py-2 border-b">Nota del cliente</th>
                            <th class="px-4 py-2 border-b">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Fila de ejemplo -->
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border-b">001</td>
                            <td class="px-4 py-2 border-b">María López</td>
                            <td class="px-4 py-2 border-b">Arroz con pollo</td>
                            <td class="px-4 py-2 border-b">2025-05-12</td>
                            <td class="px-4 py-2 border-b">12:30</td>
                            <td class="px-4 py-2 border-b">Sin cebolla, por favor</td>
                            <td class="px-4 py-2 border-b">
                                <span class="px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    Entregado
                                </span>
                            </td>
                        </tr>

                        <!-- Puedes duplicar esta fila y cambiar los valores para otros estados -->
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border-b">002</td>
                            <td class="px-4 py-2 border-b">Juan Pérez</td>
                            <td class="px-4 py-2 border-b">Pastel de choclo</td>
                            <td class="px-4 py-2 border-b">2025-05-12</td>
                            <td class="px-4 py-2 border-b">13:00</td>
                            <td class="px-4 py-2 border-b">Agregar servilleta</td>
                            <td class="px-4 py-2 border-b">
                                <span class="px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    Listo para retirar
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>


    </main>

</div>

</body>
</html>
