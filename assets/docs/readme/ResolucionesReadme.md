### README - Módulo de Resoluciones SIIA

## 📋 Descripción del Módulo

Este documento resume las mejoras implementadas en el **Módulo de Resoluciones** del SIIA para administración y organización. Se añadieron endpoints para eliminar y reemplazar el archivo PDF de una resolución, se robustecieron los flujos de edición, y se ajustó el front-end para prellenar/bloquear la información de organización en modo edición, sin afectar el flujo de creación.

## 🎯 Objetivos

- ✅ Permitir eliminar solo el archivo PDF de una resolución, preservando el registro.
- ✅ Habilitar reemplazo de PDF manteniendo la resolución existente y su relación con la organización/solicitud.
- ✅ Prellenar y bloquear campos de organización al editar; desbloquear al crear.
- ✅ Homogeneizar parámetros (`id_resolucion`/`id_res`) para evitar errores de “no encontrado”.
- ✅ Mejorar UX: mostrar nombre del archivo seleccionado y vista del PDF actual.

## 🔧 Modificaciones Implementadas

### 1) Endpoints de Archivo en `Resoluciones.php`
**Archivo**: `application/controllers/Resoluciones.php`

- `eliminarArchivoResolucion`: Elimina el PDF físico asociado a la resolución y setea el campo `resolucion` en `NULL` sin borrar el registro.
- `reemplazarArchivoResolucion`: Valida y sube un nuevo PDF, elimina el anterior y actualiza el campo `resolucion` con el nuevo nombre.

Ambos métodos aceptan indistintamente `id_resolucion` o `id_res` en POST para mayor compatibilidad.

#### Ejemplo: eliminar archivo (AJAX jQuery)
```javascript
$.ajax({
  url: base_url + "resoluciones/eliminarArchivoResolucion",
  type: "POST",
  data: { id_resolucion: idResolucionActual },
  success: function (resp) {
    if (resp.success) {
      notif({ msg: "Archivo eliminado.", type: "success" });
      // UI: ocultar enlace PDF actual y botón reemplazo
    } else {
      notif({ msg: resp.message || "No se pudo eliminar.", type: "error" });
    }
  },
  error: function () {
    notif({ msg: "Error de red al eliminar.", type: "error" });
  }
});
```

#### Ejemplo: reemplazar archivo (AJAX jQuery con `FormData`)
```javascript
const fd = new FormData();
fd.append("id_resolucion", idResolucionActual);
fd.append("resolucion", $("#resolucion_super")[0].files[0]); // input file

$.ajax({
  url: base_url + "resoluciones/reemplazarArchivoResolucion",
  type: "POST",
  data: fd,
  contentType: false,
  processData: false,
  success: function (resp) {
    if (resp.success) {
      notif({ msg: "PDF reemplazado.", type: "success" });
      // UI: refrescar enlace al nuevo PDF
    } else {
      notif({ msg: resp.message || "No se pudo reemplazar.", type: "error" });
    }
  },
  error: function () {
    notif({ msg: "Error de red al reemplazar.", type: "error" });
  }
});
```

### 2) Helper de Archivos en `files_helper.php`
**Archivo**: `application/helpers/files_helper.php`

- Se extendió el helper para soportar tipo `resoluciones` en:
  - `create_file_enhanced($type, $inputName, $targetSubdir)`: Valida MIME/extension (PDF), normaliza nombres y guarda en `uploads/resoluciones/`.
  - `delete_file($type, $fileName, $id_archivo = null, $id_formulario = null)`: Borra el archivo físico y, si no hay IDs válidos, no toca la base de datos.

#### Uso desde controlador
```php
// Subir nuevo PDF
$result = create_file_enhanced('resoluciones', 'resolucion', 'uploads/resoluciones/');
if ($result['success']) {
    $nuevoNombre = $result['file_name'];
    // actualizar DB con $nuevoNombre
}

// Eliminar PDF físico
delete_file('resoluciones', $nombreAnterior);
```

