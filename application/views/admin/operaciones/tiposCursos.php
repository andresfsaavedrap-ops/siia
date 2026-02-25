<div class="main-panel">
    <div class="content-wrapper">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="font-weight-bold text-primary mb-0">
                            <i class="mdi mdi-school text-primary mr-2"></i>
                            Tipos de Cursos
                        </h4>
                        <p class="text-muted mb-0 small">Gestión de categorías de cursos para informes de actividades</p>
                    </div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                            <li class="breadcrumb-item text-sm">
                                <a class="opacity-5 text-dark" href="<?php echo base_url('admin/panel'); ?>">Panel</a>
                            </li>
                            <li class="breadcrumb-item text-sm">
                                <a class="opacity-5 text-dark" href="<?php echo base_url('admin/operaciones'); ?>">Operaciones</a>
                            </li>
                            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Tipos de Cursos</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Formulario para crear nuevo curso -->
        <div class="row mb-4">
            <div class="col-lg-8 col-md-10 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0 text-white">
                            <i class="mdi mdi-plus-circle text-white mr-2"></i>
                            Crear Nuevo Tipo de Curso
                        </h5>
                    </div>
                    <div class="card-body">
                        <form id="formNuevoCurso">
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label for="nuevoNombreTipoCurso" class="form-label">
                                            <i class="mdi mdi-tag mr-1"></i>Nombre del Curso
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="mdi mdi-book-open"></i>
                                                </span>
                                            </div>
                                            <input type="text" 
                                                   id="nuevoNombreTipoCurso" 
                                                   class="form-control" 
                                                   placeholder="Ingrese el nombre del nuevo tipo de curso..."
                                                   required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 d-flex align-items-end">
                                    <button type="button" class="btn btn-success w-100" id="crearTipoCurso">
                                        <i class="mdi mdi-plus mr-2"></i>Crear
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lista de cursos existentes -->
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-header bg-white border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">
                                <i class="mdi mdi-format-list-bulleted mr-2 text-info"></i>
                                Lista de Tipos de Cursos Actuales
                            </h5>
                            <span class="badge badge-info">
                                <?php echo sizeof($tiposCursoInformes); ?> cursos registrados
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="tipoCursoInforme">
                            <div id='numero_tiposCurso' class='d-none' data-num-cursos='<?php echo sizeof($tiposCursoInformes); ?>'></div>
                            
                            <?php if (!empty($tiposCursoInformes)): ?>
                                <div class="row">
                                    <?php foreach ($tiposCursoInformes as $index => $curso): ?>
                                    <div class="col-md-6 mb-3">
                                        <div class="card border-left-info h-100">
                                            <div class="card-body py-3">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div class="flex-grow-1 mr-2">
                                                        <div class="form-group mb-2">
                                                            <label class="form-label small text-muted">
                                                                <i class="mdi mdi-tag mr-1"></i>Nombre del curso
                                                            </label>
                                                            <input type='text' 
                                                                   id='nombretipocurso_<?php echo $curso->id_tiposCursoInformes; ?>' 
                                                                   data-id='<?php echo $curso->id_tiposCursoInformes; ?>' 
                                                                   class='form-control form-control-sm' 
                                                                   value='<?php echo htmlspecialchars($curso->nombre); ?>'>
                                                        </div>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <button class="btn btn-sm btn-outline-danger eliminarCursoInforme" 
                                                                data-id='<?php echo $curso->id_tiposCursoInformes; ?>'
                                                                title="Eliminar curso">
                                                            <i class="mdi mdi-delete"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                                
                                <!-- Botón para actualizar todos los cursos -->
                                <div class="row mt-4">
                                    <div class="col-12 text-center">
                                        <button class='btn btn-primary actualizar_tipocurso'>
                                            <i class='mdi mdi-content-save mr-2'></i>Actualizar Todos los Cursos
                                        </button>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="text-center py-5">
                                    <div class="mb-3">
                                        <i class="mdi mdi-school-outline text-muted" style="font-size: 4rem;"></i>
                                    </div>
                                    <h5 class="text-muted">No hay tipos de cursos registrados</h5>
                                    <p class="text-muted mb-3">Comienza creando tu primer tipo de curso</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botón de navegación -->
        <div class="row mt-4">
            <div class="col-12 text-center">
                <a href="<?php echo base_url('admin/operaciones'); ?>" class="btn btn-outline-secondary">
                    <i class="mdi mdi-arrow-left mr-2"></i>Volver al Panel de Operaciones
                </a>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // Crear nuevo tipo de curso
    $('#crearTipoCurso').click(function() {
        const nombreCurso = $('#nuevoNombreTipoCurso').val().trim();
        
        if (nombreCurso === '') {
            Swal.fire({
                icon: 'warning',
                title: 'Campo requerido',
                text: 'Por favor ingrese el nombre del curso'
            });
            return;
        }

        // Aquí iría la lógica AJAX para crear el curso
        Swal.fire({
            icon: 'success',
            title: 'Curso creado',
            text: 'El tipo de curso se ha creado exitosamente'
        }).then(() => {
            $('#nuevoNombreTipoCurso').val('');
            // Recargar la página o actualizar la lista
        });
    });

    // Eliminar curso
    $('.eliminarCursoInforme').click(function() {
        const cursoId = $(this).data('id');
        
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción no se puede deshacer",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Aquí iría la lógica AJAX para eliminar
                Swal.fire(
                    'Eliminado',
                    'El tipo de curso ha sido eliminado.',
                    'success'
                );
            }
        });
    });

    // Actualizar cursos
    $('.actualizar_tipocurso').click(function() {
        Swal.fire({
            icon: 'success',
            title: 'Cursos actualizados',
            text: 'Los cambios se han guardado exitosamente'
        });
    });
});
</script>
