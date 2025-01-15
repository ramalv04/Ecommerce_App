document.addEventListener('DOMContentLoaded', (event) => {
    iniciarApp();
})

// Función para iniciar la aplicación
function iniciarApp() {
    cambiarSeccion();
    menuHamburgesa();
    cambiarCantidad();
    botonSeccion();
    animates();
}

// Función para mostrar la sección de alfombras o tapices según el enlace seleccionado
function cambiarSeccion() {
    var enlaceAlfombras = document.getElementById('enlace-alfombras');
    var enlaceTapices = document.getElementById('enlace-tapices');
    
    if(enlaceAlfombras) {
        enlaceAlfombras.addEventListener('click', function() {
            document.getElementById('seccion-alfombras').classList.remove('inactivo');
            document.getElementById('seccion-alfombras').classList.add('activo');
            document.getElementById('seccion-tapices').classList.remove('activo');
            document.getElementById('seccion-tapices').classList.add('inactivo');
            this.classList.add('activo');
            if(enlaceTapices) {
                enlaceTapices.classList.remove('activo');
            }
        });
    }

    if(enlaceTapices) {
        enlaceTapices.addEventListener('click', function() {
            document.getElementById('seccion-tapices').classList.remove('inactivo');
            document.getElementById('seccion-tapices').classList.add('activo');
            document.getElementById('seccion-alfombras').classList.remove('activo');
            document.getElementById('seccion-alfombras').classList.add('inactivo');
            this.classList.add('activo');
            if(enlaceAlfombras) {
                enlaceAlfombras.classList.remove('activo');
            }
        });
    }
}

// Función para mostrar la sección de alfombras o tapices según el parámetro 'id' de la URL
function botonSeccion(){
    var enlaceAlfombras = document.getElementById('enlace-alfombras');
    var enlaceTapices = document.getElementById('enlace-tapices');

    // Función para obtener el parámetro 'id' de la URL
    function obtenerParametroId() {
        var params = new URLSearchParams(window.location.search);
        return params.get('id');
    }

    if(obtenerParametroId() === '1' || obtenerParametroId() === '0'){
        document.getElementById('seccion-alfombras').classList.remove('inactivo');
        document.getElementById('seccion-alfombras').classList.add('activo');
        document.getElementById('seccion-tapices').classList.remove('activo');
        document.getElementById('seccion-tapices').classList.add('inactivo');
        if(enlaceAlfombras) {
            enlaceAlfombras.classList.add('activo');
        }
        if(enlaceTapices) {
            enlaceTapices.classList.remove('activo');
        }
    }

    if(obtenerParametroId() === '2'){
        document.getElementById('seccion-tapices').classList.remove('inactivo');
        document.getElementById('seccion-tapices').classList.add('activo');
        document.getElementById('seccion-alfombras').classList.remove('activo');
        document.getElementById('seccion-alfombras').classList.add('inactivo');
        if(enlaceTapices) {
            enlaceTapices.classList.add('activo');
        }
        if(enlaceAlfombras) {
            enlaceAlfombras.classList.remove('activo');
        }
    }
}

// Función para mostrar el menú en dispositivos móviles
function menuHamburgesa() {
    var menu = document.querySelector('.hamburgesa-menu');
    if (menu) {
        menu.addEventListener('click', function() {
            document.querySelector('.navegacion').classList.toggle('mostrar');
        });
    }
}

// Función para cambiar la cantidad de productos en el carrito
function cambiarCantidad() {
    document.querySelectorAll('.input-cantidad').forEach(input => {
        input.addEventListener('change', function() {
            this.closest('form').submit();
        });
    });
}

// Funciones para el temporizador de inactividad
let tiempoDeEspera = 900000; // tiempo de espera en milisegundos, 60000 milisegundos es igual a 1 minuto
let temporizador = setTimeout(cerrarSesion, tiempoDeEspera);

// Función para cerrar la sesión
function cerrarSesion() {
    window.location.href = '/logout';
    window.location.href = '/login';
}

// Reiniciar el temporizador si hay alguna actividad del usuario
window.onmousemove = reiniciarTemporizador;
window.onmousedown = reiniciarTemporizador; 
window.onclick = reiniciarTemporizador;     
window.onscroll = reiniciarTemporizador;    
window.onkeypress = reiniciarTemporizador;  

// Función para reiniciar el temporizador
function reiniciarTemporizador() {
  clearTimeout(temporizador);
  temporizador = setTimeout(cerrarSesion, tiempoDeEspera);
}
function animates(){
    $(document).ready(function() {
        $('.data-card').hover(
          function() {
            $(this).animate({marginTop: "-=1%"}, 200);
          },
          function() {
            $(this).animate({marginTop: "+=1%"}, 200);
          }
        );
      });
}