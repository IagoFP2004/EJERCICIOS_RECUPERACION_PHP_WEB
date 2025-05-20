<section class="content">
    <div class="container-fluid">
        <!--Inicio HTML -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <?php if (isset($_SESSION['mensaje'])){ ?>
                        <div class="alert alert-success">
                            <?php
                            echo $_SESSION['mensaje'];
                            unset($_SESSION['mensaje']);
                            ?>
                        </div>
                    <?php }?>
                    <?php if (isset($_SESSION['mensajeError'])){ ?>
                        <div class="alert alert-danger">
                            <?php
                            echo $_SESSION['mensajeError'];
                            unset($_SESSION['mensajeError']);
                            ?>
                        </div>
                    <?php }?>
                    <form method="get" action="">
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
                                        <input type="text" class="form-control" name="codigo" id="codigo" value="">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="mb-3">
                                        <label for="nombre_completo">Nombre:</label>
                                        <input type="text" class="form-control" name="nombre" id="nombre" value="">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="mb-3">
                                        <label for="nombre_completo">Descripcion:</label>
                                        <input type="text" class="form-control" name="descripcion" id="descripcion" value="">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="mb-3">
                                        <label for="id_proveedor">Proveedor:</label>
                                        <select name="id_proveedor[]" id="id_proveedor" class="form-control select2" data-placeholder="Tipo proveedor" multiple>
                                            <?php foreach ($proveedores as $proveedor){ ?>
                                                <option value="<?php echo $proveedor['cif']?>"><?php echo $proveedor['nombre']?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <label for="id_categoria">Categoria:</label>
                                    <select name="id_categoria" id="id_categoria" class="form-control" data-placeholder="Categorias">
                                        <?php foreach ($categorias as $categoria){ ?>
                                            <option value="<?php echo $categoria['id_categoria']?>"><?php echo $categoria['nombre_categoria']?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="mb-3">
                                        <label for="anho_fundacion">Margen:</label>
                                        <div class="row">
                                            <div class="col-6">
                                                <input type="text" class="form-control" name="min_margen" id="min_margen" value="" placeholder="Minimo">
                                            </div>
                                            <div class="col-6">
                                                <input type="text" class="form-control" name="max_margen" id="max_margen" value="" placeholder="Máximo">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="mb-3">
                                        <label for="anho_fundacion">Coste:</label>
                                        <div class="row">
                                            <div class="col-6">
                                                <input type="text" class="form-control" name="min_coste" id="min_coste" value="" placeholder="Minimo">
                                            </div>
                                            <div class="col-6">
                                                <input type="text" class="form-control" name="max_coste" id="max_coste" value="" placeholder="Máximo">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="anho_fundacion">Pvp:</label>
                                    <div class="row">
                                        <div class="col-6">
                                            <input type="text" class="form-control" name="min_pvp" id="min_pvp" value="" placeholder="Minimo">
                                        </div>
                                        <div class="col-6">
                                            <input type="text" class="form-control" name="max_pvp" id="max_pvp" value="" placeholder="Máximo">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="col-12 text-right">
                                <a href="/productos" value="" name="reiniciar" class="btn btn-danger">Reiniciar filtros</a>
                                <input type="submit" value="Aplicar filtros" name="enviar" class="btn btn-primary ml-2">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Proveedores</h6>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body" id="card_table">
                        <div id="button_container" class="mb-3"></div>
                        <!--<form action="./?sec=formulario" method="post">                   -->
                        <table id="tabladatos" class="table table-striped">
                            <thead>
                            <tr>
                                <th><a href="<?php echo $_ENV['host.folder'].'productos?'.$url.'&order='.($order==1 ? '-':'') ?>1">Codigo</a> <i class="fas fa-sort-amount-down-alt"></i></th>
                                <th><a href="<?php echo $_ENV['host.folder'].'productos?'.$url.'&order='.($order==2 ? '-':'') ?>2">Nombre</a> </th>
                                <th><a href="<?php echo $_ENV['host.folder'].'productos?'.$url.'&order='.($order==3 ? '-':'') ?>3">Nombre Proveedor</a> </th>
                                <th><a href="<?php echo $_ENV['host.folder'].'productos?'.$url.'&order='.($order==4 ? '-':'') ?>4">Coste</a> </th>
                                <th><a href="<?php echo $_ENV['host.folder'].'productos?'.$url.'&order='.($order==5 ? '-':'') ?>5">Margen</a> </th>
                                <th><a href="<?php echo $_ENV['host.folder'].'productos?'.$url.'&order='.($order==6 ? '-':'') ?>6">Stock</a> </th>
                                <th><a href="<?php echo $_ENV['host.folder'].'productos?'.$url.'&order='.($order==7 ? '-':'') ?>7">Iva</a> </th>
                                <th><a href="<?php echo $_ENV['host.folder'].'productos?'.$url.'&order='.($order==8 ? '-':'') ?>8">Pvp</a> </th>
                                <th><a href="<?php echo $_ENV['host.folder'].'productos?'.$url.'&order='.($order==9 ? '-':'') ?>9">Nombre completo de la categoria</a> </th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($productos as $producto){ ?>
                                    <tr>
                                        <td><?php echo $producto['codigo']?></td>
                                        <td><?php echo $producto['nombre']?></td>
                                        <td><?php echo $producto['nombre_proveedor']?></td>
                                        <td><?php echo $producto['coste']?></td>
                                        <td><?php echo $producto['margen']?></td>
                                        <td><?php echo $producto['stock']?></td>
                                        <td><?php echo $producto['iva']?></td>
                                        <td><?php echo $producto['pvp']?></td>
                                        <td><?php echo $producto['nombre_completo_categoria']?></td>
                                        <td><a href="<?php echo $_ENV['host.folder'].'productos/delete/'.$producto['codigo'] ?>" target="_blank" class="btn btn-danger ml-1" data-toggle="tooltip" data-placement="top" title="" data-original-title="931506210"><i class="fas fa-trash"></i></a></td>
                                    </tr>
                                <?php }?>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <nav aria-label="Navegacion por paginas">
                            <ul class="pagination justify-content-center">
                                <?php if ($page > 1){?>
                                <li class="page-item">
                                    <a class="page-link" href="<?php echo $_ENV['host.folder'].'productos?'.$urlDos.'&page=1'?>" aria-label="First">
                                        <span aria-hidden="true">«</span>
                                        <span class="sr-only">First</span>
                                    </a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="<?php echo $_ENV['host.folder'].'productos?'.$urlDos.'&page='.($page -1)?>" aria-label="Previous">
                                        <span aria-hidden="true">&lt;</span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>
                             <?php }?>
                                <li class="page-item active"><a class="page-link" href="#"><?php echo $page ?></a></li>
                                <?php if ($page < $max_page){?>
                                <li class="page-item">
                                    <a class="page-link" href="<?php echo $_ENV['host.folder'].'productos?'.$urlDos.'&page='.($page +1)?>" aria-label="Next">
                                        <span aria-hidden="true">&gt;</span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="<?php echo $_ENV['host.folder'].'productos?'.$urlDos.'&page='.$max_page?>" aria-label="Last">
                                        <span aria-hidden="true">»</span>
                                        <span class="sr-only">Last</span>
                                    </a>
                                </li>
                                <?php }?>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!--Fin HTML -->      </div><!-- /.container-fluid -->
</section>