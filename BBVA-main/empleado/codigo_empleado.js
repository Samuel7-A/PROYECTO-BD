
// Aquí van las funciones js del empleado

// 
function buscarEventos() {
    const clienteId = document.getElementById("clienteIdInput").value;

    fetch(`get_eventos?clienteId=${clienteId}`)
        .then(response => response.json())
        .then(data => {
            const tbody = document.querySelector("#tabla-registros tbody");
            tbody.innerHTML = ""; // Limpiar la tabla

            data.forEach(evento => {
                const fila = document.createElement("tr");
                fila.innerHTML = `
                    <td>${evento.CLIENTE_ID}</td>
                    <td>${evento.TIPO_CUENTA}</td>
                    <td>${evento.TIPO_TARJETA}</td>
                    <td>${evento.ESTADO_CUENTA}</td>
                `;
                tbody.appendChild(fila);
            });
        })
        .catch(error => {
            console.error("Error al obtener eventos:", error);
        });
}

