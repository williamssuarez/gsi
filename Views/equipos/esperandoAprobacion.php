<?php $salida = $equipos->esperandoAprobacion(); ?>

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800"><?php echo $salida['titulo']; ?></h1>
 <p class="mb-4">Una tabla para administrar a los equipos que esperan la aprobacion</p>

         <h1 class="h3 mb-2 text-gray-800">Tabla</h1>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Equipos Por Aprobar <i class="fa-solid fa-truck-fast"></i></h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover responsive nowrap" id="tablaequipos_aprobacion" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Equipo <i class="fa-solid fa-tag" style="color: #279608;"></i></th>
                        <th>Departamento <i class="fa-solid fa-building" style="color: #913080;"></i></th>
                        <th>Fecha Entrega <i class="fa-solid fa-calendar-days"></i></th>
                        <th>Entregado Por <i class="fa-solid fa-user-gear" style="color: #005af5;"></i></th>
                        <th>Problema <i class="fa-solid fa-triangle-exclamation" style="color: #f50a0a;"></i></th>
                        <th>Conclusion <i class="fa-solid fa-clipboard-check" style="color: #1c931a;"></i></th>
                        <th>Acciones <i class="fa-solid fa-gears"></i></th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach($salida['equipos_salida'] as $data){ ?>
                        <tr>            
                            <td> <?php echo $data['equipo'] ?> </td>
                            <td> <?php echo $data['departamento'] ?> </td>
                            <td> <?php echo $data['fecha_entrega'] ?> </td>
                            <td> <?php echo $data['entregado_por'] ?> </td>
                            <td> <?php echo $data['problema'] ?> </td>
                            <td> <?php echo $data['conclusion'] ?> </td>

                            <td>                             
                                <a id="aprobar_entrega" class="btn btn-primary" href='aprobarEntrega/<?php echo $data['id_aprobacion'] ?>'>Aprobar</a>

                                <a id="rechazar_entrega" class="btn btn-danger" href='rechazarEntrega/<?php echo $data['id_aprobacion'] ?>'>Rechazar</a>
                            </td>

                        </tr>
                    <?php } ?>

                </tbody>
            </table>
            <a class="btn btn-warning" href="<?php echo URL; ?>equipos/index">
                <i class="fa-solid fa-arrow-left"></i>
                Ir a Equipos Pendientes
            </a>
        </div>
    </div>
<?php
require_once "Views/footers/footer.php";
?>