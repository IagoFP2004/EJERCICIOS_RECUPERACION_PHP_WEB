<!DOCTYPE html>
<html lang="en">
<head>
    <base href="<?php echo $_ENV['host.folder']; ?>">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DWES | Log in</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="assets/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>DWES</b>UD6</a>
    </div>
    <?php
    include $_ENV['folder.views'] . '/templates/flash-messages.php';
    ?>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Autentícate para iniciar sesión</p>
            <!-- <p class="login-box-msg">Datos acceso: <i>admin@test.org - test</i></p>     -->
            <form action="/login" method="post">
                <div class="input-group mb-3">
                    <input type="text" name="email" class="form-control" placeholder="my_email@mail.org"
                           value="<?php echo $email ?? ''; ?>">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <p class="text-danger"><?php echo $errores['email'] ?? '' ?></p>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" name="password" placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <p class="text-danger"><?php echo $errores['password'] ?? '' ?></p>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block float-right">Acceder</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
            <div class="col-12">
                <p><a href="<?php echo $_ENV['host.folder'] . 'register'; ?>">Crear una cuenta</a></p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
</body>
</html>
