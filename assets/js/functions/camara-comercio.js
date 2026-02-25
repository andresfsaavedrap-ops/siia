import { toastSimple, mostrarAlerta, procesando, errorControlador, showNotification, confirmarAccion } from './partials/alerts-config.js';
import { redirect, reload } from './partials/other-funtions-init.js';
import { getBaseURL } from './config.js';
// Configurar baseURL
const baseURL = getBaseURL();

// Desactivar cualquier handler previo que pueda existir y causar conflictos
$(".ver_adjuntar_camara").off("click");
$(document).off("click", ".ver_adjuntar_camara");

/**
 * Helper: setear o limpiar la vista previa del PDF de Cámara de Comercio usando iframe.
 * Reemplaza el nodo para forzar re-render sin setTimeout.
 */
function setCamaraPreview(url) {
  const $container = $("#modal_camara_viewer_container");
  const $link = $("#modal_camara_view_link");
  const $estado = $("#modal_camara_estado");

  // Eliminar iframe actual (si existe)
  const $old = $("#modal_camara_viewer");
  if ($old.length) {
    $old.remove();
  }

  // Crear nuevo iframe con el mismo id (ahora con CSS seguro para ocupar todo el contenedor)
  const $iframe = $("<iframe>", {
    id: "modal_camara_viewer",
    class: "w-100 h-100",
    style: "width: 100%; height: 100%; border: 0; display: block;",
    loading: "lazy"
  });

// Al cerrar el modal: limpiar todo para evitar que la vista previa persista entre organizaciones
$(document).on("hidden.bs.modal", "#modalCamaraComercio", function () {
  $("#modalCamaraComercio").removeAttr("data-id-org");
  setCamaraPreview(null); // Limpia iframe y estados
  $("#modal_camara_file").val("");
  $("#modal_camara_upload_btn").prop("disabled", true);
});

  if (url && typeof url === "string") {
    // Bust de caché para obligar recarga del PDF
    const bust = url + (url.indexOf("?") === -1 ? "?" : "&") + "t=" + Date.now();
    $iframe.attr("src", bust);
    $link.attr("href", url).removeClass("disabled").attr("title", "Abrir PDF");
    $estado.removeClass("badge-secondary").addClass("badge-success").text("Disponible");
  } else {
    // Sin URL: iframe sin src y link deshabilitado
    $iframe.attr("src", "");
    $link.removeAttr("href").addClass("disabled").attr("title", "No disponible");
    $estado.removeClass("badge-success").addClass("badge-secondary").text("No disponible");
  }

  $container.empty().append($iframe);
}

/** Ver organización camara de comercio. */
$(document).on("click", ".ver_adjuntar_camara", function () {
  const idOrg = $(this).attr("data-organizacion");

  $.ajax({
    url: baseURL + "solicitudes/cargarInformacionCompletaSolicitud",
    type: "post",
    dataType: "JSON",
    data: { id_organizacion: idOrg },
    beforeSend: function () {
      if (typeof toastSimple === "function") {
        toastSimple("info", "Cargando datos de la organización...");
      }
    },
    success: function (response) {
      $("#modalCamaraComercio").attr("data-id-org", idOrg);
      const org = response.organizaciones || {};
      $("#modal_camara_nombre").text(org.nombreOrganizacion || "");
      $("#modal_camara_nit").text(org.numNIT || "");

      const camara = org.camaraComercio;
      const tienePDF = camara && camara !== "default.pdf";
      const pdfURL = tienePDF ? (baseURL + "uploads/camaraComercio/" + camara) : "";

      // Vista previa y estado con iframe
      setCamaraPreview(pdfURL);

      // Limpiar input de carga y botón
      $("#modal_camara_file").val("");
      $("#modal_camara_upload_btn").prop("disabled", true);

      // Abrir modal
      $("#modalCamaraComercio").modal("show");
    },
    error: function (ev) {
      if (typeof errorControlador === "function") {
        errorControlador(ev);
      } else {
        console.error(ev);
        alert("Error al cargar la información de la organización.");
      }
    },
  });

});

/**
 * Refrescar estado del modal de Cámara de Comercio
 * @param {string|number} idOrg
 */
function refreshCamaraModal(idOrg) {
  $.ajax({
    url: baseURL + "solicitudes/cargarInformacionCompletaSolicitud",
    type: "post",
    dataType: "JSON",
    data: { id_organizacion: idOrg },
    success: function (response) {
      const org = response.organizaciones || {};
      const camara = org.camaraComercio;
      const tienePDF = camara && camara !== "default.pdf";
      const pdfURL = tienePDF ? (baseURL + "uploads/camaraComercio/" + camara) : "";

      // Refrescar vista previa y estado con iframe
      setCamaraPreview(pdfURL);

      // Limpiar input
      $("#modal_camara_file").val("");
      $("#modal_camara_upload_btn").prop("disabled", true);
    },
    error: function (ev) {
      if (typeof errorControlador === "function") {
        errorControlador(ev);
      } else {
        console.error(ev);
        alert("Error al refrescar la cámara de comercio.");
      }
    },
  });
}

