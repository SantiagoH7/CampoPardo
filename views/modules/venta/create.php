<?php
require("../../partials/routes.php");
require_once("../../partials/check_login.php");

use App\Controllers\UsuariosController;
use App\Controllers\VentasController;
use App\Models\GeneralFunctions;
use Carbon\Carbon;

$nameModel = "Venta"; //Nombre del Modelo
$nameForm = 'frmCreate'.$nameModel;
$pluralModel = $nameModel.'s'; //Nombre del modelo en plural
$frmSession = $_SESSION[$nameForm]?? NULL; //Nombre del formulario (frmUsuarios)
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
                        <h1>Crear una nueva <?= $nameModel ?></h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/views/"><?= $_ENV['ALIASE_SITE'] ?></a></li>
                            <li class="breadcrumb-item"><a href="index.php"><?= $pluralModel ?></a></li>
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
                                <h3 class="card-title"><i class="fas fa-info"></i> &nbsp; Información de la <?= $nameModel ?></h3>
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
                                                    <label for="FechaVenta" class="col-sm-2 col-form-label">Fechaventa</label>
                                                    <div class="col-sm-10">
                                                        <input required type="date" max="<?= Carbon::now()->format('Y-m-d')?>" class="col-sm-3 form-control" id="FechaVenta" name="FechaVenta"
                                                               value="<?= $frmSession['FechaVenta'] ?? '' ?>">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="MedioPago" class="col-sm-2 col-form-label">Medio de pago</label>
                                                    <div class="col-sm-10">
                                                        <select required id="MedioPago" name="MedioPago" class="custom-select">
                                                            <option value="">Seleccione</option>
                                                            <option <?= ( !empty($frmSession['MedioPago']) && $frmSession['MedioPago'] == "Efectivo") ? "selected" : ""; ?> value="Efectivo">Efectivo</option>
                                                            <option <?= ( !empty($frmSession['MedioPago']) && $frmSession['MedioPago'] == "Nequi") ? "selected" : ""; ?> value="Nequi">Nequi</option>
                                                            <option <?= ( !empty($frmSession['MedioPago']) && $frmSession['MedioPago'] == "Daviplata") ? "selected" : ""; ?> value="Daviplata">Daviplata</option>
                                                        </select>
                                                    </div>
                                                </div>
                                              <div class="form-group row">
                                                  <label for="Estado" class="col-sm-2 col-form-label">Estado</label>
                                                  <div class="col-sm-10">
                                                      <select required name="Estado" id="Estado" class="custom-select">
                                                          <option value="">Seleccione</option>
                                                          <option <?= ( !empty($frmSession['Estado']) && $frmSession['Estado'] == "Pendiente") ? "selected" : ""; ?> value="Pendiente">Pendiente</option>
                                                          <option <?= ( !empty($frmSession['Estado']) && $frmSession['Estado'] == "Saldada") ? "selected" : ""; ?> value="Saldada">Saldada</option>
                                                          <option <?= ( !empty($frmSession['Estado']) && $frmSession['Estado'] == "Cancelada") ? "selected" : ""; ?> value="Cancelada">Cancelada</option>
                                                      </select>
                                                  </div>
                                              </div>
                                                <div class="form-group row">
                                                    <label for="Cliente_id" class="col-sm-2 col-form-label">Cliente</label>
                                                    <div class="col-sm-10">
                                                        <?= \App\Controllers\UsuariosController::selectUsuario(
                                                            array(
                                                                'id' => 'Cliente_id',
                                                                'name' => 'Cliente_id',
                                                                'defaultValue' => (!empty($frmSession['Cliente_id']))? $frmSession['Cliente_id']:'',
                                                                'class' => 'form-control select2bs4 select2-info',
                                                                'where' => "estado = 'Activo' and rol = 'Cliente' "
                                                            )
                                                        )
                                                        ?>
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