### 3) Organización: Gestión de Archivos y UX
**Archivo**: `assets/js/functions/admin/modules/resoluciones/organizacion.js`

- `#eliminarArchivoResolucion`: Envía `id_resolucion` al endpoint y actualiza la UI (ocultar enlace PDF/acción de reemplazo).
- `#reemplazarArchivoResolucion`: Despliega el input file, valida PDF y llama al endpoint de reemplazo vía `FormData`.
- `custom-file` Bootstrap: Actualización del label con el nombre del archivo seleccionado.
  ```javascript
  $("#resolucion_super").on("change", function () {
    const file = this.files && this.files[0];
    if (!file) return;
    $(this).next(".custom-file-label").text(file.name);
  });
  ```

### 4) Super Admin: Modal “Editar Resolución”
**Archivos**: 
- `assets/js/functions/admin/modules/resoluciones/main.js`
- `application/views/admin/resoluciones/index.php` (secciones para PDF actual y botón reemplazo)

Cambios clave:
- Al editar, se prellenan y bloquean: organización, tipo de resolución (radios), solicitud y, según aplique, cursos/modalidades.
- Se muestran el enlace al PDF actual (`#linkPdfActualSuper`) y botón para reemplazar (`#btn_reemplazar_archivo_sp`), si existe archivo.
- Al volver a “Crear Resolución”, se reestablecen estados por defecto (desbloqueo de organización/solicitud/tipo).
- Fix de `resetModal()`: desbloquea organización y radios, oculta wrapper del PDF actual y limpia referencias `data-id-res`.

#### Reset del modal (fragmento)
```javascript
function resetModal() {
  $("#form_resoluciones_super")[0].reset();

  $("#id-organizacion").prop("disabled", false).val('');
  $("input[name=tipoResolucionSuper]").prop("disabled", false);
  $("input[name=tipoResolucionSuper][value='nueva']").prop("checked", true);

  $("#resolucionViejaSuper").hide();
  $("#resolucionVigenteSuper").show();

  $("#idSolicitudSuper").prop("disabled", false).empty()
    .append('<option value="">Seleccione una solicitud...</option>');

  $("#numero-resolucion-super").val('');
  $("#anos-resolucion-super").val('').prop("disabled", true);
  $("#fecha-inicio-super").val('');
  $("#fecha-fin-super").val('').prop("disabled", true);

  $("#resolucion_super").val('').removeAttr('data-filename');
  $("#archivoActualSuperWrapper").hide();
  $("#linkPdfActualSuper").attr("href", "#").text("Ver PDF actual");
  $("#btn_reemplazar_archivo_sp").hide().removeAttr("data-id-res").removeAttr("data-id-org");

  $("#btn_actualizar_resolucion_sp").removeAttr("data-id-res").removeAttr("data-id-org");
} 
```

---

## 🚦 Flujos de Uso

### Crear Resolución
- Selecciona organización y solicitud (habilitados).
- Tipo por defecto: “Vigente”.
- Adjunta PDF (se muestra nombre en el input).
- Guarda resolución.

### Editar Resolución
- Organización, tipo y solicitud prellenados y bloqueados.
- Se muestran datos de la resolución y el PDF actual (si existe).
- Opción para reemplazar PDF; al confirmar reemplazo:
  - Se valida el tipo de archivo (PDF).
  - Se sube el nuevo PDF y se elimina el anterior.
  - Se actualiza el campo `resolucion` en DB.

### Eliminar Solo el PDF
- Usa `eliminarArchivoResolucion`.
- El registro de la resolución permanece; campo `resolucion` se setea en `NULL`.

---

## 🧪 Casos de Prueba

- Reemplazo exitoso con resolución existente: retorna `success: true` y actualiza enlace PDF.
- Intento de reemplazo sin archivo: retorna error de validación.
- Eliminar PDF y luego reemplazar: permitido; al eliminar no se borra el registro.
- Conmutación de “Editar” → “Crear”: los campos se desbloquean correctamente (ver `resetModal()`).
- Parámetros `id_resolucion` y `id_res`: ambos reconocidos por los endpoints.

