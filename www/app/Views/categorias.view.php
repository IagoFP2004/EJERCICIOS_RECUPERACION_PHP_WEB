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

                    <form method="get" action="/categoria">
                        <input type="hidden" name="order" value="1">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Filtros</h6>
                        </div>
                        <!-- Card Body -->
                        <div class="card-body">
                            <div class="row">
                                <!-- Campo: Nombre -->
                                <div class="col-12 col-lg-6">
                                    <div class="mb-3">
                                        <label for="nombre">Nombre:</label>
                                        <input type="text" class="form-control" name="nombre" id="nombre" value="">
                                    </div>
                                </div>

                                <!-- Campo: Productos proveídos -->
                                <div class="col-12 col-lg-6">
                                    <div class="mb-3">
                                        <label for="anho_fundacion">Productos proveídos:</label>
                                        <div class="row">
                                            <div class="col-6">
                                                <input type="text" class="form-control" name="min_numero_articulos" id="min_numero_articulos" value="" placeholder="Mínimo">
                                            </div>
                                            <div class="col-6">
                                                <input type="text" class="form-control" name="max_numero_articulos" id="max_numero_articulos" value="" placeholder="Máximo">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="col-12 text-right">
                                <a href="/categoria" value="" name="reiniciar" class="btn btn-danger">Reiniciar filtros</a>
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
                                <th><a href="<?php echo $_ENV['host.folder'].'categoria?'.$url.'&order='.($order ==1 ? '-':'') ?>1">Nombre Categoria</a> <i class="fas fa-sort-amount-down-alt"></i></th>
                                <th><a href="<?php echo $_ENV['host.folder'].'categoria?'.$url.'&order='.($order ==2 ? '-':'') ?>2">Nombre Completo Categoria</a></th>
                                <th><a href="<?php echo $_ENV['host.folder'].'categoria?'.$url.'&order='.($order ==3 ? '-':'') ?>3">Numero de articulos Categoria</a> </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($listado as $item){ ?>
                                <tr>
                                    <td><?php echo $item['nombre_categoria']?></td>
                                    <td><?php echo $item['nombre_completo_categoria']?></td>
                                    <td><?php echo $item['numero_articulos']?></td>
                                    <td><a href="" target="_blank" class="btn btn-success ml-1" data-toggle="tooltip" data-placement="top" title="" data-original-title="931506210"><i class="fas fa-pen"></i></a></td>
                                    <td><a href="<?php echo $_ENV['host.folder'].'categoria/delete/'.$item['id_categoria'] ?>" target="_blank" class="btn btn-danger ml-1" data-toggle="tooltip" data-placement="top" title="" data-original-title="931506210"><i class="fas fa-trash"></i></a></td>
                                </tr>
                            <?php }?>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <nav aria-label="Navegacion por paginas">
                            <ul class="pagination justify-content-center">
                                <?php if($page > 1){?>
                                <li class="page-item">
                                    <a class="page-link" href="<?php echo $_ENV['host.folder'].'categoria?'.$url2.'&page=1'?>" aria-label="First">
                                        <span aria-hidden="true">«</span>
                                        <span class="sr-only">First</span>
                                    </a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="<?php echo $_ENV['host.folder'].'categoria?'.$url2.'&page='.($page -1)?>" aria-label="Previous">
                                        <span aria-hidden="true">&lt;</span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                </li>
                                <?php }?>
                                <li class="page-item active"><a class="page-link" href="#"><?php echo $page ?></a></li>
                                <?php if($page < $max_page){?>
                                <li class="page-item">
                                    <a class="page-link" href="<?php echo $_ENV['host.folder'].'categoria?'.$url2.'&page='.($page +1)?>" aria-label="Next">
                                        <span aria-hidden="true">&gt;</span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="<?php echo $_ENV['host.folder'].'categoria?'.$url2.'&page='.$max_page?>" aria-label="Last">
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