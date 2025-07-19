document.addEventListener('DOMContentLoaded', () => {
    const botones = document.querySelectorAll('.boton-moneda');

    botones.forEach(boton => {
        boton.addEventListener('click', () => {
            botones.forEach(b => b.classList.remove('activo'));
            boton.classList.add('activo');
        });
    });
});



document.addEventListener('DOMContentLoaded', () => {
    const botones = document.querySelectorAll('.boton-moneda');

    botones.forEach(boton => {
        boton.addEventListener('click', () => {
            botones.forEach(b => b.classList.remove('activo'));
            boton.classList.add('activo');
        });
    });

    document.querySelector(".continuar-boton").addEventListener("click", () => {
        const monto = document.getElementById("monto").value;
        const moneda = document.querySelector(".boton-moneda.activo").textContent
            .toLowerCase()
            .normalize("NFD")
            .replace(/[\u0300-\u036f]/g, ""); // 'soles' o 'dolares'

        if (!monto) {
            alert("Faltan datos.");
            return;
        }

        fetch("realizar_deposito.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                monto: parseFloat(monto),
                moneda: moneda
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.exito) {
                alert("Depósito realizado con éxito.");
                // Puedes redirigir o actualizar aquí
            } else {
                alert("Error: " + data.error);
            }
        })
        .catch(err => {
            console.error("Error en fetch:", err);
            alert("Error en la solicitud.");
        });
    });
});

