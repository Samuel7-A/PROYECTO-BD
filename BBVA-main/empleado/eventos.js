
// Aquí van las funciones js del empleado

// 
function buscarEventos() {
    const clienteId = document.getElementById("clienteIdInput").value;
    console.log("DNI buscado:", clienteId);

    fetch(`get_eventos.php?clienteId=${clienteId}`)
        .then(response => response.json())
        
        .then(data => {
            const tbody = document.querySelector("#tabla-registros tbody");
            tbody.innerHTML = ""; // Limpiar la tabla

            data.forEach(evento => {
                const fila = document.createElement("tr");
                fila.innerHTML = `
                    <td>${evento.EVENTO_ID}</td>
                    <td>${evento.C_DNI}</td>
                    <td>${evento.FECHAEVENTO}</td>
                    <td>${evento.EVENTOTIPO}</td>
                    <td>${evento.MONTO_ANTIGUO || "No aplica"}</td>
                    <td>${evento.MONTO_NUEVO || "No aplica"}</td>
                    <td>${evento.Estado_Antiguo || "No aplica"}</td>
                    <td>${evento.Estado_Nuevo || "No aplica"}</td>
                `;
                tbody.appendChild(fila);
            });
        })
        .catch(error => {
            console.error("Error al obtener eventos:", error);
        });
}

