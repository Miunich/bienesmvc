document.addEventListener('DOMContentLoaded', function () {

    eventListeners();

    darkMode();
});

function darkMode() {
    //Preferencias el modo oscuro del usuario
    const prefiereDarkMode = window.matchMedia('(prefers-color-scheme: dark)');

    if (prefiereDarkMode.matches) {
        document.body.classList.add('dark-mode');
    } else {
        document.body.classList.remove('dark-mode');
    }

    prefiereDarkMode.addEventListener('change', function () {
        if (prefiereDarkMode.matches) {
            document.body.classList.add('dark-mode');
        } else {
            document.body.classList.remove('dark-mode');
        }
    });
    //fin de la deteccion de preferencias del usuario

    const botonDarkMode = document.querySelector('.dark-mode-boton');

    botonDarkMode.addEventListener('click', function () {
        document.body.classList.toggle('dark-mode');
    });
}

function eventListeners() {
    const mobileMenu = document.querySelector('.mobile-menu');
    mobileMenu.addEventListener('click', navegacionResponsive);

    //Muestra campos condicionales
    const metodoContacto = document.querySelectorAll('input[name="contacto[contacto]"]');

    metodoContacto.forEach(input => {
        input.addEventListener('click', mostrarMetodosContacto);
    });

}

function navegacionResponsive() {
    const navegacion = document.querySelector('.navegacion');

    navegacion.classList.toggle('mostrar');

}

function mostrarMetodosContacto(e) {
    const contactoDiv = document.querySelector('#contacto');

    if (e.target.value === 'telefono') {
        contactoDiv.innerHTML = '<label for="telefono"></label>'+'<input type="tel" name="contacto[telefono]" placeholder="Tu Teléfono" >'+'<p> Elija la fecha y la hora para que te contactemos</p>'+'<label for="fecha">Fecha:</label>'+'<input type="date" name="contacto[fecha]" >'+'<label for="hora">Hora:</label>'+'<input type="time" name="contacto[hora]"  min="09:00" max="18:00" >';

    } else {
        contactoDiv.innerHTML = '<label for="correo"></label>'+'<input type="email" id="correo" placeholder="Tu Correo" name="contacto[email]" required>';

    }
}