<?php
// Componente: Modal de Novedades Dinámico
// Modal para agregar novedades y tabla para mostrar las existentes
?>
<!-- Botón para abrir el modal -->
<div class="d-flex justify-content-end mb-2">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNovedad">
        <i class="bi bi-plus-circle me-1"></i> Agregar Novedad
    </button>
</div>

<!-- Modal de Novedad -->
<div class="modal fade" id="modalNovedad" tabindex="-1" aria-labelledby="modalNovedadLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalNovedadLabel">Agregar Novedad</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <form method="POST" action="<?php echo BASE_URL; ?>/src/Controllers/novedadesController.php">
        <div class="modal-body">
          <div class="mb-3">
            <label for="novedad" class="form-label">Novedad</label>
            <input type="text" name="novedad" id="novedad" class="form-control" placeholder="Escribe la novedad..." required maxlength="250">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Aceptar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Tabla de novedades -->
<div class="table-responsive" style="min-height:220px;max-height:320px;overflow-y:auto;">
    <table class="table table-borderless align-middle mb-0">
        <thead>
            <tr>
                <th style="width: 160px;">Fecha</th>
                <th>Novedad</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Mostrar novedades (se espera que $novedades venga del controlador)
            if (isset($novedades) && count($novedades) > 0):
                foreach ($novedades as $nov): ?>
                    <tr>
                        <td class="text-muted small">
                            <?php echo date('d/m/Y H:i', strtotime($nov['idCreate'])); ?>
                        </td>
                        <td><?php echo htmlspecialchars($nov['novedad']); ?></td>
                    </tr>
                <?php endforeach;
            else: ?>
                <tr><td colspan="2" class="text-center text-muted">No hay novedades aún.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
