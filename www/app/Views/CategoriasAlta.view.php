<div class="col-12">
    <div class="card shadow mb-4">
        <form method="post" action="/categoria/new">
            <input type="hidden" name="order" value="1">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Filtros</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <!--<form action="./?sec=formulario" method="post">                   -->
                <div class="row">
                    <div class="col-12 col-lg-4">
                        <div class="mb-3">
                            <label for="nombre_completo">Nombre:</label>
                            <input type="text" class="form-control" name="nombre" id="nombre" value="">
                            <p class="text-danger small"><?php  echo $errores['nombre'] ?? '' ?></p>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="mb-3">
                            <label for="id_padre">Padre:</label>
                            <select name="id_padre" id="id_padre" class="form-control" data-placeholder="Padre">
                                <?php foreach ($padre as $padre){ ?>
                                    <option value="<?php echo $padre['id_padre'] ?>"><?php echo $padre['nombre_categoria'] ?></option>
                                <?php } ?>
                            </select>
                            <p class="text-danger small"><?php  echo $errores['id_padre'] ?? '' ?></p>
                        </div>
                    </div>
            </div>
            <div class="card-footer">
                <div class="col-12 text-right">
                    <a href="/proveedores" value="" name="reiniciar" class="btn btn-danger">Cancelar</a>
                    <input type="submit" value="Guardar" name="enviar" class="btn btn-primary ml-2">
                    <a href="/proveedores/new" value="" name="reiniciar" class="btn btn-danger">Reiniciar filtros</a>
                </div>
            </div>
        </form>
    </div>
</div>