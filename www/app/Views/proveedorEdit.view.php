<div class="col-12">
    <div class="card shadow mb-4">
        <form method="post" action="">
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
                            <label for="alias">Cif:</label>
                            <input type="text" class="form-control" name="cif" id="cif" value="<?php echo $proveedor['cif'] ?? ''  ?>">
                            <p class="text-danger small"><?php  echo $errores['cif'] ?? '' ?></p>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="mb-3">
                            <label for="nombre_completo">Nombre:</label>
                            <input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo $proveedor['nombre'] ?? ''  ?>">
                            <p class="text-danger small"><?php  echo $errores['nombre'] ?? '' ?></p>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="mb-3">
                            <label for="id_country">PaIs:</label>
                            <select name="id_country" id="id_country" class="form-control" data-placeholder="Pais">
                                <?php foreach ($paises as $pais){?>
                                    <option value="<?php echo $pais['id']?>" <?php echo (isset($proveedor['id_country']) && $pais['id'] == $proveedor['id_country']) ? 'selected':'' ?>><?php echo $pais['country_name']?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="mb-3">
                            <label for="nombre_completo">Email:</label>
                            <input type="text" class="form-control" name="email" id="email" value="<?php echo $proveedor['email'] ?? ''  ?>">
                            <p class="text-danger small"><?php  echo $errores['email'] ?? '' ?></p>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="mb-3">
                            <label for="nombre_completo">Codigo:</label>
                            <input type="text" class="form-control" name="codigo" id="codigo" value="<?php echo $proveedor['codigo'] ?? ''  ?>">
                            <p class="text-danger small"><?php  echo $errores['codigo'] ?? '' ?></p>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="mb-3">
                            <label for="nombre_completo">Direccion:</label>
                            <input type="text" class="form-control" name="direccion" id="direccion" value="<?php echo $proveedor['direccion'] ?? ''  ?>">
                            <p class="text-danger small"><?php  echo $errores['direccion'] ?? '' ?></p>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="mb-3">
                            <label for="nombre_completo">Website:</label>
                            <input type="text" class="form-control" name="website" id="website" value="<?php echo $proveedor['website'] ?? ''  ?>">
                            <p class="text-danger small"><?php  echo $errores['website'] ?? '' ?></p>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="mb-3">
                            <label for="nombre_completo">Telefono:</label>
                            <input type="text" class="form-control" name="telefono" id="telefono" value="<?php echo $proveedor['telefono'] ?? ''  ?>">
                            <p class="text-danger small"><?php  echo $errores['telefono'] ?? '' ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="col-12 text-right">
                    <a href="/categoria" value="" name="reiniciar" class="btn btn-danger">Cancelar</a>
                    <input type="submit" value="Guardar cambios" name="enviar" class="btn btn-primary ml-2">
                </div>
            </div>
        </form>
    </div>
</div>