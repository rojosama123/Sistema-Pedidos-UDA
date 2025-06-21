<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            max-height: 80vh;
            overflow-y: auto;
        }
        .modal-overlay.active .modal-content {
            transform: translateY(0);
        }
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
        /* Scrollbar for modal */
        .modal-content::-webkit-scrollbar {
            width: 6px;
        }
        .modal-content::-webkit-scrollbar-thumb {
            background-color: rgba(46, 74, 66, 0.3);
            border-radius: 3px;
        }
        /* Botones resumen */
        .btn-resumen {
            font-size: 0.85rem;
            padding: 0.25rem 0.5rem;
            border-radius: 0.375rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }
        .btn-eliminar {
            background-color: #EF4444;
            color: white;
        }
        .btn-eliminar:hover {
            background-color: #DC2626;
        }
        .btn-editar {
            background-color: #3B7A57;
            color: white;
        }
        .btn-editar:hover {
            background-color: #276749;
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

        <!-- Menú de platos -->
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
                        <div class="absolute top-4 right-4 bg-secondary text-primary font-bold px-3 py-1 rounded-full text-sm">
                            ${{ number_format($plato->precio, 0, ',', '.') }}
                        </div>
                        <div class="mb-4">
                            <h2 class="text-xl font-bold text-primary mb-2">{{ $plato->nombre }}</h2>
                            <p class="text-gray-600">{{ $plato->descripcion }}</p>
                        </div>
                        <button 
                            class="w-full bg-primary hover:bg-accent text-white font-medium py-2 px-4 rounded transition flex items-center justify-center add-to-cart"
                            data-plato-id="{{ $plato->id }}"
                            data-plato-nombre="{{ $plato->nombre }}"
                            data-plato-precio="{{ $plato->precio }}"
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
            <button class="bg-secondary text-primary p-4 rounded-full shadow-lg hover:shadow-xl" id="btnVerResumen">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Modal nota plato -->
    <div class="modal-overlay" id="noteModal">
        <div class="modal-content p-6">
            <h3 class="text-xl font-bold text-primary mb-4" id="modalPlatoNombre"></h3>
            <p class="text-gray-600 mb-4">Si desea dejar una nota para el plato, escríbalo. En caso contrario, presione en "Añadir al pedido"</p>
            <textarea id="platoNota" class="w-full border border-gray-300 rounded-lg p-3 mb-4" rows="3" placeholder="Ej: Sin cebolla, poco picante..."></textarea>
            <div class="flex justify-end space-x-3">
                <button class="btn-resumen btn-eliminar" id="cancelNote">Cancelar</button>
                <button class="btn-resumen btn-editar" id="confirmAdd">Añadir al pedido</button>
            </div>
        </div>
    </div>

    <!-- Modal Resumen del Pedido -->
    <div class="modal-overlay" id="resumenModal">
        <div class="modal-content p-6 max-w-lg w-full">
            <h3 class="text-2xl font-bold text-primary mb-4">Resumen del pedido</h3>
            <ul id="resumenList" class="mb-6 max-h-64 overflow-y-auto"></ul>
            <div class="flex justify-end space-x-3">
                <button id="closeResumen" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">Cerrar</button>
                <button id="enviarPedido" class="bg-primary hover:bg-accent text-white px-4 py-2 rounded font-semibold">Enviar Pedido</button>
            </div>
        </div>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    const cartBadge = document.querySelector('.cart-badge');
    const addButtons = document.querySelectorAll('.add-to-cart');
    const modal = document.getElementById('noteModal');
    const modalPlatoNombre = document.getElementById('modalPlatoNombre');
    const platoNota = document.getElementById('platoNota');
    const cancelNote = document.getElementById('cancelNote');
    const confirmAdd = document.getElementById('confirmAdd');
    const resumenModal = document.getElementById('resumenModal');
    const resumenList = document.getElementById('resumenList');
    const closeResumen = document.getElementById('closeResumen');

    let itemCount = 0;
    let currentPlatoId = null;
    let currentPlatoNombre = '';
    let carrito = [];

    confirmAdd.addEventListener('click', function() {
        const nota = platoNota.value.trim();
        const precioText = document.querySelector(`.add-to-cart[data-plato-id="${currentPlatoId}"]`)
            .closest('.menu-card').querySelector('.absolute').textContent;
        const precio = parseInt(precioText.replace('$', '').replace(/\./g, ''));

        // Añadir una unidad individual al carrito con su nota
        carrito.push({ id: currentPlatoId, nombre: currentPlatoNombre, precio: precio, nota: nota });

        itemCount++;
        cartBadge.textContent = itemCount;
        cartBadge.classList.remove('hidden');
        modal.classList.remove('active');
    });

    cancelNote.addEventListener('click', () => modal.classList.remove('active'));

    addButtons.forEach(button => {
        button.addEventListener('click', function() {
            currentPlatoId = this.getAttribute('data-plato-id');
            currentPlatoNombre = this.getAttribute('data-plato-nombre');
            modalPlatoNombre.textContent = currentPlatoNombre;
            platoNota.value = '';
            modal.classList.add('active');
        });
    });

    modal.addEventListener('click', function(e) {
        if (e.target === modal) modal.classList.remove('active');
    });

    // Mostrar resumen agrupado por plato+nota
    function mostrarResumen() {
        resumenList.innerHTML = '';
        if (carrito.length === 0) {
            resumenList.innerHTML = '<p class="text-center text-gray-600">No hay platos en el pedido.</p>';
            return;
        }

        // Agrupar por id+nota para mostrar cantidad
        const agrupado = {};
        carrito.forEach(item => {
            const key = item.id + '|' + item.nota;
            if (!agrupado[key]) {
                agrupado[key] = { ...item, cantidad: 0 };
            }
            agrupado[key].cantidad++;
        });

        Object.values(agrupado).forEach((plato, index) => {
            const item = document.createElement('li');
            item.className = "flex justify-between items-center border-b border-gray-200 py-3";

            const info = document.createElement('div');
            info.className = 'flex flex-col';
            const nombre = document.createElement('span');
            nombre.textContent = `${plato.nombre} x${plato.cantidad}`;
            nombre.className = 'font-semibold text-primary';

            const nota = document.createElement('small');
            nota.textContent = plato.nota ? `Nota: ${plato.nota}` : '';
            nota.className = 'text-gray-600';

            info.appendChild(nombre);
            if(plato.nota) info.appendChild(nota);

            const controles = document.createElement('div');
            controles.className = 'flex items-center space-x-2';

            // Botón -
            const btnMinus = document.createElement('button');
            btnMinus.textContent = '-';
            btnMinus.className = 'bg-red-500 hover:bg-red-600 text-white rounded px-2 py-1 font-bold';
            btnMinus.addEventListener('click', () => {
                // Eliminar solo una unidad que coincida con id y nota
                for(let i = 0; i < carrito.length; i++) {
                    if(carrito[i].id === plato.id && carrito[i].nota === plato.nota){
                        carrito.splice(i, 1);
                        itemCount--;
                        break;
                    }
                }
                actualizarBadge();
                mostrarResumen();
            });

            // Botón +
            const btnPlus = document.createElement('button');
            btnPlus.textContent = '+';
            btnPlus.className = 'bg-green-500 hover:bg-green-600 text-white rounded px-2 py-1 font-bold';
            btnPlus.addEventListener('click', () => {
                // Añadir una unidad igual (mismo id y nota)
                carrito.push({ id: plato.id, nombre: plato.nombre, precio: plato.precio, nota: plato.nota });
                itemCount++;
                actualizarBadge();
                mostrarResumen();
            });

            controles.appendChild(btnMinus);
            controles.appendChild(btnPlus);

            item.appendChild(info);
            item.appendChild(controles);

            resumenList.appendChild(item);
        });
    }

    function actualizarBadge() {
        if (itemCount > 0) {
            cartBadge.textContent = itemCount;
            cartBadge.classList.remove('hidden');
        } else {
            cartBadge.textContent = '0';
            cartBadge.classList.add('hidden');
        }
    }

    // Abrir resumen
    document.querySelector('.floating-cart button').addEventListener('click', () => {
        if (carrito.length === 0) return alert('El carrito está vacío.');
        mostrarResumen();
        resumenModal.classList.add('active');
    });

    // Cerrar resumen
    closeResumen.addEventListener('click', () => resumenModal.classList.remove('active'));

    // Enviar pedido
    document.getElementById('enviarPedido').addEventListener('click', () => {
        fetch("{{ route('pedido.guardar') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ casino: "{{ $casino }}", platos: carrito })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert(data.mensaje);
                carrito = [];
                itemCount = 0;
                actualizarBadge();
                resumenModal.classList.remove('active');
            } else {
                alert('Error al enviar pedido.');
            }
        });
    });
});


</script>
</body>
</html>
