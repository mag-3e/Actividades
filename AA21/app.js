document.addEventListener('DOMContentLoaded', () => {
    const formBuscar    = document.querySelector('#form-buscar');
    const inputBuscar   = document.querySelector('#input-buscar');
    const contenedor    = document.querySelector('#resultados');

    formBuscar.addEventListener('submit', async (e) => {
        e.preventDefault(); // Previene la recarga del navegador

        const query = inputBuscar.value.trim();
        const endpoint = 'api/buscador-seguro.php';

        contenedor.textContent = 'Buscando en la base de datos...';

        try {
            const res = await fetch(`${endpoint}?q=${encodeURIComponent(query)}`);
            const texto = await res.text();

            let resultado;
            try {
                resultado = JSON.parse(texto);
            } catch (_) {
                // El servidor no devolvió JSON (error de PHP, 404, etc.)
                console.error('Respuesta no válida del servidor:', texto);
                contenedor.textContent = 'El servidor devolvió una respuesta inválida (mirá la consola).';
                return;
            }

            if (res.ok && resultado.estado === 'exito') {
                renderizarProductos(resultado.data);
            } else {
                contenedor.textContent = resultado.mensaje || 'No se encontraron productos.';
            }
        } catch (error) {
            console.error(error);
            contenedor.textContent = 'Error de conexión con el servidor.';
        }
    });

    function renderizarProductos(productos) {
        contenedor.innerHTML = ''; // Limpiamos el contenedor

        if (productos.length === 0) {
            contenedor.textContent = 'Sin resultados.';
            return;
        }

        const fragmento = document.createDocumentFragment();
        productos.forEach(prod => {
            const card = document.createElement('div');
            card.className = 'card-producto';

            // Renderizado seguro en el DOM con textContent (evita XSS)
            const titulo = document.createElement('h4');
            titulo.textContent = prod.nombre;

            const categoria = document.createElement('span');
            categoria.className = 'categoria';
            categoria.textContent = prod.categoria ?? '';

            const precio = document.createElement('p');
            precio.textContent = `$${Number(prod.precio).toLocaleString('es-AR')}`;

            card.appendChild(titulo);
            card.appendChild(categoria);
            card.appendChild(precio);
            fragmento.appendChild(card);
        });

        contenedor.appendChild(fragmento);
    }
});
