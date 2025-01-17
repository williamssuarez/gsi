<?php ob_start(); ?>
<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Sistema GSI</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/x-icon" href="<?php echo URL; ?>Views/template/img/2.png">
        <link rel="stylesheet" href="<?php echo URL; ?>Views/template/css/style.css">
        <link rel="stylesheet" href="<?php echo URL; ?>Views/template/css/sb-admin-2.min.css">
        <link rel="stylesheet" href="<?php echo URL; ?>Views/template/vendor/fontawesome-free/css/all.min.css">

         <!-- BOOTSTRAP 5.3 CSS -->
        <link rel="stylesheet" href="<?php echo URL; ?>Views/template/DataTables/css/bootstrap.min.css">
        <link rel="stylesheet" href="styles.css">

        <!-- DATATABLES CSS -->
        <link rel="stylesheet" href="<?php echo URL; ?>Views/template/DataTables/css/dataTables.bootstrap5.min.css">

        <!-- DATATABLES BUTTONS CSS -->
        <link rel="stylesheet" href="<?php echo URL; ?>Views/template/DataTables/extensions/buttons/css/buttons.dataTables.css">
        <link rel="stylesheet" href="<?php echo URL; ?>Views/template/DataTables/extensions/buttons/css/buttons.bootstrap5.css">

        <!-- DATATABLES RESPONSIVE CSS -->
        <link rel="stylesheet" href="<?php echo URL; ?>Views/template/DataTables/extensions/responsive/css/responsive.bootstrap.min.css">
        
        <!-- FONTAWESOME CSS -->
        <link rel="stylesheet" href="<?php echo URL; ?>Views/template/FontAwesome/font-awesome_6.4.2_css_all.min.css">

        <!-- SWEETALERT2 CSS -->
        <link rel="stylesheet" href="<?php echo URL; ?>Views/template/sweetalert2/dist/sweetalert2.min.css">

        <!-- SELECT2 CSS -->
        <link rel="stylesheet" href="<?php echo URL; ?>Views/template/select2/css/select2.min.css">

        <!-- FONTAWESOME JS -->
        <script src="<?php echo URL; ?>Views/template/FontAwesome/font-awesome_6.4.2_js_all.min.js"></script>
        
        <!--DataTables JS
        <script src="<//?php echo URL; ?>Views/template/js/demo/datatables-demo.js"></script> -->

        <!-- SWEETALERT2 JS -->
        <script src="<?php echo URL; ?>Views/template/sweetalert2/dist/sweetalert2.all.min.js"></script>

        

        <!--Redirigir-->
        <script src="<?php echo URL; ?>Views/template/js/scripts/redirigirTopbar.js" ></script>

        <!-- Page level plugins
        <script src="<//?php echo URL; ?>Views/template/vendor/datatables/jquery.dataTables.min.js"></script> -->

        <!-- Page level custom scripts -->
        <script src="<?php echo URL; ?>Views/template/DataTables/demo/datatables-demo.js"></script>

        <script>
            //const URL = "http://192.9.101.46/GSI/";
            const URL = "http://localhost/GSI/";
        </script>
    </head>
    <body>

    <!-- Page Wrapper -->
 <div id="wrapper">

