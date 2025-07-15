document.addEventListener('DOMContentLoaded', () => {
    const botones = document.querySelectorAll('.boton-moneda');

    botones.forEach(boton => {
        boton.addEventListener('click', () => {
            botones.forEach(b => b.classList.remove('activo'));
            boton.classList.add('activo');
        });
    });
});