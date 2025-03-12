let paso = 1;
const pasoInicial = 1;
const pasoFinal = 3;

const cita = {
  id: "",
  nombre: "",
  fecha: "",
  hora: "",
  servicios: [],
};

document.addEventListener("DOMContentLoaded", function () {
  iniciarApp();
});

function iniciarApp() {
  mostrarSeccion(); //MUESTRA Y OCULTA LAS SECCIONES
  tabs(); //CAMBIA LA SECCIÓN CUANDO SE PRESIONEN LOS TABS
  botonesPaginador(); //AGREGA O QUITA LOS BOTONES DEL PAGINADOR
  paginaAnterior();
  paginaSiguiente();

  consultarAPI(); //CONSULTA LA API EN EL BACKEND DE PHP

  idCliente(); //AÑADE EL ID DEL CLIENTE AL OBJETO DE CITA
  nombreCliente(); //AÑADE EL NOMBRE DEL CLIENTE AL OBJETO DE CITA

  seleccionarFecha(); //AÑADE LA FECHA DEL CLIENTE AL OBJETO DE CITA

  seleccionarHora(); //AÑADE LA HORA DEL CLIENTE AL OBJETO DE CITA

  mostrarResumen(); //MUESTRA EL RESUMEN DE LA CITA

  headerFijo(); //MANTENER EL HEEADER SIEMPRE VISIBLE
}

function mostrarSeccion() {
  // OCULTAR LA SECCIÓN QUE TENGA LA CLASE DE MOSTRAR

  const seccionAnterior = document.querySelector(".mostrar");

  if (seccionAnterior) {
    seccionAnterior.classList.remove("mostrar");
  }

  // SELECCIONAR LA SECCIÓN CON EL PASO
  const pasoSelector = `#paso-${paso}`;
  const seccion = document.querySelector(pasoSelector);
  seccion.classList.add("mostrar");

  //QUITA LA CLASE ACTUAL AL TAB ANTERIOR
  const tabAnterior = document.querySelector(".actual");
  if (tabAnterior) {
    tabAnterior.classList.remove("actual");
  }
  //RESALTA EL TAB ACTUAL
  const tab = document.querySelector(`[data-paso="${paso}"]`);
  tab.classList.add("actual");
}

function tabs() {
  const botones = document.querySelectorAll(".tabs button");

  botones.forEach((boton) => {
    boton.addEventListener("click", function (e) {
      paso = parseInt(e.target.dataset.paso);
      mostrarSeccion();
      botonesPaginador();
    });
  });
}

function botonesPaginador() {
  const paginaAnterior = document.querySelector("#anterior");
  const paginaSiguiente = document.querySelector("#siguiente");

  if (paso === 1) {
    paginaAnterior.classList.add("ocultar");
    paginaSiguiente.classList.remove("ocultar");
  } else if (paso === 3) {
    paginaAnterior.classList.remove("ocultar");
    paginaSiguiente.classList.add("ocultar");
    mostrarResumen();
  } else {
    paginaAnterior.classList.remove("ocultar");
    paginaSiguiente.classList.remove("ocultar");
  }
  mostrarSeccion();
}

function paginaAnterior() {
  const paginaAnterior = document.querySelector("#anterior");
  paginaAnterior.addEventListener("click", function () {
    if (paso <= pasoInicial) {
      return;
    }

    paso--;

    botonesPaginador();
  });
}

function paginaSiguiente() {
  const paginaSiguiente = document.querySelector("#siguiente");
  paginaSiguiente.addEventListener("click", function () {
    if (paso >= pasoFinal) {
      return;
    }
    paso++;

    botonesPaginador();
  });
}

async function consultarAPI() {
  try {
    const url = `${location.origin}/api/servicios`;
    const resultado = await fetch(url);
    const data = await resultado.json();
    mostrarServicios(data);
  } catch (error) {
    console.log(error);
  }
}

