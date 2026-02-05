// main.js

document.addEventListener('DOMContentLoaded', () => {
    
    // 1. Función del Reloj Digital
    function actualizarReloj() {
        const ahora = new Date();
        const opciones = { hour: '2-digit', minute: '2-digit', second: '2-digit' };
        // Usamos formato de hora local
        const horaString = ahora.toLocaleTimeString('es-MX', opciones);
        
        const elementoReloj = document.getElementById('reloj');
        if(elementoReloj) {
            elementoReloj.textContent = horaString;
        }
    }

    // Actualizar cada segundo (1000 ms)
    setInterval(actualizarReloj, 1000);
    actualizarReloj(); // Ejecutar una vez al inicio para que no tarde 1 seg en aparecer

    // 2. Efecto de entrada suave al cargar
    const card = document.querySelector('.weather-card');
    card.style.opacity = '0';
    card.style.transform = 'translateY(20px)';
    
    // Pequeña animación de entrada con JS y CSS transition
    setTimeout(() => {
        card.style.transition = 'opacity 0.8s ease, transform 0.8s cubic-bezier(0.2, 0.8, 0.2, 1)';
        card.style.opacity = '1';
        card.style.transform = 'translateY(0)';
    }, 100);

});