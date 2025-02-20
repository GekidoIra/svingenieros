document.addEventListener("DOMContentLoaded", function () {
    const menu = document.getElementById('menu');
    const gallery = document.getElementById('gallery');

    // Generar el menú de granjas
    carpetas.forEach(granja => {
        const boton = document.createElement('button');
        boton.textContent = granja;
        boton.addEventListener('click', () => cargarGaleria(granja));
        menu.appendChild(boton);
    });

    function cargarGaleria(granja) {
    gallery.innerHTML = ''; // Limpiar la galería anterior

    // Hacer una solicitud al servidor para obtener las fotos de la carpeta seleccionada
    fetch(`getFotos.php?granja=${granja}`)
        .then(response => response.json())
        .then(fotos => {
            fotos.forEach(foto => {
                // Crear un contenedor para la imagen y el campo de texto
                const galleryItem = document.createElement('div');
                galleryItem.classList.add('gallery-item');

                // Crear la imagen en miniatura
                const img = document.createElement('img');
                img.src = `2025/${granja}/${foto}`;
                img.alt = `Foto de gallo de ${granja}`;
                img.classList.add('gallery-img');

                // Extraer el nombre base (sin extensión)
                const nombreBase = foto.split('.').slice(0, -1).join('.');

                // Crear el campo de texto
                const input = document.createElement('input');
                input.type = 'text';
                input.value = nombreBase; // Mostrar solo el nombre base
                input.placeholder = 'Nuevo nombre de la imagen';

                // Manejar el evento de cambio en el campo de texto
                input.addEventListener('change', () => {
                    const nuevoNombreBase = input.value.trim();
                    if (nuevoNombreBase && nuevoNombreBase !== nombreBase) {
                        // Concatenar la extensión original al nuevo nombre
                        const extension = foto.split('.').pop();
                        const nuevoNombre = `${nuevoNombreBase}.${extension}`;
                        cambiarNombreImagen(granja, foto, nuevoNombre);
                    }
                });

                // Agregar la imagen y el campo de texto al contenedor
                galleryItem.appendChild(img);
                galleryItem.appendChild(input);

                // Agregar el contenedor a la galería
                gallery.appendChild(galleryItem);
            });
        })
        .catch(error => console.error('Error al cargar las fotos:', error));
}

    // Función para cambiar el nombre de la imagen en el servidor
    function cambiarNombreImagen(granja, nombreActual, nuevoNombre) {
    const formData = new FormData();
    formData.append('granja', granja);
    formData.append('nombreActual', nombreActual);
    formData.append('nuevoNombre', nuevoNombre);

    fetch('php/cambiarNombreImagen.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Nombre de la imagen cambiado correctamente.');
                // Actualizar el campo de texto con el nuevo nombre
                const input = document.querySelector(`input[value="${nombreActual}"]`);
                if (input) {
                    input.value = data.nuevoNombre;
                }
            } else {
                alert('Error al cambiar el nombre de la imagen.');
            }
        })
        .catch(error => console.error('Error:', error));
}

    // JavaScript para el modal de zoom
    const modal = document.createElement('div');
    modal.classList.add('modal');
    modal.innerHTML = `
        <span class="close">&times;</span>
        <img class="modal-content" id="modal-img">
    `;
    document.body.appendChild(modal);

    const modalImg = document.getElementById('modal-img');
    const closeBtn = document.querySelector('.close');

    // Abrir modal al hacer clic en una imagen de la galería
    gallery.addEventListener('click', (e) => {
        if (e.target.classList.contains('gallery-img')) {
            modal.style.display = 'block';
            modalImg.src = e.target.src;
        }
    });

    // Cerrar modal al hacer clic en la "X"
    closeBtn.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    // Cerrar modal al hacer clic fuera de la imagen
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });
});