<section class="content">
    <div class="container-fluid">
        <!--Inicio HTML -->
        <div class="row">
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
                                        <label for="alias">Codigo:</label>
                                        <input type="text" class="form-control" name="codigo" id="codigo" value="<?php echo $input['codigo'] ?? '' ?>">
                                        <p class="text-danger"><?php echo $errores['codigo'] ?? '' ?></p>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="mb-3">
                                        <label for="nombre_completo">Nombre:</label>
                                        <input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo $input['nombre'] ?? '' ?>">
                                        <p class="text-danger"><?php echo $errores['nombre'] ?? '' ?></p>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="mb-3">
                                        <label for="nombre_completo">Descripcion:</label>
                                        <input type="text" class="form-control" name="descripcion" id="descripcion" value="<?php echo $input['descripcion'] ?? '' ?>">
                                        <p class="text-danger"><?php echo $errores['descripcion'] ?? '' ?></p>

                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="mb-3">
                                        <label for="id_proveedor">Proveedor:</label>
                                        <select name="id_proveedor" id="id_proveedor" class="form-control" data-placeholder="Tipo proveedor">
                                            <?php foreach ($proveedores as $proveedor){ ?>
                                                <option value="<?php echo $proveedor['cif'] ?>" <?php echo (isset($input['cif']) && $input['cif'] == $proveedor['cif']) ? 'selected' : ''; ?>><?php echo $proveedor['nombre']; ?></option>                                            <?php } ?>
                                        </select>
                                        <p class="text-danger"><?php echo $errores['id_proveedor'] ?? '' ?></p>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <label for="id_categoria">Categoria:</label>
                                    <select name="id_categoria" id="id_categoria" class="form-control" data-placeholder="Categorias">
                                        <?php foreach ($categorias as $categoria){ ?>
                                            <option value="<?php echo $categoria['id_categoria']?>" <?php echo (isset($input['id_categoria']) && $input['id_categoria'] == $categoria['id_categoria'] ? 'selected':'') ?>><?php echo $categoria['nombre_categoria']?></option>
                                        <?php } ?>
                                    </select>
                                    <p class="text-danger"><?php echo $errores['id_categoria'] ?? '' ?></p>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="mb-3">
                                        <label for="nombre_completo">Coste:</label>
                                        <input type="text" class="form-control" name="coste" id="coste" value="<?php echo $input['coste'] ?? '' ?>">
                                        <p class="text-danger"><?php echo $errores['coste'] ?? '' ?></p>

                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="mb-3">
                                        <label for="nombre_completo">Margen:</label>
                                        <input type="text" class="form-control" name="margen" id="margen" value="<?php echo $input['margen'] ?? '' ?>">
                                        <p class="text-danger"><?php echo $errores['margen'] ?? '' ?></p>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <label for="iva">IVA:</label>
                                    <select name="iva" id="iva" class="form-control" data-placeholder="IVA">
                                        <option value="0">0</option>
                                        <option value="10">10</option>
                                        <option value="21">21</option>
                                    </select>
                                    <p class="text-danger"><?php echo $errores['iva'] ?? '' ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="col-12 text-right">
                                <a href="/productos" value="" name="reiniciar" class="btn btn-danger ml-2">Cancelar</a>
                                <a href="/productos/new" value="" name="reiniciar" class="btn btn-danger ml-2">Reiniciar filtros</a>
                                <input type="submit" value="Guardar" name="enviar" class="btn btn-primary ml-2">
                            </div>
                        </div>
                    </form>