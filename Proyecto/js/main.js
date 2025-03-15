
function TraerDatos() {
	var usuarios = $('#usuarioprincipal').val();
	$.ajax({
		url: '../controlador/usuario/controlador_traerdatos_usuario.php',
		type: 'POST',
		data: {
			usuario: usuarios

		}

	}).done(function (resp) {

		var data = JSON.parse(resp);
		if (data.length > 0) {

			if (data[0][5] == "ACTIVO") {

				const swith = document.querySelector('#switch');

				swith.addEventListener('click', () => {
					Swal.fire({
						title: 'Esta seguro de desactivar al usuario?',
						text: "Una vez hecho esto el usuario  tendra acceso al sistema",
						icon: 'warning',
						showCancelButton: true,
						confirmButtonColor: '#3085d6',
						cancelButtonColor: '#d33',
						confirmButtonText: 'Si'
					}).then((result) => {
						if (result.value) {

							if (data[0][7] != "INACTIVO") {
								document.body.classList.toggle('dark');
								swith.classList.toggle('active');
								Modificar_status(data[0][0], 'INACTIVO');

							}

						}

					})

				});
				if (data[0][5] == "INACTIVO") {
					document.body.classList.toggle('dark');
					swith.classList.toggle('active');

				}
				if (data[0][5] == "ACTIVO") {
					document.body.classList.toggle('dark');
					swith.classList.toggle('active');

				}

			}
			if (data[0][5] == "INACTIVO") {
				const swith2 = document.querySelector('#switch');

				swith2.addEventListener('click', () => {
					Swal.fire({
						title: 'Esta seguro de activar al usuario?',
						text: "Una vez hecho esto el usuario  tendra acceso al sistema",
						icon: 'warning',
						showCancelButton: true,
						confirmButtonColor: '#3085d6',
						cancelButtonColor: '#d33',
						confirmButtonText: 'Si'
					}).then((result) => {
						if (result.value) {

							if (data[0][5] != "ACTIVO") {
								document.body.classList.toggle('dark');
								swith2.classList.toggle('active');
								Modificar_status(data[0][0], 'ACTIVO');
							}

						}
					})

				});
			}
		}

	})
}

function Modificar_status(id, status) {
	$.ajax({
		url: "../controlador/usuario/controlador_modificar_estatus_usuario.php",
		type: "POST",
		data: {
			idusuario: id,
			estatus: status
		}
	}).done(function (resp) {
		if (resp > 0) {
			Swal.fire("Mensaje De Confirmacion", "El usuario se " + status + " con exito", "success")
				.then((value) => {
					location.reload();
				});

		} else {
			Swal.fire("Mensaje De Confirmacion", "El usuario no se pudo " + status + " con exito", "success")
				.then((value) => {
					location.reload();
				});
		}
	})
}






