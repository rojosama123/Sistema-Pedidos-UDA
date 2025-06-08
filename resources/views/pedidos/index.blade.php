<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Menú del Día - {{ $casino }} | UDA Lunch</title>
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
                    },
                    fontFamily: {
                        poppins: ['Poppins', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body {
            background-color: #F5F5F5;
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(46, 74, 66, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(244, 197, 24, 0.05) 0%, transparent 50%);
            padding-bottom: 80px;
        }
        .menu-card {
            transition: all 0.3s ease;
            border-left: 4px solid #3B7A57;
        }
        .menu-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
        }
        .floating-cart {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 50;
            transition: all 0.3s ease;
        }
        .floating-cart:hover {
            transform: scale(1.1);
        }
        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: #EF4444;
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
            animation: pulse 1.5s infinite;
        }
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0,0,0,0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 100;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }
        .modal-overlay.active {
            opacity: 1;
            pointer-events: all;
        }
        .modal-content {
            background: white;
            border-radius: 12px;
            width: 90%;
            max-width: 400px;
            transform: translateY(20px);
            transition: transform 0.3s ease;
        }
        .modal-overlay.active .modal-content {
            transform: translateY(0);
        }
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
    </style>
</head>
<body class="font-poppins min-h-screen">
    <div class="container mx-auto py-12 px-4 max-w-7xl">
        <!-- Encabezado -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-primary mb-3">Menú del Día</h1>
            <div class="inline-flex items-center bg-accent text-white px-4 py-2 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                </svg>
                <span class="font-medium">{{ $casino }}</span>
            </div>
            <p class="text-lg text-gray-600 mt-4 max-w-2xl mx-auto">Descubre las deliciosas opciones disponibles hoy en nuestro casino</p>
        </div>

        <!-- Contenido principal -->
        @if($platos->isEmpty())
            <div class="bg-secondary bg-opacity-20 text-primary p-6 rounded-xl text-center max-w-md mx-auto">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-3 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <h3 class="text-xl font-semibold mb-2">Menú no disponible</h3>
                <p class="text-gray-700">Actualmente no hay platos disponibles para hoy.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($platos as $plato)
                    <div class="menu-card bg-white p-6 rounded-lg shadow-md overflow-hidden relative">
                        <!-- Etiqueta de precio -->
                        <div class="absolute top-4 right-4 bg-secondary text-primary font-bold px-3 py-1 rounded-full text-sm">
                            ${{ number_format($plato->precio, 0, ',', '.') }}
                        </div>
                        
                        <div class="mb-4">
                            <h2 class="text-xl font-bold text-primary mb-2">{{ $plato->nombre }}</h2>
                            <p class="text-gray-600">{{ $plato->descripcion }}</p>
                        </div>
                        
                        <!-- Botón de acción -->
                        <button 
                            class="w-full bg-primary hover:bg-accent text-white font-medium py-2 px-4 rounded transition flex items-center justify-center add-to-cart"
                            data-plato-id="{{ $plato->id }}"
                            data-plato-nombre="{{ $plato->nombre }}"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                            </svg>
                            Añadir al pedido
                        </button>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Carrito flotante -->
    <div class="floating-cart">
        <div class="relative">
            <div class="cart-badge hidden">0</div>
            <button class="bg-secondary text-primary p-4 rounded-full shadow-lg hover:shadow-xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Modal para añadir notas -->
    <div class="modal-overlay" id="noteModal">
        <div class="modal-content p-6">
            <h3 class="text-xl font-bold text-primary mb-4" id="modalPlatoNombre"></h3>
            <p class="text-gray-600 mb-4">Si desea dejar una nota para el plato, escríbalo. En caso contrario, presione en "Añadir al pedido"</p>
            
            <textarea 
                id="platoNota" 
                class="w-full border border-gray-300 rounded-lg p-3 mb-4 focus:ring-2 focus:ring-accent focus:border-transparent" 
                rows="3" 
                placeholder="Ej: Sin picante, bien cocido, etc."
            ></textarea>
            
            <div class="flex space-x-3">
                <button 
                    id="cancelNote" 
                    class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded transition"
                >
                    Cancelar
                </button>
                <button 
                    id="confirmAdd" 
                    class="flex-1 bg-primary hover:bg-accent text-white font-medium py-2 px-4 rounded transition flex items-center justify-center"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                    </svg>
                    Añadir al pedido
                </button>
            </div>
        </div>
    </div>

    <!-- Script para manejar el carrito y modal -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cartBadge = document.querySelector('.cart-badge');
            const addButtons = document.querySelectorAll('.add-to-cart');
            const modal = document.getElementById('noteModal');
            const modalPlatoNombre = document.getElementById('modalPlatoNombre');
            const platoNota = document.getElementById('platoNota');
            const cancelNote = document.getElementById('cancelNote');
            const confirmAdd = document.getElementById('confirmAdd');
            
            let itemCount = 0;
            let currentPlatoId = null;
            let currentPlatoNombre = '';

            // Mostrar modal al hacer clic en añadir
            addButtons.forEach(button => {
                button.addEventListener('click', function() {
                    currentPlatoId = this.getAttribute('data-plato-id');
                    currentPlatoNombre = this.getAttribute('data-plato-nombre');
                    modalPlatoNombre.textContent = currentPlatoNombre;
                    platoNota.value = '';
                    modal.classList.add('active');
                });
            });

            // Cancelar nota
            cancelNote.addEventListener('click', function() {
                modal.classList.remove('active');
            });

            // Confirmar añadir al pedido
            confirmAdd.addEventListener('click', function() {
                // Aquí iría la lógica para agregar el plato con la nota
                const nota = platoNota.value.trim();
                console.log(`Plato ${currentPlatoId} añadido con nota: "${nota}"`);
                
                itemCount++;
                cartBadge.textContent = itemCount;
                cartBadge.classList.remove('hidden');
                modal.classList.remove('active');
                
                // Mostrar feedback visual
                const button = document.querySelector(`.add-to-cart[data-plato-id="${currentPlatoId}"]`);
                const badge = button.querySelector('svg').cloneNode(true);
                badge.classList.add('absolute', 'animate-bounce', 'text-secondary');
                button.appendChild(badge);
                
                setTimeout(() => {
                    button.removeChild(badge);
                }, 500);
            });

            // Cerrar modal haciendo clic fuera del contenido
            modal.addEventListener('click', function(e) {
                if(e.target === modal) {
                    modal.classList.remove('active');
                }
            });
        });
    </script>
</body>
</html>