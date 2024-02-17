<?php  namespace Controllers;

//AUTOLOAD DE COMPOSER
require __DIR__.'/../vendor/autoload.php';

//HTML2PDF
use Spipu\Html2Pdf\Html2Pdf;

use Models\Conexion;
use Repository\Procesos1;
use Models\Equipos_ingresados;
use Models\Usuario;
use Models\Auditoria;

class inicioController{

    private $proceso1;
    private $equipos_ingresados;
    private $usuarios;
    private $auditoria;
    private $conexion;

    public function __construct()
    {
        $this->conexion = new Conexion();
        $this->proceso1 = new Procesos1();
        $this->equipos_ingresados = new Equipos_ingresados();
        $this->usuarios = new Usuario();
        $this->auditoria = new Auditoria();

        if (!isset($_SESSION['usuario'])) {
            // El usuario no está autenticado, muestra la alerta y redirige al formulario de inicio de sesión.
            echo '<script>
            Swal.fire({
                title: "Error",
                text: "Tienes que iniciar sesión primero!",
                icon: "warning",
                showConfirmButton: true,
                confirmButtonColor: "#3464eb",
                confirmButtonText: "Iniciar Sesión",
                customClass: {
                    confirmButton: "rounded-button" // Identificador personalizado
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "' . URL . 'login/index";
                }
            }).then(() => {
                window.location.href = "' . URL . 'login/index"; // Esta línea se ejecutará cuando se cierre la alerta.
            });
            </script>';
            exit; // Asegúrate de salir del script de PHP para evitar cualquier salida adicional.
        }
        

    }

    public function index(){

        //OBTENIENDO EL ID DEL USUARIO POR EL NOMBRE USUARIO
        $this->usuarios->set('usuario', $_SESSION['usuario']);
        $id_user = $this->usuarios->getIdUserbyUsuario();
        $user = $id_user['id_user'];

        $datos['pendiente'] = $this->equipos_ingresados->getIngresosTotalesEquipos();
        $datos['entregado'] = $this->equipos_ingresados->getIngresosTotalesEntregados();
        $datos['aprobacion'] = $this->equipos_ingresados->getIngresosTotalesAprobacion();

        //OBTENIENDO LOS EQUIPOS RECHAZADOS DEL OPERADOR
        $this->equipos_ingresados->set('usuario', $id_user['id_user']);
        $datos['rechazos'] = $this->equipos_ingresados->verificarRechazosTotales();

        // PARA OBTENER LOS EQUIPOS ASIGNADOS A EL
        $this->equipos_ingresados->set('recibido_por', $user);
        $datos['asignados'] = $this->equipos_ingresados->getAsignacionesTotalesaUsuario();


        $tipo_cambio = 10;
        $tabla_afectada = "Inicio";
        $registro_afectado = "Ninguno";
        $valor_antes = "Ninguno";
        $valor_despues = "Ninguno";
        $usuario = $user;

        //EJECUTANDO LA AUDITORIA
        $this->auditoria->auditar($tipo_cambio, $tabla_afectada, $registro_afectado, $valor_antes, $valor_despues, $usuario);

        return $datos;
    }

    public function reportehtml2() {
        ob_clean(); // Clear output buffer
    
        $html2pdf = new Html2Pdf();
        $plantilla = require_once "plantilla.html";
        $html2pdf->writeHTML($plantilla);
    
        header('Content-type: application/pdf');
        return $html2pdf->output();
        //return $html2pdf->output('Manual.pdf', 'S');*/
    }

    public function backup(){

        // Get the provided storage location
        $location = $_POST["location"];
        $date = date("Y-m-d_H-i-s");

        // Generate a unique filename
        $filename = "backup_" . $date;

        // Generate the backup command
        //$command = "mysqldump -u $db_user -p$db_password $db_name > $location/$filename";

        // Execute the backup command
        $result = $this->conexion->respaldo($location, $filename);

        if ($result !== false) {
        echo "Backup created successfully: $location/$filename";
        } else {
        echo "Error creating backup.";
        }

    }
    
    public function pieChart() {

        ob_start();

        //OBTENIENDO EL ID DEL USUARIO POR EL NOMBRE USUARIO
        $this->usuarios->set('usuario', $_SESSION['usuario']);
        $id_user = $this->usuarios->getIdUserbyUsuario();
        $user = $id_user['id_user'];

        //OBTENIENDO LOS EQUIPOS RECHAZADOS DEL OPERADOR
        $this->equipos_ingresados->set('usuario', $id_user['id_user']);
        $datos['rechazos'] = $this->equipos_ingresados->verificarRechazosTotales();
        $datos['pendiente'] = $this->equipos_ingresados->getIngresosTotalesEquipos();
        $datos['entregado'] = $this->equipos_ingresados->getIngresosTotalesEntregados();
        $datos['aprobacion'] = $this->equipos_ingresados->getIngresosTotalesAprobacion();

        // Simulación de datos para propósitos de ejemplo
        $data = array(
            "labels" => ["Ingresados", "Entregados", "En Revision", "Entregas Rechazadas"],
            "data" => [$datos['pendiente'], $datos['entregado'], $datos['aprobacion'], $datos['rechazos']]
        );

        // Convierte los datos a formato JSON y envíalos de vuelta
        header('Content-Type: application/json');
        echo json_encode($data);

        ob_clean();
    }


}

$inicio = new inicioController();

?>