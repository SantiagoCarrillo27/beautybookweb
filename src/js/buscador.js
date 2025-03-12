document.addEventListener('DOMContentLoaded', function(){
    iniciarApp();
})

function iniciarApp(){
    buscarPorFecha();
}


function buscarPorFecha() {
    const inputFecha = document.querySelector("#fecha");
  
    flatpickr(inputFecha, {
      dateFormat: "Y-m-d", // Formato de fecha (YYYY-MM-DD)
      locale: "es", // Localización en español
      disableMobile: true, // Evita conflictos con selectores nativos en móviles
      onClose: function (selectedDates, dateStr) {
        if (dateStr) {
          // Redirigir con la fecha seleccionada en el query string
          window.location = `?fecha=${dateStr}`;
        }
      },
    });
  }
  

// function buscarPorFecha(){

//     const inputFecha = document.querySelector('#fecha');

//     inputFecha.addEventListener('input', (e) => {
//         const fechaSeleccionada = e.target.value;
        
//         // OPCIÓN PARA MANDAR LA FECHA SELECCIONADA AL URL Y PODER LEERLA CON PHP
//         //queryString
//         window.location = `?fecha=${fechaSeleccionada}`;
        
//     })
// }


// function seleccionarFecha() {
//     const inputFecha = document.querySelector("#fecha");
  
//     flatpickr(inputFecha, {
//       dateFormat: "Y-m-d", // Formato de fecha
//       minDate: new Date().fp_incr(1), // Restricción de fechas futuras
//       locale: "es", // Localización en español
//       disable: [
//         function (date) {
//           // Bloquear fines de semana
//           return date.getDay() === 0 || date.getDay() === 6;
//         },
//       ],
//       onOpen: function () {
//         document.querySelector("#fecha").placeholder = "Seleccionando fecha...";
//       },
//       onClose: function (selectedDates, dateStr) {
//         if (!dateStr) {
//           document.querySelector("#fecha").placeholder = "Seleccione una fecha";
//         } else {
//           cita.fecha = dateStr; // Actualizar la fecha en el objeto cita
//         }
//       },
//     });
//   }