// Habilitar botón de subir cuando se selecciona un archivo
$(document).on("change", "#modal_camara_file", function () {
  const file = $(this).prop("files")[0];
  $("#modal_camara_upload_btn").prop("disabled", !file);
});

// Subir/Actualizar PDF desde el modal
$(document).on("click", "#modal_camara_upload_btn", function () {
  const idOrg = $("#modalCamaraComercio").attr("data-id-org");
  const file = $("#modal_camara_file").prop("files")[0];
  if (!file) {
    if (typeof mostrarAlerta === "function") {
      mostrarAlerta("warning", "Archivo requerido", "Selecciona un archivo PDF para subir.");
    } else {
      alert("Selecciona un archivo PDF para subir.");
    }
    return;
  }

  const formData = new FormData();
  formData.append("file", file);
  formData.append("id_organizacion", idOrg);

  $.ajax({
    url: baseURL + "organizaciones/subirCamara",
    cache: false,
    contentType: false,
    processData: false,
    type: "post",
    dataType: "JSON",
    data: formData,
    beforeSend: function () {
      if (typeof toastSimple === "function") {
        toastSimple("info", "Subiendo archivo...");
      }
      $("#modal_camara_upload_btn").prop("disabled", true);
    },
    success: function (response) {
      if (typeof toastSimple === "function") {
        toastSimple("success", response.msg || "Cámara de comercio actualizada.");
      }
      refreshCamaraModal(idOrg);
    },
    error: function (ev) {
      if (typeof errorControlador === "function") {
        errorControlador(ev);
      } else {
        console.error(ev);
        alert("Error al subir la cámara de comercio.");
      }
      $("#modal_camara_upload_btn").prop("disabled", false);
    },
  });
});

// Eliminar (resetear a default.pdf) desde el modal
$(document).on("click", "#modal_camara_delete_btn", function () {
  const idOrg = $("#modalCamaraComercio").attr("data-id-org");

  confirmarAccion(
    "Eliminar cámara de comercio",
    "¿Está seguro de eliminar la cámara de comercio y volver al archivo por defecto?",
    "warning",
    "popup-swalert-lg"
  ).then((result) => {
    if (!result.isConfirmed) return;

    $.ajax({
      url: baseURL + "organizaciones/solicitarCamara",
      type: "post",
      data: { id_organizacion: idOrg },
      beforeSend: function () {
        if (typeof toastSimple === "function") {
          toastSimple("info", "Procesando eliminación...");
        }
        $("#modal_camara_delete_btn").prop("disabled", true);
      },
      success: function () {
        if (typeof toastSimple === "function") {
          toastSimple("success", "Se eliminó la cámara de comercio y se restauró el valor por defecto.");
        }
        $("#modal_camara_delete_btn").prop("disabled", false);
        refreshCamaraModal(idOrg);
      },
      error: function (ev) {
        if (typeof errorControlador === "function") {
          errorControlador(ev);
        } else {
          console.error(ev);
          alert("Error al eliminar la cámara de comercio.");
        }
        $("#modal_camara_delete_btn").prop("disabled", false);
      },
    });
  });
});

// Abrir modal de Prioritarias y cargar contenido
$(document).on("click", "#btnPrioritarias", function () {
  $("#prioritarias_content").empty();
  $("#prioritarias_loader").show();

  $.ajax({
    url: baseURL + "organizaciones/organizacionesSinCamaraDeComercio",
    type: "get",
    dataType: "html",
    success: function (html) {
      $("#prioritarias_loader").hide();
      // Inyectar el HTML del backend dentro de una tarjeta estilizada
      $("#prioritarias_content").html(`
        <div class="card border-0 shadow-sm">
          <div class="card-body">
            ${html}
          </div>
        </div>
      `);
      $("#modalPrioritarias").modal("show");
    },
    error: function (ev) {
      $("#prioritarias_loader").hide();
      if (typeof errorControlador === "function") {
        errorControlador(ev);
      } else {
        $("#prioritarias_content").html("<p class='text-danger'>No fue posible cargar las prioritarias.</p>");
      }
      $("#modalPrioritarias").modal("show");
    },
  });
});

// Limpiar al cerrar
$(document).on("hidden.bs.modal", "#modalPrioritarias", function () {
  $("#prioritarias_content").empty();
  $("#prioritarias_loader").hide();
});
