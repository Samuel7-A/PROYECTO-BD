document.getElementById("numero-tarjeta").addEventListener("input", function (e) {
    let valor = e.target.value.replace(/\D/g, ''); // Quita todo lo que no sea número
    valor = valor.substring(0, 16); // Limita a 16 dígitos reales

    // Inserta un espacio cada 4 dígitos
    const separado = valor.match(/.{1,4}/g);
    e.target.value = separado ? separado.join(" ") : "";
});
