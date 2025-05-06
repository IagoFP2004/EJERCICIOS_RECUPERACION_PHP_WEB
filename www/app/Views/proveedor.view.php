<section class="content">
    <div class="container-fluid">
        <!--Inicio HTML -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow mb-4">
                    <?php if (!empty($_SESSION['mensaje'])){ ?>
                        <div class="alert alert-success">
                            <?php
                            echo $_SESSION['mensaje'];
                            unset($_SESSION['mensaje']);
                            ?>
                        </div>
                    <?php }?>
                    <form method="get" action="/proveedores">
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
                                        <input type="text" class="form-control" name="cif" id="cif" value="">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="mb-3">
                                        <label for="nombre_completo">Nombre:</label>
                                        <input type="text" class="form-control" name="nombre" id="nombre" value="">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3">
                                <div class="mb-3">
                                    <label for="id_pais">Pais:</label>
                                    <select name="id_pais[]" id="id_pais" class="form-control select2" data-placeholder="Tipo proveedor" multiple>
                                        <?php foreach ($paises as $pais){ ?>
                                            <option value="<?php echo $pais['id'] ?>"><?php echo $pais['country_name']?></option>
                                        <?php }?>
                                    </select>
                                </div>
                            </div>
                                <div class="col-12 col-lg-4">
                                    <div class="mb-3">
                                        <label for="anho_fundacion">Productos proveidos:</label>
                                        <div class="row">
                                            <div class="col-6">
                                                <input type="text" class="form-control" name="min_productos" id="min_prouctos" value="" placeholder="Minimo">
                                            </div>
                                            <div class="col-6">
                                                <input type="text" class="form-control" name="max_productos" id="max_productos" value="" placeholder="Máximo">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="mb-3">
                                        <label for="nombre_completo">Email:</label>
                                        <input type="text" class="form-control" name="email" id="email" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="col-12 text-right">
                                <a href="/proveedores" value="" name="reiniciar" class="btn btn-danger">Reiniciar filtros</a>
                                <input type="submit" value="Aplicar filtros" name="enviar" class="btn btn-primary ml-2">
                                <a href="/proveedores/new" value="" name="reiniciar" class="btn btn-warning">Añadir proveedor</a>
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
                                <th><a href="<?php echo $_ENV['host.folder'].'proveedores?'.$url.'&order='.($order ==1 ? '-':'')?>1">Cif</a> <i class="fas fa-sort-amount-down-alt"></i></th>
                                <th><a href="<?php echo $_ENV['host.folder'].'proveedores?'.$url.'&order='.($order ==2 ? '-':'')?>2">Nombre</a> </th>
                                <th><a href="<?php echo $_ENV['host.folder'].'proveedores?'.$url.'&order='.($order ==3 ? '-':'')?>3">Pais</a> </th>
                                <th><a href="<?php echo $_ENV['host.folder'].'proveedores?'.$url.'&order='.($order ==4 ? '-':'')?>4">Email</a> </th>
                                <th><a href="<?php echo $_ENV['host.folder'].'proveedores?'.$url.'&order='.($order ==5 ? '-':'')?>5">Telefono</a> </th>
                                <th><a href="<?php echo $_ENV['host.folder'].'proveedores?'.$url.'&order='.($order ==6 ? '-':'')?>6">Numero de productos diferentes proveidos</a> </th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($listado as $lista){?>
                                    <tr>
                                        <td><?php echo $lista['cif'] ?></td>
                                        <td><?php echo $lista['nombre'] ?></td>
                                        <td><?php echo $lista['pais'] ?></td>
                                        <td><?php echo $lista['email'] ?></td>
                                        <td><?php echo $lista['telefono'] ?></td>
                                        <td><?php echo $lista['numero_productos_diferentes_vendidos'] ?></td>
                                        <td><a href="tel: 931506210" target="_blank" class="btn btn-success ml-1" data-toggle="tooltip" data-placement="top" title="" data-original-title="931506210"><i class="fas fa-pen"></i></a></td>
                                        <td><a href="<?php echo $_ENV['host.folder']. 'proveedores/delete/'.$lista['cif']?>" target="_blank" class="btn btn-danger ml-1" data-toggle="tooltip" data-placement="top" title="" data-original-title="931506210"><i class="fas fa-trash"></i></a></td>
                                        <td><a href="tel: 931506210" target="_blank" class="btn btn-primary ml-1" data-toggle="tooltip" data-placement="top" title="" data-original-title="931506210"><i class="fas fa-globe-europe"></i></a></td>
                                    </tr>
                                <?php }?>
                            </tbody>
                        </table>
                    </div>
                    <!--
                    <div class="card-footer">
                        <nav aria-label="Navegacion por paginas">
                            <ul class="pagination justify-content-center">
                                <?php if($page > 1){ ?>
                                    <li class="page-item">
                                        <a class="page-link" href="<?php echo $_ENV['host.folder']. 'proveedores?'.$urlDos.'&page=1' ?>" aria-label="First">
                                            <span aria-hidden="true">«</span>
                                            <span class="sr-only">First</span>
                                        </a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="<?php echo $_ENV['host.folder']. 'proveedores?'.$urlDos.'&page='.($page - 1) ?>" aria-label="Previous">
                                            <span aria-hidden="true">&lt;</span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                    </li>
                                <?php } ?>

                                <li class="page-item active"><a class="page-link" href="#"><?php echo $page ?></a></li>

                                <?php if ($page < $max_page){ ?>
                                    <li class="page-item">
                                        <a class="page-link" href="<?php echo $_ENV['host.folder']. 'proveedores?'.$urlDos.'page='.($page + 1) ?>" aria-label="Next">
                                            <span aria-hidden="true">&gt;</span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="<?php echo $_ENV['host.folder']. 'proveedores?'.$urlDos?> &page=<?php echo $max_page ?>" aria-label="Last">
                                            <span aria-hidden="true">»</span>
                                            <span class="sr-only">Last</span>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </nav>
                -->
                    </div>
                </div>
            </div>
        </div>
        <!--Fin HTML -->      </div><!-- /.container-fluid -->
</section>