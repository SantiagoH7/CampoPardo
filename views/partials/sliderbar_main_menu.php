<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= $baseURL; ?>/views/index.php" class="brand-link">
        <img src="<?= $baseURL ?>/views/public/img/Logo-Campo-Pardo.jpeg"
             alt="AdminLTE Logo"
             class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light"><?= $_ENV['ALIASE_SITE'] ?></span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 d-flex">
            <div class="image align-middle">
                <img src="<?= $baseURL ?>/views/public/img/user.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="d-flex flex-column">
                <div class="info"  style="padding-bottom: 0px; !important;">
                    <a href="<?= "$baseURL/views/modules/usuario/show.php?id=" .$_SESSION['UserInSession']['id']?>" class="d-block">
                        <?= $_SESSION['UserInSession']['Nombres'] ?>
                    </a>
                </div>
                <div class="info"  style="padding-top: 0px; !important;">
                    <a href="#" class="d-block">
                        <?= $_SESSION['UserInSession']['Rol'] ?>
                    </a>
                </div>
            </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="<?= $baseURL; ?>/views/index.php" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Inicio
                        </p>
                    </a>
                </li>
                <li class="nav-header">Modulos Principales</li>
                <?php  if ( $_SESSION['UserInSession']['Rol'] == 'Administrador'){ ?>

                    <li class="nav-item has-treeview <?= strpos($_SERVER['REQUEST_URI'],'Usuarios') ? 'menu-open' : '' ?>">
                        <a href="#" class="nav-link <?= strpos($_SERVER['REQUEST_URI'],'Usuarios') ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Usuarios
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= $baseURL ?>/views/modules/usuario/index.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Gestionar</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= $baseURL ?>/views/modules/usuario/create.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Registrar</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview <?= strpos($_SERVER['REQUEST_URI'],'Productos') ? 'menu-open' : '' ?>">
                        <a href="#" class="nav-link <?= strpos($_SERVER['REQUEST_URI'],'Productos') ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-cheese"></i>
                            <p>
                                Productos
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= $baseURL ?>/views/modules/producto/index.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Gestionar</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= $baseURL ?>/views/modules/producto/create.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Registrar</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview <?= strpos($_SERVER['REQUEST_URI'],'Ventas') ? 'menu-open' : '' ?>">
                        <a href="#" class="nav-link <?= strpos($_SERVER['REQUEST_URI'],'Ventas') ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-dollar-sign"></i>
                            <p>
                                Ventas
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= $baseURL ?>/views/modules/venta/index.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Gestionar</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= $baseURL ?>/views/modules/venta/create.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Registrar</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                  <li class="nav-item has-treeview <?= strpos($_SERVER['REQUEST_URI'],'DetalleVentas') ? 'menu-open' : '' ?>">
                        <a href="#" class="nav-link <?= strpos($_SERVER['REQUEST_URI'],'DetalleVentas') ? 'active' : '' ?>">
                            <i class="nav-icon fas fa-file-invoice-dollar"></i>
                           <p>
                                Detalle ventas
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= $baseURL ?>/views/modules/detalle_venta/index.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                    <p>Gestionar</p>
                                </a>
                            </li>
                           <li class="nav-item">
                                <a href="<?= $baseURL ?>/views/modules/detalle_venta/create.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Registrar</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php  } ?>
            </ul>

        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>