<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo URL; ?>inicio/index">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fa-solid fa-gear fa-2xl"></i>
        </div>
        <div class="sidebar-brand-text mx-3">GSI</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="<?php echo URL; ?>inicio/index">
        <i class="fa-solid fa-house"></i>
            <span> Inicio</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fa-solid fa-desktop"></i>
                    <span>Equipos</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Administrar Equipos:</h6>
                        <a class="collapse-item" href="<?php echo URL; ?>equipos/registrados">
                            <i class="fa-solid fa-desktop"></i>
                            Equipos Registrados</a>
                        <a class="collapse-item" href="<?php echo URL; ?>equipos/index">
                            <i class="fa-solid fa-truck-arrow-right fa-flip-horizontal"></i>
                            Equipos Ingresados</a>
                        <a class="collapse-item" href="<?php echo URL; ?>equipos/esperandoAprobacion">
                            <i class="fa-solid fa-question"></i>
                            Equipos por Aprobar</a>
                        <a class="collapse-item" href="<?php echo URL; ?>equipos/rechazosAdmin">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                            Entregas Rechazadas</a>                            
                        <a class="collapse-item" href="<?php echo URL; ?>equipos/salida">
                            <i class="fa-solid fa-truck-fast"></i>
                            Equipos Entregados</a>                            
                    </div>
                </div>
            </li>

    

    <!-- Divider -->
    <hr class="sidebar-divider"> 

    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="<?php echo URL; ?>usuarios/index">
            <i class="fa-solid fa-users-gear"></i>
            <span>Operadores</span></a>
    </li>

    <!-- Nav Item - Charts -->
    <li class="nav-item">
        <a class="nav-link" href="<?php echo URL; ?>direcciones/index">
            <i class="fa-solid fa-globe"></i>
            <span>Direcciones</span></a>
    </li>

    <!-- Nav Item - Pages Collapse Menu  -->
    <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fa-solid fa-print"></i>
                    <span>Dispositivos Generales</span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Administrar Dispositivos:</h6>
                        <a class="collapse-item" href="<?php echo URL; ?>categoria/index">
                            <i class="fa-solid fa-table"></i>
                            Categorias</a>
                        <a class="collapse-item" href="<?php echo URL; ?>tipos/index">
                            <i class="fa-solid fa-table-cells"></i>
                            Tipos de Dispositivos</a>
                        <a class="collapse-item" href="<?php echo URL; ?>dispositivos/index">
                            <i class="fa-solid fa-print"></i>
                            Dispositivos</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Configuraciones</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Extras: </h6>
                        <a class="collapse-item" href="<?php echo URL; ?>departamentos/index">
                            <i class="fa-solid fa-building"></i>    
                            Departamentos</a>
                        <a class="collapse-item" href="<?php echo URL; ?>dispositivos_general/index">
                            <i class="fa-solid fa-print"></i>
                            Dispositivos</a>
                        <a class="collapse-item" href="<?php echo URL; ?>sistemas/index">
                            <i class="fa-brands fa-ubuntu"></i>    
                            Sistemas</a>
                        <a class="collapse-item" href="<?php echo URL; ?>auditoria/index">
                            <i class="fas fa-list fa-sm fa-fw mr-2"></i>
                            Auditoria</a>
                        <!-- <a class="collapse-item" href="<?php echo URL; ?>empleados/index">
                            <i class="fa-solid fa-users"></i> 
                            Empleados</a> -->
                        <a class="collapse-item" href="<?php echo URL; ?>ajax/manualAdministrador">
                            <i class="fa-solid fa-circle-info"></i> 
                            Ayuda</a>
                </div>
            </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <li class="nav-item">
        <a class="nav-link" href="<?php echo URL; ?>login/logout">
            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
            <span>Logout</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Search -->
    <form onsubmit="return redirigir()" class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
        <div class="input-group">
            <input id="ir" type="text" class="form-control bg-light border-0 small" placeholder="Buscar..."
                aria-label="Search" aria-describedby="basic-addon2">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">
                    <i class="fas fa-search fa-sm"></i>
                </button>
            </div>
        </div>
    </form>

   

        <div class="topbar-divider d-none d-sm-block"></div>
        

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                    <?php $nombre = $_SESSION['usuario']; 
                    
                        echo $nombre;

                    ?>    
                </span>
                <img class="img-profile rounded-circle"
                    src="<?php echo URL; ?>Views/template/img/profile.png">
            </a>
            
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="userDropdown">
                <a class="dropdown-item" href="<?php echo URL; ?>usuarios/profile/<?php echo $_SESSION['usuario'] ?>">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Perfil
                </a>
                <a class="dropdown-item" href="<?php echo URL; ?>usuarios/index">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                    Cuentas de Usuarios
                </a>
                <a class="dropdown-item" href="<?php echo URL; ?>auditoria/index">
                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                    Auditoria
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?php echo URL; ?>login/logout">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>

    </ul>

</nav>
<!-- End of Topbar -->


<div class="container-fluid">
    <div class="row">
   
    
</div>