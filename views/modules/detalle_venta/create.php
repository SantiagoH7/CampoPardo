<?php
require_once("../../../app/Controllers/DetalleVentasController.php");
require_once("../../partials/routes.php");
require_once("../../partials/check_login.php");

use App\Controllers\DetalleVentasController;
use App\Controllers\VentasController;
use App\Controllers\ProductosController;
use App\Models\GeneralFunctions;

$nameModel = "DetalleVenta"; //Nombre del Modelo
$nameForm = 'frmCreate'.$nameModel;
$pluralModel = $nameModel.'s'; //Nombre del modelo en plural
$frmSession = $_SESSION[$nameForm] ?? NULL; //Nombre del formulario (frmUsuarios)
?>
<!DOCTYPE html>
<html>
<head>
    <title>Crear | <?= $nameModel ?></title>
    <?php require("../../partials/head_imports.php"); ?>
</head>
<body class="hold-transition sidebar-mini">

<!-- Site wrapper -->
<div class="wrapper">
    <?php require("../../partials/navbar_customization.php"); ?>

    <?php require("../../partials/sliderbar_main_menu.php"); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Crear un nuevo <?= $nameModel ?></h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/views/"><?= $_ENV['ALIASE_SITE'] ?></a></li>
                            <li class="breadcrumb-item"><a href="index.php"><?= $nameModel ?></a></li>
                            <li class="breadcrumb-item active">Crear</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Generar Mensaje de alerta -->
            <?= (!empty($_GET['respuesta'])) ? GeneralFunctions::getAlertDialog($_GET['respuesta'], $_GET['mensaje']) : ""; ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Horizontal Form -->
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-info"></i> &nbsp; Información del <?= $nameModel ?></h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="maximize"><i
                                            class="fas fa-expand"></i></button>
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                            class="fas fa-minus"></i></button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                            <!-- form start -->
                                <form class="form-horizontal" method="post" id="<?= $nameForm ?>"
                                      name="<?= $nameForm ?>"
                                      action="../../../app/Controllers/MainController.php?controller=<?= $pluralModel ?>&action=create">

                                      <div class="row">
                                          <div class="col-sm-12">
                                                <div class="form-group row">
                                                    <label for="Venta_id" class="col-sm-2 col-form-label">Venta</label>
                                                    <div class="col-sm-10">
                                                        <?= VentasController::selectVenta(array (
                                                                'id' => 'Venta_id',
                                                                'name' => 'Venta_id',
                                                                'defaultValue' => (!empty($_GET['idVenta'])) ? $_GET['idVenta'] : ($frmSession['Venta_id'] ?? ''),
                                                                'class' => 'form-control select2bs4 select2-info',
                                                                'where' => "estado = 'Pendiente'"
                                                            )
                                                        )
                                                        ?>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="ProductoId" class="col-sm-2 col-form-label">Producto</label>
                                                    <div class="col-sm-10">
                                                        <?= ProductosController::selectProducto
                                                        (array (
                                                                'id' => 'Producto_id',
                                                                'name' => 'Producto_id',
                                                                'defaultValue' => (!empty($frmSession['Producto_id'])) ? $frmSession['Producto_id'] : '',
                                                                'class' => 'form-control select2bs4 select2-info',
                                                                'where' => "estado = 'Activo'"
                                                            )
                                                        )
                                                        ?>
                                                    </div>
                                                </div>
                                              <div class="form-group row">
                                                  <label for="CantidadProducto" class="col-sm-2 col-form-label">Cantidad de producto</label>
                                                  <div class="col-sm-10">
                                                      <input required type="number" max="50" class="form-control" id="CantidadProducto" name="CantidadProducto"
                                                             placeholder="Ingrese la cantidad de producto" value="<?= $frmSession['CantidadProducto'] ?? '' ?>">
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                    <hr>
                                    <button id="frmName" name="frmName" value="<?= $nameForm ?>" type="submit" class="btn btn-info">Enviar</button>
                                    <a href="index.php" role="button" class="btn btn-default float-right">Cancelar</a>
                                </form>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <?php require('../../partials/footer.php'); ?>
</div>
<!-- ./wrapper -->
<?php require('../../partials/scripts.php'); ?>
</body>
</html>

