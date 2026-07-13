// Sidebar toggle
var sidebarToggle = document.getElementById('sidebar-toggle');
var sidebarClose = document.getElementById('sidebar-close');
var sidebar = document.getElementById('sidebar');

if (sidebarToggle) {
    sidebarToggle.addEventListener('click', function() {
        sidebar.classList.toggle('open');
    });
}
if (sidebarClose) {
    sidebarClose.addEventListener('click', function() {
        sidebar.classList.remove('open');
    });
}

// Copiar enlace de tienda
function copiarEnlace() {
    var input = document.getElementById('tienda-url');
    if (!input) return;
    input.select();
    input.setSelectionRange(0, 99999);
    navigator.clipboard.writeText(input.value).then(function() {
        var btn = input.nextElementSibling;
        var textoOriginal = btn.textContent;
        btn.textContent = 'Copiado!';
        setTimeout(function() { btn.textContent = textoOriginal; }, 2000);
    });
}

// ===== CARRITO =====
var carrito = JSON.parse(localStorage.getItem('carrito_' + (window.carritoSlug || '')) || '[]');

function guardarCarrito() {
    localStorage.setItem('carrito_' + (window.carritoSlug || ''), JSON.stringify(carrito));
    actualizarUI();
}

function agregarAlCarrito(id, nombre, precio, cantidad) {
    cantidad = cantidad || 1;
    var existente = null;
    for (var i = 0; i < carrito.length; i++) {
        if (carrito[i].id === id) { existente = carrito[i]; break; }
    }
    if (existente) {
        existente.cantidad += cantidad;
    } else {
        carrito.push({ id: id, nombre: nombre, precio: precio, cantidad: cantidad });
    }
    guardarCarrito();

    var botones = document.querySelectorAll('.btn-agregar');
    for (var j = 0; j < botones.length; j++) {
        var onclick = botones[j].getAttribute('onclick');
        if (onclick && onclick.indexOf('agregarAlCarrito(' + id + ',') !== -1) {
            mostrarFeedback(botones[j]);
        }
    }
}

function mostrarFeedback(btn) {
    var textoOriginal = btn.textContent;
    btn.textContent = 'Agregado';
    btn.classList.add('btn-agregado');
    setTimeout(function() {
        btn.textContent = textoOriginal;
        btn.classList.remove('btn-agregado');
    }, 1500);
}

function cambiarCantidad(id, delta) {
    for (var i = 0; i < carrito.length; i++) {
        if (carrito[i].id === id) {
            carrito[i].cantidad += delta;
            if (carrito[i].cantidad <= 0) {
                carrito.splice(i, 1);
            }
            break;
        }
    }
    guardarCarrito();
}

function eliminarDelCarrito(id) {
    for (var i = 0; i < carrito.length; i++) {
        if (carrito[i].id === id) {
            carrito.splice(i, 1);
            break;
        }
    }
    guardarCarrito();
}

function actualizarUI() {
    var flotante = document.getElementById('carrito-flotante');
    var countEl = document.getElementById('carrito-count');
    var itemsEl = document.getElementById('carrito-items');
    var totalEl = document.getElementById('carrito-total');
    var totalBtnEl = document.getElementById('carrito-total-btn');

    if (!flotante) return;

    var totalItems = 0;
    var totalPrecio = 0;

    for (var i = 0; i < carrito.length; i++) {
        totalItems += carrito[i].cantidad;
        totalPrecio += carrito[i].precio * carrito[i].cantidad;
    }

    flotante.style.display = totalItems > 0 ? 'block' : 'none';
    if (countEl) countEl.textContent = totalItems;
    if (totalBtnEl) totalBtnEl.textContent = (window.carritoMoneda || 'C$') + ' ' + totalPrecio.toFixed(2);

    if (itemsEl) {
        if (carrito.length === 0) {
            itemsEl.innerHTML = '<p class="carrito-vacio">Tu carrito esta vacio. Agrega productos para hacer tu pedido.</p>';
        } else {
            var html = '';
            for (var j = 0; j < carrito.length; j++) {
                var item = carrito[j];
                var sub = (item.precio * item.cantidad).toFixed(2);
                html += '<div class="carrito-item">';
                html += '<span class="carrito-item-nombre">' + item.nombre + '</span>';
                html += '<div class="carrito-item-qty">';
                html += '<button onclick="cambiarCantidad(' + item.id + ', -1)">-</button>';
                html += '<span>' + item.cantidad + '</span>';
                html += '<button onclick="cambiarCantidad(' + item.id + ', 1)">+</button>';
                html += '</div>';
                html += '<span>' + (window.carritoMoneda || 'C$') + ' ' + sub + '</span>';
                html += '<button class="carrito-item-eliminar" onclick="eliminarDelCarrito(' + item.id + ')" title="Eliminar">&times;</button>';
                html += '</div>';
            }
            itemsEl.innerHTML = html;
        }
    }

    if (totalEl) {
        totalEl.textContent = (window.carritoMoneda || 'C$') + ' ' + totalPrecio.toFixed(2);
    }
}

function toggleCarrito() {
    var panel = document.getElementById('carrito-panel');
    if (panel) {
        panel.style.display = panel.style.display === 'none' ? 'flex' : 'none';
    }
}

// Enviar pedido
var pedidoForm = document.getElementById('pedido-form');
if (pedidoForm) {
    pedidoForm.addEventListener('submit', function(e) {
        e.preventDefault();

        if (carrito.length === 0) {
            alert('Agrega productos al carrito primero');
            return;
        }

        var formData = new FormData(pedidoForm);
        var data = {
            cliente_nombre: formData.get('cliente_nombre'),
            cliente_telefono: formData.get('cliente_telefono'),
            cliente_direccion: formData.get('cliente_direccion') || '',
            nota: formData.get('nota') || '',
            metodo_entrega: formData.get('metodo_entrega'),
            items: carrito.map(function(item) {
                return { id: item.id, cantidad: item.cantidad };
            })
        };

        var btn = pedidoForm.querySelector('button[type="submit"]');
        btn.disabled = true;
        btn.textContent = 'Enviando...';

        fetch('/tienda/' + window.carritoSlug + '/pedido', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        })
        .then(function(res) { return res.json(); })
        .then(function(resp) {
            if (resp.url) {
                carrito = [];
                guardarCarrito();
                window.location.href = resp.url;
            } else {
                alert(resp.error || 'Error al enviar el pedido');
                btn.disabled = false;
                btn.textContent = 'Enviar pedido por WhatsApp';
            }
        })
        .catch(function() {
            alert('Error de conexion');
            btn.disabled = false;
            btn.textContent = 'Enviar pedido por WhatsApp';
        });
    });
}

// Inicializar carrito al cargar
actualizarUI();