function mostrarServicios(servicios) {
  const contenedorServicios = document.querySelector("#servicios");
  // Limpiar el contenido antes de agregar los servicios
  contenedorServicios.innerHTML = "";

  if (servicios.length === 0) {
    contenedorServicios.style.display = "block";
    const mensaje = document.createElement("H2");
    mensaje.classList.add("sin-info");
    mensaje.textContent = "No hay Servicios disponibles";
    contenedorServicios.appendChild(mensaje);
    return;
  }

  servicios.forEach((servicio) => {
    const { id, nombre, precio, imagen_url } = servicio;

    const imagenServicio = document.createElement("IMG");
    imagenServicio.classList.add("imagen-servicio");
    imagenServicio.src = `/build/imagenes/${imagen_url}`;
    imagenServicio.alt = "Imagen del servicio";

    const nombreServicio = document.createElement("P");
    nombreServicio.classList.add("nombre-servicio");
    nombreServicio.textContent = nombre;

    const precioServicio = document.createElement("P");
    precioServicio.classList.add("precio-servicio");
    precioServicio.textContent = `€${precio}`;

    const spanFooter = document.createElement("SPAN");
    spanFooter.classList.add("border-footer");

    const btnFooter = document.createElement("BUTTON");
    btnFooter.classList.add("btn-footer");
    btnFooter.textContent = `Seleccionar`;

    const servicioDiv = document.createElement("DIV");
    servicioDiv.classList.add("servicio");
    servicioDiv.dataset.idServicio = id;

    btnFooter.onclick = function () {
      seleccionarServicio(servicio);
    };

    servicioDiv.appendChild(imagenServicio);
    servicioDiv.appendChild(nombreServicio);
    servicioDiv.appendChild(precioServicio);
    servicioDiv.appendChild(spanFooter);
    servicioDiv.appendChild(btnFooter);

    contenedorServicios.appendChild(servicioDiv);
  });
}

function seleccionarServicio(servicio) {
  const { id } = servicio;
  const { servicios } = cita;

  // IDENTIFICAR EL ELEMENTO AL QUE SE LE DA CLICK
  const divServicio = document.querySelector(`[data-id-servicio="${id}"]`);
  const btnFooter = divServicio.querySelector(".btn-footer");

  // COMPROBAR SI UN SERVICIO YA FUE AGREGADO
  if (servicios.some((agregado) => agregado.id === id)) {
    // ELIMINARLO

    cita.servicios = servicios.filter((agregado) => agregado.id !== id);
    divServicio.classList.remove("seleccionado");
    btnFooter.textContent = "Seleccionar";
  } else {
    // AGREGARLO
    cita.servicios = [...servicios, servicio];
    divServicio.classList.add("seleccionado");
    btnFooter.textContent = "Seleccionado";
  }

  // console.log(cita);
}

function idCliente() {
  cita.id = document.querySelector("#id").value;
}

function nombreCliente() {
  cita.nombre = document.querySelector("#nombre").value;
}

function seleccionarFecha() {
  const inputFecha = document.querySelector("#fecha");

  flatpickr(inputFecha, {
    dateFormat: "Y-m-d", // Formato de fecha
    minDate: new Date().fp_incr(1), // Restricción de fechas futuras
    locale: "es", // Localización en español
    disable: [
      function (date) {
        // Bloquear fines de semana
        return date.getDay() === 0 || date.getDay() === 6;
      },
    ],
    onOpen: function () {
      document.querySelector("#fecha").placeholder = "Seleccionando fecha...";
    },
    onClose: function (selectedDates, dateStr) {
      if (!dateStr) {
        document.querySelector("#fecha").placeholder = "Seleccione una fecha";
      } else {
        cita.fecha = dateStr; // Actualizar la fecha en el objeto cita
      }
    },
  });
}

// function seleccionarFecha() {
//   const inputFecha = document.querySelector("#fecha");
//   inputFecha.addEventListener("input", function (e) {
//     // VALIDAR EL DÍA PARA RESTRINGIR SEGÚN DISPONIBILIDAD
//     const dia = new Date(e.target.value).getUTCDay();

