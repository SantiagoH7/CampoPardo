<?php use App\Controllers\ImagenesController;
use App\Models\Imagenes;

require("partials/routes.php"); ?>
<?php $baseURL = $baseURL ?? ""; require("partials/check_login.php"); ?>

<!DOCTYPE html>
<html>
<head>
    <title><?= $_ENV['TITLE_SITE'] ?> | Home</title>
    <?php require("partials/head_imports.php"); ?>
</head>
<body class="hold-transition sidebar-mini">

<!-- Site wrapper -->
<div class="wrapper">
    <?php require("partials/navbar_customization.php"); ?>

    <?php require("partials/sliderbar_main_menu.php"); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Inicio</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/views/index.php"><?= $_ENV['ALIASE_SITE'] ?></a></li>
                            <li class="breadcrumb-item active">Home</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <div class="card card-solid">
            <br>
            <div class=" m-auto">
                <h1 class="mb-0">¿Qué estás buscando?</h1>
            </div>
            <br>
            <div class="card-body pb-0">
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column mx-auto">
                        <div class="card bg-light d-flex flex-fill">
                            <div class="card-header text-muted border-bottom-0">
                               Admin CEO - Campo Pardo
                            </div>
                            <div class="card-body pt-0">
                                <div class="row">
                                    <div class="col-7">
                                        <h2 class="lead"><b>Jeisson Pardo</b></h2>
                                        <ul class="ml-4 mb-0 fa-ul text-muted">
                                            <li class="small"><span class="fa-li"><i class="fas fa-map-marker-alt"></i></span> Barrio: Villa del sol Sogamoso</li>
                                            <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span> Telefono #: 3203487292</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                    |               <?php  if ( $_SESSION['UserInSession']['Rol'] == 'Administrador'){ ?>
                                    <div class="text-right">
                                        <div class="mr-3">
                                            <a href="modules/usuario/index.php" class="btn btn-sm btn-bitbucket">
                                                <i class="fas fa-users"></i>&nbsp;Gestionar usuarios
                                            </a>
                                            <a href="modules/venta/index.php" class="btn btn-sm btn-success">
                                                <i class="fas fa-dollar-sign"></i>&nbsp;Gestionar ventas
                                            </a>
                                            <div class="mt-2 mr-5">
                                                <a href="modules/producto/index.php" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-cheese"></i>&nbsp;Gestionar productos
                                                </a>
                                            </div>
                                        </div>
                                        <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!-- Main content -->
            <br>
            <br>
            <br>
            <br>
        </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <?php require ('partials/footer.php');?>
</div>
<!-- ./wrapper -->
<?php require ('partials/scripts.php');?>
</body>
</html>