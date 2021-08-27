<?php
require("../../partials/routes.php");
require_once("../../partials/check_login.php");
require("../../../app/Controllers/ProductosController.php");


use App\Controllers\ProductosController;
use App\Controllers\UsuariosController;
use App\Models\GeneralFunctions;
use App\Models\Productos;


$nameModel = "Producto";
$nameForm = 'frmEdit'.$nameModel;
$pluralModel = $nameModel.'s';
$frmSession = $_SESSION[$nameForm] ?? null;

?>
<!DOCTYPE html>
<html>
<head>
    <title>Editar |<?= $nameModel ?></title>
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
                        <h1>Editar <?= $nameModel ?></h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= $baseURL; ?>/views/"><?= $_ENV['ALIASE_SITE'] ?></a></li>
                            <li class="breadcrumb-item"><a href="index.php"><?= $pluralModel ?></a></li>
                            <li class="breadcrumb-item active">Editar</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Generar Mensajes de alerta -->
            <?= (!empty($_GET['respuesta'])) ? GeneralFunctions::getAlertDialog($_GET['respuesta'], $_GET['mensaje']) : ""; ?>
            <?= (empty($_GET['id'])) ? GeneralFunctions::getAlertDialog('error', 'Faltan Criterios de Búsqueda') : ""; ?>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Horizontal Form -->
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title"><i class="fas fa-info"></i>&nbsp; Información del <?= $nameModel ?></h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="maximize"><i
                                                class="fas fa-expand"></i></button>
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                                class="fas fa-minus"></i></button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <?php if (!empty($_GET["id"]) && isset($_GET["id"])) { ?>
                                <p>
                                <?php

                                $DataProducto = ProductosController::searchForID(["id" => $_GET["id"]]);
                                /* @var $DataProducto Productos */
                                if (!empty($DataProducto)) {
                                    ?>
                                    <!-- form start -->
                                    <div class="card-body">
                                        <form class="form-horizontal" enctype="multipart/form-data" method="post" id="<?= $nameForm ?>"
                                              name="<?= $nameForm ?>"
                                              action="../../../app/Controllers/MainController.php?controller=<?= $pluralModel ?>&action=edit">
                                            <input id="id" name="id" value="<?= $DataProducto->getId(); ?>" hidden
                                                   required="required" type="text"><div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <label for="Nombre" class="col-sm-2 col-form-label">Nombre</label>
                                                        <div class="col-sm-10">
                                                            <input required type="text" class="form-control" id="Nombre" name="Nombre"
                                                                   placeholder="Ingrese el nombre del producto" value="<?= $DataProducto->getNombre() ?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="Tamano" class="col-sm-2 col-form-label">Tamaño</label>
                                                        <div class="col-sm-10">
                                                            <input required type="number" max="9999" class="form-control" id="Tamano" name="Tamano"
                                                                   placeholder="Ingrese el tamaño del producto" value="<?= $DataProducto->getTamano() ?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="Clasificacion" class="col-sm-2 col-form-label">Clasificación</label>
                                                        <div class="col-sm-10">
                                                            <select required name="Clasificacion" id="Clasificacion" class="custom-select">
                                                                <option value="">Seleccione</option>
                                                                <option <?= ( $DataProducto->getClasificacion() == "ml") ? "selected" : ""; ?> value="ml">ml</option>
                                                                <option <?= ( $DataProducto->getClasificacion() == "Lt") ? "selected" : ""; ?> value="Lt">Lt</option>
                                                                <option <?= ( $DataProducto->getClasificacion() == "gr") ? "selected" : ""; ?> value="gr">gr</option>
                                                                <option <?= ( $DataProducto->getClasificacion() == "Kg") ? "selected" : ""; ?> value="Kg">Kg</option>
                                                                <option <?= ( $DataProducto->getClasificacion() == "Lb") ? "selected" : ""; ?> value="Lb">Lb</option>
                                                                <option <?= ( $DataProducto->getClasificacion() == "Oz") ? "selected" : ""; ?> value="Oz">Oz</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="Referencia" class="col-sm-2 col-form-label">Referencia</label>
                                                        <div class="col-sm-10">
                                                            <input required type="text" class="form-control" id="Referencia" name="Referencia"
                                                                   placeholder="Ingrese la referencia del producto" value="<?= $DataProducto->getReferencia() ?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="PrecioProduccion" class="col-sm-2 col-form-label">Precio producción</label>
                                                        <div class="col-sm-10">
                                                            <input required type="number" step="0.01" max="999999" class="form-control" id="PrecioProduccion" name="PrecioProduccion"
                                                                   placeholder="Ingrese el precio de producción del producto" value="<?= $DataProducto->getPrecioProduccion() ?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="PrecioVenta" class="col-sm-2 col-form-label">Precio venta</label>
                                                        <div class="col-sm-10">
                                                            <input  required type="number" step="0.01" max="999999" class="form-control" id="PrecioVenta" name="PrecioVenta"
                                                                    placeholder="Ingrese el precio de venta" value="<?= $DataProducto->getPrecioVenta() ?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="Presentacion" class="col-sm-2 col-form-label">Presentación</label>
                                                        <div class="col-sm-10">
                                                            <select required id="Presentacion" name="Presentacion" class="custom-select">
                                                                <option value="">Seleccione</option>
                                                                <option <?= ( $DataProducto->getPresentacion() == "Envase plastico") ? "selected" : ""; ?> value="Envase plastico">Envase plastico</option>
                                                                <option <?= ( $DataProducto->getPresentacion() == "Envase vidrio") ? "selected" : ""; ?> value="Envase vidrio">Envase vidrio</option>
                                                                <option <?= ( $DataProducto->getPresentacion() == "Predeterminado") ? "selected" : ""; ?> value="Predeterminado">Predeterminado</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="Cantidad" class="col-sm-2 col-form-label">Cantidad</label>
                                                        <div class="col-sm-10">
                                                            <input  required type="number" max="9999" class="form-control" id="Cantidad" name="Cantidad"
                                                                    placeholder="Ingrese la cantidad del producto" value="<?= $DataProducto->getCantidad() ?>" >
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="Descripcion" class="col-sm-2 col-form-label">Descripción</label>
                                                        <div class="col-sm-10">
                                                            <input required type="text" class="form-control" id="Descripcion" name="Descripcion"
                                                                   placeholder="Ingrese una descripción" value="<?= $DataProducto->getDescripcion() ?? '' ?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="Estado" class="col-sm-2 col-form-label">Estado</label>
                                                        <div class="col-sm-10">
                                                            <select required name="Estado" id="Estado" class="custom-select">
                                                                <option value="">Seleccione</option>
                                                                <option <?= ( $DataProducto->getEstado() == "Activo") ? "selected" : ""; ?> value="Activo">Activo</option>
                                                                <option <?= ( $DataProducto->getEstado() == "Inactivo") ? "selected" : ""; ?> value="Inactivo">Inactivo</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="Proveedor_id" class="col-sm-2 col-form-label">Proveedor</label>
                                                        <div class="col-sm-10">
                                                            <?= UsuariosController::selectUsuario(
                                                                array(
                                                                    'id' => 'Proveedor_id',
                                                                    'name' => 'Proveedor_id',
                                                                    'defaultValue' => $DataProducto->getProveedorId(),
                                                                    'class' => 'form-control select2bs4 select2-info',
                                                                    'where' => "estado = 'Activo' "
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

                                <?php } else { ?>
                                    <div class="alert alert-danger alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                                            &times;
                                        </button>
                                        <h5><i class="icon fas fa-ban"></i> Error!</h5>
                                        No se encontro ningun registro con estos parametros de
                                        busqueda <?= ($_GET['mensaje']) ?? "" ?>
                                    </div>
                                <?php } ?>
                                </p>
                            <?php } ?>
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