//     if ([6, 0].includes(dia)) {
//       e.target.value = "";
//       mostrarAlerta("Fines de Semana no permitidos", "error", ".formulario");
//     } else {
//       cita.fecha = e.target.value;
//       console.log(cita.fecha);

//     }
//   });
// }

function seleccionarHora() {
  const inputHora = document.querySelector("#hora");

  flatpickr(inputHora, {
    enableTime: true,
    noCalendar: true, // Desactiva el calendario (solo hora)
    time_24hr: true, // Establece el formato de 12 horas (AM/PM)
    dateFormat: "H:i", // Formato de 12 horas (AM/PM)
    minTime: "09:00", // Hora mínima permitida
    maxTime: "20:00",
    minuteIncrement: 30, // Hora máxima permitida
    locale: "es", // Configuración en español
    onChange: function (selectedDates, dateStr, instance) {
      const horaCita = selectedDates[0] ? selectedDates[0].getHours() : null;

      if (horaCita < 9 || horaCita > 20) {
        mostrarAlerta("Horario no permitido", "error", ".formulario");
        inputHora.value = ""; // Borra el valor si no está en el rango
      } else {
        cita.hora = dateStr; // Guarda la hora seleccionada
      }
    },
  });
}

// function seleccionarHora() {
//   const inputHora = document.querySelector("#hora");

//   inputHora.addEventListener("input", function (e) {
//     const horaCita = e.target.value;
//     const hora = horaCita.split(":")[0];

//     if (hora < 10 || hora > 19) {
//       e.target.value = "";
//       mostrarAlerta("Horario no permitido", "error", ".formulario");
//     } else {
//       cita.hora = e.target.value;
//       // console.log(cita);
//     }
//   });
// }

function mostrarAlerta(mensaje, tipoAlerta, elemento, desaparece = true) {
  // PREVIENE QUE SE GENERE MÁS DE UNA ALERTA
  const alertaPrevia = document.querySelector(".alerta");

  if (alertaPrevia) {
    alertaPrevia.remove();
  }

  // SCRIPTING PARA GENERAR ALERTA
  const alerta = document.createElement("DIV");

  alerta.textContent = mensaje;

  alerta.classList.add("alerta");

  alerta.classList.add(tipoAlerta);

  const referencia = document.querySelector(elemento);

  referencia.appendChild(alerta);

  if (desaparece) {
    // ELIMINAR ALERTA
    setTimeout(() => {
      alerta.remove();
    }, 3000);
  }
}