---

## 📁 Estructura de Archivos Modificados

application/
├── controllers/
│   └── Resoluciones.php          # eliminarArchivoResolucion, reemplazarArchivoResolucion
├── helpers/
│   └── files_helper.php          # soporte 'resoluciones', create/delete robusto
└── views/
    └── admin/
        └── resoluciones/
            ├── index.php         # Admin resoluciones - wrapper PDF actual y reemplazo
            └── organizacion.php  # Organización - gestión de archivo y UI

assets/
└── js/
    └── functions/
        └── admin/
            └── modules/
                └── resoluciones/
                    ├── main.js         # lógica de edición y reset modal
                    └── organizacion.js # manejo de archivo y UX

## 📦 Respuestas de API (Ejemplos)

### Eliminar archivo
```json
{
  "success": true,
  "message": "Archivo de resolución eliminado",
  "id_resolucion": 123
}
```

### Reemplazar archivo (error de validación)
```json
{
  "success": false,
  "message": "Debe adjuntar un archivo PDF válido"
}
```

### Reemplazar archivo (éxito)
```json
{
  "success": true,
  "message": "Resolución reemplazada",
  "file_name": "resolucion_123_2025.pdf"
}
```

---

## 🔌 Endpoints y Parámetros

- `POST resoluciones/eliminarArchivoResolucion`
  - Parámetros: `id_resolucion` o `id_res`
  - Resultado: elimina PDF físico y setea `resolucion = NULL`

- `POST resoluciones/reemplazarArchivoResolucion`
  - Parámetros: `id_resolucion` o `id_res`, `resolucion` (archivo PDF)
  - Resultado: valida PDF, sube nuevo archivo, borra anterior y actualiza campo `resolucion`

---

## 🚧 Errores Comunes y Soluciones

- “Resolución no encontrada” al reemplazar tras eliminar:
  - Usar `eliminarArchivoResolucion` (no `eliminarResolucion`) para eliminar solo el PDF.
  - Mantener el `id_resolucion` en el formulario de edición.

- Archivo no válido:
  - Verificar que el MIME sea `application/pdf` y extensión `.pdf`.

- IDs inconsistentes (`id_resolucion` vs `id_res`):
  - Ambos son soportados por los endpoints; asegurar que el front-end envíe uno consistentemente.

---

## 🚦 Flujos de Uso

### Crear Resolución
- Organización y solicitud habilitadas; tipo por defecto “Vigente”.
- Adjuntar PDF: se muestra el nombre en el input.
- Guardar resolución.

### Editar Resolución
- Organización, tipo y solicitud prellenados y bloqueados.
- Visualización del PDF actual (si existe) y opción de reemplazo.
- Reemplazo: valida, sube nuevo PDF, elimina anterior y actualiza campo `resolucion`.

### Eliminar Solo el PDF
- Usar `eliminarArchivoResolucion`.
- El registro de la resolución permanece; `resolucion = NULL`.

---

## 🧭 Checklist de Validación Rápida

- Crear → organización y solicitud habilitadas; tipo “Vigente” por defecto.
- Editar → organización, tipo y solicitud bloqueados; datos prellenados.
- PDF actual y botón de reemplazo visibles si hay archivo.
- Reemplazo actualiza enlace y elimina archivo anterior.
- Cambiar de “Editar” a “Crear” restablece estados por defecto (`resetModal()`).

---

## ✅ Consideraciones

- Para eliminar el registro completo usar `eliminarResolucion`; para solo PDF, `eliminarArchivoResolucion`.
- `files_helper` no toca la base de datos si no se proporcionan `id_archivo`/`id_formulario`.
- Validar extensión y MIME (`application/pdf`) en back-end y front-end.
- Mantener consistente el uso de `id_resolucion` o `id_res`.

---

## **Versión 1.0.0** - Gestión de Resoluciones (Edición y Archivo)