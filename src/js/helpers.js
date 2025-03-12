document.addEventListener("DOMContentLoaded", function () {
  iniciarApp();
  menuLateral();
});

function iniciarApp() {
  cambiarIcon();
  eliminarServicio();
  alertActualizarServicio();
}

function cambiarIcon() {
  const icon = document.getElementById("cambioIconoPassword");
  if (icon) {
    icon.addEventListener("click", function () {
      const passwordInput = document.getElementById("password");

      if (passwordInput.type === "password") {
        passwordInput.type = "text";
        icon.textContent = "visibility_off";
      } else {
        passwordInput.type = "password";
        icon.textContent = "visibility";
      }
    });
  }
}

function mostrarImagenPrevia(event) {
  const input = event.target;
  const preview = document.getElementById("preview");
  const imagenActual = document.getElementById("imagen-actual");

  if (input.files && input.files[0]) {
    const reader = new FileReader();

    reader.onload = function (e) {
      preview.src = e.target.result;
      // console.log(preview.src);

      preview.style.display = "block";

      imagenActual.style.display = "none";
    };

    reader.readAsDataURL(input.files[0]); // Convierte la imagen a base64
  } else {
    preview.style.display = "none";
    imagenActual.style.display = "block";
  }
}

function menuLateral() {
  const logo = document.getElementById("logo");
  const barraLateral = document.querySelector(".barra-servicios-admin");
  const textoLogos = document.querySelectorAll(".logo-admin");
  const menu = document.querySelector(".menu-hamburguer");

  const contenedorAdmin = document.querySelector(".contenedor-admin");

  // MENU DISPOSITIVOS MÓVILES

  if (menu && barraLateral && contenedorAdmin) {
    menu.addEventListener("click", () => {
      barraLateral.classList.toggle("max-barra-lateral");
      menu.classList.toggle("is-open");

      if (window.innerWidth <= 320) {
        barraLateral.classList.add("barra-mini-admin");
        contenedorAdmin.classList.add("min-contenedor-admin");
        textoLogos.forEach((textos) => {
          textos.classList.add("ocultar");
        });
      }
    });
  }

  //REDUCIR TAMAÑO BARRA LATERAL
  if (logo && barraLateral && contenedorAdmin) {
    logo.addEventListener("click", () => {
      barraLateral.classList.toggle("barra-mini-admin");
      contenedorAdmin.classList.toggle("min-contenedor-admin");
      textoLogos.forEach((textos) => {
        textos.classList.toggle("ocultar");
      });
    });
  }
}

function mostrarSweetAlert(mensaje, tipo = "info") {
  Swal.fire({
    title: "Mensaje",
    text: mensaje,
    icon: tipo,
    confirmButtonText: "OK",
  });
}

const eliminarServicio = () => {
  const formulariosEliminar = document.querySelectorAll(
    "form[action='/servicios/eliminar']"
  );

  if (formulariosEliminar) {
    formulariosEliminar.forEach((formulario) => {
      formulario.addEventListener("submit", (event) => {
        event.preventDefault(); // Evita el envío automático

        Swal.fire({
          title: "¿Estás seguro?",
          text: "Esta acción no se puede deshacer",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#d33",
          cancelButtonColor: "#3085d6",
          confirmButtonText: "Sí, eliminar",
          cancelButtonText: "Cancelar",
        }).then((result) => {
          if (result.isConfirmed) {
            formulario.submit(); // Enviar formulario si confirma
          }
        });
      });
    });
  }
};



const alertActualizarServicio = () => {
  const formularioActualizar = document.querySelector("#actualizar"); // Capturamos el formulario
  if (!formularioActualizar) return; // Si no existe, salir

  let cambiosRealizados = false; // Bandera para detectar cambios

  // Detectar cambios en los campos del formulario
  formularioActualizar.addEventListener("input", () => {
    cambiosRealizados = true; // Si el usuario modifica algo, cambiamos la bandera
  });

  // Interceptar el envío del formulario
  formularioActualizar.addEventListener("submit", (event) => {
    if (!cambiosRealizados) return; // Si no hubo cambios, permitir envío normal y salir

    event.preventDefault(); // Evita el envío automático solo si hubo cambios

    Swal.fire({
      title: "¿Actualizar Servicio?",
      text: "Se guardarán los cambios realizados.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#28a745",
      cancelButtonColor: "#d33",
      confirmButtonText: "Sí, actualizar",
      cancelButtonText: "Cancelar",
    }).then((result) => {
      if (result.isConfirmed) {
        formularioActualizar.submit(); // Si confirma, enviamos el formulario
      }
    });
  });
};