function mostrarResumen() {
  const resumen = document.querySelector(".contenido-resumen");

  while (resumen.firstChild) {
    resumen.removeChild(resumen.firstChild);
  }

  if (Object.values(cita).includes("") || cita.servicios.length === 0) {
    mostrarAlerta(
      "Hacen falta datos o servicios",
      "error",
      ".contenido-resumen",
      false
    );

    return;
  }

  // FORMATEAR EL DIV DE RESUMEN

  const { nombre, fecha, hora, servicios } = cita;

  // HEADING PARA SERVICIOS EN RESUMEN
  const headingServicios = document.createElement("H3");
  headingServicios.textContent = "Resumen de Servicios";
  resumen.appendChild(headingServicios);

  // ITERANDO Y MOSTRANDO LOS SERVIVIOS
  servicios.forEach((servicio) => {
    const { id, nombre, precio } = servicio;
    const contenedorServicio = document.createElement("DIV");
    contenedorServicio.classList.add("contenedor-servicio");

    const textoServicio = document.createElement("P");
    textoServicio.textContent = nombre;

    const precioServicio = document.createElement("P");
    precioServicio.innerHTML = `<span>Precio:</span> € ${precio}`;

    contenedorServicio.appendChild(textoServicio);
    contenedorServicio.appendChild(precioServicio);

    resumen.appendChild(contenedorServicio);
  });

  // HEADING PARA CITA EN RESUMEN
  const headingCita = document.createElement("H3");
  headingCita.textContent = "Resumen de Cita";
  resumen.appendChild(headingCita);

  const nombreCliente = document.createElement("P");
  nombreCliente.innerHTML = `<span>Nombre:</span> ${nombre}`;

  // FORMATEAR FECHA EN ESPAÑOL

  const fechaObj = new Date(fecha);

  const mes = fechaObj.getMonth();
  const dia = fechaObj.getDate();
  const year = fechaObj.getFullYear();

  const fechaUTC = new Date(Date.UTC(year, mes, dia));

  const opciones = {
    weekday: "long",
    year: "numeric",
    month: "long",
    day: "numeric",
  };
  const fechaFormateada = fechaUTC.toLocaleDateString("es-ES", opciones);

  const fechaCliente = document.createElement("P");
  fechaCliente.innerHTML = `<span>Fecha:</span> ${fechaFormateada}`;

  const horaCliente = document.createElement("P");
  horaCliente.innerHTML = `<span>Hora:</span> ${hora} Horas`;

  // BOTÓN PARA CREAR UNA CITA
  const botonReservar = document.createElement("BUTTON");
  botonReservar.classList.add("boton");
  botonReservar.textContent = "Reservar Cita";

  botonReservar.onclick = function () {
    // Deshabilitar el botón
    botonReservar.disabled = true;
    botonReservar.textContent = "Procesando...";

    // Llamar a la función para reservar la cita
    reservarCita()
      .then(() => {
        // Habilitar el botón nuevamente después de que se haya procesado la cita
        botonReservar.textContent = "Cita Reservada";
        setTimeout(() => {
          botonReservar.disabled = false; // Habilitar de nuevo el botón después de unos segundos
        }, 2000); // Esperar 2 segundos antes de habilitar el botón
      })
      .catch((error) => {
        // En caso de error, habilitar el botón nuevamente y mostrar el error
        botonReservar.textContent = "Reservar Cita";
        botonReservar.disabled = false;
        Swal.fire({
          icon: "error",
          title: "Oops, algo ha salido mal",
          text: "Hubo un error al intentar guardar la cita",
          color: "black",
        });
      });
  };

  resumen.appendChild(nombreCliente);
  resumen.appendChild(fechaCliente);
  resumen.appendChild(horaCliente);

  resumen.appendChild(botonReservar);
}

async function reservarCita() {
  const { id, fecha, hora, servicios } = cita;

  const idServicios = servicios.map((servicio) => servicio.id);
  // console.log(idServicios);

  const datos = new FormData();

  datos.append("fecha", fecha);
  datos.append("hora", hora);
  datos.append("usuarioId", id);
  datos.append("servicios", idServicios);

  //  console.log([...datos]);

  try {
    // PETICIÓN HACÍA LA API
    const url = `${location.origin}/api/citas`;
    const respuesta = await fetch(url, {
      method: "POST",
      body: datos,
    });

    const data = await respuesta.json();
    // console.log(data.resultado);

    if (data.resultado) {
      let mensaje = "Tu cita ha sido creada correctamente!";

      if (!data.correoEnviado) {
        mensaje +=
          " Sin embargo, no pudimos enviarte un correo de confirmación.";
      }

      Swal.fire({
        title: "Cita Creada!",
        text: mensaje,
        icon: "success",
        color: "black",
      }).then(() => {
        location.reload(); // Recarga la página después de cerrar la alerta
      });
    }
  } catch (error) {
    Swal.fire({
      icon: "error",
      title: "Oops, algo ha salido mal",
      text: "Hubo un error al intentar guardar la cita",
      color: "black",
    });
    console.log(error);
  }

  // console.log([...datos]);
}

function headerFijo() {
  const header = document.querySelector(".barra");

  window.addEventListener("scroll", function () {
    if (window.scrollY > 30) {
      header.classList.add("scrolled");
    } else {
      header.classList.remove("scrolled");
    }
  });
}
