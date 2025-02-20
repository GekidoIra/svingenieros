// script.js

// Función para registrar un nuevo pollo
$("#formRegistro").submit(function (e) {
	e.preventDefault();
	var formData = new FormData(this);

	$.ajax({
		url: "php/registrar_pollo.php",
		type: "POST",
		data: formData,
		contentType: false,
		processData: false,
		beforeSend: function () {
			$("#mensaje").html("Procesando, espere por favor...");
		},
		success: function (respuesta) {
			$("#mensaje").html(respuesta);
		},
		error: function (respuesta) {
			$("#mensaje").html(respuesta);
		}
	});
});

// Función para buscar un pollo por número de anillo
function buscarPollo() {
	var anillo = $("#buscarAnillo").val();

	$.ajax({
		url: "php/buscar_pollo.php",
		type: "POST",
		data: {
			anillo: anillo
		},
		beforeSend: function () {
			$("#resultado").html("Procesando, espere por favor...");
		},
		success: function (response) {
			// Manejar la respuesta del servidor
			if (response.hasOwnProperty("error")) {
				// Si hay un error, mostrarlo en algún lugar de tu interfaz
				$("#resultado").html("<p class='error'>" + response.error + "</p>");
			} else if (response.hasOwnProperty("html")) {
				// Si hay datos, mostrar la información en tu interfaz
				$("#resultado").html(response.html);
				var imagenElement = document.getElementById('imagen');

				// Si el elemento de la imagen existe, haz el desplazamiento hacia él.
				if (imagenElement) {
					imagenElement.scrollIntoView({
						behavior: 'smooth'
					});
				}
			}
		},
		error: function (xhr, status, error) {
			// Manejar errores de la solicitud AJAX
			$("#resultado").html(error + "<br>" + "Error en la solicitud AJAX:" + status + "<br>" + xhr.responseText);
		}
	});
}
